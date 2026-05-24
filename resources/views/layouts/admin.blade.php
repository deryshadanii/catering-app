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
            --warning-soft: #fef3c7;
            --warning-text: #92400e;
            --blue-soft: #dbeafe;
            --blue-text: #1e40af;
            --purple-soft: #ede9fe;
            --purple-text: #5b21b6;
            --orange-soft: #ffedd5;
            --orange-text: #9a3412;
            --shadow: 0 14px 34px rgba(31, 91, 47, 0.08);
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            max-width: 100%;
            display: block;
        }

        .admin-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 280px 1fr;
            transition: 0.25s ease;
        }

        .admin-sidebar {
            position: sticky;
            top: 0;
            height: 100vh;
            background: #102d19;
            color: #fff;
            padding: 22px;
            overflow-y: auto;
            transition: 0.25s ease;
            z-index: 1002;
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.14);
            margin-bottom: 22px;
        }

        .admin-brand img {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            object-fit: cover;
            background: #fff;
            padding: 4px;
            flex: 0 0 auto;
        }

        .admin-brand-title {
            font-size: 18px;
            font-weight: 900;
            line-height: 1.1;
        }

        .admin-brand-subtitle {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.72);
            margin-top: 4px;
            line-height: 1.4;
        }

        .admin-nav {
            display: grid;
            gap: 8px;
        }

        .admin-nav-label {
            margin: 18px 0 8px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: rgba(255, 255, 255, 0.52);
            font-weight: 900;
        }

        .admin-nav a,
        .admin-nav button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 13px;
            border-radius: 14px;
            border: none;
            background: transparent;
            color: rgba(255, 255, 255, 0.82);
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            text-align: left;
            transition: 0.2s ease;
        }

        .admin-nav a:hover,
        .admin-nav button:hover,
        .admin-nav a.active {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
        }

        .admin-nav a.active {
            box-shadow: inset 4px 0 0 var(--accent);
        }

        .admin-nav-icon {
            width: 28px;
            height: 28px;
            border-radius: 10px;
            display: grid;
            place-items: center;
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            font-size: 12px;
            font-weight: 900;
            flex: 0 0 auto;
        }

        .admin-nav-text {
            white-space: nowrap;
        }

        .admin-main {
            min-width: 0;
            display: flex;
            flex-direction: column;
        }

        .admin-topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            min-height: 76px;
            background: rgba(255, 255, 255, 0.96);
            border-bottom: 1px solid var(--border);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 0 28px;
        }

        .admin-topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .admin-toggle {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            border: 1px solid #e6e0d6;
            background: #fff;
            color: #102d19;
            font-size: 20px;
            font-weight: 900;
            cursor: pointer;
            display: grid;
            place-items: center;
            box-shadow: 0 8px 18px rgba(31, 91, 47, 0.08);
            transition: 0.2s ease;
            flex: 0 0 auto;
        }

        .admin-toggle:hover {
            background: var(--primary-soft);
            color: var(--primary);
        }

        .admin-topbar-title {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 0;
        }

        .admin-topbar-title strong {
            color: #102d19;
            font-size: 20px;
        }

        .admin-topbar-title span {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.4;
        }

        .admin-user {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 0 0 auto;
        }

        .admin-avatar {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: var(--primary);
            color: #fff;
            font-weight: 900;
        }

        .admin-user-info {
            text-align: right;
        }

        .admin-user-info strong {
            display: block;
            color: #102d19;
            font-size: 14px;
        }

        .admin-user-info span {
            color: var(--muted);
            font-size: 12px;
        }

        .admin-content {
            padding: 28px;
        }

        .admin-overlay {
            display: none;
        }

        .page-header {
            margin-bottom: 24px;
        }

        .page-header h1 {
            margin: 0 0 8px;
            color: #102d19;
            font-size: 36px;
            line-height: 1.15;
        }

        .page-header p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
            max-width: 760px;
        }

        .card,
        .form-card,
        .filter-card,
        .stat-card {
            background: #fff;
            border: 1px solid #eee5d8;
            border-radius: 22px;
            box-shadow: var(--shadow);
        }

        .card,
        .stat-card {
            padding: 22px;
        }

        .form-card,
        .filter-card {
            padding: 22px;
        }

        .card h1,
        .card h2,
        .card h3,
        .form-card h2 {
            color: #102d19;
            margin-top: 0;
        }

        .muted {
            color: var(--muted);
            line-height: 1.7;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 8px;
        }

        .stat-value {
            color: var(--primary);
            font-size: 30px;
            font-weight: 900;
            line-height: 1.2;
        }

        .stat-note {
            margin-top: 8px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
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

        .filter-row {
            display: grid;
            grid-template-columns: minmax(220px, 1.5fr) minmax(180px, 1fr) auto;
            gap: 14px;
            align-items: end;
        }

        .filter-actions,
        .inline-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
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

        .empty-state {
            padding: 34px 22px;
            text-align: center;
        }

        .empty-state h3 {
            margin: 0 0 8px;
            color: #102d19;
        }

        body.sidebar-collapsed .admin-shell {
            grid-template-columns: 92px 1fr;
        }

        body.sidebar-collapsed .admin-sidebar {
            padding: 22px 14px;
        }

        body.sidebar-collapsed .admin-brand {
            justify-content: center;
            padding-bottom: 18px;
        }

        body.sidebar-collapsed .admin-brand > div {
            display: none;
        }

        body.sidebar-collapsed .admin-nav-label {
            display: none;
        }

        body.sidebar-collapsed .admin-nav {
            gap: 10px;
        }

        body.sidebar-collapsed .admin-nav a,
        body.sidebar-collapsed .admin-nav button {
            justify-content: center;
            padding: 12px;
        }

        body.sidebar-collapsed .admin-nav-text {
            display: none;
        }

        body.sidebar-collapsed .admin-nav-icon {
            margin: 0;
        }

        @media (max-width: 1100px) {
            .admin-shell {
                grid-template-columns: 1fr;
            }

            .admin-sidebar {
                position: fixed;
                left: 0;
                top: 0;
                width: 280px;
                height: 100vh;
                transform: translateX(-100%);
                box-shadow: 20px 0 40px rgba(0, 0, 0, 0.18);
            }

            body.mobile-sidebar-open .admin-sidebar {
                transform: translateX(0);
            }

            .admin-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.38);
                z-index: 1001;
            }

            body.mobile-sidebar-open .admin-overlay {
                display: block;
            }

            body.sidebar-collapsed .admin-shell {
                grid-template-columns: 1fr;
            }

            body.sidebar-collapsed .admin-sidebar {
                width: 280px;
                padding: 22px;
            }

            body.sidebar-collapsed .admin-brand {
                justify-content: flex-start;
            }

            body.sidebar-collapsed .admin-brand > div {
                display: block;
            }

            body.sidebar-collapsed .admin-nav-label {
                display: block;
            }

            body.sidebar-collapsed .admin-nav a,
            body.sidebar-collapsed .admin-nav button {
                justify-content: flex-start;
                padding: 12px 13px;
            }

            body.sidebar-collapsed .admin-nav-text {
                display: inline;
            }

            .admin-topbar {
                position: static;
            }

            .stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 760px) {
            .admin-content {
                padding: 20px;
            }

            .admin-topbar {
                padding: 16px 20px;
                align-items: flex-start;
                flex-direction: column;
            }

            .admin-topbar-left {
                width: 100%;
                align-items: flex-start;
            }

            .admin-user-info {
                text-align: left;
            }

            .filter-row {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .page-header h1 {
                font-size: 30px;
            }

            th,
            td {
                padding: 13px 12px;
                font-size: 14px;
            }
        }

        @media (max-width: 560px) {
            .admin-user {
                width: 100%;
            }

            .admin-topbar-title strong {
                font-size: 18px;
            }

            .admin-topbar-title span {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a href="{{ route('admin.dashboard') }}" class="admin-brand">
                <img src="{{ asset('images/logo-dapurmahasiswa.jpeg') }}" alt="Logo DapurMahasiswa">

                <div>
                    <div class="admin-brand-title">DapurMahasiswa</div>
                    <div class="admin-brand-subtitle">Admin Panel</div>
                </div>
            </a>

            <nav class="admin-nav">
                
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span class="admin-nav-icon">D</span>
                    <span class="admin-nav-text">Dashboard</span>
                </a>

                <div class="admin-nav-label">Kelola Data</div>

                @if(Route::has('admin.menu-items.index'))
                    <a href="{{ route('admin.menu-items.index') }}" class="{{ request()->routeIs('admin.menu-items.*') ? 'active' : '' }}">
                        <span class="admin-nav-icon">M</span>
                        <span class="admin-nav-text">Kelola Menu</span>
                    </a>
                @endif

                @if(Route::has('admin.meal-packages.index'))
    <a href="{{ route('admin.meal-packages.index') }}" class="{{ request()->routeIs('admin.meal-packages.*') ? 'active' : '' }}">
        <span class="admin-nav-icon">P</span>
        <span class="admin-nav-text">Kelola Paket</span>
    </a>
@elseif(Route::has('admin.packages.index'))
    <a href="{{ route('admin.packages.index') }}" class="{{ request()->routeIs('admin.packages.*') ? 'active' : '' }}">
        <span class="admin-nav-icon">P</span>
        <span class="admin-nav-text">Kelola Paket</span>
    </a>
@endif

                @if(Route::has('admin.orders.index'))
                    <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <span class="admin-nav-icon">K</span>
                        <span class="admin-nav-text">Kelola Pesanan</span>
                    </a>
                @endif

                @if(Route::has('admin.reports.index'))
    <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
        <span class="admin-nav-icon">R</span>
        <span class="admin-nav-text">Laporan</span>
    </a>
@endif

                <div class="admin-nav-label">Navigasi</div>

                <a href="{{ route('home') }}">
                    <span class="admin-nav-icon">W</span>
                    <span class="admin-nav-text">Lihat Website</span>
                </a>

                @if(Route::has('profile.show'))
                    <a href="{{ route('profile.show') }}">
                        <span class="admin-nav-icon">U</span>
                        <span class="admin-nav-text">Profil Saya</span>
                    </a>
                @endif

                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf

                    <button type="submit">
                        <span class="admin-nav-icon">L</span>
                        <span class="admin-nav-text">Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        <div class="admin-overlay" onclick="closeMobileSidebar()"></div>

        <main class="admin-main">
            <header class="admin-topbar">
                <div class="admin-topbar-left">
                    <button type="button" class="admin-toggle" onclick="toggleAdminSidebar()" aria-label="Toggle Sidebar">
                        ☰
                    </button>

                    <div class="admin-topbar-title">
                        <strong>@yield('title', 'Admin DapurMahasiswa')</strong>
                        <span>Kelola menu, paket, dan pesanan pelanggan.</span>
                    </div>
                </div>

                @auth
                    <div class="admin-user">
                        <div class="admin-user-info">
                            <strong>{{ auth()->user()->name }}</strong>
                            <span>{{ auth()->user()->email }}</span>
                        </div>

                        <div class="admin-avatar">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                    </div>
                @endauth
            </header>

            <section class="admin-content">
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
            </section>
        </main>
    </div>

    <script>
        function isMobileAdmin() {
            return window.innerWidth <= 1100;
        }

        function toggleAdminSidebar() {
            if (isMobileAdmin()) {
                document.body.classList.toggle('mobile-sidebar-open');
                return;
            }

            document.body.classList.toggle('sidebar-collapsed');

            if (document.body.classList.contains('sidebar-collapsed')) {
                localStorage.setItem('adminSidebar', 'collapsed');
            } else {
                localStorage.setItem('adminSidebar', 'expanded');
            }
        }

        function closeMobileSidebar() {
            document.body.classList.remove('mobile-sidebar-open');
        }

        document.addEventListener('DOMContentLoaded', function () {
            const sidebarState = localStorage.getItem('adminSidebar');

            if (sidebarState === 'collapsed' && !isMobileAdmin()) {
                document.body.classList.add('sidebar-collapsed');
            }

            const sidebarLinks = document.querySelectorAll('.admin-sidebar a');

            sidebarLinks.forEach(function (link) {
                link.addEventListener('click', function () {
                    if (isMobileAdmin()) {
                        closeMobileSidebar();
                    }
                });
            });
        });

        window.addEventListener('resize', function () {
            if (isMobileAdmin()) {
                document.body.classList.remove('sidebar-collapsed');
            } else {
                document.body.classList.remove('mobile-sidebar-open');

                const sidebarState = localStorage.getItem('adminSidebar');

                if (sidebarState === 'collapsed') {
                    document.body.classList.add('sidebar-collapsed');
                }
            }
        });
    </script>
</body>
</html>