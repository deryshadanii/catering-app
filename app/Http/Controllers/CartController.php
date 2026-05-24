<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\MealPackage;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = collect($cart)->sum('total');

        return view('cart.index', compact('cart', 'subtotal'));
    }

    public function addMenu(MenuItem $menuItem)
    {
        $cart = session()->get('cart', []);
        $key = 'menu_' . $menuItem->id;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += 1;
            $cart[$key]['total'] = $cart[$key]['price'] * $cart[$key]['quantity'];
        } else {
            $cart[$key] = [
                'item_type' => 'menu',
                'item_id' => $menuItem->id,
                'item_name' => $menuItem->name,
                'price' => $menuItem->price,
                'quantity' => 1,
                'total' => $menuItem->price,
                'preference_note' => null,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Menu berhasil ditambahkan ke keranjang.');
    }

    public function addPackage(Request $request, MealPackage $package)
    {
        $cart = session()->get('cart', []);
        $key = 'package_' . $package->id . '_' . time();

        $cart[$key] = [
            'item_type' => 'package',
            'item_id' => $package->id,
            'item_name' => $package->name,
            'price' => $package->price,
            'quantity' => 1,
            'total' => $package->price,
            'preference_note' => $request->preference_note,
        ];

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Paket berhasil ditambahkan ke keranjang.');
    }

    public function update(Request $request, string $key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            $quantity = max(1, (int) $request->quantity);
            $cart[$key]['quantity'] = $quantity;
            $cart[$key]['total'] = $cart[$key]['price'] * $quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui.');
    }

    public function destroy(string $key)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Keranjang dikosongkan.');
    }
}
