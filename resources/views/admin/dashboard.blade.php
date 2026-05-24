@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    @php
        $statusLabels = [
            'pending' => 'Pending',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'delivering' => 'Diantar',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        $statusStyles = [
            'pending' => 'background:#fef3c7; color:#92400e;',
            'confirmed' => 'background:#dbeafe; color:#1e40af;',
            'processing' => 'background:#ede9fe; color:#5b21b6;',
            'delivering' => 'background:#ffedd5; color:#9a3412;',
            'completed' => 'background:#dcfce7; color:#166534;',
            'cancelled' => 'background:#fee2e2; color:#991b1b;',
        ];

        $paymentLabels = [
            'cod' => 'COD',
            'qris' => 'QRIS',
        ];

        $paymentStyles = [
            'cod' => 'background:#e0f2fe; color:#075985;',
            'qris' => 'background:#dcfce7; color:#166534;',
        ];
    @endphp

    <style>
        .hero-admin {
            background:
                radial-gradient(circle at top right, rgba(217, 155, 43, 0.16), transparent 28%),
                linear-gradient(135deg, #ffffff 0%, #edf7ef 100%);
            border: 1px solid #eee5d8;
            border-radius: 26px;
            box-shadow: var(--shadow);
            padding: 26px;
            margin-bottom: 24px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 20px;
            align-items: center;
        }

        .hero-admin h1 {
            margin: 0 0 8px;
            color: #102d19;
            font-size: 34px;
            line-height: 1.15;
        }

        .hero-admin p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
            max-width: 780px;
        }

        .hero-admin img {
            width: 110px;
            height: 110px;
            border-radius: 28px;
            object-fit: cover;
            background: #fff;
            padding: 6px;
            border: 1px solid #e4dccf;
            box-shadow: 0 14px 30px rgba(31, 91, 47, 0.14);
        }

        .dashboard-table-card {
            overflow: hidden;
        }

        .dashboard-table-head {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: flex-start;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .dashboard-table-head h2 {
            margin-bottom: 8px;
        }

        .dashboard-order-code {
            margin: 0 0 5px;
            color: #102d19;
            font-weight: 900;
            line-height: 1.4;
        }

        .dashboard-order-meta {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .dashboard-customer-name {
            color: #102d19;
            font-weight: 900;
            line-height: 1.4;
        }

        .dashboard-customer-email {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .dashboard-total {
            color: var(--primary);
            font-weight: 900;
            white-space: nowrap;
        }

        @media (max-width: 620px) {
            .hero-admin {
                grid-template-columns: 1fr;
            }

            .hero-admin h1 {
                font-size: 28px;
            }

            .hero-admin img {
                width: 90px;
                height: 90px;
                border-radius: 24px;
            }

            .dashboard-table-head .btn {
                width: 100%;
            }
        }
    </style>

    <section class="hero-admin">
        <div>
            <h1>Dashboard Admin</h1>
            <p>
                Pantau aktivitas DapurMahasiswa, jumlah menu, paket catering, pesanan hari ini,
                dan pendapatan dari pesanan yang sudah selesai.
            </p>
        </div>

        <img src="{{ asset('images/logo-dapurmahasiswa.jpeg') }}" alt="Logo DapurMahasiswa">
    </section>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Menu</div>
            <div class="stat-value">{{ $totalMenus ?? 0 }}</div>
            <div class="stat-note">{{ $availableMenus ?? 0 }} menu tersedia</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Total Paket</div>
            <div class="stat-value">{{ $totalPackages ?? 0 }}</div>
            <div class="stat-note">{{ $availablePackages ?? 0 }} paket tersedia</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Pesanan Hari Ini</div>
            <div class="stat-value">{{ $todayOrders ?? 0 }}</div>
            <div class="stat-note">{{ $pendingOrders ?? 0 }} pesanan pending</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Pendapatan Selesai</div>
            <div class="stat-value">
                Rp{{ number_format($totalRevenue ?? 0, 0, ',', '.') }}
            </div>
            <div class="stat-note">Dari pesanan berstatus selesai</div>
        </div>
    </div>

    <div class="card dashboard-table-card">
        <div class="dashboard-table-head">
            <div>
                <h2>Pesanan Terbaru</h2>
                <p class="muted" style="margin:0;">
                    Lima pesanan terakhir yang masuk ke sistem DapurMahasiswa.
                </p>
            </div>

            @if(Route::has('admin.orders.index'))
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                    Lihat Semua Pesanan
                </a>
            @endif
        </div>

        @if(($recentOrders ?? collect())->isEmpty())
            <div class="empty-state">
                <h3>Belum ada pesanan</h3>
                <p class="muted">
                    Pesanan terbaru akan tampil di sini setelah user melakukan checkout.
                </p>
            </div>
        @else
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Kode Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($recentOrders as $order)
                            @php
                                $status = $order->status ?? 'pending';
                                $paymentMethod = $order->payment_method ?? '-';
                            @endphp

                            <tr>
                                <td style="min-width:190px;">
                                    <p class="dashboard-order-code">
                                        {{ $order->order_code }}
                                    </p>

                                    <p class="dashboard-order-meta">
                                        {{ $order->created_at->format('d M Y H:i') }}
                                    </p>
                                </td>

                                <td style="min-width:210px;">
                                    <div class="dashboard-customer-name">
                                        {{ $order->user->name ?? 'User tidak ditemukan' }}
                                    </div>

                                    <div class="dashboard-customer-email">
                                        {{ $order->user->email ?? '-' }}
                                    </div>
                                </td>

                                <td>
                                    <span class="dashboard-total">
                                        Rp{{ number_format($order->total, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td>
                                    <span class="status" style="{{ $paymentStyles[$paymentMethod] ?? 'background:#f3f4f6; color:#374151;' }}">
                                        {{ $paymentLabels[$paymentMethod] ?? strtoupper($paymentMethod) }}
                                    </span>
                                </td>

                                <td>
                                    <span class="status" style="{{ $statusStyles[$status] ?? '' }}">
                                        {{ $statusLabels[$status] ?? ucfirst($status) }}
                                    </span>
                                </td>

                                <td>
                                    @if(Route::has('admin.orders.show'))
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary">
                                            Detail
                                        </a>
                                    @else
                                        <span class="muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection