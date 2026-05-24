@extends('layouts.admin')

@section('title', 'Tambah Paket Catering - DapurMahasiswa')

@section('content')
    <div class="form-card">
        <h2>Tambah Paket Catering</h2>
        <p class="muted">Isi data paket catering mingguan atau bulanan.</p>

        <form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label>Nama Paket</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Paket A - Seimbang" required>

            <label>Tipe Paket</label>
            <select name="type" required>
                <option value="mingguan" {{ old('type') === 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                <option value="bulanan" {{ old('type') === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
            </select>

            <label>Deskripsi</label>
            <textarea name="description" placeholder="Contoh: Paket hemat untuk anak kos yang ingin makan teratur.">{{ old('description') }}</textarea>

            <label>Harga</label>
            <input type="number" name="price" value="{{ old('price') }}" placeholder="Contoh: 105000" required>

            <label>Keuntungan Paket</label>
            <textarea name="benefits" placeholder="Contoh:
Ikan 3x seminggu
Sayur setiap hari
Nasi + lauk + sayur">{{ old('benefits') }}</textarea>

            <label>Status Paket</label>
            <select name="is_available" required>
                <option value="1" {{ old('is_available', '1') == '1' ? 'selected' : '' }}>Tersedia</option>
                <option value="0" {{ old('is_available') == '0' ? 'selected' : '' }}>Tidak Tersedia</option>
            </select>

            <label>Upload Gambar Paket</label>
            <input type="file" name="image" accept="image/png,image/jpeg,image/jpg,image/webp">
            <p class="muted">Format: JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.</p>

            <div style="margin-top:18px; display:flex; gap:10px;">
                <button type="submit" class="btn">Simpan Paket</button>
                <a href="{{ route('admin.packages.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
@endsection