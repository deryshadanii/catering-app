@extends('layouts.app')

@section('title', 'Riwayat Pesanan - DapurMahasiswa')

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
        .orders-list {
            display: grid;
            gap: 16px;
        }

        .order-card {
            background: #fff;
            border: 1px solid #eee5d8;
            border-radius: 22px;
            box-shadow: var(--shadow);
            padding: 20px;
        }

        .order-card-top {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            align-items: flex-start;
            margin-bottom: 16px;
        }

        .order-code {
            margin: 0 0 6px;
            color: #102d19;
            font-size: 22px;
            line-height: 1.3;
        }

        .order-date {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .order-badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .order-info-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            padding: 16px;
            background: #fbfaf7;
            border: 1px solid #eee5d8;
            border-radius: 18px;
            margin-bottom: 16px;
        }

        .order-info-label {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 5px;
        }

        .order-info-value {
            color: var(--text);
            font-weight: 800;
            line-height: 1.5;
        }

        .order-total {
            color: var(--primary);
            font-size: 20px;
            font-weight: 900;
        }

        .order-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .order-actions form {
            margin: 0;
        }

        @media (max-width: 900px) {
            .order-info-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 620px) {
            .order-card-top {
                flex-direction: column;
            }

            .order-badges,
            .order-actions {
                justify-content: flex-start;
            }

            .order-info-grid {
                grid-template-columns: 1fr;
            }

            .order-actions .btn,
            .order-actions form,
            .order-actions button {
                width: 100%;
            }
        }
    </style>

    <div class="page-header">
        <h1>Riwayat Pesanan</h1>
        <p>
            Pantau semua pesanan kamu, mulai dari pesanan baru, sedang diproses, dikirim, sampai selesai.
        </p>
    </div>

    @if($orders->count() === 0)
        <div class="card empty-state">
            <h3>Belum ada pesanan</h3>
            <p class="muted">
                Kamu belum membuat pesanan. Pilih menu harian atau paket catering untuk mulai memesan.
            </p>

            <div class="inline-actions" style="justify-content:center; margin-top:16px;">
                <a href="{{ route('menu.index') }}" class="btn">
                    Lihat Menu Harian
                </a>

                <a href="{{ route('packages.index') }}" class="btn btn-secondary">
                    Lihat Paket
                </a>
            </div>
        </div>
    @else
        <div class="orders-list">
            @foreach($orders as $order)
                @php
                    $status = $order->status ?? 'pending';
                    $paymentMethod = $order->payment_method ?? '-';
                @endphp

                <div class="order-card">
                    <div class="order-card-top">
                        <div>
                            <h3 class="order-code">
                                Pesanan {{ $order->order_code }}
                            </h3>

                            <div class="order-date">
                                Dibuat pada {{ $order->created_at->format('d M Y H:i') }}
                            </div>
                        </div>

                        <div class="order-badges">
                            <span class="status" style="{{ $statusStyles[$status] ?? '' }}">
                                {{ $statusLabels[$status] ?? ucfirst($status) }}
                            </span>

                            <span class="status" style="{{ $paymentStyles[$paymentMethod] ?? 'background:#f3f4f6; color:#374151;' }}">
                                {{ $paymentLabels[$paymentMethod] ?? strtoupper($paymentMethod) }}
                            </span>
                        </div>
                    </div>

                    <div class="order-info-grid">
                        <div>
                            <div class="order-info-label">Alamat</div>
                            <div class="order-info-value">
                                {{ \Illuminate\Support\Str::limit($order->delivery_address, 55) }}
                            </div>
                        </div>

                        <div>
                            <div class="order-info-label">Tanggal Pengiriman</div>
                            <div class="order-info-value">
                                {{ $order->delivery_date ?? '-' }}
                            </div>
                        </div>

                        <div>
                            <div class="order-info-label">Metode Pembayaran</div>
                            <div class="order-info-value">
                                {{ $paymentLabels[$paymentMethod] ?? strtoupper($paymentMethod) }}
                            </div>
                        </div>

                        <div>
                            <div class="order-info-label">Total</div>
                            <div class="order-total">
                                Rp{{ number_format($order->total, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>

                    <div class="order-actions">
                        <a href="{{ route('orders.show', $order) }}" class="btn">
                            Lihat Detail
                        </a>

                        @if(in_array($order->status, ['pending', 'confirmed']) && Route::has('orders.cancel'))
                            <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                @csrf
                                @method('PATCH')

                                <button type="submit" class="btn btn-danger">
                                    Batalkan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if(method_exists($orders, 'links'))
            <div style="margin-top:22px;">
                {{ $orders->links() }}
            </div>
        @endif
    @endif
@endsection