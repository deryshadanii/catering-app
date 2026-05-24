@extends('layouts.admin')

@section('title', 'Admin Pesanan')

@section('content')
    <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:20px;">
        <div>
            <h1>Admin Pesanan</h1>
            <p class="muted">Kelola dan pantau pesanan pelanggan DapurMahasiswa.</p>
        </div>
    </div>

    @if($orders->count() === 0)
        <div class="card">
            <p>Belum ada pesanan yang masuk.</p>
        </div>
    @else
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Kode Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Alamat Pengantaran</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal Pesan</th>
                        <th style="width:120px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>
                                <strong>{{ $order->order_code }}</strong>
                            </td>

                            <td>
                                {{ $order->user->name ?? 'User tidak ditemukan' }}
                                <br>
                                <span class="muted">
                                    {{ $order->user->email ?? '-' }}
                                </span>
                            </td>

                            <td>
                                {{ $order->delivery_address }}
                            </td>

                            <td>
                                Rp{{ number_format($order->total, 0, ',', '.') }}
                            </td>

                            <td>
                                @if($order->status === 'pending')
                                    <span class="status" style="background:#fef3c7; color:#92400e;">Pending</span>
                                @elseif($order->status === 'confirmed')
                                    <span class="status" style="background:#dbeafe; color:#1e40af;">Dikonfirmasi</span>
                                @elseif($order->status === 'processing')
                                    <span class="status" style="background:#ede9fe; color:#5b21b6;">Diproses</span>
                                @elseif($order->status === 'delivering')
                                    <span class="status" style="background:#ffedd5; color:#9a3412;">Diantar</span>
                                @elseif($order->status === 'completed')
                                    <span class="status">Selesai</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="status" style="background:#fee2e2; color:#991b1b;">Dibatalkan</span>
                                @else
                                    <span class="status">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>

                            <td>
                                {{ $order->created_at->format('d M Y H:i') }}
                            </td>

                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection