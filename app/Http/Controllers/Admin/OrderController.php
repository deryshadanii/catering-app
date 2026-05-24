<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
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

        $orders = Order::with(['user', 'items'])
            ->latest()
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->ensureAdmin();

        $order->load(['user', 'items']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'status' => ['required', 'in:pending,confirmed,processing,delivering,completed,cancelled'],
        ]);

        $order->update([
            'status' => $data['status'],
        ]);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
