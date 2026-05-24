@extends('layouts.app')

@section('title', 'Detail Pesanan Admin - DapurMahasiswa')

@section('content')
    <div class="card">
        <h1>Detail Pesanan {{ $order->order_code }}</h1>

        <p><strong>Pelanggan:</strong> {{ $order->user->name }}</p>
        <p><strong>Email:</strong> {{ $order->user->email }}</p>
        <p><strong>No. HP:</strong> {{ $order->user->phone ?? '-' }}</p>
        <p><strong>Alamat Pengiriman:</strong> {{ $order->delivery_address }}</p>
        <p><strong>Status:</strong> <span class="status">{{ ucfirst($order->status) }}</span></p>

        <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
            @csrf
            @method('PATCH')

            <label>Ubah Status</label>
            <select name="status">
                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="delivering" {{ $order->status === 'delivering' ? 'selected' : '' }}>Delivering</option>
                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <button type="submit" class="btn" style="margin-top:14px;">Simpan Status</button>
        </form>
    </div>

    <h2 class="section-title">Item Pesanan</h2>

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
                            <span class="muted">Catatan: {{ $item->preference_note }}</span>
                        @endif
                    </td>
                    <td>Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp{{ number_format($item->total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card" style="margin-top:18px;">
        <p>Subtotal: Rp{{ number_format($order->subtotal, 0, ',', '.') }}</p>
        <p>Ongkir: Rp{{ number_format($order->delivery_fee, 0, ',', '.') }}</p>
        <h3>Total: Rp{{ number_format($order->total, 0, ',', '.') }}</h3>
    </div>
@endsection