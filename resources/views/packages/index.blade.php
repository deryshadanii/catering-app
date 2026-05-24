@extends('layouts.app')

@section('title', 'Paket Catering - DapurMahasiswa')

@section('content')
    <h1>Paket Catering</h1>
    <p class="muted">Pilih paket mingguan atau bulanan sesuai kebutuhan makan anak kos.</p>

    @if($packages->isEmpty())
        <div class="card">
            <p>Belum ada paket catering yang tersedia.</p>
        </div>
    @else
        <div class="menu-grid">
            @foreach($packages as $package)
                <div class="menu-card">
                    <div class="menu-card-image">
                        @if($package->image_url)
                            <img src="{{ asset('storage/' . $package->image_url) }}" alt="{{ $package->name }}">
                        @else
                            <span>Belum ada gambar</span>
                        @endif
                    </div>

                    <div class="menu-card-body">
                        <h3 class="menu-card-title">{{ $package->name }}</h3>

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
@endsection