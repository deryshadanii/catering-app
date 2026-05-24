@extends('layouts.app')

@section('title', 'Daftar Akun - DapurMahasiswa')

@section('content')
    <style>
        .auth-page {
            min-height: calc(100vh - 250px);
            display: grid;
            grid-template-columns: 0.9fr 1fr;
            gap: 28px;
            align-items: center;
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

        .auth-form-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 0;
        }

        .auth-hero {
            background:
                radial-gradient(circle at top right, rgba(217, 155, 43, 0.16), transparent 30%),
                linear-gradient(135deg, #ffffff 0%, #edf7ef 100%);
            border: 1px solid #eee5d8;
            border-radius: 30px;
            box-shadow: var(--shadow);
            padding: 36px;
            min-height: 560px;
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

        .auth-benefits {
            display: grid;
            gap: 12px;
            margin-top: 26px;
        }

        .auth-benefit {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 14px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid #eee5d8;
        }

        .auth-benefit-icon {
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

        .auth-benefit strong {
            display: block;
            color: #102d19;
            margin-bottom: 3px;
        }

        .auth-benefit span {
            color: var(--muted);
            line-height: 1.6;
            font-size: 14px;
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

        .password-hint {
            margin-top: 8px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        @media (max-width: 980px) {
            .auth-page {
                grid-template-columns: 1fr;
            }

            .auth-hero {
                min-height: auto;
                order: -1;
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
        }
    </style>

    <div class="auth-page">
        <section class="auth-card">
            <h2>Daftar Akun</h2>

            <p>
                Buat akun untuk mulai memesan menu harian dan paket catering dari DapurMahasiswa.
            </p>

            <form action="{{ route('register') }}" method="POST" class="auth-form">
                @csrf

                <div class="auth-form-grid">
                    <div>
                        <label>Nama Lengkap</label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Contoh: Riska Anggraini"
                            required
                            autofocus
                        >
                    </div>

                    <div>
                        <label>Email</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="Contoh: mahasiswa@email.com"
                            required
                        >
                    </div>

                    <div>
                        <label>Password</label>
                        <input
                            type="password"
                            name="password"
                            placeholder="Minimal 8 karakter"
                            required
                        >

                        <div class="password-hint">
                            Gunakan password yang mudah kamu ingat, tetapi tidak mudah ditebak orang lain.
                        </div>
                    </div>

                    <div>
                        <label>Konfirmasi Password</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            required
                        >
                    </div>
                </div>

                <button type="submit" class="btn" style="width:100%; margin-top:22px;">
                    Daftar Sekarang
                </button>
            </form>

            <div class="auth-bottom">
                Sudah punya akun?
                <a href="{{ route('login') }}">
                    Login di sini
                </a>
            </div>
        </section>

        <section class="auth-hero">
            <img
                src="{{ asset('images/logo-dapurmahasiswa.jpeg') }}"
                alt="Logo DapurMahasiswa"
                class="auth-logo"
            >

            <span class="auth-badge">
                Selamat Bergabung
            </span>

            <h1>Pesan catering anak kos jadi lebih praktis dan murah.</h1>

            <p>
                Dengan akun DapurMahasiswa, kamu bisa menyimpan profil, mengisi alamat lebih cepat,
                memilih menu harian, membeli paket catering, dan memantau status pesanan.
            </p>

            
            </div>
        </section>
    </div>
@endsection