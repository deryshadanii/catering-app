@extends('layouts.app')

@section('title', 'Tambah Menu - DapurMahasiswa')

@section('content')
    <div class="form-card">
        <h2>Tambah Menu</h2>
        <p class="muted">Isi data menu harian yang akan tampil di website DapurMahasiswa.</p>

        <form action="{{ route('admin.menu-items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label>Nama Menu</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Ayam Geprek Original" required>

            <label>Deskripsi</label>
            <textarea name="description" placeholder="Contoh: Nasi, ayam geprek, lalapan, dan sambal.">{{ old('description') }}</textarea>

            <label>Harga</label>
            <input type="number" name="price" value="{{ old('price') }}" placeholder="Contoh: 18000" required>

            <label>Kategori</label>
            <input type="text" name="category" value="{{ old('category') }}" placeholder="Contoh: Ayam, Ikan, Daging, Vegetarian">

            <label>Tanggal Tersedia</label>
            <input type="date" name="available_date" value="{{ old('available_date') }}">

            <label>Status Menu</label>
            <select name="is_available" required>
                <option value="1" {{ old('is_available', '1') == '1' ? 'selected' : '' }}>Tersedia</option>
                <option value="0" {{ old('is_available') == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
            </select>

            <label>Upload Gambar Menu</label>
            <input type="file" name="image" accept="image/png,image/jpeg,image/jpg,image/webp">
            <p class="muted">Format: JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.</p>

            <div style="margin-top:18px; display:flex; gap:10px;">
                <button type="submit" class="btn">Simpan Menu</button>
                <a href="{{ route('admin.menu-items.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
@endsection