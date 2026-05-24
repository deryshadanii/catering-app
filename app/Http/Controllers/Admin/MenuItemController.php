<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuItemController extends Controller
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

        $menus = MenuItem::latest()->get();

        return view('admin.menu-items.index', compact('menus'));
    }

    public function create()
    {
        $this->ensureAdmin();

        return view('admin.menu-items.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'category' => ['nullable', 'string', 'max:255'],
            'available_date' => ['nullable', 'date'],
            'is_available' => ['required', 'in:0,1'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('menu-images', 'public');
        }

        unset($data['image']);

        MenuItem::create($data);

        return redirect()
            ->route('admin.menu-items.index')
            ->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(MenuItem $menuItem)
    {
        $this->ensureAdmin();

        return view('admin.menu-items.edit', compact('menuItem'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'category' => ['nullable', 'string', 'max:255'],
            'available_date' => ['nullable', 'date'],
            'is_available' => ['required', 'in:0,1'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            if ($menuItem->image_url && Storage::disk('public')->exists($menuItem->image_url)) {
                Storage::disk('public')->delete($menuItem->image_url);
            }

            $data['image_url'] = $request->file('image')->store('menu-images', 'public');
        }

        unset($data['image']);

        $menuItem->update($data);

        return redirect()
            ->route('admin.menu-items.index')
            ->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(MenuItem $menuItem)
    {
        $this->ensureAdmin();

        if ($menuItem->image_url && Storage::disk('public')->exists($menuItem->image_url)) {
            Storage::disk('public')->delete($menuItem->image_url);
        }

        $menuItem->delete();

        return redirect()
            ->route('admin.menu-items.index')
            ->with('success', 'Menu berhasil dihapus.');
    }
}
