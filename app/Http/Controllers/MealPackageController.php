<?php

namespace App\Http\Controllers;

use App\Models\MealPackage;

class MealPackageController extends Controller
{
    public function index()
    {
        $packages = MealPackage::where('is_available', true)
            ->latest()
            ->get();

        return view('packages.index', compact('packages'));
    }

    public function show(MealPackage $package)
    {
        return view('packages.show', compact('package'));
    }
}
