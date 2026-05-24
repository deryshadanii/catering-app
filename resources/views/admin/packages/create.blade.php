@extends('layouts.admin')

@section('title', 'Tambah Paket')

@section('content')
    @php
        $packageStoreRoute = Route::has('admin.meal-packages.store')
            ? route('admin.meal-packages.store')
            : route('admin.packages.store');

        $packageIndexRoute = Route::has('admin.meal-packages.index')
            ? route('admin.meal-packages.index')
            : route('admin.packages.index');
    @endphp

    <style>
        .admin-form-layout {
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 24px;
            align-items: start;
        }

        .image-preview-box {
            width: 100%;
            min-height: 260px;
            border-radius: 22px;
            border: 1px dashed #cfc7ba;
            background: #fbfaf7;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: var(--muted);
            text-align: center;
            padding: 18px;
        }

        .image-preview-box img {
            width: 100%;
            height: 260px;
            object-fit: cover;
            border-radius: 18px;
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .form-grid-2 .full {
            grid-column: 1 / -1;
        }

        @media (max-width: 920px) {
            .admin-form-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 620px) {
            .form-grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="page-header">
        <h1>Tambah Paket Catering</h1>
        <p>
            Buat paket catering mingguan atau bulanan untuk user DapurMahasiswa.
        </p>
    </div>

    <form action="{{ $packageStoreRoute }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="admin-form-layout">
            <div class="form-card">
                <h2>Informasi Paket</h2>
                <p class="muted">
                    Isi detail paket dengan jelas agar user mudah memahami isi dan keunggulannya.
                </p>

                <div class="form-grid-2">
                    <div class="full">
                        <label>Nama Paket</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Paket Hemat Mingguan"
                            required
                        >
                    </div>

                    <div>
                        <label>Tipe Paket</label>
                        <select name="type" required>
                            <option value="mingguan" {{ old('type') === 'mingguan' ? 'selected' : '' }}>
                                Mingguan
                            </option>
                            <option value="bulanan" {{ old('type') === 'bulanan' ? 'selected' : '' }}>
                                Bulanan
                            </option>
                        </select>
                    </div>

                    <div>
                        <label>Harga</label>
                        <input
                            type="number"
                            name="price"
                            value="{{ old('price') }}"
                            placeholder="Contoh: 120000"
                            required
                        >
                    </div>

                    <div class="full">
                        <label>Deskripsi</label>
                        <textarea
                            name="description"
                            placeholder="Contoh: Paket makan siang selama 7 hari untuk mahasiswa."
                        >{{ old('description') }}</textarea>
                    </div>

                    <div class="full">
                        <label>Keunggulan Paket</label>
                        <textarea
                            name="benefits"
                            placeholder="Contoh:
Gratis ongkir area dekat kampus
Menu berbeda setiap hari
Cocok untuk anak kos"
                        >{{ old('benefits') }}</textarea>
                    </div>

                    <div>
                        <label>Status Paket</label>
                        <select name="is_available" required>
                            <option value="1" {{ old('is_available', '1') == '1' ? 'selected' : '' }}>
                                Tersedia
                            </option>
                            <option value="0" {{ old('is_available') == '0' ? 'selected' : '' }}>
                                Tidak Tersedia
                            </option>
                        </select>
                    </div>
                </div>

                <div class="inline-actions" style="margin-top:22px;">
                    <button type="submit" class="btn">
                        Simpan Paket
                    </button>

                    <a href="{{ $packageIndexRoute }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="card">
                <h2>Gambar Paket</h2>
                <p class="muted">
                    Upload gambar paket agar tampilan katalog lebih menarik.
                </p>

                <label>Upload Gambar</label>
                <input
                    type="file"
                    name="image"
                    accept="image/png,image/jpeg,image/jpg,image/webp"
                    onchange="previewAdminImage(event, 'packagePreview')"
                >

                <p class="muted" style="font-size:13px;">
                    Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                </p>

                <div class="image-preview-box" id="packagePreview">
                    Preview gambar akan muncul di sini.
                </div>
            </div>
        </div>
    </form>

    <script>
        function previewAdminImage(event, previewId) {
            const preview = document.getElementById(previewId);
            const file = event.target.files[0];

            if (!preview || !file) {
                return;
            }

            const reader = new FileReader();

            reader.onload = function(e) {
                preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview Gambar">';
            };

            reader.readAsDataURL(file);
        }
    </script>
@endsection