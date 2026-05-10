<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Order, Shipment};
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['user', 'payment', 'items'])
            ->when($request->search, fn($q) => $q->where('invoice_number', 'like', "%{$request->search}%")
                ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$request->search}%")))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'payment', 'shipment']);
        return view('admin.orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus!');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,processing,shipped,completed,cancelled']);
        $order->update(['status' => $request->status]);

        // Auto-create shipment when status becomes shipped
        if ($request->status === 'shipped' && !$order->shipment) {
            Shipment::create([
                'order_id'  => $order->id,
                'courier'   => $request->courier ?? 'JNE',
                'cost'      => $order->shipping_cost,
                'status'    => 'shipped',
                'shipped_at' => now(),
            ]);
        }

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
