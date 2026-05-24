@extends('layouts.app')

@section('title', 'DapurMahasiswa - Catering Anak Kos UINSU Medan')

@section('content')
    <section class="hero">
        <div>
            <h1>Makan Enak, Hemat, Sesuai Selera Anak Kos</h1>
            <p>
                DapurMahasiswa membantu mahasiswa sekitar UINSU Medan mendapatkan makanan harian
                dan paket catering yang praktis, sehat, hemat, dan mudah dipesan.
            </p>

            <div style="margin-top:20px;">
                <a href="{{ route('menu.index') }}" class="btn">Lihat Menu</a>
                <a href="{{ route('packages.index') }}" class="btn btn-secondary">Lihat Paket</a>
            </div>
        </div>

        <div class="hero-box">
            <h2>Paket Hemat Anak Kos</h2>
            <p class="muted">Menu harian, paket mingguan, dan paket bulanan untuk mahasiswa sibuk.</p>
            <p class="price">Mulai dari Rp15.000</p>
        </div>
    </section>

    <h2 class="section-title">Menu Hari Ini</h2>

    <div class="grid">
        @foreach($menus as $menu)
            <div class="card">
                @if($menu->image_url)
                    <img src="{{ asset('storage/' . $menu->image_url) }}" alt="{{ $menu->name }}" class="menu-image">
                @endif

                <h3>{{ $menu->name }}</h3>
                <p class="muted">{{ $menu->description }}</p>
                <p class="price">Rp{{ number_format($menu->price, 0, ',', '.') }}</p>

                @auth
                    <form action="{{ route('cart.addMenu', $menu) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn">Tambah ke Keranjang</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn">Login untuk Pesan</a>
                @endauth
            </div>
        @endforeach
    </div>

    <h2 class="section-title">Paket Populer</h2>

    <div class="grid">
        @foreach($packages as $package)
            <div class="card">
                @if($package->image_url)
                    <img src="{{ asset('storage/' . $package->image_url) }}" alt="{{ $package->name }}" class="menu-image">
                @endif

                <h3>{{ $package->name }}</h3>
                <p class="muted">{{ $package->description }}</p>
                <p class="price">Rp{{ number_format($package->price, 0, ',', '.') }}</p>
                <a href="{{ route('packages.show', $package) }}" class="btn">Lihat Paket</a>
            </div>
        @endforeach
    </div>
@endsection