<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MealPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MealPackageController extends Controller
{
    private function ensureAdmin()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Halaman ini hanya untuk admin.');
        }
    }

    public function index()
    {
        $this->ensureAdmin();

        $packages = MealPackage::latest()->get();

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        $this->ensureAdmin();

        return view('admin.packages.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:mingguan,bulanan'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'benefits' => ['nullable', 'string'],
            'is_available' => ['required', 'in:0,1'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('package-images', 'public');
        }

        unset($data['image']);

        MealPackage::create($data);

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Paket catering berhasil ditambahkan.');
    }

    public function edit(MealPackage $mealPackage)
    {
        $this->ensureAdmin();

        return view('admin.packages.edit', compact('mealPackage'));
    }

    public function update(Request $request, MealPackage $mealPackage)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:mingguan,bulanan'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'benefits' => ['nullable', 'string'],
            'is_available' => ['required', 'in:0,1'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($mealPackage->image_url && Storage::disk('public')->exists($mealPackage->image_url)) {
                Storage::disk('public')->delete($mealPackage->image_url);
            }

            $data['image_url'] = $request->file('image')->store('package-images', 'public');
        }

        unset($data['image']);

        $mealPackage->update($data);

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Paket catering berhasil diperbarui.');
    }

    public function destroy(MealPackage $mealPackage)
    {
        $this->ensureAdmin();

        if ($mealPackage->image_url && Storage::disk('public')->exists($mealPackage->image_url)) {
            Storage::disk('public')->delete($mealPackage->image_url);
        }

        $mealPackage->delete();

        return redirect()
            ->route('admin.packages.index')
            ->with('success', 'Paket catering berhasil dihapus.');
    }
}
