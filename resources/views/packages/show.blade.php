@extends('layouts.app')

@section('title', $package->name . ' - DapurMahasiswa')

@section('content')
    <div class="page-header">
        <h1>{{ $package->name }}</h1>
        <p>
            Detail paket catering {{ strtolower($package->type) }} dari DapurMahasiswa.
            Cocok untuk mahasiswa yang ingin makan lebih praktis dan terjadwal.
        </p>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 0.85fr; gap:24px; align-items:start;" class="package-detail-grid">
        <div class="card" style="padding:0; overflow:hidden;">
            <div style="height:380px; background:#f3efe8; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                @if($package->image_url)
                    <img
                        src="{{ asset('storage/' . $package->image_url) }}"
                        alt="{{ $package->name }}"
                        style="width:100%; height:100%; object-fit:cover;"
                    >
                @else
                    <span class="muted">Belum ada gambar paket</span>
                @endif
            </div>

            <div style="padding:24px;">
                <h2 style="margin-top:0;">Tentang Paket</h2>

                <p class="muted">
                    {{ $package->description ?? 'Belum ada deskripsi untuk paket ini.' }}
                </p>

                <div style="display:flex; gap:10px; flex-wrap:wrap; margin-top:18px;">
                    <span class="status" style="background:#e0f2fe; color:#075985;">
                        Paket {{ ucfirst($package->type) }}
                    </span>

                    @if($package->is_available)
                        <span class="status">
                            Tersedia
                        </span>
                    @else
                        <span class="status" style="background:#fee2e2; color:#991b1b;">
                            Tidak Tersedia
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <h2 style="margin-bottom:8px;">Ringkasan Paket</h2>

            <p class="muted" style="margin-top:0;">
                Periksa detail paket sebelum menambahkannya ke keranjang.
            </p>

            <div style="margin-top:20px;">
                <p style="margin:0 0 8px;">
                    <strong>Nama Paket</strong>
                </p>
                <p class="muted" style="margin-top:0;">
                    {{ $package->name }}
                </p>

                <p style="margin:18px 0 8px;">
                    <strong>Tipe Paket</strong>
                </p>
                <p class="muted" style="margin-top:0;">
                    {{ ucfirst($package->type) }}
                </p>

                <p style="margin:18px 0 8px;">
                    <strong>Harga Paket</strong>
                </p>
                <p style="margin:0; color:var(--primary); font-size:30px; font-weight:900;">
                    Rp{{ number_format($package->price, 0, ',', '.') }}
                </p>
            </div>

            @if($package->benefits)
                <div style="margin-top:24px; padding:18px; border-radius:18px; background:#fbfaf7; border:1px solid #eee5d8;">
                    <h3 style="margin-top:0;">Keunggulan Paket</h3>

                    <ul style="margin:0; padding-left:20px; color:var(--muted); line-height:1.8;">
                        @foreach(preg_split('/\r\n|\r|\n/', $package->benefits) as $benefit)
                            @if(trim($benefit) !== '')
                                <li>{{ trim($benefit) }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="margin-top:24px;">
                @if($package->is_available)
                    @auth
                        @if(Route::has('cart.addPackage'))
                            <form action="{{ route('cart.addPackage', $package) }}" method="POST">
                                @csrf

                                <button type="submit" class="btn" style="width:100%;">
                                    Tambah Paket ke Keranjang
                                </button>
                            </form>
                        @else
                            <a href="{{ route('packages.index') }}" class="btn" style="width:100%;">
                                Pilih Paket
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn" style="width:100%;">
                            Login untuk Pesan Paket
                        </a>
                    @endauth
                @else
                    <button type="button" class="btn btn-secondary" style="width:100%;" disabled>
                        Paket Tidak Tersedia
                    </button>
                @endif

                <a href="{{ route('packages.index') }}" class="btn btn-secondary" style="width:100%; margin-top:10px;">
                    Kembali ke Paket
                </a>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 900px) {
            .package-detail-grid {
                grid-template-columns: 1fr !important;
            }
        }
    </style>
@endsection