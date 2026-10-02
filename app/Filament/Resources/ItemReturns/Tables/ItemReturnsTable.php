<?php

namespace App\Filament\Resources\ItemReturns\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ItemReturnsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('item.image')
                    ->label('Image')
                    ->disk('public')
                    ->square()
                    ->size(40),
                TextColumn::make('item.name')
                    ->label('Item')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('vendor.name')
                    ->label('Vendor')
                    ->placeholder('General / None')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('quantity')
                    ->label('Pieces / Qty')
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->summarize(Sum::make()->label('Total Quantity')),
                TextColumn::make('item.unit')
                    ->label('Unit')
                    ->badge()
                    ->color('info'),
                TextColumn::make('unit_payout_price')
                    ->label('Unit Price')
                    ->prefix('Rs. ')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),
                TextColumn::make('total_payout')
                    ->label('Total Payout')
                    ->prefix('Rs. ')
                    ->numeric(decimalPlaces: 2)
                    ->weight('bold')
                    ->color('warning')
                    ->sortable()
                    ->summarize(Sum::make()->label('Total Payout')->prefix('Rs. ')),
                TextColumn::make('return_date')
                    ->label('Return Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('reference_number')
                    ->label('Ref #')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('vendor_id')
                    ->label('Vendor')
                    ->relationship('vendor', 'name'),
                SelectFilter::make('item_id')
                    ->label('Item')
                    ->relationship('item', 'name'),
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
