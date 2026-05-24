<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show(\App\Models\Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Kamu tidak memiliki akses ke pesanan ini.');
        }

        $order->load('items');

        return view('orders.show', compact('order'));
    }

    public function cancel(\App\Models\Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Kamu tidak memiliki akses ke pesanan ini.');
        }

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return redirect()
                ->route('orders.show', $order)
                ->with('error', 'Pesanan tidak bisa dibatalkan karena sudah diproses.');
        }

        $order->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
