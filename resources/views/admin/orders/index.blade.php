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
        <div class="grid">
            @foreach($menus as $menu)
                <div class="card">
                    @if($menu->image_url)
                        <img src="{{ asset('storage/' . $menu->image_url) }}" alt="{{ $menu->name }}" style="width:100%; height:170px; object-fit:cover; border-radius:12px; margin-bottom:14px;">
                    @endif

                    <h3>{{ $menu->name }}</h3>

                    <p class="muted">
                        {{ $menu->description }}
                    </p>

                    <p>
                        <strong>Kategori:</strong>
                        {{ $menu->category ?? '-' }}
                    </p>

                    @if($menu->available_date)
                        <p>
                            <strong>Tersedia:</strong>
                            {{ \Carbon\Carbon::parse($menu->available_date)->format('d M Y') }}
                        </p>
                    @endif

                    <p class="price">
                        Rp{{ number_format($menu->price, 0, ',', '.') }}
                    </p>

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
            @endforeach
        </div>
    @endif
@endsection