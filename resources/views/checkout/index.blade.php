@extends('layouts.app')

@section('title', 'Checkout - DapurMahasiswa')

@section('content')
    @php
        $items = $cartItems ?? $cart ?? session('cart', []);
        $items = $items instanceof \Illuminate\Support\Collection ? $items : collect($items);

        $getValue = function ($item, $key, $default = null) {
            if (is_array($item)) {
                return $item[$key] ?? $default;
            }

            return $item->$key ?? $default;
        };

        $subtotal = $subtotal ?? $items->sum(function ($item) use ($getValue) {
            $price = (int) $getValue($item, 'price', 0);
            $quantity = (int) $getValue($item, 'quantity', 1);

            return $price * $quantity;
        });

        $deliveryFee = $deliveryFee ?? $delivery_fee ?? 5000;
        $total = $total ?? ($subtotal + $deliveryFee);

        $checkoutAction = Route::has('checkout.store')
            ? route('checkout.store')
            : (Route::has('checkout.process') ? route('checkout.process') : url('/checkout'));
    @endphp

    <style>
        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 390px;
            gap: 24px;
            align-items: start;
        }

        .checkout-form-card {
            background: #fff;
            border: 1px solid #eee5d8;
            border-radius: 22px;
            box-shadow: var(--shadow);
            padding: 26px;
        }

        .checkout-summary {
            position: sticky;
            top: 106px;
        }

        .checkout-items {
            display: grid;
            gap: 12px;
            margin-top: 18px;
        }

        .checkout-item {
            display: grid;
            grid-template-columns: 64px 1fr auto;
            gap: 12px;
            align-items: center;
            padding: 12px;
            border: 1px solid #eee5d8;
            border-radius: 16px;
            background: #fbfaf7;
        }

        .checkout-item-image {
            width: 64px;
            height: 64px;
            border-radius: 14px;
            background: #f3efe8;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            font-size: 11px;
            text-align: center;
        }

        .checkout-item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .checkout-item-name {
            margin: 0 0 4px;
            color: #102d19;
            font-weight: 800;
            line-height: 1.3;
        }

        .checkout-item-meta {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .checkout-item-total {
            color: var(--primary);
            font-weight: 900;
            white-space: nowrap;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 12px 0;
            border-bottom: 1px solid #eee5d8;
            color: var(--muted);
        }

        .summary-row strong {
            color: var(--text);
        }

        .summary-total {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding-top: 18px;
            color: #102d19;
            font-size: 22px;
            font-weight: 900;
        }

        .payment-options {
            display: grid;
            gap: 12px;
            margin-top: 8px;
        }

        .payment-option {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            padding: 15px;
            border: 1px solid #d9d2c6;
            border-radius: 16px;
            background: #fff;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .payment-option:hover {
            border-color: #82b28d;
            background: #fbfaf7;
        }

        .payment-option input {
            width: auto;
            margin-top: 4px;
        }

        .payment-option strong {
            display: block;
            color: #102d19;
            margin-bottom: 4px;
        }

        .qris-box {
            display: none;
            margin-top: 16px;
            padding: 18px;
            background: #fbfaf7;
            border: 1px solid #eee5d8;
            border-radius: 18px;
        }

        .qris-box img {
            width: 260px;
            max-width: 100%;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            background: #fff;
            padding: 10px;
        }

        @media (max-width: 940px) {
            .checkout-layout {
                grid-template-columns: 1fr;
            }

            .checkout-summary {
                position: static;
            }
        }

        @media (max-width: 600px) {
            .checkout-form-card {
                padding: 20px;
            }

            .checkout-item {
                grid-template-columns: 56px 1fr;
            }

            .checkout-item-total {
                grid-column: 1 / -1;
            }
        }
    </style>

    <div class="page-header">
        <h1>Checkout</h1>
        <p>
            Lengkapi alamat pengantaran dan pilih metode pembayaran sebelum membuat pesanan.
        </p>
    </div>

    @if($items->isEmpty())
        <div class="card empty-state">
            <h3>Keranjang masih kosong</h3>
            <p class="muted">
                Tambahkan menu atau paket terlebih dahulu sebelum checkout.
            </p>

            <a href="{{ route('menu.index') }}" class="btn">
                Lihat Menu Harian
            </a>
        </div>
    @else
        <div class="checkout-layout">
            <div class="checkout-form-card">
                <h2 style="margin-top:0;">Data Pengantaran</h2>

                <p class="muted">
                    Pastikan alamat dan jadwal pengantaran sudah benar agar pesanan mudah diproses.
                </p>

                <form action="{{ $checkoutAction }}" method="POST">
                    @csrf

                    <label>Alamat Pengantaran</label>
                    <textarea
                        name="delivery_address"
                        placeholder="Contoh: Kos Putri Melati No. 12, Jl. Merdeka, sekitar UINSU"
                        required
                    >{{ old('delivery_address', auth()->user()->address ?? '') }}</textarea>

                    <label>Tanggal Pengantaran</label>
                    <input
                        type="date"
                        name="delivery_date"
                        value="{{ old('delivery_date') }}"
                    >

                    <label>Catatan untuk Catering</label>
                    <textarea
                        name="note"
                        placeholder="Contoh: tidak pedas, antar setelah zuhur, hubungi lewat WhatsApp"
                    >{{ old('note') }}</textarea>

                    <label>Metode Pembayaran</label>

                    <div class="payment-options">
                        <label class="payment-option">
                            <input
                                type="radio"
                                name="payment_method"
                                value="cod"
                                {{ old('payment_method', 'cod') === 'cod' ? 'checked' : '' }}
                                onchange="toggleQrisBox()"
                            >

                            <span>
                                <strong>COD</strong>
                                <span class="muted">
                                    Bayar langsung saat makanan diterima.
                                </span>
                            </span>
                        </label>

                        <label class="payment-option">
                            <input
                                type="radio"
                                name="payment_method"
                                value="qris"
                                {{ old('payment_method') === 'qris' ? 'checked' : '' }}
                                onchange="toggleQrisBox()"
                            >

                            <span>
                                <strong>QRIS</strong>
                                <span class="muted">
                                    Scan barcode QRIS DapurMahasiswa untuk melakukan pembayaran.
                                </span>
                            </span>
                        </label>
                    </div>

                    <div id="qrisBox" class="qris-box">
                        <h3 style="margin-top:0;">Scan QRIS DapurMahasiswa</h3>

                        <p class="muted">
                            Silakan scan barcode berikut jika memilih pembayaran QRIS.
                        </p>

                        <img
                            src="{{ asset('images/qris-dapurmahasiswa.png') }}"
                            alt="QRIS DapurMahasiswa"
                        >

                        <p class="muted" style="margin-top:12px;">
                            Setelah membayar, pesanan tetap tercatat dan admin akan memproses pesanan kamu.
                        </p>
                    </div>

                    <button type="submit" class="btn" style="width:100%; margin-top:22px;">
                        Buat Pesanan
                    </button>
                </form>
            </div>

            <div class="card checkout-summary">
                <h2>Ringkasan Checkout</h2>

                <p class="muted">
                    Daftar item yang akan kamu pesan.
                </p>

                <div class="checkout-items">
                    @foreach($items as $item)
                        @php
                            $name = $getValue($item, 'name', $getValue($item, 'item_name', 'Item Keranjang'));
                            $price = (int) $getValue($item, 'price', 0);
                            $quantity = (int) $getValue($item, 'quantity', 1);
                            $itemTotal = $price * $quantity;
                            $imageUrl = $getValue($item, 'image_url', $getValue($item, 'image', null));

                            if ($imageUrl) {
                                if (\Illuminate\Support\Str::startsWith($imageUrl, ['http://', 'https://'])) {
                                    $imageSrc = $imageUrl;
                                } elseif (\Illuminate\Support\Str::startsWith($imageUrl, ['images/'])) {
                                    $imageSrc = asset($imageUrl);
                                } else {
                                    $imageSrc = asset('storage/' . $imageUrl);
                                }
                            } else {
                                $imageSrc = null;
                            }
                        @endphp

                        <div class="checkout-item">
                            <div class="checkout-item-image">
                                @if($imageSrc)
                                    <img src="{{ $imageSrc }}" alt="{{ $name }}">
                                @else
                                    <span>No image</span>
                                @endif
                            </div>

                            <div>
                                <p class="checkout-item-name">
                                    {{ $name }}
                                </p>

                                <p class="checkout-item-meta">
                                    {{ $quantity }} x Rp{{ number_format($price, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="checkout-item-total">
                                Rp{{ number_format($itemTotal, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="margin-top:20px;">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <strong>Rp{{ number_format($subtotal, 0, ',', '.') }}</strong>
                    </div>

                    <div class="summary-row">
                        <span>Ongkir</span>
                        <strong>Rp{{ number_format($deliveryFee, 0, ',', '.') }}</strong>
                    </div>

                    <div class="summary-total">
                        <span>Total</span>
                        <span>Rp{{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                </div>

                <a href="{{ route('cart.index') }}" class="btn btn-secondary" style="width:100%; margin-top:16px;">
                    Kembali ke Keranjang
                </a>
            </div>
        </div>
    @endif

    <script>
        function toggleQrisBox() {
            const selectedPayment = document.querySelector('input[name="payment_method"]:checked');
            const qrisBox = document.getElementById('qrisBox');

            if (!qrisBox) {
                return;
            }

            if (selectedPayment && selectedPayment.value === 'qris') {
                qrisBox.style.display = 'block';
            } else {
                qrisBox.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', toggleQrisBox);
    </script>
@endsection