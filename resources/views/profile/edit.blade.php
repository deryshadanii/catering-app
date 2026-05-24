@extends('layouts.app')

@section('title', 'Edit Profil - DapurMahasiswa')

@section('content')
    <div class="form-card">
        <h2>Edit Profil</h2>
        <p class="muted">
            Lengkapi nomor HP dan alamat kos agar proses checkout lebih cepat.
        </p>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PATCH')

            <label>Nama</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required>

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>

            <label>Nomor HP</label>
            <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" placeholder="Contoh: 081234567890">

            <label>Alamat Kos</label>
            <textarea name="address" placeholder="Contoh: Jalan Williem Iskandar, Gang ..., dekat UINSU Medan">{{ old('address', auth()->user()->address) }}</textarea>

            <div style="margin-top:18px; display:flex; gap:10px;">
                <button type="submit" class="btn">
                    Simpan Perubahan
                </button>

                <a href="{{ route('profile.show') }}" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection