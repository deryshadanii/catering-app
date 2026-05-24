@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

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
        .orders-summary-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 22px;
        }

        .orders-summary-card {
            background: #fff;
            border: 1px solid #eee5d8;
            border-radius: 20px;
            box-shadow: var(--shadow);
            padding: 18px;
        }

        .orders-summary-label {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 8px;
        }

        .orders-summary-value {
            color: var(--primary);
            font-size: 30px;
            font-weight: 900;
        }

        .admin-order-code {
            margin: 0 0 5px;
            color: #102d19;
            font-weight: 900;
            line-height: 1.4;
        }

        .admin-order-meta {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .customer-name {
            color: #102d19;
            font-weight: 900;
            line-height: 1.4;
        }

        .customer-email {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .order-total-text {
            color: var(--primary);
            font-weight: 900;
            white-space: nowrap;
        }

        .status-update-form {
            display: grid;
            gap: 8px;
            min-width: 170px;
        }

        .status-update-form select {
            padding: 9px 10px;
            font-size: 13px;
        }

        .status-update-form .btn {
            min-height: 36px;
            padding: 8px 12px;
            font-size: 13px;
        }

        .admin-order-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        .admin-order-actions form {
            margin: 0;
        }

        .filter-card {
            margin-bottom: 22px;
        }

        .order-filter-row {
            display: grid;
            grid-template-columns: 1.4fr 0.8fr 0.8fr auto;
            gap: 14px;
            align-items: end;
        }

        @media (max-width: 1050px) {
            .orders-summary-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .order-filter-row {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 640px) {
            .orders-summary-grid,
            .order-filter-row {
                grid-template-columns: 1fr;
            }

            .admin-order-actions .btn,
            .admin-order-actions form,
            .admin-order-actions button {
                width: 100%;
            }
        }
    </style>

    <div class="page-header">
        <h1>Kelola Pesanan</h1>
        <p>
            Pantau pesanan pelanggan, cek metode pembayaran, dan ubah status pesanan sesuai proses pengantaran.
        </p>
    </div>

    <div class="orders-summary-grid">
        <div class="orders-summary-card">
            <div class="orders-summary-label">Total Pesanan</div>
            <div class="orders-summary-value">{{ $summary['total'] ?? 0 }}</div>
        </div>

        <div class="orders-summary-card">
            <div class="orders-summary-label">Pending</div>
            <div class="orders-summary-value">{{ $summary['pending'] ?? 0 }}</div>
        </div>

        <div class="orders-summary-card">
            <div class="orders-summary-label">Sedang Berjalan</div>
            <div class="orders-summary-value">{{ $summary['processing'] ?? 0 }}</div>
        </div>

        <div class="orders-summary-card">
            <div class="orders-summary-label">Selesai</div>
            <div class="orders-summary-value">{{ $summary['completed'] ?? 0 }}</div>
        </div>
    </div>

    <div class="filter-card">
        <form action="{{ route('admin.orders.index') }}" method="GET">
            <div class="order-filter-row">
                <div>
                    <label>Cari Pesanan</label>
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari kode, nama user, email, atau alamat"
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
                        <option value="cod" {{ request('payment_method') === 'cod' ? 'selected' : '' }}>COD</option>
                        <option value="qris" {{ request('payment_method') === 'qris' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn">
                        Filter
                    </button>

                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    @if($orders->isEmpty())
        <div class="card empty-state">
            <h3>Pesanan tidak ditemukan</h3>
            <p class="muted">
                Belum ada pesanan, atau filter yang kamu gunakan tidak memiliki hasil.
            </p>

            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                Lihat Semua Pesanan
            </a>
        </div>
    @else
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Kode Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Item</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th>Update Status</th>
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
                                <p class="admin-order-code">
                                    {{ $order->order_code }}
                                </p>

                                <p class="admin-order-meta">
                                    {{ $order->created_at->format('d M Y H:i') }}
                                    <br>
                                    Pengiriman:
                                    {{ $order->delivery_date ?? '-' }}
                                </p>
                            </td>

                            <td style="min-width:210px;">
                                <div class="customer-name">
                                    {{ $order->user->name ?? 'User tidak ditemukan' }}
                                </div>

                                <div class="customer-email">
                                    {{ $order->user->email ?? '-' }}
                                </div>

                                @if($order->user && $order->user->phone)
                                    <div class="customer-email">
                                        {{ $order->user->phone }}
                                    </div>
                                @endif
                            </td>

                            <td>
                                {{ $order->items->count() }} item
                            </td>

                            <td>
                                <span class="order-total-text">
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
                                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="status-update-form">
                                    @csrf
                                    @method('PATCH')

                                    <select name="status">
                                        @foreach($statusLabels as $statusValue => $statusText)
                                            <option value="{{ $statusValue }}" {{ $status === $statusValue ? 'selected' : '' }}>
                                                {{ $statusText }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button type="submit" class="btn btn-secondary">
                                        Simpan
                                    </button>
                                </form>
                            </td>

                            <td>
                                <div class="admin-order-actions">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn">
                                        Detail
                                    </a>

                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini? Data pesanan akan hilang dari admin dan user.')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
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
@endsection