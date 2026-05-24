@extends('layouts.app')

@section('title', 'Daftar - DapurMahasiswa')

@section('content')
    <div class="form-card">
        <h2>Daftar Akun</h2>
        <p class="muted">Buat akun untuk memesan catering anak kos.</p>

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <label>Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" required>

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>

            <label>No. HP</label>
            <input type="text" name="phone" value="{{ old('phone') }}">

            <label>Alamat Kos</label>
            <textarea name="address">{{ old('address') }}</textarea>

            <label>Password</label>
            <input type="password" name="password" required>

            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required>

            <button type="submit" class="btn" style="margin-top:18px;">Daftar</button>
        </form>
    </div>
@endsection