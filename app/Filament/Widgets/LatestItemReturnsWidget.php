<?php

namespace App\Filament\Widgets;

use App\Models\ItemReturn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestItemReturnsWidget extends TableWidget
{
    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Recent Items Sent Back to Vendor';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => ItemReturn::query()->with(['item', 'vendor'])->latest('return_date')->latest('id'))
            ->paginated([5])
            ->defaultPaginationPageOption(5)
            ->columns([
                ImageColumn::make('item.image')
                    ->label('Image')
                    ->disk('public')
                    ->square()
                    ->size(35),
                TextColumn::make('item.name')
                    ->label('Item')
                    ->weight('bold'),
                TextColumn::make('vendor.name')
                    ->label('Vendor')
                    ->placeholder('General / None'),
                TextColumn::make('quantity')
                    ->label('Pieces / Qty')
                    ->numeric(decimalPlaces: 2),
                TextColumn::make('item.unit')
                    ->label('Unit')
                    ->badge()
                    ->color('info'),
                TextColumn::make('unit_payout_price')
                    ->label('Unit Price')
                    ->prefix('Rs. ')
                    ->numeric(decimalPlaces: 2),
                TextColumn::make('total_payout')
                    ->label('Total Payout')
                    ->prefix('Rs. ')
                    ->numeric(decimalPlaces: 2)
                    ->weight('bold')
                    ->color('warning'),
                TextColumn::make('return_date')
                    ->label('Return Date')
                    ->date(),
            ]);
    }
}
