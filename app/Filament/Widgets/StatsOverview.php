<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        //Calculation for product
        $currentMonthCount = Product::whereMonth('created_at', Carbon::now()->month)->count();
        $previousMonthCount = Product::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
        $totalProducts = Product::count();
        $newProducts = Product::whereMonth('created_at', Carbon::now()->month)->count();

        if ($currentMonthCount > $previousMonthCount) {
            $percentageChange = ($totalProducts - $newProducts) / $totalProducts * 100;
            $description = number_format(abs($percentageChange)) . '% ' . ($percentageChange > 0 ? 'Increase' : 'Decrease');
            $chart = [$previousMonthCount, $currentMonthCount];
            $descriptionIcon = 'heroicon-s-trending-up';
            $color = 'success';
        } elseif ($currentMonthCount < $previousMonthCount) {
            $percentageChange = ($newProducts - $totalProducts) / $totalProducts * 100;
            $description = number_format(abs($percentageChange)) . '% ' . ($percentageChange > 0 ? 'Increase' : 'Decrease');
            $chart = [$previousMonthCount, $currentMonthCount];
            $descriptionIcon = 'heroicon-s-trending-down';
            $color = 'danger';
        } else {
            $description = 'No changes';
            $chart = [$previousMonthCount, $currentMonthCount];
            $descriptionIcon = 'heroicon-s-minus';
            $color = 'primary';
        }

        //Calculation for product
        $currentMonthOrder = Order::whereMonth('created_at', Carbon::now()->month)->count();
        $previousMonthOrder = Order::whereMonth('created_at', Carbon::now()->subMonth()->month)->count();
        $totalOrders = Order::count();
        $newOrders = Order::whereMonth('created_at', Carbon::now()->month)->count();

        if ($currentMonthOrder > $previousMonthOrder) {
            $percentageOrderChange = ($totalOrders - $newOrders) / $totalOrders * 100;
            $descriptionOrder = number_format(abs($percentageOrderChange)) . '% ' . ($percentageOrderChange > 0 ? 'Increase' : 'Decrease');
            $chartOrder = [$previousMonthOrder, $currentMonthOrder];
            $descriptionIconOrder = 'heroicon-s-trending-up';
            $colorOrder = 'success';
        } elseif ($currentMonthOrder < $previousMonthOrder) {
            $percentageOrderChange = ($newOrders - $totalOrders) / $totalOrders * 100;
            $descriptionOrder = number_format(abs($percentageOrderChange)) . '% ' . ($percentageOrderChange > 0 ? 'Increase' : 'Decrease');
            $chartOrder = [$previousMonthOrder, $currentMonthOrder];
            $descriptionIconOrder = 'heroicon-s-trending-down';
            $colorOrder = 'danger';
        } else {
            $descriptionOrder = 'No changes';
            $chartOrder = [$previousMonthOrder, $currentMonthOrder];
            $descriptionIconOrder = 'heroicon-s-minus';
            $colorOrder = 'primary';
        }

        //

        return [
            Card::make('Stock Keeping', Product::sum('quantity_on_hand'))
                ->description('Available')
                ->descriptionIcon('heroicon-s-check-circle')
                ->color('success'),
            Card::make('New Products ('.now()->format('F').')', $currentMonthCount)
                ->description($description)
                ->chart($chart)
                ->descriptionIcon($descriptionIcon)
                ->color($color),
            Card::make('New Orders ('. now()->format('F') . ')', $currentMonthOrder)
                ->description($descriptionOrder)
                ->chart($chartOrder)
                ->descriptionIcon($descriptionIconOrder)
                ->color($colorOrder),
        ];
    }
}
