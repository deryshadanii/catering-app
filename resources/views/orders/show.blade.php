@extends('layouts.app')

@section('title', 'Detail Pesanan - DapurMahasiswa')

@section('content')
<div class="card">
  <h1>Pesanan {{ $order->order_code }}</h1>

  <p>
    <strong>Status:</strong>
    <span class="status">{{ ucfirst($order->status) }}</span>
  </p>

  <p><strong>Alamat:</strong> {{ $order->delivery_address }}</p>
  <p><strong>Tanggal Pengiriman:</strong> {{ $order->delivery_date ?? '-' }}</p>
  <p><strong>Metode Pembayaran:</strong> {{ str_replace('_', ' ', strtoupper($order->payment_method)) }}</p>
  <p><strong>Catatan:</strong> {{ $order->note ?? '-' }}</p>

  <h3>Tracking Pesanan</h3>

  <ol>
    <li>Pesanan diterima</li>

    @if(in_array($order->status, ['confirmed', 'processing', 'delivering', 'completed']))
    <li>Pesanan dikonfirmasi</li>
    @endif

    @if(in_array($order->status, ['processing', 'delivering', 'completed']))
    <li>Sedang diproses</li>
    @endif

    @if(in_array($order->status, ['delivering', 'completed']))
    <li>Sedang dikirim</li>
    @endif

    @if($order->status === 'completed')
    <li>Selesai</li>
    @endif

    @if($order->status === 'cancelled')
    <li>Pesanan dibatalkan</li>
    @endif
  </ol>
</div>

<h2 class="section-title">Detail Item</h2>

@if($order->items->isEmpty())
<div class="card">
  <p>Belum ada item pada pesanan ini.</p>
</div>
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
          {{ $item->item_name }}

          @if($item->preference_note)
          <br>
          <span class="muted">
            Catatan: {{ $item->preference_note }}
          </span>
          @endif
        </td>

        <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
        <td>{{ $item->quantity }}</td>
        <td>Rp{{ number_format($item->total, 0, ',', '.') }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@endif

<div class="card" style="margin-top:18px;">
  <p>Subtotal: Rp{{ number_format($order->subtotal, 0, ',', '.') }}</p>
  <p>Ongkir: Rp{{ number_format($order->delivery_fee, 0, ',', '.') }}</p>
  <h3>Total: Rp{{ number_format($order->total, 0, ',', '.') }}</h3>
</div>

<div style="margin-top:18px;">
  <a href="{{ route('orders.index') }}" class="btn btn-secondary">
    Kembali ke Riwayat Pesanan
  </a>
</div>
@endsection