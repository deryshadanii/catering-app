<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = collect(session('cart', []));

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        $subtotal = $cartItems->sum(function ($item) {
            $price = (int) ($item['price'] ?? 0);
            $quantity = (int) ($item['quantity'] ?? 1);

            return $price * $quantity;
        });

        $deliveryFee = 5000;
        $total = $subtotal + $deliveryFee;

        return view('checkout.index', compact(
            'cartItems',
            'subtotal',
            'deliveryFee',
            'total'
        ));
    }

    public function store(Request $request)
    {
        $cartItems = collect(session('cart', []));

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        $data = $request->validate([
            'delivery_address' => ['required', 'string', 'max:1000'],
            'delivery_date' => ['nullable', 'date'],
            'note' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:cod,qris'],
        ]);

        $subtotal = $cartItems->sum(function ($item) {
            $price = (int) ($item['price'] ?? 0);
            $quantity = (int) ($item['quantity'] ?? 1);

            return $price * $quantity;
        });

        $deliveryFee = 5000;
        $total = $subtotal + $deliveryFee;

        DB::transaction(function () use ($cartItems, $data, $subtotal, $deliveryFee, $total) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_code' => 'ORD-' . now()->format('YmdHis') . '-' . auth()->id(),
                'delivery_address' => $data['delivery_address'],
                'delivery_date' => $data['delivery_date'] ?? null,
                'note' => $data['note'] ?? null,
                'payment_method' => $data['payment_method'],
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                $itemType = $item['item_type'] ?? $item['type'] ?? 'menu';
                $itemId = $item['item_id'] ?? $item['id'] ?? null;
                $itemName = $item['item_name'] ?? $item['name'] ?? 'Item Pesanan';
                $price = (int) ($item['price'] ?? 0);
                $quantity = (int) ($item['quantity'] ?? 1);
                $itemTotal = $price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'item_type' => $itemType,
                    'item_id' => $itemId,
                    'item_name' => $itemName,
                    'price' => $price,
                    'quantity' => $quantity,
                    'total' => $itemTotal,
                    'preference_note' => $item['preference_note'] ?? null,
                ]);
            }

            session()->forget('cart');
        });

        return redirect()
            ->route('orders.index')
            ->with('success', 'Pesanan berhasil dibuat.');
    }
}
