@extends('layouts.admin')

@section('title', 'Detail Pesanan')

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
    @endphp

    <style>
        .order-detail-layout {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 24px;
            align-items: start;
        }

        .order-detail-main {
            display: grid;
            gap: 20px;
        }

        .order-detail-side {
            display: grid;
            gap: 20px;
            position: sticky;
            top: 100px;
        }

        .detail-hero {
            background:
                radial-gradient(circle at top right, rgba(217, 155, 43, 0.16), transparent 28%),
                linear-gradient(135deg, #ffffff 0%, #edf7ef 100%);
            border: 1px solid #eee5d8;
            border-radius: 26px;
            box-shadow: var(--shadow);
            padding: 24px;
        }

        .detail-hero-top {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .detail-order-code {
            margin: 0 0 8px;
            color: #102d19;
            font-size: 30px;
            line-height: 1.2;
        }

        .detail-order-date {
            color: var(--muted);
            line-height: 1.6;
        }

        .detail-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .detail-info-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .detail-info-box {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid #eee5d8;
            border-radius: 16px;
            padding: 15px;
        }

        .detail-info-label {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 6px;
        }

        .detail-info-value {
            color: var(--text);
            font-weight: 800;
            line-height: 1.6;
            word-break: break-word;
        }

        .status-form {
            display: grid;
            gap: 12px;
        }

        .payment-qris-image {
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

        @media (max-width: 980px) {
            .order-detail-layout {
                grid-template-columns: 1fr;
            }

            .order-detail-side {
                position: static;
            }
        }

        @media (max-width: 650px) {
            .detail-hero-top {
                flex-direction: column;
            }

            .detail-badges {
                justify-content: flex-start;
            }

            .detail-info-grid {
                grid-template-columns: 1fr;
            }

            .detail-order-code {
                font-size: 25px;
            }
        }
    </style>

    <div class="page-header">
        <h1>Detail Pesanan</h1>
        <p>
            Lihat informasi lengkap pesanan, data pelanggan, item pesanan, pembayaran, dan ubah status pengiriman.
        </p>
    </div>

    <div class="order-detail-layout">
        <div class="order-detail-main">
            <div class="detail-hero">
                <div class="detail-hero-top">
                    <div>
                        <h2 class="detail-order-code">
                            {{ $order->order_code }}
                        </h2>

                        <div class="detail-order-date">
                            Dibuat pada {{ $order->created_at->format('d M Y H:i') }}
                        </div>
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

                <div class="detail-info-grid">
                    <div class="detail-info-box">
                        <div class="detail-info-label">Nama Pelanggan</div>
                        <div class="detail-info-value">
                            {{ $order->user->name ?? 'User tidak ditemukan' }}
                        </div>
                    </div>

                    <div class="detail-info-box">
                        <div class="detail-info-label">Email</div>
                        <div class="detail-info-value">
                            {{ $order->user->email ?? '-' }}
                        </div>
                    </div>

                    <div class="detail-info-box">
                        <div class="detail-info-label">Nomor HP</div>
                        <div class="detail-info-value">
                            {{ $order->user->phone ?? '-' }}
                        </div>
                    </div>

                    <div class="detail-info-box">
                        <div class="detail-info-label">Tanggal Pengiriman</div>
                        <div class="detail-info-value">
                            {{ $order->delivery_date ?? '-' }}
                        </div>
                    </div>

                    <div class="detail-info-box">
                        <div class="detail-info-label">Alamat Pengantaran</div>
                        <div class="detail-info-value">
                            {{ $order->delivery_address }}
                        </div>
                    </div>

                    <div class="detail-info-box">
                        <div class="detail-info-label">Catatan User</div>
                        <div class="detail-info-value">
                            {{ $order->note ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <h2>Item Pesanan</h2>

                @if($order->items->isEmpty())
                    <p class="muted">
                        Tidak ada item pada pesanan ini.
                    </p>
                @else
                    <div class="table-wrapper">
                        <table>
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Tipe</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td style="min-width:240px;">
                                            <strong>{{ $item->item_name }}</strong>

                                            @if($item->preference_note)
                                                <br>
                                                <span class="muted">
                                                    Catatan: {{ $item->preference_note }}
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $item->item_type === 'package' ? 'Paket' : 'Menu' }}
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

        <div class="order-detail-side">
            <div class="card">
                <h2>Update Status</h2>

                <p class="muted">
                    Ubah status pesanan sesuai proses yang sedang berjalan.
                </p>

                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="status-form">
                    @csrf
                    @method('PATCH')

                    <label>Status Pesanan</label>
                    <select name="status" required>
                        @foreach($statusLabels as $statusValue => $statusText)
                            <option value="{{ $statusValue }}" {{ $status === $statusValue ? 'selected' : '' }}>
                                {{ $statusText }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn">
                        Simpan Status
                    </button>
                </form>
            </div>

            <div class="card">
                <h2>Pembayaran</h2>

                @if($paymentMethod === 'qris')
                    <p class="muted">
                        Pesanan ini menggunakan pembayaran QRIS.
                    </p>

                    <img
                        src="{{ asset('images/qris-dapurmahasiswa.png') }}"
                        alt="QRIS DapurMahasiswa"
                        class="payment-qris-image"
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
                <h2>Aksi</h2>

                <div class="inline-actions" style="flex-direction:column; align-items:stretch;">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                        Kembali ke Pesanan
                    </a>

                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan ini? Data pesanan akan hilang dari admin dan user.')" style="margin:0;">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger" style="width:100%;">
                            Hapus Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection