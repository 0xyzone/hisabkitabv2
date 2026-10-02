<?php

namespace App\Filament\Resources\ItemReturns;

use App\Filament\Resources\ItemReturns\Pages\CreateItemReturn;
use App\Filament\Resources\ItemReturns\Pages\EditItemReturn;
use App\Filament\Resources\ItemReturns\Pages\ListItemReturns;
use App\Filament\Resources\ItemReturns\Schemas\ItemReturnForm;
use App\Filament\Resources\ItemReturns\Tables\ItemReturnsTable;
use App\Models\ItemReturn;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ItemReturnResource extends Resource
{
    protected static ?string $model = ItemReturn::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUturnLeft;

    protected static string|\UnitEnum|null $navigationGroup = 'Returns & Payouts';

    protected static ?string $navigationLabel = 'Item Returns';

    protected static ?string $modelLabel = 'Item Return';

    protected static ?string $pluralModelLabel = 'Item Returns';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return ItemReturnForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ItemReturnsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListItemReturns::route('/'),
            'create' => CreateItemReturn::route('/create'),
            'edit' => EditItemReturn::route('/{record}/edit'),
        ];
    }
}
