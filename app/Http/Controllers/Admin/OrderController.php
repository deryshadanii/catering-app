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

    public function index(Request $request)
    {
        $this->ensureAdmin();

        $search = $request->input('search');
        $status = $request->input('status');
        $paymentMethod = $request->input('payment_method');

        $orders = Order::with(['user', 'items'])
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('order_code', 'like', '%' . $search . '%')
                        ->orWhere('delivery_address', 'like', '%' . $search . '%')
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($paymentMethod, function ($query, $paymentMethod) {
                $query->where('payment_method', $paymentMethod);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $summary = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::whereIn('status', ['confirmed', 'processing', 'delivering'])->count(),
            'completed' => Order::where('status', 'completed')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'summary'));
    }

    public function show(Order $order)
    {
        $this->ensureAdmin();

        $order->load(['user', 'items']);

        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'status' => ['required', 'in:pending,confirmed,processing,delivering,completed,cancelled'],
        ]);

        $order->update([
            'status' => $data['status'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        return $this->update($request, $order);
    }

    public function destroy(Order $order)
    {
        $this->ensureAdmin();

        $order->items()->delete();
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Pesanan berhasil dihapus.');
    }
}
