<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // KPI
        $totalCustomers = User::where('role', 'customer')->count();
        $totalOrders    = Order::count();
        $totalRevenue   = Order::where('status', 'completed')->sum('total');

        $repeatCustomers = User::where('role', 'customer')
            ->withCount('orders')
            ->having('orders_count', '>', 1)
            ->count();

        $repeatRate = $totalCustomers > 0
            ? round(($repeatCustomers / $totalCustomers) * 100)
            : 0;

        // Customer loyal
        $customers = User::where('role', 'customer')
            ->withCount('orders')
            ->withSum('orders', 'total')
            ->orderByDesc('orders_count')
            ->get();

        $topCustomers = $customers->take(5);

        // Booking bulanan
        $monthlyOrders = Order::select(
                DB::raw("DATE_FORMAT(date, '%b %Y') as month"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('month')
            ->orderByRaw("MIN(date)")
            ->get();

        // Jam favorit
        $favoriteTimes = Order::select(
                'time_slot as time',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('time')
            ->orderByDesc('total')
            ->limit(6)
            ->get();
        
        $topServices = DB::table('order_pets')
        ->select(
            'service_name',
            DB::raw('SUM(quantity) as total_ordered') // <-- ubah "qty" jadi "quantity"
        )
        ->join('orders', 'order_pets.order_id', '=', 'orders.id')
        ->whereIn('orders.status', ['confirmed', 'on_progress', 'completed'])
        ->groupBy('service_name')
        ->orderByDesc('total_ordered')
        ->limit(5)
        ->get();

        return view('admin.analytics.index', compact(
            'totalCustomers',
            'totalOrders',
            'repeatRate',
            'totalRevenue',
            'customers',
            'topCustomers',
            'monthlyOrders',
            'favoriteTimes',
            'topServices'
        ));
    }

}
