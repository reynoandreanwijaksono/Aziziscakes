<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\{Cart, Product, Order, OrderItem, Payment};
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::with(['product.images'])
            ->where('user_id', auth()->id())
            ->get();

        $total = $cartItems->sum('subtotal');
        return view('user.cart.index', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        $cart = Cart::firstOrNew([
            'user_id'    => auth()->id(),
            'product_id' => $request->product_id,
        ]);

        $cart->quantity = ($cart->exists ? $cart->quantity : 0) + $request->quantity;
        $cart->save();

        return back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request, Cart $cart)
    {
        abort_if($cart->user_id !== auth()->id(), 403);
        $request->validate(['quantity' => 'required|integer|min:1']);
        $cart->update(['quantity' => $request->quantity]);
        return back()->with('success', 'Keranjang diperbarui!');
    }

    public function destroy(Cart $cart)
    {
        abort_if($cart->user_id !== auth()->id(), 403);
        $cart->delete();
        return back()->with('success', 'Item dihapus dari keranjang!');
    }
}
