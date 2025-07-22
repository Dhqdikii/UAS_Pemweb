<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Filament\Admin\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// Pastikan use statements ini ada dan benar untuk OrderResource:
use Filament\Tables\Columns\SelectColumn;
use Filament\Forms\Components\ViewField;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;


class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form // PASTIKAN FUNGSI INI DI DALAM KELAS
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Order Information')
                    ->schema([
                        Forms\Components\TextInput::make('user.name')->label('Customer Name')->disabled(),
                        Forms\Components\TextInput::make('total_price')->label('Total Price')->money('IDR')->disabled(),
                        Select::make('status')
                            ->options([
                                'pending' => 'Diproses',
                                'preparing' => 'Siap Diambil',
                                'completed' => 'Selesai',
                            ])
                            ->required()
                            ->live(),

                        ViewField::make('orderDetails')
                            ->view('filament.forms.components.order-details-viewer')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table // PASTIKAN FUNGSI INI DI DALAM KELAS
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Customer')->searchable()->sortable(),
                TextColumn::make('total_price')->money('IDR')->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'preparing' => 'info',
                        'completed' => 'success',
                    })
                    ->sortable(),
                TextColumn::make('created_at')->dateTime()->label('Order Date')->sortable(),
            ]);
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}