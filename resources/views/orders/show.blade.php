@extends('layouts.app')

@section('title', 'Detail Pesanan - DapurMahasiswa')

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

        $status = $order->status ?? 'pending';
        $paymentMethod = $order->payment_method ?? '-';

        $trackingSteps = [
            'pending' => 'Pesanan diterima',
            'confirmed' => 'Pesanan dikonfirmasi',
            'processing' => 'Sedang diproses',
            'delivering' => 'Sedang dikirim',
            'completed' => 'Selesai',
        ];

        $activeIndexMap = [
            'pending' => 0,
            'confirmed' => 1,
            'processing' => 2,
            'delivering' => 3,
            'completed' => 4,
            'cancelled' => 0,
        ];

        $activeIndex = $activeIndexMap[$status] ?? 0;
    @endphp

    <style>
        .order-detail-layout {
            display: grid;
            grid-template-columns: 1fr 370px;
            gap: 24px;
            align-items: start;
        }

        .detail-main {
            display: grid;
            gap: 20px;
        }

        .detail-side {
            position: sticky;
            top: 106px;
            display: grid;
            gap: 20px;
        }

        .detail-header-card {
            background:
                radial-gradient(circle at top right, rgba(217, 155, 43, 0.13), transparent 28%),
                linear-gradient(135deg, #ffffff 0%, #edf7ef 100%);
            border: 1px solid #eee5d8;
            border-radius: 24px;
            box-shadow: var(--shadow);
            padding: 24px;
        }

        .detail-header-top {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .detail-title {
            margin: 0 0 8px;
            color: #102d19;
            font-size: 30px;
            line-height: 1.2;
        }

        .detail-subtitle {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
        }

        .detail-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .info-box {
            padding: 15px;
            border-radius: 16px;
            background: #fbfaf7;
            border: 1px solid #eee5d8;
        }

        .info-label {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 6px;
        }

        .info-value {
            color: var(--text);
            font-weight: 800;
            line-height: 1.6;
        }

        .tracking-list {
            display: grid;
            gap: 12px;
            margin-top: 16px;
        }

        .tracking-step {
            display: grid;
            grid-template-columns: 34px 1fr;
            gap: 12px;
            align-items: start;
        }

        .tracking-dot {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            display: grid;
            place-items: center;
            background: #f3f4f6;
            color: #6b7280;
            font-weight: 900;
            font-size: 13px;
        }

        .tracking-step.active .tracking-dot {
            background: var(--primary);
            color: #fff;
        }

        .tracking-step.cancelled .tracking-dot {
            background: #dc2626;
            color: #fff;
        }

        .tracking-text {
            padding-top: 6px;
            color: var(--muted);
            line-height: 1.6;
        }

        .tracking-step.active .tracking-text {
            color: var(--text);
            font-weight: 800;
        }

        .payment-card img {
            width: 260px;
            max-width: 100%;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            background: #fff;
            padding: 10px;
            margin-top: 12px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 12px 0;
            border-bottom: 1px solid #eee5d8;
            color: var(--muted);
        }

        .total-row strong {
            color: var(--text);
        }

        .grand-total {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding-top: 16px;
            color: #102d19;
            font-size: 22px;
            font-weight: 900;
        }

        @media (max-width: 960px) {
            .order-detail-layout {
                grid-template-columns: 1fr;
            }

            .detail-side {
                position: static;
            }
        }

        @media (max-width: 650px) {
            .detail-header-top {
                flex-direction: column;
            }

            .detail-badges {
                justify-content: flex-start;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .detail-title {
                font-size: 26px;
            }
        }
    </style>

    <div class="page-header">
        <h1>Detail Pesanan</h1>
        <p>
            Lihat informasi pesanan, status tracking, metode pembayaran, dan detail item yang kamu pesan.
        </p>
    </div>

    <div class="order-detail-layout">
        <div class="detail-main">
            <div class="detail-header-card">
                <div class="detail-header-top">
                    <div>
                        <h2 class="detail-title">
                            Pesanan {{ $order->order_code }}
                        </h2>

                        <p class="detail-subtitle">
                            Dibuat pada {{ $order->created_at->format('d M Y H:i') }}
                        </p>
                    </div>

                    <div class="detail-badges">
                        <span class="status" style="{{ $statusStyles[$status] ?? '' }}">
                            {{ $statusLabels[$status] ?? ucfirst($status) }}
                        </span>

                        <span class="status" style="{{ $paymentStyles[$paymentMethod] ?? 'background:#f3f4f6; color:#374151;' }}">
                            {{ $paymentLabels[$paymentMethod] ?? strtoupper($paymentMethod) }}
                        </span>
                    </div>
                </div>

                <div class="info-grid">
                    <div class="info-box">
                        <div class="info-label">Alamat Pengantaran</div>
                        <div class="info-value">
                            {{ $order->delivery_address }}
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">Tanggal Pengantaran</div>
                        <div class="info-value">
                            {{ $order->delivery_date ?? '-' }}
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">Metode Pembayaran</div>
                        <div class="info-value">
                            {{ $paymentLabels[$paymentMethod] ?? strtoupper($paymentMethod) }}
                        </div>
                    </div>

                    <div class="info-box">
                        <div class="info-label">Catatan</div>
                        <div class="info-value">
                            {{ $order->note ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h2>Tracking Pesanan</h2>

                <p class="muted">
                    Status pesanan akan berubah sesuai proses yang dilakukan admin.
                </p>

                <div class="tracking-list">
                    @if($status === 'cancelled')
                        <div class="tracking-step cancelled">
                            <div class="tracking-dot">!</div>
                            <div class="tracking-text">
                                Pesanan dibatalkan.
                            </div>
                        </div>
                    @else
                        @foreach($trackingSteps as $stepStatus => $stepLabel)
                            @php
                                $stepIndex = array_search($stepStatus, array_keys($trackingSteps));
                                $isActive = $stepIndex <= $activeIndex;
                            @endphp

                            <div class="tracking-step {{ $isActive ? 'active' : '' }}">
                                <div class="tracking-dot">
                                    {{ $stepIndex + 1 }}
                                </div>

                                <div class="tracking-text">
                                    {{ $stepLabel }}
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="card">
                <h2>Detail Item</h2>

                @if($order->items->isEmpty())
                    <p class="muted">
                        Belum ada item pada pesanan ini.
                    </p>
                @else
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <strong>{{ $item->item_name }}</strong>

                                            @if($item->preference_note)
                                                <br>
                                                <span class="muted">
                                                    Catatan: {{ $item->preference_note }}
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            Rp{{ number_format($item->price, 0, ',', '.') }}
                                        </td>

                                        <td>
                                            {{ $item->quantity }}
                                        </td>

                                        <td>
                                            <strong>
                                                Rp{{ number_format($item->total, 0, ',', '.') }}
                                            </strong>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <div class="detail-side">
            <div class="card payment-card">
                <h2>Informasi Pembayaran</h2>

                @if($paymentMethod === 'qris')
                    <p class="muted">
                        Pesanan ini menggunakan pembayaran QRIS. Scan barcode berikut untuk membayar.
                    </p>

                    <img
                        src="{{ asset('images/qris-dapurmahasiswa.png') }}"
                        alt="QRIS DapurMahasiswa"
                    >
                @elseif($paymentMethod === 'cod')
                    <p class="muted">
                        Pesanan ini menggunakan pembayaran COD. Pembayaran dilakukan saat makanan diterima.
                    </p>
                @else
                    <p class="muted">
                        Metode pembayaran belum tersedia.
                    </p>
                @endif
            </div>

            <div class="card">
                <h2>Ringkasan Biaya</h2>

                <div class="total-row">
                    <span>Subtotal</span>
                    <strong>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</strong>
                </div>

                <div class="total-row">
                    <span>Ongkir</span>
                    <strong>Rp{{ number_format($order->delivery_fee, 0, ',', '.') }}</strong>
                </div>

                <div class="grand-total">
                    <span>Total</span>
                    <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="card">
                <h2>Aksi Pesanan</h2>

                <div class="inline-actions" style="flex-direction:column; align-items:stretch;">
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                        Kembali ke Riwayat
                    </a>

                    @if(in_array($order->status, ['pending', 'confirmed']) && Route::has('orders.cancel'))
                        <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')" style="margin:0;">
                            @csrf
                            @method('PATCH')

                            <button type="submit" class="btn btn-danger" style="width:100%;">
                                Batalkan Pesanan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection