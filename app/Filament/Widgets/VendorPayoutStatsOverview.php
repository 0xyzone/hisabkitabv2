<?php

namespace App\Filament\Widgets;

use App\Models\Item;
use App\Models\ItemReturn;
use App\Models\VendorPayment;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class VendorPayoutStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalItems = Item::count();
        $activeItems = Item::where('is_active', true)->count();

        $totalPiecesReturned = (float) ItemReturn::sum('quantity');
        $totalReturnEntries = ItemReturn::count();

        $totalPayout = (float) ItemReturn::sum('total_payout');
        $totalPaymentsReceived = (float) VendorPayment::sum('amount');
        $totalPaymentEntries = VendorPayment::count();

        $outstandingBalance = $totalPayout - $totalPaymentsReceived;

        return [
            Stat::make('Total Items', (string) $totalItems)
                ->description("{$activeItems} active catalog items")
                ->descriptionIcon(Heroicon::OutlinedCube)
                ->color('info'),

            Stat::make('Pieces Sent Back', number_format($totalPiecesReturned, 0))
                ->description("{$totalReturnEntries} return entries recorded")
                ->descriptionIcon(Heroicon::OutlinedArrowUturnLeft)
                ->color('primary'),

            Stat::make('Total Payout Expected', 'Rs. '.number_format($totalPayout, 2))
                ->description('Calculated return payout')
                ->descriptionIcon(Heroicon::OutlinedBanknotes)
                ->color('warning'),

            Stat::make('Payments Received', 'Rs. '.number_format($totalPaymentsReceived, 2))
                ->description("{$totalPaymentEntries} payment transactions")
                ->descriptionIcon(Heroicon::OutlinedCheckCircle)
                ->color('success'),

            Stat::make('Outstanding Due', 'Rs. '.number_format(abs($outstandingBalance), 2))
                ->description($outstandingBalance > 0 ? 'Pending payout from vendor' : ($outstandingBalance < 0 ? 'Advance paid by vendor' : 'Fully settled'))
                ->descriptionIcon($outstandingBalance > 0 ? Heroicon::OutlinedExclamationCircle : Heroicon::OutlinedCheckBadge)
                ->color($outstandingBalance > 0 ? 'danger' : 'success'),
        ];
    }
}
