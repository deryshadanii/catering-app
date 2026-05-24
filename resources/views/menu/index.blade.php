@extends('layouts.app')

@section('title', 'Menu Harian - DapurMahasiswa')

@section('content')
    <h1>Menu Harian</h1>
    <p class="muted">Pilih menu makan harian yang tersedia hari ini.</p>

    <div class="grid">
        @foreach($menus as $menu)
            <div class="card">
                <h3>{{ $menu->name }}</h3>
                <p class="muted">{{ $menu->description }}</p>
                <p>Kategori: {{ $menu->category }}</p>
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
@endsection