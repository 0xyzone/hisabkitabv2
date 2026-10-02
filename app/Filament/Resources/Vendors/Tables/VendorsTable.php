<?php

namespace App\Filament\Resources\Vendors\Tables;

use App\Models\Vendor;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VendorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Vendor Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('item_returns_sum_total_payout')
                    ->sum('itemReturns', 'total_payout')
                    ->label('Total Returns Payout')
                    ->prefix('Rs. ')
                    ->numeric(decimalPlaces: 2)
                    ->color('warning')
                    ->sortable(),
                TextColumn::make('vendor_payments_sum_amount')
                    ->sum('vendorPayments', 'amount')
                    ->label('Total Received')
                    ->prefix('Rs. ')
                    ->numeric(decimalPlaces: 2)
                    ->color('success')
                    ->sortable(),
                TextColumn::make('balance')
                    ->label('Balance Due')
                    ->state(function (Vendor $record): float {
                        $payout = (float) $record->itemReturns()->sum('total_payout');
                        $paid = (float) $record->vendorPayments()->sum('amount');

                        return round($payout - $paid, 2);
                    })
                    ->prefix('Rs. ')
                    ->numeric(decimalPlaces: 2)
                    ->weight('bold')
                    ->color(fn (float $state): string => $state > 0 ? 'danger' : ($state < 0 ? 'info' : 'success')),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
