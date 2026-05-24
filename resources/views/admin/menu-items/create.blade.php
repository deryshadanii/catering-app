@extends('layouts.admin')

@section('title', 'Tambah Menu')

@section('content')
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
        <h1>Tambah Menu Harian</h1>
        <p>
            Isi data menu yang akan ditampilkan pada halaman Menu Harian user.
        </p>
    </div>

    <form action="{{ route('admin.menu-items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="admin-form-layout">
            <div class="form-card">
                <h2>Informasi Menu</h2>
                <p class="muted">
                    Gunakan nama menu yang jelas dan deskripsi singkat agar user mudah memilih.
                </p>

                <div class="form-grid-2">
                    <div class="full">
                        <label>Nama Menu</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Ayam Geprek Original"
                            required
                        >
                    </div>

                    <div class="full">
                        <label>Deskripsi</label>
                        <textarea
                            name="description"
                            placeholder="Contoh: Nasi, ayam geprek, lalapan, dan sambal."
                        >{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label>Harga</label>
                        <input
                            type="number"
                            name="price"
                            value="{{ old('price') }}"
                            placeholder="Contoh: 18000"
                            required
                        >
                    </div>

                    <div>
                        <label>Kategori</label>
                        <input
                            type="text"
                            name="category"
                            value="{{ old('category') }}"
                            placeholder="Contoh: Ayam"
                        >
                    </div>

                    <div>
                        <label>Tanggal Tersedia</label>
                        <input
                            type="date"
                            name="available_date"
                            value="{{ old('available_date') }}"
                        >
                    </div>

                    <div>
                        <label>Status Menu</label>
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
                        Simpan Menu
                    </button>

                    <a href="{{ route('admin.menu-items.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="card">
                <h2>Gambar Menu</h2>
                <p class="muted">
                    Upload gambar agar tampilan menu lebih menarik.
                </p>

                <label>Upload Gambar</label>
                <input
                    type="file"
                    name="image"
                    accept="image/png,image/jpeg,image/jpg,image/webp"
                    onchange="previewAdminImage(event, 'menuPreview')"
                >

                <p class="muted" style="font-size:13px;">
                    Format: JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                </p>

                <div class="image-preview-box" id="menuPreview">
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