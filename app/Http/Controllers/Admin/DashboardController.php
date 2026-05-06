<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Order, Product, User, Payment};
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products'  => Product::count(),
            'total_orders'    => Order::count(),
            'total_users'     => User::where('role', 'user')->count(),
            'total_revenue'   => Payment::where('status', 'paid')->sum('amount'),
            'pending_orders'  => Order::where('status', 'pending')->count(),
            'monthly_revenue' => Payment::where('status', 'paid')
                ->whereMonth('paid_at', now()->month)
                ->sum('amount'),
        ];

        $recentOrders = Order::with(['user', 'payment'])
            ->latest()
            ->take(10)
            ->get();

        $topProducts = Product::withCount('cartItems')
            ->orderByDesc('sold_count')
            ->take(5)
            ->get();

        $monthlyData = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(total) as revenue')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard.index', compact('stats', 'recentOrders', 'topProducts', 'monthlyData'));
    }
}
