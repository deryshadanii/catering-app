<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\MealPackage;

class HomeController extends Controller
{
    public function index()
    {
        $menus = MenuItem::where('is_available', true)
            ->latest()
            ->take(4)
            ->get();

        $packages = MealPackage::where('is_available', true)
            ->latest()
            ->take(3)
            ->get();

        return view('home', compact('menus', 'packages'));
    }
}
