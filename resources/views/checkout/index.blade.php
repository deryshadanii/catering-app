@extends('layouts.app')

@section('title', 'Checkout - DapurMahasiswa')

@section('content')
    <h1>Checkout</h1>

    <div class="grid">
        <div class="card">
            <h3>Ringkasan Pesanan</h3>

            @foreach($cart as $item)
                <p>
                    <strong>{{ $item['item_name'] }}</strong><br>
                    {{ $item['quantity'] }} x Rp{{ number_format($item['price'], 0, ',', '.') }}
                    = Rp{{ number_format($item['total'], 0, ',', '.') }}
                </p>
            @endforeach

            <hr>
            <p>Subtotal: Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
            <p>Ongkir: Rp{{ number_format($deliveryFee, 0, ',', '.') }}</p>
            <h3>Total: Rp{{ number_format($total, 0, ',', '.') }}</h3>
        </div>

        <div class="card">
            <h3>Data Pengiriman</h3>

            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf

                <label>Alamat Pengiriman</label>
                <textarea name="delivery_address" required>{{ old('delivery_address', auth()->user()->address) }}</textarea>

                <label>Tanggal Pengiriman</label>
                <input type="date" name="delivery_date" value="{{ old('delivery_date') }}">

                <label>Catatan untuk Catering</label>
                <textarea name="note" placeholder="Contoh: antar jam 12 siang, jangan terlalu pedas.">{{ old('note') }}</textarea>

                <label>Metode Pembayaran</label>
                <select name="payment_method" required>
                    <option value="cod">COD</option>
                    <option value="transfer_bank">Transfer Bank</option>
                    <option value="e_wallet">E-Wallet</option>
                </select>

                <button type="submit" class="btn" style="margin-top:18px;">Buat Pesanan</button>
            </form>
        </div>
    </div>
@endsection