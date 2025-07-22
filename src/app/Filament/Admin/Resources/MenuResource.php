<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\MenuResource\Pages;
use App\Filament\Admin\Resources\MenuResource\RelationManagers;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// Pastikan use statements ini ada dan benar untuk MenuResource:
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\Select;


class MenuResource extends Resource
{
    protected static ?string $model = Menu::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form // PASTIKAN FUNGSI INI DI DALAM KELAS
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('price')->required()->numeric()->prefix('Rp.'),
                Textarea::make('description')->rows(3)->maxLength(65535),
                FileUpload::make('image')
                    ->image()
                    ->directory('menu-images')
                    ->visibility('public'),
                Select::make('category')
                    ->options([
                        'makanan berat' => 'Makanan Berat',
                        'minuman' => 'Minuman',
                        'snack' => 'Snack',
                    ])
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table // PASTIKAN FUNGSI INI DI DALAM KELAS
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('price')->money('IDR')->sortable(),
                TextColumn::make('category')->searchable()->sortable(),
                ImageColumn::make('image')->circular(),
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
            'index' => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit' => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}