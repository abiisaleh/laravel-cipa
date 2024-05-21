<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelangganResource\Pages;
use App\Models\Pelanggan;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PelangganResource extends Resource
{
    protected static ?string $model = Pelanggan::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 2;

    public static function getNavigationBadge(): ?string
    {
        $countVerified = static::getModel()::where('verified', false)->count();
        return $countVerified == 0 ? '' : $countVerified;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    TextInput::make('instansi')->disabled(),
                    TextInput::make('alamat_kantor')->disabled(),
                    TextInput::make('telp_kantor')->disabled(),
                    TextInput::make('email_kantor')->disabled(),
                    Toggle::make('verified')->label('Data yang dimasukkan sudah benar'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('instansi')->searchable(),
                TextColumn::make('alamat_kantor')->searchable(),
                TextColumn::make('telp_kantor'),
                TextColumn::make('email_kantor'),
                IconColumn::make('verified')->boolean(),
            ])
            ->filters([
                Filter::make('verified')->query(fn (Builder $query) => $query->where('verified', true)),
                Filter::make('not verified')->query(fn (Builder $query) => $query->where('verified', false))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListPelanggans::route('/'),
            'create' => Pages\CreatePelanggan::route('/create'),
            'edit' => Pages\EditPelanggan::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()->role != 'petugas';
    }

    public static function canDelete(Model $record): bool
    {
        if (auth()->user()->role == 'karyawan')
            return true;

        return false;
    }

    public static function canDeleteAny(): bool
    {
        if (auth()->user()->role == 'karyawan')
            return true;

        return false;
    }
}
