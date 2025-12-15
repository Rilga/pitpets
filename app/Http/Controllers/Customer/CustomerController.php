<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Total booking milik customer
        $totalOrders = Order::where('customer_id', $userId)->count();

        // Booking aktif (belum selesai)
        $activeOrders = Order::where('customer_id', $userId)
            ->whereIn('status', ['pending', 'confirmed', 'on_progress'])
            ->count();

        return view('customer.dashboard', compact(
            'totalOrders',
            'activeOrders'
        ));
    }

    public function history()
    {
        $orders = Order::where('customer_id', Auth::id())
            ->orderBy('date', 'desc')
            ->paginate(10);

        return view('customer.history', compact('orders'));
    }

    public function show(Order $order)
    {
        // Security: pastikan order milik customer login
        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }

        return view('customer.history-show', compact('order'));
    }
}
