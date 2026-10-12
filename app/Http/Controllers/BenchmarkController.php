<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BenchmarkController extends Controller
{
    /**
     * Level 1: Simple query.
     * GET /benchmark/easy?limit=10000
     */
    public function easy(Request $request): JsonResponse
    {
        $limit = $this->getLimit($request);

        return $this->benchmark(function () use ($limit) {
            return Transaction::query()
                ->orderBy('id')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Level 2: Transactions with customer relationship.
     * GET /benchmark/relations?customer_id=1
     */
    public function relations(Request $request): JsonResponse
    {
        $customerId = $request->integer('customer_id', 1);

        abort_if($customerId < 1, 422, 'Invalid customer ID.');

        return $this->benchmark(function () use ($customerId) {
            return Transaction::query()
                ->where('customer_id', $customerId)
                ->with('customer')
                ->get();
        });
    }

    /**
     * Level 3: Multiple relationships.
     * GET /benchmark/complex?category_id=1
     */
    public function complex(Request $request): JsonResponse
    {
        $categoryId = $request->integer('category_id', 1);

        abort_if($categoryId < 1, 422, 'Invalid category ID.');

        return $this->benchmark(function () use ($categoryId) {
            return Transaction::query()
                ->whereHas('items.product', function ($query) use ($categoryId) {
                    $query->where('category_id', $categoryId);
                })
                ->with([
                    'customer',
                    'items.product',
                ])
                ->get();
        });
    }

    private function getLimit(Request $request): int
    {
        return min(
            max($request->integer('limit', 10000), 1),
            100000
        );
    }

    private function benchmark(callable $callback): JsonResponse
    {
        DB::flushQueryLog();
        DB::enableQueryLog();

        $start = hrtime(true);
        $memoryBefore = memory_get_usage(true);

        try {
            $result = $callback();

            $elapsedMs = (hrtime(true) - $start) / 1_000_000;
            $memoryUsed = max(
                0,
                memory_get_peak_usage(true) - $memoryBefore
            );

            return response()->json([
                'success' => true,
                'benchmark' => [
                    'execution_time_ms' => round($elapsedMs, 3),
                    'query_count' => count(DB::getQueryLog()),
                    'memory_used_mb' => round(
                        $memoryUsed / 1024 / 1024,
                        2
                    ),
                    'result_count' => $result->count(),
                ],
                'data' => $result,
            ]);
        } finally {
            DB::disableQueryLog();
            DB::flushQueryLog();
        }
    }
}
