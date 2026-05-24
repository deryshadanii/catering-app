<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin DapurMahasiswa')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6f4;
            color: #1f2937;
        }

        a {
            text-decoration: none;
        }

        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .admin-sidebar {
            width: 250px;
            background: #005f2f;
            color: white;
            padding: 24px 18px;
            flex-shrink: 0;
        }

        .admin-brand {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 6px;
        }

        .admin-subtitle {
            font-size: 13px;
            color: #d1fae5;
            line-height: 1.5;
            margin-bottom: 28px;
        }

        .admin-menu {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .admin-menu a,
        .admin-menu button {
            width: 100%;
            display: block;
            padding: 11px 12px;
            border-radius: 8px;
            color: white;
            background: transparent;
            border: none;
            text-align: left;
            font-size: 15px;
            cursor: pointer;
        }

        .admin-menu a:hover,
        .admin-menu button:hover {
            background: rgba(255,255,255,0.15);
        }

        .admin-menu .active {
            background: white;
            color: #005f2f;
            font-weight: bold;
        }

        .admin-content-wrapper {
            flex: 1;
            min-width: 0;
        }

        .admin-topbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 18px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-topbar-title {
            font-weight: bold;
            font-size: 18px;
        }

        .admin-user {
            font-size: 14px;
            color: #6b7280;
        }

        .admin-content {
            padding: 28px;
        }

        h1 {
            margin-top: 0;
            color: #003f22;
        }

        h2, h3 {
            color: #003f22;
        }

        .muted {
            color: #6b7280;
            line-height: 1.5;
        }

        .btn {
            display: inline-block;
            background: #006b35;
            color: white;
            border: none;
            padding: 10px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn:hover {
            background: #004f27;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
        }

        .btn-secondary:hover {
            background: #d1d5db;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
        }

        .btn-danger:hover {
            background: #b91c1c;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.05);
        }

        .form-card {
            background: white;
            border-radius: 14px;
            padding: 24px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.05);
            max-width: 760px;
        }

        label {
            display: block;
            margin-top: 16px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            vertical-align: top;
        }

        th {
            background: #f9fafb;
            color: #374151;
            font-size: 14px;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            background: #dcfce7;
            color: #166534;
            font-size: 13px;
            font-weight: bold;
        }

        .admin-thumb {
            width: 90px;
            height: 70px;
            object-fit: cover;
            border-radius: 10px;
            display: block;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 18px;
            margin: 22px 0;
        }

        .stat-card {
            background: white;
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 6px 18px rgba(0,0,0,0.05);
        }

        .stat-label {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: #006b35;
        }

.filter-card {
    background: white;
    border-radius: 14px;
    padding: 18px;
    margin: 22px 0;
    box-shadow: 0 6px 18px rgba(0,0,0,0.05);
}

.filter-row {
    display: grid;
    grid-template-columns: 1.5fr 1fr auto;
    gap: 14px;
    align-items: end;
}

.filter-actions {
    display: flex;
    gap: 8px;
    align-items: center;
}

.filter-actions .btn {
    white-space: nowrap;
}

        @media (max-width: 800px) {
            .admin-wrapper {
                flex-direction: column;
            }

            .admin-sidebar {
                width: 100%;
            }

            .admin-menu {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
            }

            .admin-topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .admin-content {
                padding: 18px;
            }

            table {
                min-width: 760px;
            }
            .filter-row {
    grid-template-columns: 1fr;
}

.filter-actions {
    flex-wrap: wrap;
}
        }
        @media print {
    .admin-sidebar,
    .admin-topbar,
    .filter-card,
    .btn {
        display: none !important;
    }

    .admin-wrapper {
        display: block;
    }

    .admin-content {
        padding: 0;
    }

    body {
        background: white;
    }

    .card,
    .stat-card,
    table {
        box-shadow: none;
    }

    table {
        font-size: 12px;
    }
}
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <aside class="admin-sidebar">
            <div class="admin-brand">DapurMahasiswa</div>
            <div class="admin-subtitle">
                Panel admin untuk mengelola menu, paket catering, dan pesanan.
            </div>

            <nav class="admin-menu">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.menu-items.index') }}" class="{{ request()->routeIs('admin.menu-items.*') ? 'active' : '' }}">
                    Kelola Menu
                </a>

                <a href="{{ route('admin.packages.index') }}" class="{{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
                    Kelola Paket
                </a>

                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    Admin Pesanan
                </a>
                <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
    Laporan
</a>

                <a href="{{ route('home') }}">
                    Lihat Website
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </nav>
        </aside>

        <main class="admin-content-wrapper">
            <header class="admin-topbar">
                <div class="admin-topbar-title">
                    @yield('title', 'Admin DapurMahasiswa')
                </div>

                <div class="admin-user">
                    {{ auth()->user()->name ?? 'Admin' }}
                </div>
            </header>

            <section class="admin-content">
                @if(session('success'))
                    <div class="alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-error">
                        <strong>Terjadi kesalahan:</strong>
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </section>
        </main>
    </div>
</body>
</html>