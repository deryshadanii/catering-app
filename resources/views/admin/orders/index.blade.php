@extends('layouts.app')

@section('title', 'Admin Pesanan - DapurMahasiswa')

@section('content')
    <h1>Admin Pesanan</h1>
    <p class="muted">Kelola status pesanan pelanggan DapurMahasiswa.</p>

    @if($orders->isEmpty())
        <div class="card">
            <p>Belum ada pesanan.</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Ubah Status</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $order->order_code }}</td>
                        <td>
                            {{ $order->user->name }}<br>
                            <span class="muted">{{ $order->user->email }}</span>
                        </td>
                        <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                        <td><span class="status">{{ ucfirst($order->status) }}</span></td>
                        <td>
                            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <select name="status">
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="delivering" {{ $order->status === 'delivering' ? 'selected' : '' }}>Delivering</option>
                                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>

                                <button type="submit" class="btn" style="margin-top:8px;">Update</button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection