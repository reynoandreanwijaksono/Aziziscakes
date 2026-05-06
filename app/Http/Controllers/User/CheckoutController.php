<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{Cart, Order, OrderItem, Payment, Shipment};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with(['product.images'])
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong!');
        }

        $subtotal = $cartItems->sum('subtotal');
        return view('user.checkout.index', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address'     => 'required|string',
            'shipping_city'        => 'required|string',
            'shipping_province'    => 'required|string',
            'shipping_postal_code' => 'required|string',
            'shipping_phone'       => 'required|string',
            'courier'              => 'required|string',
            'payment_method'       => 'required|in:transfer_bank,ewallet,cod',
            'notes'                => 'nullable|string',
        ]);

        $cartItems = Cart::with(['product'])
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang belanja kosong!');
        }

        DB::transaction(function () use ($validated, $cartItems, $request) {
            $subtotal = $cartItems->sum('subtotal');
            $shippingCost = $this->calculateShipping($validated['courier']);
            $total = $subtotal + $shippingCost;

            $order = Order::create([
                'user_id'              => auth()->id(),
                'subtotal'             => $subtotal,
                'shipping_cost'        => $shippingCost,
                'total'                => $total,
                'status'               => 'pending',
                'shipping_address'     => $validated['shipping_address'],
                'shipping_city'        => $validated['shipping_city'],
                'shipping_province'    => $validated['shipping_province'],
                'shipping_postal_code' => $validated['shipping_postal_code'],
                'shipping_phone'       => $validated['shipping_phone'],
                'notes'                => $validated['notes'] ?? null,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'price'        => $item->product->effective_price,
                    'quantity'     => $item->quantity,
                    'subtotal'     => $item->subtotal,
                ]);

                // Reduce stock
                $item->product->decrement('stock', $item->quantity);
                $item->product->increment('sold_count', $item->quantity);
            }

            Payment::create([
                'order_id' => $order->id,
                'method'   => $validated['payment_method'],
                'amount'   => $total,
                'status'   => 'pending',
            ]);

            Shipment::create([
                'order_id'       => $order->id,
                'courier'        => $validated['courier'],
                'cost'           => $shippingCost,
                'estimated_days' => $this->getEstimation($validated['courier']),
                'status'         => 'pending',
            ]);

            // Clear cart
            Cart::where('user_id', auth()->id())->delete();

            session(['latest_order_id' => $order->id]);
        });

        return redirect()->route('orders.show', session('latest_order_id'))
            ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    private function calculateShipping(string $courier): int
    {
        return match ($courier) {
            'JNE'  => 15000,
            'JNT'  => 12000,
            'SiCepat' => 13000,
            'Grab' => 20000,
            'Gojek' => 18000,
            default => 15000,
        };
    }

    private function getEstimation(string $courier): string
    {
        return match ($courier) {
            'JNE'  => '2-3 hari',
            'JNT'  => '2-4 hari',
            'SiCepat' => '1-2 hari',
            'Grab' => 'Same day',
            'Gojek' => 'Same day',
            default => '2-3 hari',
        };
    }
}
