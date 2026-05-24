<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'DapurMahasiswa')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --primary: #1f5b2f;
            --primary-dark: #154221;
            --primary-soft: #edf7ef;
            --accent: #d99b2b;
            --bg: #f8f4ec;
            --surface: #ffffff;
            --surface-soft: #fbfaf7;
            --text: #172033;
            --muted: #667085;
            --border: #e6e0d6;
            --danger: #dc2626;
            --success-soft: #dcfce7;
            --success-text: #166534;
            --shadow: 0 14px 34px rgba(31, 91, 47, 0.08);
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        img {
            max-width: 100%;
            display: block;
        }

        .container {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
        }

        .topbar {
            background: rgba(255, 255, 255, 0.97);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(10px);
        }

        .navbar {
            min-height: 82px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 260px;
        }

        .brand-logo {
            width: 58px;
            height: 58px;
            border-radius: 18px;
            object-fit: cover;
            border: 1px solid #e4dccf;
            background: #fff;
            padding: 4px;
            box-shadow: 0 8px 18px rgba(31, 91, 47, 0.12);
        }

        .brand-text {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .brand-title {
            font-size: 24px;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
        }

        .brand-subtitle {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.3;
        }

        .nav-links {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 8px;
        }

        .nav-links a,
        .nav-links button {
            padding: 10px 13px;
            border-radius: 999px;
            border: none;
            background: transparent;
            color: #263238;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .nav-links a:hover,
        .nav-links button:hover {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .nav-links .nav-highlight {
            background: var(--primary);
            color: #fff;
        }

        .nav-links .nav-highlight:hover {
            background: var(--primary-dark);
            color: #fff;
        }

        .page {
            min-height: calc(100vh - 170px);
            padding: 34px 0 56px;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .page-header h1 {
            margin: 0 0 8px;
            font-size: 38px;
            color: #102d19;
            line-height: 1.15;
        }

        .page-header p {
            margin: 0;
            max-width: 760px;
            color: var(--muted);
            line-height: 1.7;
        }

        .hero {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 30px;
            align-items: center;
            background:
                radial-gradient(circle at top right, rgba(217, 155, 43, 0.14), transparent 28%),
                linear-gradient(135deg, #ffffff 0%, #edf7ef 100%);
            border: 1px solid #e8ddcd;
            border-radius: 32px;
            padding: 38px;
            box-shadow: var(--shadow);
            margin-bottom: 34px;
            overflow: hidden;
        }

        .hero-badge {
            display: inline-flex;
            width: fit-content;
            padding: 9px 14px;
            border-radius: 999px;
            background: #fff7e8;
            color: #8a5a10;
            border: 1px solid #f2d8a6;
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 16px;
        }

        .hero h1 {
            margin: 0 0 14px;
            font-size: 48px;
            line-height: 1.12;
            color: #102d19;
        }

        .hero p {
            margin: 0 0 24px;
            color: var(--muted);
            line-height: 1.8;
            font-size: 16px;
        }

        .hero-actions,
        .inline-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
        }

        .hero-visual {
            background: #fff;
            border-radius: 28px;
            padding: 20px;
            border: 1px solid #eee5d8;
            box-shadow: 0 18px 34px rgba(31, 91, 47, 0.09);
        }

        .hero-logo-card {
            display: grid;
            place-items: center;
            padding: 20px;
            min-height: 330px;
            background: #fbfaf7;
            border-radius: 22px;
            border: 1px solid #eee5d8;
        }

        .hero-logo-card img {
            width: min(340px, 100%);
            border-radius: 22px;
            object-fit: cover;
        }

        .section {
            margin-bottom: 34px;
        }

        .section-head {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 18px;
        }

        .section-title {
            margin: 0 0 8px;
            font-size: 30px;
            color: #102d19;
            line-height: 1.2;
        }

        .section-subtitle,
        .muted {
            color: var(--muted);
            line-height: 1.7;
        }

        .section-subtitle {
            margin: 0;
        }

        .feature-grid,
        .stats-grid {
            display: grid;
            gap: 20px;
        }

        .feature-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .stats-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .menu-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            align-items: stretch;
        }

        .card,
        .form-card,
        .feature-card,
        .stat-card,
        .menu-card,
        .filter-card {
            background: var(--surface);
            border: 1px solid #eee5d8;
            border-radius: 20px;
            box-shadow: var(--shadow);
        }

        .card,
        .feature-card,
        .stat-card {
            padding: 22px;
        }

        .form-card {
            padding: 26px;
            max-width: 820px;
        }

        .card h1,
        .card h2,
        .card h3,
        .feature-card h3,
        .form-card h2 {
            color: #102d19;
            margin-top: 0;
        }

        .card p,
        .feature-card p {
            line-height: 1.7;
        }

        .stat-label {
            font-size: 14px;
            color: var(--muted);
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 30px;
            color: var(--primary);
            font-weight: 800;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 42px;
            padding: 11px 17px;
            border-radius: 13px;
            border: none;
            background: var(--primary);
            color: #fff;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            transition: 0.2s ease;
            text-align: center;
        }

        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #eef2ef;
            color: var(--text);
        }

        .btn-secondary:hover {
            background: #dfe7e1;
            color: var(--text);
        }

        .btn-danger {
            background: var(--danger);
            color: #fff;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .filter-card {
            padding: 18px;
            margin-bottom: 24px;
        }

        .filter-row {
            display: grid;
            grid-template-columns: minmax(220px, 1.5fr) minmax(180px, 1fr) auto;
            gap: 14px;
            align-items: end;
        }

        .filter-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        label {
            display: block;
            margin-top: 16px;
            margin-bottom: 8px;
            color: #102d19;
            font-size: 14px;
            font-weight: 800;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d9d2c6;
            border-radius: 13px;
            background: #fff;
            color: var(--text);
            font-size: 14px;
        }

        textarea {
            min-height: 118px;
            resize: vertical;
        }

        input:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #82b28d;
            box-shadow: 0 0 0 4px rgba(31, 91, 47, 0.09);
        }

        .menu-card {
            overflow: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }

        .menu-card-image {
            width: 100%;
            height: 170px;
            background: #f3efe8;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            overflow: hidden;
        }

        .menu-card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .menu-card-body {
            padding: 16px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .menu-card-title {
            margin: 0 0 10px;
            color: #102d19;
            font-size: 19px;
            line-height: 1.3;
            min-height: 50px;
        }

        .menu-card-description {
            margin: 0 0 12px;
            color: var(--muted);
            line-height: 1.6;
            font-size: 14px;
            min-height: 68px;
        }

        .menu-card-info {
            margin: 0 0 8px;
            line-height: 1.5;
            font-size: 14px;
        }

        .menu-card-price {
            margin: 12px 0 14px;
            color: var(--primary);
            font-size: 20px;
            font-weight: 900;
        }

        .menu-card-action {
            margin-top: auto;
        }

        .menu-card-action .btn,
        .menu-card-action form,
        .menu-card-action button {
            width: 100%;
        }

        .menu-card-action form {
            margin: 0;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid #eee5d8;
            box-shadow: var(--shadow);
        }

        th,
        td {
            padding: 15px 14px;
            text-align: left;
            vertical-align: top;
            border-bottom: 1px solid #ece5da;
            line-height: 1.6;
        }

        th {
            background: #fbfaf7;
            color: #344054;
            font-size: 14px;
            white-space: nowrap;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .status {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            padding: 7px 12px;
            border-radius: 999px;
            background: var(--success-soft);
            color: var(--success-text);
            font-size: 13px;
            font-weight: 800;
            white-space: nowrap;
        }

        .alert-success,
        .alert-error {
            padding: 14px 16px;
            border-radius: 14px;
            margin-bottom: 18px;
            line-height: 1.6;
        }

        .alert-success {
            background: var(--success-soft);
            color: var(--success-text);
            border: 1px solid #bbf7d0;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .payment-box,
        .qris-box {
            margin-top: 16px;
            padding: 18px;
            background: var(--surface-soft);
            border: 1px solid #eee5d8;
            border-radius: 20px;
        }

        .qris-image {
            width: 260px;
            max-width: 100%;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            background: #fff;
            padding: 10px;
        }

        .empty-state {
            padding: 34px 22px;
            text-align: center;
        }

        .empty-state h3 {
            margin: 0 0 8px;
            color: #102d19;
        }

        .footer {
            background: #fff;
            border-top: 1px solid var(--border);
        }

        .footer-inner {
            padding: 24px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .footer-logo {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid #e4dccf;
        }

        @media (max-width: 1100px) {
            .menu-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .feature-grid,
            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 980px) {
            .hero {
                grid-template-columns: 1fr;
                padding: 28px;
            }

            .hero h1 {
                font-size: 38px;
            }

            .page-header h1 {
                font-size: 34px;
            }
        }

        @media (max-width: 760px) {
            .navbar {
                flex-direction: column;
                align-items: flex-start;
                padding: 16px 0;
            }

            .brand {
                min-width: 0;
            }

            .nav-links {
                width: 100%;
                justify-content: flex-start;
            }

            .filter-row {
                grid-template-columns: 1fr;
            }

            .menu-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .footer-inner {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (max-width: 560px) {
            .container {
                width: min(100% - 24px, 1180px);
            }

            .page {
                padding: 24px 0 42px;
            }

            .brand-logo {
                width: 50px;
                height: 50px;
                border-radius: 15px;
            }

            .brand-title {
                font-size: 21px;
            }

            .brand-subtitle {
                font-size: 11px;
            }

            .nav-links a,
            .nav-links button {
                padding: 9px 11px;
                font-size: 13px;
            }

            .hero {
                padding: 22px;
                border-radius: 24px;
            }

            .hero h1,
            .page-header h1 {
                font-size: 30px;
            }

            .section-title {
                font-size: 25px;
            }

            .section-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .menu-grid,
            .feature-grid,
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .menu-card-image {
                height: 190px;
            }

            th,
            td {
                padding: 13px 12px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <header class="topbar">
        <div class="container navbar">
            <a href="{{ route('home') }}" class="brand">
                <img
                    src="{{ asset('images/logo-dapurmahasiswa.jpeg') }}"
                    alt="Logo DapurMahasiswa"
                    class="brand-logo"
                >

                <span class="brand-text">
                    <span class="brand-title">DapurMahasiswa</span>
                    <span class="brand-subtitle">Catering anak kampus, enak, hemat, tanpa ribet</span>
                </span>
            </a>

            <nav class="nav-links">
                <a href="{{ route('home') }}">Beranda</a>
                <a href="{{ route('menu.index') }}">Menu Harian</a>
                <a href="{{ route('packages.index') }}">Paket</a>

                @auth
                    <a href="{{ route('cart.index') }}">Keranjang</a>
                    <a href="{{ route('orders.index') }}">Pesanan</a>
                    <a href="{{ route('profile.show') }}">Profil</a>

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-highlight">Dashboard Admin</a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>

                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="nav-highlight">Daftar</a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <main class="page">
        <div class="container">
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert-error">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    <strong>Terjadi kesalahan:</strong>

                    <ul style="margin:10px 0 0 18px; padding:0;">
                        @foreach($errors->all() as $error)
                            <li style="margin-bottom:6px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <div class="container footer-inner">
            <div class="footer-brand">
                <img
                    src="{{ asset('images/logo-dapurmahasiswa.jpeg') }}"
                    alt="Logo DapurMahasiswa"
                    class="footer-logo"
                >

                <div>
                    <strong>DapurMahasiswa</strong>
                    <br>
                    Catering anak kampus sekitar UINSU Medan.
                </div>
            </div>

            <div>
                © 2026 DapurMahasiswa. Enak, hemat, tanpa ribet.
            </div>
        </div>
    </footer>
</body>
</html>