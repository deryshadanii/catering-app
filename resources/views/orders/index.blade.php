@extends('layouts.app')

@section('title', 'Pesanan Saya - DapurMahasiswa')

@section('content')
    <h1>Pesanan Saya</h1>

    @if($orders->isEmpty())
        <div class="card">
            <p>Kamu belum memiliki pesanan.</p>
            <a href="{{ route('menu.index') }}" class="btn">Pesan Sekarang</a>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->order_code }}</td>
                        <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                        <td><span class="status">{{ ucfirst($order->status) }}</span></td>
                        <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection