@extends('layouts.admin')

@section('title', 'Kelola Menu')

@section('content')
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
                <h1>Kelola Menu Harian</h1>
                <p>
                    Tambahkan, ubah, atau hapus menu harian yang tampil di halaman user DapurMahasiswa.
                </p>
            </div>

            <div class="admin-page-actions">
                <a href="{{ route('admin.menu-items.create') }}" class="btn">
                    Tambah Menu
                </a>

                <a href="{{ route('menu.index') }}" class="btn btn-secondary">
                    Lihat Halaman User
                </a>
            </div>
        </div>
    </div>

    <div class="card" style="margin-bottom:22px;">
        <h2 style="margin-bottom:8px;">Daftar Menu</h2>
        <p class="muted" style="margin:0;">
            Total menu yang tersimpan: <strong>{{ $menus->count() }}</strong>
        </p>
    </div>

    @if($menus->isEmpty())
        <div class="card empty-state">
            <h3>Belum ada menu</h3>
            <p class="muted">
                Silakan tambahkan menu harian pertama untuk DapurMahasiswa.
            </p>

            <a href="{{ route('admin.menu-items.create') }}" class="btn">
                Tambah Menu Sekarang
            </a>
        </div>
    @else
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Menu</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($menus as $menu)
                        <tr>
                            <td>
                                <div class="admin-table-image">
                                    @if($menu->image_url)
                                        <img src="{{ asset('storage/' . $menu->image_url) }}" alt="{{ $menu->name }}">
                                    @else
                                        <span>No image</span>
                                    @endif
                                </div>
                            </td>

                            <td style="min-width:240px;">
                                <p class="admin-item-title">
                                    {{ $menu->name }}
                                </p>

                                <p class="admin-item-desc">
                                    {{ \Illuminate\Support\Str::limit($menu->description ?? 'Tidak ada deskripsi.', 90) }}
                                </p>
                            </td>

                            <td>
                                {{ $menu->category ?? '-' }}
                            </td>

                            <td>
                                @if($menu->available_date)
                                    {{ \Carbon\Carbon::parse($menu->available_date)->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                <span class="admin-price">
                                    Rp{{ number_format($menu->price, 0, ',', '.') }}
                                </span>
                            </td>

                            <td>
                                @if($menu->is_available)
                                    <span class="status">Tersedia</span>
                                @else
                                    <span class="status" style="background:#fee2e2; color:#991b1b;">
                                        Tidak Tersedia
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="admin-action-group">
                                    <a href="{{ route('admin.menu-items.edit', $menu) }}" class="btn btn-secondary">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.menu-items.destroy', $menu) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
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