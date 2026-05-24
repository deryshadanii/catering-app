@extends('layouts.admin')

@section('title', 'Laporan Penjualan')

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
        .report-hero {
            background:
                radial-gradient(circle at top right, rgba(217, 155, 43, 0.16), transparent 28%),
                linear-gradient(135deg, #ffffff 0%, #edf7ef 100%);
            border: 1px solid #eee5d8;
            border-radius: 26px;
            box-shadow: var(--shadow);
            padding: 26px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            gap: 20px;
            align-items: center;
        }

        .report-hero h1 {
            margin: 0 0 8px;
            color: #102d19;
            font-size: 34px;
            line-height: 1.15;
        }

        .report-hero p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
            max-width: 720px;
        }

        .report-hero-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .report-summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }

        .report-summary-card {
            background: #fff;
            border: 1px solid #eee5d8;
            border-radius: 20px;
            box-shadow: var(--shadow);
            padding: 18px;
        }

        .report-summary-label {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 8px;
            line-height: 1.5;
        }

        .report-summary-value {
            color: var(--primary);
            font-size: 30px;
            font-weight: 900;
            line-height: 1.2;
        }

        .report-summary-note {
            margin-top: 8px;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .report-filter-row {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr)) auto;
            gap: 14px;
            align-items: end;
        }

        .report-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: 22px;
            align-items: start;
        }

        .report-side {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            position: static;
        }

        .top-item-list {
            display: grid;
            gap: 12px;
            margin-top: 14px;
        }

        .top-item {
            padding: 14px;
            border-radius: 16px;
            background: #fbfaf7;
            border: 1px solid #eee5d8;
        }

        .top-item-name {
            margin: 0 0 6px;
            color: #102d19;
            font-weight: 900;
            line-height: 1.4;
        }

        .top-item-meta {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .report-order-code {
            margin: 0 0 5px;
            color: #102d19;
            font-weight: 900;
            line-height: 1.4;
        }

        .report-order-meta {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .report-customer {
            color: #102d19;
            font-weight: 900;
            line-height: 1.4;
        }

        .report-customer-email {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .report-total {
            color: var(--primary);
            font-weight: 900;
            white-space: nowrap;
        }

        @media (max-width: 1180px) {
            .report-filter-row {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .report-side {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 860px) {
            .report-hero {
                align-items: flex-start;
                flex-direction: column;
            }

            .report-hero-actions {
                justify-content: flex-start;
            }

            .report-summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 620px) {
            .report-filter-row,
            .report-summary-grid,
            .report-side {
                grid-template-columns: 1fr;
            }

            .report-hero h1 {
                font-size: 28px;
            }

            .report-hero-actions,
            .report-hero-actions .btn {
                width: 100%;
            }
        }
    </style>

    <section class="report-hero">
        <div>
            <h1>Laporan Penjualan</h1>
            <p>
                Pantau rekap pesanan, pendapatan selesai, metode pembayaran, dan item terlaris
                berdasarkan periode laporan yang dipilih.
            </p>
        </div>

        <div class="report-hero-actions">
            <a href="{{ route('admin.reports.export', request()->query()) }}" class="btn">
                Export CSV
            </a>

            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                Dashboard
            </a>
        </div>
    </section>

    <div class="report-summary-grid">
        <div class="report-summary-card">
            <div class="report-summary-label">Total Pesanan</div>
            <div class="report-summary-value">
                {{ $summary['total_orders'] ?? 0 }}
            </div>
            <div class="report-summary-note">
                Semua pesanan pada filter aktif
            </div>
        </div>

        <div class="report-summary-card">
            <div class="report-summary-label">Pesanan Selesai</div>
            <div class="report-summary-value">
                {{ $summary['completed_orders'] ?? 0 }}
            </div>
            <div class="report-summary-note">
                Pesanan dengan status selesai
            </div>
        </div>

        <div class="report-summary-card">
            <div class="report-summary-label">Pendapatan Selesai</div>
            <div class="report-summary-value">
                Rp{{ number_format($summary['total_revenue'] ?? 0, 0, ',', '.') }}
            </div>
            <div class="report-summary-note">
                Dihitung dari pesanan selesai
            </div>
        </div>

        <div class="report-summary-card">
            <div class="report-summary-label">Total Nilai Pesanan</div>
            <div class="report-summary-value">
                Rp{{ number_format($summary['gross_total'] ?? 0, 0, ',', '.') }}
            </div>
            <div class="report-summary-note">
                Semua status pesanan
            </div>
        </div>
    </div>

    <div class="filter-card">
        <form action="{{ route('admin.reports.index') }}" method="GET">
            <div class="report-filter-row">
                <div>
                    <label>Tanggal Mulai</label>
                    <input
                        type="date"
                        name="start_date"
                        value="{{ request('start_date') }}"
                    >
                </div>

                <div>
                    <label>Tanggal Akhir</label>
                    <input
                        type="date"
                        name="end_date"
                        value="{{ request('end_date') }}"
                    >
                </div>

                <div>
                    <label>Status</label>
                    <select name="status">
                        <option value="">Semua Status</option>

                        @foreach($statusLabels as $statusValue => $statusText)
                            <option value="{{ $statusValue }}" {{ request('status') === $statusValue ? 'selected' : '' }}>
                                {{ $statusText }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label>Pembayaran</label>
                    <select name="payment_method">
                        <option value="">Semua Pembayaran</option>

                        <option value="cod" {{ request('payment_method') === 'cod' ? 'selected' : '' }}>
                            COD
                        </option>

                        <option value="qris" {{ request('payment_method') === 'qris' ? 'selected' : '' }}>
                            QRIS
                        </option>
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn">
                        Terapkan
                    </button>

                    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="report-layout">
        <div class="card">
            <div style="display:flex; justify-content:space-between; gap:16px; align-items:flex-start; flex-wrap:wrap; margin-bottom:18px;">
                <div>
                    <h2 style="margin-bottom:8px;">Data Pesanan</h2>
                    <p class="muted" style="margin:0;">
                        Daftar pesanan berdasarkan filter laporan yang sedang aktif.
                    </p>
                </div>

                <span class="status" style="background:#fff7e8; color:#8a5a10;">
                    {{ $orders->total() ?? 0 }} data
                </span>
            </div>

            @if($orders->isEmpty())
                <div class="empty-state">
                    <h3>Data laporan tidak ditemukan</h3>
                    <p class="muted">
                        Belum ada pesanan pada periode atau filter yang dipilih.
                    </p>

                    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
                        Reset Filter
                    </a>
                </div>
            @else
                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th>Kode Pesanan</th>
                                <th>Pelanggan</th>
                                <th>Pembayaran</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($orders as $order)
                                @php
                                    $status = $order->status ?? 'pending';
                                    $paymentMethod = $order->payment_method ?? '-';
                                @endphp

                                <tr>
                                    <td style="min-width:190px;">
                                        <p class="report-order-code">
                                            {{ $order->order_code }}
                                        </p>

                                        <p class="report-order-meta">
                                            {{ $order->items->count() }} item
                                        </p>
                                    </td>

                                    <td style="min-width:210px;">
                                        <div class="report-customer">
                                            {{ $order->user->name ?? 'User tidak ditemukan' }}
                                        </div>

                                        <div class="report-customer-email">
                                            {{ $order->user->email ?? '-' }}
                                        </div>
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
                                        <span class="report-total">
                                            Rp{{ number_format($order->total, 0, ',', '.') }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $order->created_at->format('d M Y') }}
                                        <br>
                                        <span class="muted">
                                            {{ $order->created_at->format('H:i') }}
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

                @if(method_exists($orders, 'links'))
                    <div style="margin-top:22px;">
                        {{ $orders->links() }}
                    </div>
                @endif
            @endif
        </div>

        <aside class="report-side">
            <div class="card">
                <h2>Ringkasan Pembayaran</h2>

                <div class="top-item-list">
                    <div class="top-item">
                        <p class="top-item-name">COD</p>
                        <p class="top-item-meta">
                            {{ $summary['cod_orders'] ?? 0 }} pesanan menggunakan pembayaran COD.
                        </p>
                    </div>

                    <div class="top-item">
                        <p class="top-item-name">QRIS</p>
                        <p class="top-item-meta">
                            {{ $summary['qris_orders'] ?? 0 }} pesanan menggunakan pembayaran QRIS.
                        </p>
                    </div>

                    <div class="top-item">
                        <p class="top-item-name">Dibatalkan</p>
                        <p class="top-item-meta">
                            {{ $summary['cancelled_orders'] ?? 0 }} pesanan berstatus dibatalkan.
                        </p>
                    </div>

                    <div class="top-item">
                        <p class="top-item-name">Pending</p>
                        <p class="top-item-meta">
                            {{ $summary['pending_orders'] ?? 0 }} pesanan masih menunggu konfirmasi.
                        </p>
                    </div>
                </div>
            </div>

            <div class="card">
                <h2>Item Terlaris</h2>

                @if(($topItems ?? collect())->isEmpty())
                    <p class="muted">
                        Belum ada data item terlaris.
                    </p>
                @else
                    <div class="top-item-list">
                        @foreach($topItems as $item)
                            <div class="top-item">
                                <p class="top-item-name">
                                    {{ $item['name'] }}
                                </p>

                                <p class="top-item-meta">
                                    Terjual {{ $item['quantity'] }} item
                                    <br>
                                    Total Rp{{ number_format($item['total'], 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </aside>
    </div>
@endsection