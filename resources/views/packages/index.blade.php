@extends('layouts.app')

@section('title', 'Paket Catering - DapurMahasiswa')

@section('content')
    <h1>Paket Catering</h1>
    <p class="muted">Pilih paket mingguan atau bulanan sesuai kebutuhan makan anak kos.</p>

    <div class="grid">
        @foreach($packages as $package)
            <div class="card">
                <h3>{{ $package->name }}</h3>
                <p class="muted">{{ $package->description }}</p>
                <p>Tipe: {{ ucfirst($package->type) }}</p>
                <p class="price">Rp{{ number_format($package->price, 0, ',', '.') }}</p>
                <a href="{{ route('packages.show', $package) }}" class="btn">Lihat Detail</a>
            </div>
        @endforeach
    </div>
@endsection