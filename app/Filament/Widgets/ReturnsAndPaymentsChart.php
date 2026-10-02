<?php

namespace App\Filament\Widgets;

use App\Models\ItemReturn;
use App\Models\VendorPayment;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class ReturnsAndPaymentsChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected ?string $heading = 'Monthly Returns Payout vs Payments Received';

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(function (int $i): Carbon {
            return now()->subMonths($i);
        });

        $labels = $months->map(fn (Carbon $month): string => $month->format('M Y'))->toArray();

        $returnsPayoutData = $months->map(function (Carbon $month): float {
            return (float) ItemReturn::whereYear('return_date', $month->year)
                ->whereMonth('return_date', $month->month)
                ->sum('total_payout');
        })->toArray();

        $paymentsData = $months->map(function (Carbon $month): float {
            return (float) VendorPayment::whereYear('payment_date', $month->year)
                ->whereMonth('payment_date', $month->month)
                ->sum('amount');
        })->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Returns Payout Expected (Rs.)',
                    'data' => $returnsPayoutData,
                    'backgroundColor' => 'rgba(245, 158, 11, 0.7)',
                    'borderColor' => '#f59e0b',
                ],
                [
                    'label' => 'Payments Received (Rs.)',
                    'data' => $paymentsData,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.7)',
                    'borderColor' => '#10b981',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
