@extends('layouts.admin')

@section('title', 'Edit Paket Catering - DapurMahasiswa')

@section('content')
    <div class="form-card">
        <h2>Edit Paket Catering</h2>
        <p class="muted">Perbarui data paket catering DapurMahasiswa.</p>

        <form action="{{ route('admin.packages.update', $mealPackage) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <label>Nama Paket</label>
            <input type="text" name="name" value="{{ old('name', $mealPackage->name) }}" required>

            <label>Tipe Paket</label>
            <select name="type" required>
                <option value="mingguan" {{ old('type', $mealPackage->type) === 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                <option value="bulanan" {{ old('type', $mealPackage->type) === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
            </select>

            <label>Deskripsi</label>
            <textarea name="description">{{ old('description', $mealPackage->description) }}</textarea>

            <label>Harga</label>
            <input type="number" name="price" value="{{ old('price', $mealPackage->price) }}" required>

            <label>Keuntungan Paket</label>
            <textarea name="benefits">{{ old('benefits', $mealPackage->benefits) }}</textarea>

            <label>Status Paket</label>
            <select name="is_available" required>
                <option value="1" {{ old('is_available', $mealPackage->is_available) == '1' ? 'selected' : '' }}>Tersedia</option>
                <option value="0" {{ old('is_available', $mealPackage->is_available) == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
            </select>

            <label>Upload Gambar Baru</label>
            <input type="file" name="image" accept="image/png,image/jpeg,image/jpg,image/webp">
            <p class="muted">Kosongkan jika tidak ingin mengganti gambar.</p>

            @if($mealPackage->image_url)
                <div style="margin-top:14px;">
                    <p class="muted">Gambar Saat Ini:</p>
                    <img src="{{ asset('storage/' . $mealPackage->image_url) }}" alt="{{ $mealPackage->name }}" style="max-width:100%; border-radius:12px;">
                </div>
            @endif

            <div style="margin-top:18px; display:flex; gap:10px;">
                <button type="submit" class="btn">Simpan Perubahan</button>
                <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
@endsection