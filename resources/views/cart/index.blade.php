@extends('layouts.app')

@section('title', 'Keranjang - DapurMahasiswa')

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

        $checkoutUrl = Route::has('checkout.index')
            ? route('checkout.index')
            : (Route::has('checkout') ? route('checkout') : url('/checkout'));
    @endphp

    <style>
        .cart-layout {
            display: grid;
            grid-template-columns: 1fr 360px;
            gap: 24px;
            align-items: start;
        }

        .cart-list {
            display: grid;
            gap: 16px;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 18px;
            padding: 18px;
            background: #fff;
            border: 1px solid #eee5d8;
            border-radius: 20px;
            box-shadow: var(--shadow);
        }

        .cart-image {
            width: 120px;
            height: 120px;
            border-radius: 16px;
            background: #f3efe8;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--muted);
            font-size: 13px;
            text-align: center;
        }

        .cart-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-content {
            min-width: 0;
        }

        .cart-title-row {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: flex-start;
        }

        .cart-title {
            margin: 0 0 8px;
            color: #102d19;
            font-size: 21px;
            line-height: 1.3;
        }

        .cart-type {
            display: inline-flex;
            padding: 6px 10px;
            border-radius: 999px;
            background: #edf7ef;
            color: var(--primary);
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .cart-description {
            margin: 0 0 12px;
            color: var(--muted);
            line-height: 1.6;
        }

        .cart-meta {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 14px;
            color: var(--muted);
            font-size: 14px;
        }

        .cart-price {
            color: var(--primary);
            font-size: 22px;
            font-weight: 900;
        }

        .cart-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
            margin-top: 12px;
        }

        .qty-form {
            display: flex;
            gap: 8px;
            align-items: center;
            margin: 0;
        }

        .qty-input {
            width: 82px;
        }

        .summary-card {
            position: sticky;
            top: 106px;
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

        @media (max-width: 900px) {
            .cart-layout {
                grid-template-columns: 1fr;
            }

            .summary-card {
                position: static;
            }
        }

        @media (max-width: 620px) {
            .cart-item {
                grid-template-columns: 1fr;
            }

            .cart-image {
                width: 100%;
                height: 190px;
            }

            .cart-title-row {
                flex-direction: column;
                gap: 8px;
            }

            .qty-form {
                width: 100%;
            }

            .qty-input {
                flex: 1;
            }

            .cart-actions .btn,
            .cart-actions form {
                width: 100%;
            }
        }
    </style>

    <div class="page-header">
        <h1>Keranjang</h1>
        <p>
            Periksa kembali menu dan paket catering yang sudah kamu pilih sebelum melanjutkan ke checkout.
        </p>
    </div>

    @if($items->isEmpty())
        <div class="card empty-state">
            <h3>Keranjang masih kosong</h3>
            <p class="muted">
                Kamu belum menambahkan menu atau paket catering ke keranjang.
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
        <div class="cart-layout">
            <div class="cart-list">
                @foreach($items as $itemKey => $item)
                    @php
                        $cartKey = $getValue($item, 'cart_key', $getValue($item, 'key', $itemKey));
                        $name = $getValue($item, 'name', $getValue($item, 'item_name', 'Item Keranjang'));
                        $description = $getValue($item, 'description', null);
                        $type = $getValue($item, 'type', $getValue($item, 'item_type', 'menu'));
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

                    <div class="cart-item">
                        <div class="cart-image">
                            @if($imageSrc)
                                <img src="{{ $imageSrc }}" alt="{{ $name }}">
                            @else
                                <span>Belum ada gambar</span>
                            @endif
                        </div>

                        <div class="cart-content">
                            <div class="cart-title-row">
                                <div>
                                    <h3 class="cart-title">
                                        {{ $name }}
                                    </h3>

                                    @if($description)
                                        <p class="cart-description">
                                            {{ \Illuminate\Support\Str::limit($description, 110) }}
                                        </p>
                                    @endif
                                </div>

                                <span class="cart-type">
                                    {{ strtolower($type) === 'package' || strtolower($type) === 'paket' ? 'Paket' : 'Menu' }}
                                </span>
                            </div>

                            <div class="cart-meta">
                                <span>
                                    Harga:
                                    <strong>Rp{{ number_format($price, 0, ',', '.') }}</strong>
                                </span>

                                <span>
                                    Jumlah:
                                    <strong>{{ $quantity }}</strong>
                                </span>
                            </div>

                            <div class="cart-price">
                                Rp{{ number_format($itemTotal, 0, ',', '.') }}
                            </div>

                            <div class="cart-actions">
                                @if(Route::has('cart.update'))
                                    <form action="{{ route('cart.update', $cartKey) }}" method="POST" class="qty-form">
                                        @csrf
                                        @method('PATCH')

                                        <input
                                            type="number"
                                            name="quantity"
                                            value="{{ $quantity }}"
                                            min="1"
                                            class="qty-input"
                                        >

                                        <button type="submit" class="btn btn-secondary">
                                            Update
                                        </button>
                                    </form>
                                @endif

                                @if(Route::has('cart.remove'))
                                    <form action="{{ route('cart.remove', $cartKey) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')" style="margin:0;">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="card summary-card">
                <h2>Ringkasan Pesanan</h2>

                <p class="muted">
                    Pastikan pesanan sudah sesuai sebelum checkout.
                </p>

                <div style="margin-top:18px;">
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

                <a href="{{ $checkoutUrl }}" class="btn" style="width:100%; margin-top:22px;">
                    Lanjut Checkout
                </a>

                <a href="{{ route('menu.index') }}" class="btn btn-secondary" style="width:100%; margin-top:10px;">
                    Tambah Menu Lagi
                </a>
            </div>
        </div>
    @endif
@endsection