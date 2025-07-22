<?php // Pastikan ada tag pembuka PHP ini di baris pertama

namespace App\Filament\Admin\Resources; // Pastikan namespace ini benar

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use App\Models\User; // Pastikan ini mengarah ke model User Anda
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select; // Pastikan ini ada jika Anda menggunakannya
use Filament\Tables\Columns\TextColumn; // Pastikan ini ada jika Anda menggunakannya
use Illuminate\Support\Facades\Hash; // Pastikan ini ada jika Anda menggunakannya untuk password

class UserResource extends Resource // INI ADALAH AWAL DEFINISI KELAS
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form // FUNGSI INI HARUS DI DALAM KELAS
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('email')->email()->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
                Select::make('role')
                    ->options([
                        'admin' => 'Admin Kantin',
                        'user' => 'Mahasiswa',
                    ])
                    ->default('user')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table // FUNGSI INI JUGA HARUS DI DALAM KELAS
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('role')->badge()->color(fn (string $state): string => match ($state) {
                    'admin' => 'success',
                    'user' => 'info',
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
} // INI ADALAH AKHIR DEFINISI KELAS