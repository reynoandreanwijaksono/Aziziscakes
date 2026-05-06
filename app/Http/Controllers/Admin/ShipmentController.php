<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Shipment, User};
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $shipments = Shipment::with(['order.user'])
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.shipments.index', compact('shipments'));
    }

    public function update(Request $request, Shipment $shipment)
    {
        $validated = $request->validate([
            'courier'         => 'required|string',
            'service'         => 'nullable|string',
            'tracking_number' => 'nullable|string',
            'estimated_days'  => 'nullable|string',
            'status'          => 'required|in:pending,processing,shipped,delivered',
        ]);

        if ($validated['status'] === 'shipped') $validated['shipped_at'] = now();
        if ($validated['status'] === 'delivered') {
            $validated['delivered_at'] = now();
            $shipment->order->update(['status' => 'completed']);
        }

        $shipment->update($validated);
        return back()->with('success', 'Data pengiriman berhasil diperbarui!');
    }
}

// ─────────────────────────────────────────────────────────

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::withCount('orders')
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%"))
            ->when($request->role, fn($q) => $q->where('role', $request->role))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        return back()->with('success', 'Status user berhasil diperbarui!');
    }
}
