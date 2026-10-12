<?php

namespace App\Http\Controllers;

use App\Mail\TransactionReceiptMail;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();
        return view('users', compact('users'));
    }

    public function sendEmail(User $user)
    {
        $transaction = Transaction::where('customer_id', $user->id)
            ->latest()
            ->first();

        Mail::to($user->email)->send(
            new TransactionReceiptMail($transaction)
        );

        return redirect()
            ->back()
            ->with('success', 'Email sent successfully to ' . $user->email);
    }
}
