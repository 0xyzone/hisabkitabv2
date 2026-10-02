<?php

namespace App\Filament\Resources\VendorPayments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VendorPaymentForm
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
                TextInput::make('amount')
                    ->label('Payment Amount Received')
                    ->required()
                    ->numeric()
                    ->minValue(0.01)
                    ->step(0.01)
                    ->prefix('Rs. ')
                    ->placeholder('0.00'),
                DatePicker::make('payment_date')
                    ->label('Payment Date')
                    ->default(now())
                    ->required(),
                Select::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'cash' => 'Cash',
                        'bank_transfer' => 'Bank Transfer',
                        'cheque' => 'Cheque',
                        'digital_wallet' => 'Digital Wallet (eSewa / Khalti)',
                        'other' => 'Other',
                    ])
                    ->default('cash')
                    ->required(),
                TextInput::make('reference_number')
                    ->label('Reference / Transaction ID / Cheque #')
                    ->maxLength(255)
                    ->placeholder('e.g. TXN-109283'),
                Textarea::make('notes')
                    ->label('Notes')
                    ->rows(3)
                    ->columnSpanFull()
                    ->placeholder('Any payment details or remarks...'),
            ]);
    }
}
