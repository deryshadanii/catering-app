@extends('layouts.admin')

@section('title', 'Edit Paket')

@section('content')
    @php
        $packageData = $package ?? $mealPackage ?? null;

        $packageUpdateRouteName = Route::has('admin.meal-packages.update')
            ? 'admin.meal-packages.update'
            : 'admin.packages.update';

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
        <h1>Edit Paket Catering</h1>
        <p>
            Perbarui data paket catering yang tampil di halaman user.
        </p>
    </div>

    <form action="{{ route($packageUpdateRouteName, $packageData) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="admin-form-layout">
            <div class="form-card">
                <h2>Informasi Paket</h2>
                <p class="muted">
                    Pastikan nama, tipe, harga, dan status paket sudah sesuai.
                </p>

                <div class="form-grid-2">
                    <div class="full">
                        <label>Nama Paket</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $packageData->name) }}"
                            required
                        >
                    </div>

                    <div>
                        <label>Tipe Paket</label>
                        <select name="type" required>
                            <option value="mingguan" {{ old('type', $packageData->type) === 'mingguan' ? 'selected' : '' }}>
                                Mingguan
                            </option>
                            <option value="bulanan" {{ old('type', $packageData->type) === 'bulanan' ? 'selected' : '' }}>
                                Bulanan
                            </option>
                        </select>
                    </div>

                    <div>
                        <label>Harga</label>
                        <input
                            type="number"
                            name="price"
                            value="{{ old('price', $packageData->price) }}"
                            required
                        >
                    </div>

                    <div class="full">
                        <label>Deskripsi</label>
                        <textarea name="description">{{ old('description', $packageData->description) }}</textarea>
                    </div>

                    <div class="full">
                        <label>Keunggulan Paket</label>
                        <textarea name="benefits">{{ old('benefits', $packageData->benefits) }}</textarea>
                    </div>

                    <div>
                        <label>Status Paket</label>
                        <select name="is_available" required>
                            <option value="1" {{ old('is_available', $packageData->is_available) == '1' ? 'selected' : '' }}>
                                Tersedia
                            </option>
                            <option value="0" {{ old('is_available', $packageData->is_available) == '0' ? 'selected' : '' }}>
                                Tidak Tersedia
                            </option>
                        </select>
                    </div>
                </div>

                <div class="inline-actions" style="margin-top:22px;">
                    <button type="submit" class="btn">
                        Simpan Perubahan
                    </button>

                    <a href="{{ $packageIndexRoute }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="card">
                <h2>Gambar Paket</h2>
                <p class="muted">
                    Upload gambar baru jika ingin mengganti gambar lama.
                </p>

                <label>Upload Gambar Baru</label>
                <input
                    type="file"
                    name="image"
                    accept="image/png,image/jpeg,image/jpg,image/webp"
                    onchange="previewAdminImage(event, 'packagePreview')"
                >

                <p class="muted" style="font-size:13px;">
                    Kosongkan jika tidak ingin mengganti gambar.
                </p>

                <div class="image-preview-box" id="packagePreview">
                    @if($packageData->image_url)
                        <img src="{{ asset('storage/' . $packageData->image_url) }}" alt="{{ $packageData->name }}">
                    @else
                        Preview gambar akan muncul di sini.
                    @endif
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