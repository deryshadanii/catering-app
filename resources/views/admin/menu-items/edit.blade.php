@extends('layouts.admin')

@section('title', 'Edit Menu - DapurMahasiswa')

@section('content')
    <div class="form-card">
        <h2>Edit Menu</h2>
        <p class="muted">Perbarui data menu harian DapurMahasiswa.</p>

        <form action="{{ route('admin.menu-items.update', $menuItem) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <label>Nama Menu</label>
            <input type="text" name="name" value="{{ old('name', $menuItem->name) }}" required>

            <label>Deskripsi</label>
            <textarea name="description">{{ old('description', $menuItem->description) }}</textarea>

            <label>Harga</label>
            <input type="number" name="price" value="{{ old('price', $menuItem->price) }}" required>

            <label>Kategori</label>
            <input type="text" name="category" value="{{ old('category', $menuItem->category) }}">

            <label>Tanggal Tersedia</label>
            <input type="date" name="available_date" value="{{ old('available_date', $menuItem->available_date) }}">

            <label>Status Menu</label>
            <select name="is_available" required>
                <option value="1" {{ old('is_available', $menuItem->is_available) == '1' ? 'selected' : '' }}>Tersedia</option>
                <option value="0" {{ old('is_available', $menuItem->is_available) == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
            </select>

            <label>Upload Gambar Baru</label>
            <input type="file" name="image" accept="image/png,image/jpeg,image/jpg,image/webp">
            <p class="muted">Kosongkan jika tidak ingin mengganti gambar.</p>

            @if($menuItem->image_url)
                <div style="margin-top:14px;">
                    <p class="muted">Gambar Saat Ini:</p>
                    <img src="{{ asset('storage/' . $menuItem->image_url) }}" alt="{{ $menuItem->name }}" style="max-width:100%; border-radius:12px;">
                </div>
            @endif

            <div style="margin-top:18px; display:flex; gap:10px;">
                <button type="submit" class="btn">Simpan Perubahan</button>
                <a href="{{ route('admin.menu-items.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
@endsection