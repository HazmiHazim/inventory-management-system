<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use Illuminate\Support\Facades\DB;

class TotalOrderChart extends LineChartWidget
{
    protected static ?string $heading = 'Orders per month';

    protected function getData(): array
    {
        $orders = DB::table('orders')
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $datasets = [
            [
                'label' => 'Orders', 
                'data' => $orders->pluck('count')->toArray(),
            ],
        ];

        for ($month = 1; $month <= 12; $month++) {
            $monthLabel = date('M', mktime(0, 0, 0, $month, 1));
            $ordersCount = $orders->where('month', $month)->sum('count');

            $labels[] = $monthLabel;
            $datasets[0]['data'][] = $ordersCount;
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }
}
