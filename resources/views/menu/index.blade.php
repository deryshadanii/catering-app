@extends('layouts.app')

@section('title', 'Menu Harian - DapurMahasiswa')

@section('content')
    <h1>Menu Harian</h1>
    <p class="muted">Pilih menu makan harian yang tersedia hari ini.</p>

    @if($menus->isEmpty())
        <div class="card">
            <p>Belum ada menu yang tersedia.</p>
        </div>
    @else
        <div class="menu-grid">
            @foreach($menus as $menu)
                <div class="menu-card">
                    <div class="menu-card-image">
                        @if($menu->image_url)
                            <img src="{{ asset('storage/' . $menu->image_url) }}" alt="{{ $menu->name }}">
                        @else
                            <span>Belum ada gambar</span>
                        @endif
                    </div>

                    <div class="menu-card-body">
                        <h3 class="menu-card-title">{{ $menu->name }}</h3>

                        <p class="menu-card-description">
                            {{ $menu->description ?? 'Tidak ada deskripsi menu.' }}
                        </p>

                        <p class="menu-card-info">
                            <strong>Kategori:</strong>
                            {{ $menu->category ?? '-' }}
                        </p>

                        <p class="menu-card-info">
                            <strong>Tersedia:</strong>
                            @if($menu->available_date)
                                {{ \Carbon\Carbon::parse($menu->available_date)->format('d M Y') }}
                            @else
                                -
                            @endif
                        </p>

                        <p class="menu-card-price">
                            Rp{{ number_format($menu->price, 0, ',', '.') }}
                        </p>

                        <div class="menu-card-action">
                            @auth
                                <form action="{{ route('cart.addMenu', $menu) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn">
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn">
                                    Login untuk Pesan
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection