<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private function statusLabels()
    {
        return [
            'all' => 'Semua Status',
            'pending' => 'Pending',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'delivering' => 'Diantar',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
    }

    private function filteredOrdersQuery(Request $request)
    {
        $statusLabels = $this->statusLabels();

        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $status = $request->input('status', 'completed');

        if (!array_key_exists($status, $statusLabels)) {
            $status = 'completed';
        }

        return Order::with('user')
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            });
    }

    public function index(Request $request)
    {
        $statusLabels = $this->statusLabels();

        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $status = $request->input('status', 'completed');

        if (!array_key_exists($status, $statusLabels)) {
            $status = 'completed';
        }

        $query = $this->filteredOrdersQuery($request);

        $orders = (clone $query)
            ->latest()
            ->get();

        $totalOrders = (clone $query)->count();
        $totalSubtotal = (clone $query)->sum('subtotal');
        $totalDeliveryFee = (clone $query)->sum('delivery_fee');
        $totalRevenue = (clone $query)->sum('total');

        $completedRevenue = Order::where('status', 'completed')
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->sum('total');

        return view('admin.reports.index', compact(
            'orders',
            'statusLabels',
            'dateFrom',
            'dateTo',
            'status',
            'totalOrders',
            'totalSubtotal',
            'totalDeliveryFee',
            'totalRevenue',
            'completedRevenue'
        ));
    }

    public function exportCsv(Request $request)
    {
        $orders = $this->filteredOrdersQuery($request)
            ->latest()
            ->get();

        $fileName = 'laporan-dapurmahasiswa-' . now()->format('Y-m-d-H-i-s') . '.csv';

        return response()->streamDownload(function () use ($orders) {
            echo "\xEF\xBB\xBF";

            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Kode Pesanan',
                'Nama Pelanggan',
                'Email Pelanggan',
                'Status',
                'Alamat Pengantaran',
                'Metode Pembayaran',
                'Subtotal',
                'Ongkir',
                'Total',
                'Tanggal Pesan',
            ]);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->order_code,
                    $order->user->name ?? 'User tidak ditemukan',
                    $order->user->email ?? '-',
                    ucfirst($order->status),
                    $order->delivery_address,
                    strtoupper(str_replace('_', ' ', $order->payment_method)),
                    $order->subtotal,
                    $order->delivery_fee,
                    $order->total,
                    $order->created_at->format('d-m-Y H:i'),
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
