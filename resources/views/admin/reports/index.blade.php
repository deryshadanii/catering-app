@extends('layouts.admin')

@section('title', 'Laporan Pendapatan')

@section('content')
    <h1>Laporan Pendapatan</h1>
    <p class="muted">
        Halaman ini digunakan untuk melihat laporan pesanan dan pendapatan DapurMahasiswa berdasarkan tanggal dan status pesanan.
    </p>

    <div class="filter-card">
        <form action="{{ route('admin.reports.index') }}" method="GET">
            <div class="filter-row">
                <div>
                    <label>Tanggal Awal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}">
                </div>

                <div>
                    <label>Tanggal Akhir</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}">
                </div>

                <div>
                    <label>Status</label>
                    <select name="status">
                        @foreach($statusLabels as $statusKey => $statusLabel)
                            <option value="{{ $statusKey }}" {{ request('status', 'completed') === $statusKey ? 'selected' : '' }}>
                                {{ $statusLabel }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn">
                        Tampilkan
                    </button>

                    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Jumlah Pesanan</div>
            <div class="stat-value">{{ $totalOrders }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Subtotal Pesanan</div>
            <div class="stat-value" style="font-size:22px;">
                Rp{{ number_format($totalSubtotal, 0, ',', '.') }}
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Total Ongkir</div>
            <div class="stat-value" style="font-size:22px;">
                Rp{{ number_format($totalDeliveryFee, 0, ',', '.') }}
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-label">
                @if($status === 'completed')
                    Pendapatan Selesai
                @else
                    Total Nilai Pesanan
                @endif
            </div>
            <div class="stat-value" style="font-size:22px;">
                Rp{{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Pendapatan Valid Selesai</div>
            <div class="stat-value" style="font-size:22px;">
                Rp{{ number_format($completedRevenue, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; gap:16px; margin-bottom:16px;">
    <div>
        <h2>Detail Laporan</h2>
        <p class="muted">
            Data pesanan sesuai filter yang dipilih.
        </p>
    </div>

    <div style="display:flex; gap:8px; flex-wrap:wrap;">
        <a href="{{ route('admin.reports.export', request()->query()) }}" class="btn">
            Export CSV
        </a>

        <button onclick="window.print()" class="btn btn-secondary">
            Cetak Laporan
        </button>
    </div>
</div>

    @if($orders->isEmpty())
        <div class="card">
            <p>Tidak ada data pesanan pada filter ini.</p>
        </div>
    @else
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Kode Pesanan</th>
                        <th>Pelanggan</th>
                        <th>Status</th>
                        <th>Subtotal</th>
                        <th>Ongkir</th>
                        <th>Total</th>
                        <th>Tanggal</th>
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
                                Rp{{ number_format($order->subtotal, 0, ',', '.') }}
                            </td>

                            <td>
                                Rp{{ number_format($order->delivery_fee, 0, ',', '.') }}
                            </td>

                            <td>
                                <strong>Rp{{ number_format($order->total, 0, ',', '.') }}</strong>
                            </td>

                            <td>
                                {{ $order->created_at->format('d M Y H:i') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <th colspan="3">Total</th>
                        <th>Rp{{ number_format($totalSubtotal, 0, ',', '.') }}</th>
                        <th>Rp{{ number_format($totalDeliveryFee, 0, ',', '.') }}</th>
                        <th>Rp{{ number_format($totalRevenue, 0, ',', '.') }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    @endif
@endsection