@extends('layouts.app')

@section('title', 'Login - DapurMahasiswa')

@section('content')
    <div class="form-card">
        <h2>Login</h2>
        <p class="muted">Masuk untuk memesan menu DapurMahasiswa.</p>

        <form action="{{ route('login.store') }}" method="POST">
            @csrf

            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit" class="btn" style="margin-top:18px;">Masuk</button>
        </form>

        <p class="muted" style="margin-top:16px;">
            Belum punya akun?
            <a href="{{ route('register') }}" style="color:#0b5d2a; font-weight:bold;">Daftar</a>
        </p>
    </div>
@endsection