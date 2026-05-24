@extends('layouts.app')

@section('title', 'Login - DapurMahasiswa')

@section('content')
    <style>
        .auth-page {
            min-height: calc(100vh - 250px);
            display: grid;
            grid-template-columns: 1fr 0.9fr;
            gap: 28px;
            align-items: center;
        }

        .auth-hero {
            background:
                radial-gradient(circle at top right, rgba(217, 155, 43, 0.16), transparent 30%),
                linear-gradient(135deg, #ffffff 0%, #edf7ef 100%);
            border: 1px solid #eee5d8;
            border-radius: 30px;
            box-shadow: var(--shadow);
            padding: 36px;
            min-height: 520px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-logo {
            width: 110px;
            height: 110px;
            border-radius: 28px;
            object-fit: cover;
            border: 1px solid #e4dccf;
            background: #fff;
            padding: 6px;
            box-shadow: 0 14px 30px rgba(31, 91, 47, 0.14);
            margin-bottom: 22px;
        }

        .auth-badge {
            display: inline-flex;
            width: fit-content;
            padding: 9px 14px;
            border-radius: 999px;
            background: #fff7e8;
            color: #8a5a10;
            border: 1px solid #f2d8a6;
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 18px;
        }

        .auth-hero h1 {
            margin: 0 0 14px;
            color: #102d19;
            font-size: 44px;
            line-height: 1.12;
        }

        .auth-hero p {
            margin: 0;
            color: var(--muted);
            line-height: 1.8;
            font-size: 16px;
            max-width: 560px;
        }

        .auth-feature-list {
            display: grid;
            gap: 12px;
            margin-top: 26px;
        }

        .auth-feature {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid #eee5d8;
        }

        .auth-feature-icon {
            width: 34px;
            height: 34px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: var(--primary);
            color: #fff;
            font-weight: 900;
            flex: 0 0 auto;
        }

        .auth-feature strong {
            display: block;
            color: #102d19;
            margin-bottom: 3px;
        }

        .auth-feature span {
            color: var(--muted);
            line-height: 1.6;
            font-size: 14px;
        }

        .auth-card {
            background: #fff;
            border: 1px solid #eee5d8;
            border-radius: 26px;
            box-shadow: var(--shadow);
            padding: 30px;
        }

        .auth-card h2 {
            margin: 0 0 8px;
            color: #102d19;
            font-size: 30px;
            line-height: 1.2;
        }

        .auth-card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
        }

        .auth-form {
            margin-top: 22px;
        }

        .auth-password-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            align-items: center;
            margin-top: 16px;
            margin-bottom: 8px;
        }

        .auth-password-row label {
            margin: 0;
        }

        .auth-password-row a {
            color: var(--primary);
            font-size: 14px;
            font-weight: 800;
        }

        .auth-password-row a:hover {
            color: var(--primary-dark);
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-top: 16px;
            color: var(--muted);
            font-size: 14px;
        }

        .remember-row input {
            width: auto;
        }

        .auth-bottom {
            margin-top: 20px;
            padding-top: 18px;
            border-top: 1px solid #eee5d8;
            color: var(--muted);
            line-height: 1.7;
            text-align: center;
        }

        .auth-bottom a {
            color: var(--primary);
            font-weight: 900;
        }

        .auth-bottom a:hover {
            color: var(--primary-dark);
        }

        @media (max-width: 980px) {
            .auth-page {
                grid-template-columns: 1fr;
            }

            .auth-hero {
                min-height: auto;
            }

            .auth-hero h1 {
                font-size: 36px;
            }
        }

        @media (max-width: 600px) {
            .auth-hero,
            .auth-card {
                padding: 22px;
                border-radius: 24px;
            }

            .auth-logo {
                width: 88px;
                height: 88px;
                border-radius: 24px;
            }

            .auth-hero h1 {
                font-size: 30px;
            }

            .auth-card h2 {
                font-size: 26px;
            }

            .auth-password-row {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="auth-page">
        <section class="auth-hero">
            <img
                src="{{ asset('images/logo-dapurmahasiswa.jpeg') }}"
                alt="Logo DapurMahasiswa"
                class="auth-logo"
            >

            <span class="auth-badge">
                Selamat datang
            </span>

            <h1>Masuk dan pesan makanan favoritmu dengan lebih mudah.</h1>

    

            
        </section>

        <section class="auth-card">
            <h2>Login Akun</h2>

            <p>
                Masukkan email dan password yang sudah terdaftar.
            </p>

            <form action="{{ route('login') }}" method="POST" class="auth-form">
                @csrf

                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Contoh: mahasiswa@email.com"
                    required
                    autofocus
                >

                <div class="auth-password-row">
                    <label>Password</label>

                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <input
                    type="password"
                    name="password"
                    placeholder="Masukkan password"
                    required
                >

                <label class="remember-row">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    Ingat saya
                </label>

                <button type="submit" class="btn" style="width:100%; margin-top:20px;">
                    Login
                </button>
            </form>

            @if(Route::has('register'))
                <div class="auth-bottom">
                    Belum punya akun?
                    <a href="{{ route('register') }}">
                        Daftar sekarang
                    </a>
                </div>
            @endif
        </section>
    </div>
@endsection