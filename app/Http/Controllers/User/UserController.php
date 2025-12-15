<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tanggal dari query (?date=YYYY-MM-DD)
        $selectedDate = $request->date
            ? Carbon::parse($request->date)
            : Carbon::today();

        $orders = Order::with('pets')
            ->where('groomer_id', auth()->id())
            ->whereDate('date', $selectedDate)
            ->where('status', '!=', 'cancelled')
            ->orderBy('time_slot', 'asc')
            ->get();

        return view('user.dashboard', compact('orders', 'selectedDate'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        // Pastikan order ini milik si groomer (Security check)
        if ($order->groomer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Update status (misal: Selesai)
        $order->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status pekerjaan diperbarui!');
    }

    public function mapView(Request $request)
    {
        $date = $request->get('date', now()->toDateString());

        $orders = Order::where('groomer_id', auth()->id())
            ->where('status', 'confirmed')
            ->whereDate('date', $date)
            ->whereNotNull('customer_address')
            ->where('customer_address', '!=', '')
            ->get();

        return view('user.maps', compact('orders', 'date'));
    }
}
