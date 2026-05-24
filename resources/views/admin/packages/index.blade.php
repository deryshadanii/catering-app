@extends('layouts.admin')

@section('title', 'Kelola Paket')

@section('content')
    @php
        $packageItems = $packages ?? $mealPackages ?? collect();

        $packageIndexRoute = Route::has('admin.meal-packages.index')
            ? route('admin.meal-packages.index')
            : route('admin.packages.index');

        $packageCreateRoute = Route::has('admin.meal-packages.create')
            ? route('admin.meal-packages.create')
            : route('admin.packages.create');

        $packageEditRouteName = Route::has('admin.meal-packages.edit')
            ? 'admin.meal-packages.edit'
            : 'admin.packages.edit';

        $packageDestroyRouteName = Route::has('admin.meal-packages.destroy')
            ? 'admin.meal-packages.destroy'
            : 'admin.packages.destroy';
    @endphp

    <style>
        .admin-page-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .admin-table-image {
            width: 78px;
            height: 64px;
            border-radius: 14px;
            background: #f3efe8;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            font-size: 11px;
            text-align: center;
        }

        .admin-table-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .admin-item-title {
            margin: 0 0 5px;
            color: #102d19;
            font-weight: 900;
            line-height: 1.4;
        }

        .admin-item-desc {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .admin-action-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .admin-action-group form {
            margin: 0;
        }

        .admin-price {
            color: var(--primary);
            font-weight: 900;
            white-space: nowrap;
        }

        @media (max-width: 760px) {
            .admin-page-actions .btn {
                width: 100%;
            }
        }
    </style>

    <div class="page-header">
        <div style="display:flex; justify-content:space-between; gap:18px; align-items:flex-start; flex-wrap:wrap;">
            <div>
                <h1>Kelola Paket Catering</h1>
                <p>
                    Tambahkan, ubah, atau hapus paket mingguan dan bulanan yang tampil di halaman user.
                </p>
            </div>

            <div class="admin-page-actions">
                <a href="{{ $packageCreateRoute }}" class="btn">
                    Tambah Paket
                </a>

                <a href="{{ route('packages.index') }}" class="btn btn-secondary">
                    Lihat Halaman User
                </a>
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom:22px;">
        <h2 style="margin-bottom:8px;">Daftar Paket</h2>
        <p class="muted" style="margin:0;">
            Total paket yang tersimpan: <strong>{{ $packageItems->count() }}</strong>
        </p>
    </div>

    @if($packageItems->isEmpty())
        <div class="card empty-state">
            <h3>Belum ada paket</h3>
            <p class="muted">
                Silakan tambahkan paket catering pertama untuk DapurMahasiswa.
            </p>

            <a href="{{ $packageCreateRoute }}" class="btn">
                Tambah Paket Sekarang
            </a>
        </div>
    @else
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Paket</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($packageItems as $package)
                        <tr>
                            <td>
                                <div class="admin-table-image">
                                    @if($package->image_url)
                                        <img src="{{ asset('storage/' . $package->image_url) }}" alt="{{ $package->name }}">
                                    @else
                                        <span>No image</span>
                                    @endif
                                </div>
                            </td>

                            <td style="min-width:260px;">
                                <p class="admin-item-title">
                                    {{ $package->name }}
                                </p>

                                <p class="admin-item-desc">
                                    {{ \Illuminate\Support\Str::limit($package->description ?? 'Tidak ada deskripsi.', 90) }}
                                </p>

                                @if($package->benefits)
                                    <p class="admin-item-desc" style="margin-top:6px;">
                                        Keunggulan: {{ \Illuminate\Support\Str::limit($package->benefits, 80) }}
                                    </p>
                                @endif
                            </td>

                            <td>
                                <span class="status" style="background:#e0f2fe; color:#075985;">
                                    {{ ucfirst($package->type) }}
                                </span>
                            </td>

                            <td>
                                <span class="admin-price">
                                    Rp{{ number_format($package->price, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                @if($package->is_available)
                                    <span class="status">Tersedia</span>
                                @else
                                    <span class="status" style="background:#fee2e2; color:#991b1b;">
                                        Tidak Tersedia
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="admin-action-group">
                                    <a href="{{ route($packageEditRouteName, $package) }}" class="btn btn-secondary">
                                        Edit
                                    </a>

                                    <form action="{{ route($packageDestroyRouteName, $package) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection