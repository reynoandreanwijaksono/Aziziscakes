<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with(['order.user'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->method, fn($q) => $q->where('method', $request->method))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.payments.index', compact('payments'));
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate(['status' => 'required|in:pending,paid,failed,refunded']);

        $payment->update([
            'status'  => $request->status,
            'paid_at' => $request->status === 'paid' ? now() : $payment->paid_at,
        ]);

        // Update order status when payment is confirmed
        if ($request->status === 'paid') {
            $payment->order->update(['status' => 'processing']);
        }

        return back()->with('success', 'Status pembayaran berhasil diperbarui!');
    }
}
