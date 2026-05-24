@extends('layouts.app')

@section('title', 'Kelola Menu - DapurMahasiswa')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:20px;">
        <div>
            <h1>Kelola Menu</h1>
            <p class="muted">Admin dapat menambah, mengedit, dan menghapus menu harian DapurMahasiswa.</p>
        </div>

        <a href="{{ route('admin.menu-items.create') }}" class="btn">
            Tambah Menu
        </a>
    </div>

    @if($menus->isEmpty())
        <div class="card">
            <p>Belum ada menu yang tersedia.</p>
            <a href="{{ route('admin.menu-items.create') }}" class="btn">Tambah Menu Pertama</a>
        </div>
    @else
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Tanggal Tersedia</th>
                        <th>Status</th>
                        <th style="width:190px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($menus as $menu)
                        <tr>
                            <td>
                                @if($menu->image_url)
                                    <img src="{{ asset('storage/' . $menu->image_url) }}" alt="{{ $menu->name }}" class="admin-thumb">
                                @else
                                    <span class="muted">Belum ada</span>
                                @endif
                            </td>

                            <td>
                                <strong>{{ $menu->name }}</strong>
                                <br>
                                <span class="muted">{{ $menu->description ?? '-' }}</span>
                            </td>

                            <td>{{ $menu->category ?? '-' }}</td>

                            <td>Rp{{ number_format($menu->price, 0, ',', '.') }}</td>

                            <td>
                                @if($menu->available_date)
                                    {{ \Carbon\Carbon::parse($menu->available_date)->format('d M Y') }}
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                @if($menu->is_available)
                                    <span class="status">Tersedia</span>
                                @else
                                    <span class="status" style="background:#fee2e2; color:#991b1b;">Tidak Tersedia</span>
                                @endif
                            </td>

                            <td>
                                <div class="action-buttons">
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