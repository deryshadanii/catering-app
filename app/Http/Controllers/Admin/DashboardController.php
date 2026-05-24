<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MealPackage;
use App\Models\MenuItem;
use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Halaman ini hanya untuk admin.');
        }

        $totalMenus = MenuItem::count();
        $availableMenus = MenuItem::where('is_available', true)->count();

        $totalPackages = MealPackage::count();
        $availablePackages = MealPackage::where('is_available', true)->count();

        $todayOrders = Order::whereDate('created_at', Carbon::today())->count();

        $pendingOrders = Order::where('status', 'pending')->count();

        $processingOrders = Order::whereIn('status', [
            'confirmed',
            'processing',
            'delivering',
        ])->count();

        $completedOrders = Order::where('status', 'completed')->count();

        $totalRevenue = Order::where('status', 'completed')->sum('total');

        $recentOrders = Order::with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMenus',
            'availableMenus',
            'totalPackages',
            'availablePackages',
            'todayOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'totalRevenue',
            'recentOrders'
        ));
    }
}
