@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <h1>Dashboard Admin</h1>
    <p class="muted">
        Ringkasan data DapurMahasiswa untuk memantau menu, paket, pesanan, dan pendapatan.
    </p>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Menu</div>
            <div class="stat-value">{{ $totalMenus }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Total Paket</div>
            <div class="stat-value">{{ $totalPackages }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Total Pesanan</div>
            <div class="stat-value">{{ $totalOrders }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Pesanan Pending</div>
            <div class="stat-value">{{ $pendingOrders }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Diproses</div>
            <div class="stat-value">{{ $processingOrders }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Selesai</div>
            <div class="stat-value">{{ $completedOrders }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Pendapatan Selesai</div>
            <div class="stat-value" style="font-size:22px;">
                Rp{{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:16px;">
        <div>
            <h2>Pesanan Terbaru</h2>
            <p class="muted">Lima pesanan terbaru yang masuk ke sistem.</p>
        </div>

        <a href="{{ route('admin.orders.index') }}" class="btn">
            Lihat Semua Pesanan
        </a>
    </div>

    @if($latestOrders->isEmpty())
        <div class="card">
            <p>Belum ada pesanan.</p>
        </div>
    @else
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($latestOrders as $order)
                        <tr>
                            <td><strong>{{ $order->order_code }}</strong></td>
                            <td>{{ $order->user->name ?? 'User tidak ditemukan' }}</td>
                            <td>Rp{{ number_format($order->total, 0, ',', '.') }}</td>
                            <td>
                                <span class="status">{{ ucfirst($order->status) }}</span>
                            </td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
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