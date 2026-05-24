<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MealPackage;
use App\Models\MenuItem;
use App\Models\Order;

class DashboardController extends Controller
{
    private function ensureAdmin()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Halaman ini hanya untuk admin.');
        }
    }

    public function index()
    {
        $this->ensureAdmin();

        $totalMenus = MenuItem::count();
        $totalPackages = MealPackage::count();
        $totalOrders = Order::count();

        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        $totalRevenue = Order::where('status', 'completed')->sum('total');

        $latestOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMenus',
            'totalPackages',
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'totalRevenue',
            'latestOrders'
        ));
    }
}
