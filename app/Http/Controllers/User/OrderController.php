<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{Order, Payment};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items.product.images', 'payment', 'shipment'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('user.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        $order->load(['items.product.images', 'payment', 'shipment', 'user']);
        return view('user.orders.show', compact('order'));
    }

    public function uploadPaymentProof(Request $request, Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('payment-proofs', 'public');

        $order->payment->update([
            'payment_proof' => $path,
            'status'      => 'pending', // Admin will confirm
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah!');
    }

    public function cancel(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        abort_if(!in_array($order->status, ['pending']), 403);

        $order->update(['status' => 'cancelled']);

        // Restore stock
        foreach ($order->items as $item) {
            $item->product->increment('stock', $item->quantity);
            $item->product->decrement('sold_count', $item->quantity);
        }

        return back()->with('success', 'Pesanan berhasil dibatalkan!');
    }
}