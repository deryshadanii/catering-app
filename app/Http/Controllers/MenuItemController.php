<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;

class MenuItemController extends Controller
{
    public function index()
    {
        $menus = MenuItem::where('is_available', true)
            ->latest()
            ->get();

        return view('menu.index', compact('menus'));
    }
}
