<?php

namespace App\Filament\Resources\ItemReturns\Schemas;

use App\Models\Item;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class ItemReturnForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('vendor_id')
                    ->label('Vendor')
                    ->relationship('vendor', 'name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->label('Vendor Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->maxLength(255),
                        Textarea::make('address')
                            ->label('Address')
                            ->rows(2),
                    ]),
                Select::make('item_id')
                    ->label('Item')
                    ->relationship('item', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (?string $state, Set $set, Get $get): void {
                        if (! $state) {
                            return;
                        }

                        $item = Item::find($state);
                        if (! $item) {
                            return;
                        }

                        $unitPrice = (float) $item->payout_price;
                        $set('unit_payout_price', $unitPrice);

                        $quantity = (float) ($get('quantity') ?: 1);
                        if (! $get('quantity')) {
                            $set('quantity', 1);
                        }

                        $set('total_payout', round($quantity * $unitPrice, 2));
                    }),
                TextInput::make('quantity')
                    ->label('Pieces / Quantity Sent Back')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->minValue(0.01)
                    ->live(onBlur: false)
                    ->helperText(function (Get $get): string {
                        $itemId = $get('item_id');
                        if (! $itemId) {
                            return 'Enter quantity/pieces sent back';
                        }
                        $item = Item::find($itemId);

                        return $item ? 'Item Unit: '.$item->unit : '';
                    })
                    ->afterStateUpdated(function (?string $state, Set $set, Get $get): void {
                        $quantity = (float) ($state ?: 0);
                        $unitPrice = (float) ($get('unit_payout_price') ?: 0);
                        $set('total_payout', round($quantity * $unitPrice, 2));
                    }),
                TextInput::make('unit_payout_price')
                    ->label('Unit Payout Price')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01)
                    ->prefix('Rs. ')
                    ->live(onBlur: false)
                    ->afterStateUpdated(function (?string $state, Set $set, Get $get): void {
                        $unitPrice = (float) ($state ?: 0);
                        $quantity = (float) ($get('quantity') ?: 0);
                        $set('total_payout', round($quantity * $unitPrice, 2));
                    }),
                TextInput::make('total_payout')
                    ->label('Total Payout')
                    ->required()
                    ->numeric()
                    ->prefix('Rs. ')
                    ->readOnly()
                    ->dehydrated()
                    ->helperText('Auto-calculated: Quantity × Unit Payout Price'),
                DatePicker::make('return_date')
                    ->label('Return Date')
                    ->default(now())
                    ->required(),
                TextInput::make('reference_number')
                    ->label('Reference / Challan No.')
                    ->maxLength(255)
                    ->placeholder('e.g. RET-001'),
                Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3)
                    ->columnSpanFull()
                    ->placeholder('Notes or return reasons...'),
            ]);
    }
}
