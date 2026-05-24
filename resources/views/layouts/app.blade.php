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

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7f3ea;
            color: #1f2933;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .navbar {
            background: #0b5d2a;
            color: white;
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-weight: bold;
            font-size: 22px;
        }

        .nav-links {
            display: flex;
            gap: 18px;
            align-items: center;
        }

        .nav-links a,
        .nav-links button {
            color: white;
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .hero {
            background: #fff;
            border-radius: 18px;
            padding: 40px;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            gap: 30px;
            align-items: center;
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
        }

        .hero h1 {
            font-size: 42px;
            margin: 0 0 14px;
            color: #0b3d20;
        }

        .hero p {
            font-size: 17px;
            color: #52616b;
            line-height: 1.6;
        }

        .hero-box {
            background: #edf7ed;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
        }

        .btn {
            display: inline-block;
            background: #0b5d2a;
            color: white;
            border: none;
            padding: 11px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-secondary {
            background: #e8f5e9;
            color: #0b5d2a;
            border: 1px solid #0b5d2a;
        }

        .btn-danger {
            background: #b91c1c;
        }

        .section-title {
            margin-top: 36px;
            margin-bottom: 16px;
            font-size: 24px;
            color: #0b3d20;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 18px;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 18px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.05);
        }

        .card h3 {
            margin-top: 0;
            color: #0b3d20;
        }

        .price {
            font-weight: bold;
            color: #0b5d2a;
            font-size: 18px;
        }

        .muted {
            color: #6b7280;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
        }

        .form-card {
            background: white;
            max-width: 520px;
            margin: 0 auto;
            padding: 26px;
            border-radius: 14px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.05);
        }

        label {
            display: block;
            margin-top: 14px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 11px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }

        textarea {
            min-height: 90px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }

        th,
        td {
            padding: 13px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #e8f5e9;
            color: #0b3d20;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            background: #e8f5e9;
            color: #0b5d2a;
            font-size: 13px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            padding: 28px;
            color: #6b7280;
        }

        @media (max-width: 700px) {
            .navbar {
                flex-direction: column;
                gap: 12px;
                padding: 16px;
            }

            .hero {
                grid-template-columns: 1fr;
                padding: 26px;
            }

            .hero h1 {
                font-size: 32px;
            }

            .nav-links {
                flex-wrap: wrap;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="{{ route('home') }}" class="brand">DapurMahasiswa</a>

        <div class="nav-links">
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('menu.index') }}">Menu Harian</a>
            <a href="{{ route('packages.index') }}">Paket</a>

            @auth
                <a href="{{ route('cart.index') }}">Keranjang</a>
                <a href="{{ route('orders.index') }}">Pesanan</a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.orders.index') }}">Admin</a>
                @endif

                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}">Daftar</a>
            @endauth
        </div>
    </nav>

    <main class="container">
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <ul style="margin:0; padding-left:18px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        &copy; {{ date('Y') }} DapurMahasiswa. Catering hemat untuk anak kos sekitar UINSU Medan.
    </footer>
</body>
</html>