<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $subtotal = collect($cart)->sum('total');
        $deliveryFee = 5000;
        $total = $subtotal + $deliveryFee;

        return view('checkout.index', compact('cart', 'subtotal', 'deliveryFee', 'total'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang masih kosong.');
        }

        $data = $request->validate([
            'delivery_address' => ['required', 'string'],
            'delivery_date' => ['nullable', 'date'],
            'note' => ['nullable', 'string'],
            'payment_method' => ['required', 'in:transfer_bank,e_wallet,cod'],
        ]);

        $subtotal = collect($cart)->sum('total');
        $deliveryFee = 5000;
        $total = $subtotal + $deliveryFee;

        DB::transaction(function () use ($data, $cart, $subtotal, $deliveryFee, $total) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_code' => 'DM-' . now()->format('YmdHis') . '-' . Auth::id(),
                'delivery_address' => $data['delivery_address'],
                'delivery_date' => $data['delivery_date'] ?? null,
                'note' => $data['note'] ?? null,
                'payment_method' => $data['payment_method'],
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_type' => $item['item_type'],
                    'item_id' => $item['item_id'],
                    'item_name' => $item['item_name'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['total'],
                    'preference_note' => $item['preference_note'] ?? null,
                ]);
            }
        });

        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat.');
    }
}
