<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $statusLabels = [
            'all' => 'Semua Status',
            'pending' => 'Pending',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'delivering' => 'Diantar',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $status = $request->input('status', 'completed');

        if (!array_key_exists($status, $statusLabels)) {
            $status = 'completed';
        }

        $query = Order::with('user')
            ->when($dateFrom, function ($query) use ($dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function ($query) use ($dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            });

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
}
