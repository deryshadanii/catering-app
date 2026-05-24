@extends('layouts.admin')

@section('title', 'Kelola Paket Catering - DapurMahasiswa')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:20px;">
        <div>
            <h1>Kelola Paket Catering</h1>
            <p class="muted">Admin dapat menambah, mengedit, dan menghapus paket catering DapurMahasiswa.</p>
        </div>

        <a href="{{ route('admin.packages.create') }}" class="btn">
            Tambah Paket
        </a>
    </div>

    @if($packages->isEmpty())
        <div class="card">
            <p>Belum ada paket catering.</p>
            <a href="{{ route('admin.packages.create') }}" class="btn">Tambah Paket Pertama</a>
        </div>
    @else
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Paket</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th style="width:190px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($packages as $package)
                        <tr>
                            <td>
                                @if($package->image_url)
                                    <img src="{{ asset('storage/' . $package->image_url) }}" alt="{{ $package->name }}" class="admin-thumb">
                                @else
                                    <span class="muted">Belum ada</span>
                                @endif
                            </td>

                            <td>
                                <strong>{{ $package->name }}</strong>
                                <br>
                                <span class="muted">{{ $package->description ?? '-' }}</span>
                            </td>

                            <td>{{ ucfirst($package->type) }}</td>

                            <td>Rp{{ number_format($package->price, 0, ',', '.') }}</td>

                            <td>
                                @if($package->is_available)
                                    <span class="status">Tersedia</span>
                                @else
                                    <span class="status" style="background:#fee2e2; color:#991b1b;">Tidak Tersedia</span>
                                @endif
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.packages.edit', $package) }}" class="btn btn-secondary">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus paket ini?')">
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