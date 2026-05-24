@extends('layouts.app')

@section('title', 'Paket Catering - DapurMahasiswa')

@section('content')
    <h1>Paket Catering</h1>
    <p class="muted">Pilih paket mingguan atau bulanan sesuai kebutuhan makan anak kos.</p>

    <div class="filter-card">
        <form action="{{ route('packages.index') }}" method="GET">
            <div class="filter-row">
                <div>
                    <label>Cari Paket</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Contoh: hemat, protein, bulanan">
                </div>

                <div>
                    <label>Tipe Paket</label>
                    <select name="type">
                        <option value="">Semua Tipe</option>
                        <option value="mingguan" {{ request('type') === 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                        <option value="bulanan" {{ request('type') === 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn">
                        Cari
                    </button>

                    <a href="{{ route('packages.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if(request('search') || request('type'))
        <p class="muted">
            Menampilkan hasil pencarian
            @if(request('search'))
                untuk kata kunci <strong>{{ request('search') }}</strong>
            @endif

            @if(request('type'))
                dengan tipe <strong>{{ ucfirst(request('type')) }}</strong>
            @endif
        </p>
    @endif

    @if($packages->isEmpty())
        <div class="card">
            <p>Paket catering tidak ditemukan.</p>
            <a href="{{ route('packages.index') }}" class="btn btn-secondary">
                Lihat Semua Paket
            </a>
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