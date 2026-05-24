<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\MealPackage;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = collect(session('cart', []));

        $subtotal = $cartItems->sum(function ($item) {
            return ((int) ($item['price'] ?? 0)) * ((int) ($item['quantity'] ?? 1));
        });

        $deliveryFee = $cartItems->isEmpty() ? 0 : 5000;
        $total = $subtotal + $deliveryFee;

        return view('cart.index', compact('cartItems', 'subtotal', 'deliveryFee', 'total'));
    }

    public function addMenu(MenuItem $menuItem)
    {
        $cart = session()->get('cart', []);

        $key = 'menu_' . $menuItem->id;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += 1;
        } else {
            $cart[$key] = [
                'cart_key' => $key,
                'id' => $menuItem->id,
                'item_id' => $menuItem->id,
                'type' => 'menu',
                'name' => $menuItem->name,
                'description' => $menuItem->description,
                'price' => $menuItem->price,
                'quantity' => 1,
                'image_url' => $menuItem->image_url,
            ];
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Menu berhasil ditambahkan ke keranjang.');
    }

    public function addPackage(MealPackage $mealPackage)
    {
        $cart = session()->get('cart', []);

        $key = 'package_' . $mealPackage->id;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += 1;
        } else {
            $cart[$key] = [
                'cart_key' => $key,
                'id' => $mealPackage->id,
                'item_id' => $mealPackage->id,
                'type' => 'package',
                'name' => $mealPackage->name,
                'description' => $mealPackage->description,
                'price' => $mealPackage->price,
                'quantity' => 1,
                'image_url' => $mealPackage->image_url,
            ];
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', 'Paket berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, $cartKey)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] = $data['quantity'];
            session()->put('cart', $cart);
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Jumlah item berhasil diperbarui.');
    }

    public function remove($cartKey)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            session()->put('cart', $cart);
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');

        return redirect()
            ->route('cart.index')
            ->with('success', 'Keranjang berhasil dikosongkan.');
    }
}
