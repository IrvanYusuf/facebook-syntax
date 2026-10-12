<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CustomController extends Controller
{
    public function create(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:users,id'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => [
                'required',
                'exists:products,id',
                'distinct',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        $transaction = DB::transaction(function () use ($validated) {
            $items = collect($validated['items']);

            $products = Product::whereIn(
                'id',
                $items->pluck('product_id')
            )->get()->keyBy('id');

            $total = 0;

            $transaction = Transaction::create([
                'customer_id' => $validated['customer_id'],
                'invoice_number' => 'INV-' . Str::upper(Str::random(10)),
                'status' => 'pending',
                'total' => 0,
                'transaction_date' => now(),
            ]);

            foreach ($items as $item) {
                $product = $products->get($item['product_id']);

                if (! $product) {
                    throw ValidationException::withMessages([
                        'items' => 'Product not found.',
                    ]);
                }

                $unitPrice = (float) $product->price;
                $quantity = (int) $item['quantity'];

                $total += $unitPrice * $quantity;

                $transaction->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                ]);
            }

            $transaction->update([
                'total' => $total,
            ]);

            return $transaction->load('items.product');
        });

        // Read the secret from Laravel configuration.
        $SECRET = config('app.payment.secret');
        $BASE_URL = config('app.payment.base_url');

        if (blank($SECRET)) {
            return response()->json([
                'message' => 'Payment configuration is missing.',
                'invoice_number' => $transaction->invoice_number,
            ], 500);
        }

        // Example only: replace with your actual payment gateway API.
        $response = Http::withToken($SECRET)
            ->acceptJson()
            ->post(
                $BASE_URL . '/payments',
                [
                    'reference' => $transaction->invoice_number,
                    'amount' => (float) $transaction->total,
                ]
            );

        if ($response->failed()) {
            return response()->json([
                'message' => 'Unable to create payment.',
                'transaction' => $transaction,
            ], 502);
        }

        return response()->json([
            'message' => 'Transaction created successfully.',
            'transaction' => $transaction,
            'payment' => $response->json(),
        ], 201);
    }
}
