<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    private function ensureAdmin()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403, 'Halaman ini hanya untuk admin.');
        }
    }

    private function filteredOrders(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');
        $paymentMethod = $request->input('payment_method');

        return Order::with(['user', 'items'])
            ->when($startDate, function ($query, $startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            })
            ->when($status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($paymentMethod, function ($query, $paymentMethod) {
                $query->where('payment_method', $paymentMethod);
            });
    }

    public function index(Request $request)
    {
        $this->ensureAdmin();

        $ordersQuery = $this->filteredOrders($request);

        $ordersForSummary = (clone $ordersQuery)->get();

        $orders = (clone $ordersQuery)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $summary = [
            'total_orders' => $ordersForSummary->count(),
            'completed_orders' => $ordersForSummary->where('status', 'completed')->count(),
            'pending_orders' => $ordersForSummary->where('status', 'pending')->count(),
            'cancelled_orders' => $ordersForSummary->where('status', 'cancelled')->count(),
            'total_revenue' => $ordersForSummary->where('status', 'completed')->sum('total'),
            'gross_total' => $ordersForSummary->sum('total'),
            'cod_orders' => $ordersForSummary->where('payment_method', 'cod')->count(),
            'qris_orders' => $ordersForSummary->where('payment_method', 'qris')->count(),
        ];

        $topItems = $ordersForSummary
            ->flatMap(function ($order) {
                return $order->items;
            })
            ->groupBy('item_name')
            ->map(function ($items, $name) {
                return [
                    'name' => $name,
                    'quantity' => $items->sum('quantity'),
                    'total' => $items->sum('total'),
                ];
            })
            ->sortByDesc('quantity')
            ->take(5)
            ->values();

        return view('admin.reports.index', compact(
            'orders',
            'summary',
            'topItems'
        ));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $this->ensureAdmin();

        $orders = $this->filteredOrders($request)
            ->latest()
            ->get();

        $fileName = 'laporan-dapurmahasiswa-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($orders) {
            $handle = fopen('php://output', 'w');

            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, [
                'Kode Pesanan',
                'Tanggal Pesanan',
                'Nama Pelanggan',
                'Email',
                'Metode Pembayaran',
                'Status',
                'Subtotal',
                'Ongkir',
                'Total',
                'Alamat Pengantaran',
                'Tanggal Pengantaran',
            ]);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->order_code,
                    optional($order->created_at)->format('d-m-Y H:i'),
                    $order->user->name ?? '-',
                    $order->user->email ?? '-',
                    strtoupper($order->payment_method ?? '-'),
                    ucfirst($order->status ?? '-'),
                    $order->subtotal,
                    $order->delivery_fee,
                    $order->total,
                    $order->delivery_address,
                    $order->delivery_date,
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
