<?php

namespace App\Filament\Widgets;

use App\Models\VendorPayment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestVendorPaymentsWidget extends TableWidget
{
    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Recent Payments Received from Vendor';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => VendorPayment::query()->with('vendor')->latest('payment_date')->latest('id'))
            ->paginated([5])
            ->defaultPaginationPageOption(5)
            ->columns([
                TextColumn::make('vendor.name')
                    ->label('Vendor')
                    ->placeholder('General / None')
                    ->weight('bold'),
                TextColumn::make('amount')
                    ->label('Amount Received')
                    ->prefix('Rs. ')
                    ->numeric(decimalPlaces: 2)
                    ->weight('bold')
                    ->color('success'),
                TextColumn::make('payment_date')
                    ->label('Payment Date')
                    ->date(),
                TextColumn::make('payment_method')
                    ->label('Method')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'cash' => 'Cash',
                        'bank_transfer' => 'Bank Transfer',
                        'cheque' => 'Cheque',
                        'digital_wallet' => 'Digital Wallet',
                        default => ucfirst(str_replace('_', ' ', $state)),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'cash' => 'success',
                        'bank_transfer' => 'info',
                        'cheque' => 'warning',
                        'digital_wallet' => 'primary',
                        default => 'gray',
                    }),
                TextColumn::make('reference_number')
                    ->label('Ref / Cheque #')
                    ->placeholder('-'),
            ]);
    }
}
