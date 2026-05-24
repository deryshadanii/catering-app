@extends('layouts.app')

@section('title', $package->name . ' - DapurMahasiswa')

@section('content')
    <div class="card">
        <h1>{{ $package->name }}</h1>
        <p class="muted">{{ $package->description }}</p>

        <p><strong>Tipe Paket:</strong> {{ ucfirst($package->type) }}</p>
        <p class="price">Rp{{ number_format($package->price, 0, ',', '.') }}</p>

        <h3>Keuntungan Paket</h3>
        <p style="white-space: pre-line;">{{ $package->benefits }}</p>

        @auth
            <form action="{{ route('cart.addPackage', $package) }}" method="POST">
                @csrf

                <label>Catatan Preferensi</label>
                <textarea name="preference_note" placeholder="Contoh: sambal sedikit, sayur banyak, tidak pakai telur.">{{ old('preference_note') }}</textarea>

                <button type="submit" class="btn" style="margin-top:18px;">Pilih Paket</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn">Login untuk Pilih Paket</a>
        @endauth
    </div>
@endsection