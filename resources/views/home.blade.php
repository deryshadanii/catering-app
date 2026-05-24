@extends('layouts.app')

@section('title', 'Beranda - DapurMahasiswa')

@section('content')
    @php
        $homeMenus = $menus ?? collect();
        $homePackages = $packages ?? collect();
    @endphp

    <section class="hero">
        <div>
            <span class="hero-badge">
                Catering anak kampus sekitar UINSU Medan
            </span>

            <h1>Makan enak, hemat, dan tanpa ribet untuk anak kos.</h1>

            <p>
                DapurMahasiswa membantu mahasiswa mendapatkan makanan harian dan paket catering
                yang praktis, terjangkau, dan mudah dipesan dari sekitar kampus.
            </p>

            <div class="hero-actions">
                <a href="{{ route('menu.index') }}" class="btn">
                    Lihat Menu Hari Ini
                </a>

                <a href="{{ route('packages.index') }}" class="btn btn-secondary">
                    Lihat Paket Catering
                </a>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-logo-card">
                <img
                    src="{{ asset('images/logo-dapurmahasiswa.jpeg') }}"
                    alt="Logo DapurMahasiswa"
                >
            </div>
        </div>
    </section>

    <section class="section">
        <div class="feature-grid">
            <div class="feature-card">
                <h3>Hemat untuk anak kos</h3>
                <p>
                    Harga menu dibuat ramah untuk mahasiswa yang ingin makan teratur tanpa boros.
                </p>
            </div>

            <div class="feature-card">
                <h3>Menu harian fleksibel</h3>
                <p>
                    User bisa memilih menu harian sesuai selera dan kebutuhan makan.
                </p>
            </div>

            <div class="feature-card">
                <h3>Paket mingguan dan bulanan</h3>
                <p>
                    Cocok untuk mahasiswa yang ingin makan lebih terjadwal setiap minggu atau bulan.
                </p>
            </div>

            <div class="feature-card">
                <h3>Pemesanan mudah</h3>
                <p>
                    Pesanan, checkout, pembayaran, dan tracking dapat dilakukan melalui website.
                </p>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-head">
            <div>
                <h2 class="section-title">Menu Hari Ini</h2>
                <p class="section-subtitle">
                    Pilihan menu harian yang bisa langsung kamu pesan.
                </p>
            </div>

            <a href="{{ route('menu.index') }}" class="btn btn-secondary">
                Lihat Semua
            </a>
        </div>

        @if($homeMenus->isEmpty())
            <div class="card empty-state">
                <h3>Menu belum tersedia</h3>
                <p class="muted">
                    Admin belum menambahkan menu harian.
                </p>
            </div>
        @else
            <div class="menu-grid">
                @foreach($homeMenus as $menu)
                    <div class="menu-card">
                        <div class="menu-card-image">
                            @if($menu->image_url)
                                <img src="{{ asset('storage/' . $menu->image_url) }}" alt="{{ $menu->name }}">
                            @else
                                <span>Belum ada gambar</span>
                            @endif
                        </div>

                        <div class="menu-card-body">
                            <h3 class="menu-card-title">
                                {{ $menu->name }}
                            </h3>

                            <p class="menu-card-description">
                                {{ $menu->description ?? 'Tidak ada deskripsi menu.' }}
                            </p>

                            <p class="menu-card-price">
                                Rp{{ number_format($menu->price, 0, ',', '.') }}
                            </p>

                            <div class="menu-card-action">
                                <a href="{{ route('menu.index') }}" class="btn">
                                    Pilih Menu
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section class="section">
        <div class="section-head">
            <div>
                <h2 class="section-title">Paket Catering</h2>
                <p class="section-subtitle">
                    Pilihan paket mingguan dan bulanan untuk makan lebih teratur.
                </p>
            </div>

            <a href="{{ route('packages.index') }}" class="btn btn-secondary">
                Lihat Semua Paket
            </a>
        </div>

        @if($homePackages->isEmpty())
            <div class="card empty-state">
                <h3>Paket belum tersedia</h3>
                <p class="muted">
                    Admin belum menambahkan paket catering.
                </p>
            </div>
        @else
            <div class="menu-grid">
                @foreach($homePackages as $package)
                    <div class="menu-card">
                        <div class="menu-card-image">
                            @if($package->image_url)
                                <img src="{{ asset('storage/' . $package->image_url) }}" alt="{{ $package->name }}">
                            @else
                                <span>Belum ada gambar</span>
                            @endif
                        </div>

                        <div class="menu-card-body">
                            <h3 class="menu-card-title">
                                {{ $package->name }}
                            </h3>

                            <p class="menu-card-description">
                                {{ $package->description ?? 'Tidak ada deskripsi paket.' }}
                            </p>

                            <p class="menu-card-info">
                                <strong>Tipe:</strong>
                                {{ ucfirst($package->type) }}
                            </p>

                            <p class="menu-card-price">
                                Rp{{ number_format($package->price, 0, ',', '.') }}
                            </p>

                            <div class="menu-card-action">
                                <a href="{{ route('packages.show', $package) }}" class="btn">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section class="section">
        <div class="card">
            <h2>Mulai pesan makananmu sekarang</h2>
            <p class="muted">
                Pilih menu harian atau paket catering, masukkan ke keranjang, lalu checkout dengan COD atau QRIS.
            </p>

            <div class="inline-actions" style="margin-top:16px;">
                <a href="{{ route('menu.index') }}" class="btn">
                    Pesan Menu
                </a>

                <a href="{{ route('packages.index') }}" class="btn btn-secondary">
                    Pilih Paket
                </a>
            </div>
        </div>
    </section>
@endsection