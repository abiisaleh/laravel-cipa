<?php

namespace App\Filament\Resources\TabungResource\RelationManagers;

use App\Models\StokTabung;
use App\Models\Tabung;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TabungRelationManager extends RelationManager
{
    protected static string $relationship = 'stokTabung';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('jumlah')->numeric()->default(1)->minValue(1)->maxValue(99)->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('kode')
            ->columns([
                Tables\Columns\TextColumn::make('kode')->searchable(),
                Tables\Columns\ToggleColumn::make('active'),
                Tables\Columns\IconColumn::make('digunakan')->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah stok')
                    ->mutateFormDataUsing(function (array $data): array {

                        $tabung = $this->ownerRecord;
                        $stokTabung = [];
                        for ($i = 0; $i < $data['jumlah']; $i++) {
                            $stokTabung[] = [
                                'tabung_id' => $tabung->id,
                                'kode' => $tabung->kode . str_pad((StokTabung::where('tabung_id', $tabung->id)->count() + 1 + $i), 2, '0', STR_PAD_LEFT)
                            ];
                        }

                        return $stokTabung;
                    })->using(function (array $data, string $model): Model {
                        $model::insert($data);
                        return $model::latest()->first();
                    }),
            ])
            ->actions([
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

public function isReadOnly(): bool
{
    return auth()->user()->role != 'petugas';
}

}
