<?php

namespace App\Filament\Resources\VendorPayments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VendorPaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vendor.name')
                    ->label('Vendor')
                    ->placeholder('General / None')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('amount')
                    ->label('Payment Received')
                    ->prefix('Rs. ')
                    ->numeric(decimalPlaces: 2)
                    ->weight('bold')
                    ->color('success')
                    ->sortable()
                    ->summarize(Sum::make()->label('Total Received')->prefix('Rs. ')),
                TextColumn::make('payment_date')
                    ->label('Payment Date')
                    ->date()
                    ->sortable(),
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
                    })
                    ->searchable(),
                TextColumn::make('reference_number')
                    ->label('Ref / Cheque #')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('vendor_id')
                    ->label('Vendor')
                    ->relationship('vendor', 'name'),
                SelectFilter::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'cash' => 'Cash',
                        'bank_transfer' => 'Bank Transfer',
                        'cheque' => 'Cheque',
                        'digital_wallet' => 'Digital Wallet',
                        'other' => 'Other',
                    ]),
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
