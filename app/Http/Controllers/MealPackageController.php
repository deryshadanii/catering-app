<?php

namespace App\Http\Controllers;

use App\Models\MealPackage;
use Illuminate\Http\Request;

class MealPackageController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $type = $request->input('type');

        $packages = MealPackage::where('is_available', true)
            ->when($search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%')
                        ->orWhere('benefits', 'like', '%' . $search . '%');
                });
            })
            ->when($type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->latest()
            ->get();

        return view('packages.index', compact('packages', 'search', 'type'));
    }

    public function show(MealPackage $package)
    {
        if (!$package->is_available) {
            abort(404);
        }

        return view('packages.show', compact('package'));
    }
}
