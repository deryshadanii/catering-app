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
    <div style="display:flex; gap:8px; flex-wrap:wrap;">
        <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary">
            Detail
        </a>

        @if(in_array($order->status, ['pending', 'confirmed']))
            <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                @csrf
                @method('PATCH')

                <button type="submit" class="btn btn-danger">
                    Batal
                </button>
            </form>
        @endif
    </div>
</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection