<?php

namespace App\Filament\Resources\Items\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Item Name')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('e.g. Cotton Shirt'),
                FileUpload::make('image')
                    ->label('Item Image')
                    ->image()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/svg+xml'])
                    ->disk('public')
                    ->directory('items')
                    ->visibility('public')
                    ->imageEditor()
                    ->maxSize(5120)
                    ->columnSpanFull(),
                TextInput::make('payout_price')
                    ->label('Payout Price')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->step(0.01)
                    ->prefix('Rs. ')
                    ->placeholder('0.00'),
                TextInput::make('unit')
                    ->label('Unit')
                    ->required()
                    ->datalist([
                        'per piece',
                        'per box',
                        'per dozen',
                        'per kg',
                        'per meter',
                        'per pack',
                        'per set',
                    ])
                    ->default('per piece')
                    ->placeholder('e.g. per piece'),
                Textarea::make('description')
                    ->label('Description')
                    ->rows(3)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->label('Active Status')
                    ->default(true),
            ]);
    }
}
