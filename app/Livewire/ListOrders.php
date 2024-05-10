<?php

namespace App\Livewire;

use App\Models\Pembayaran;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ListOrders extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public ?string $activeTab = 'semua';

    public function table(Table $table): Table
    {
        return $table
            ->query(Pembayaran::query())
            ->modifyQueryUsing(function ($query) {
                if ($this->activeTab === 'belumBayar')
                    $query->where('tgl_lunas', null);

                if ($this->activeTab === 'sudahBayar')
                    $query->whereNot('tgl_lunas', null)->where('tgl_diterima', null);

                if ($this->activeTab === 'selesai')
                    $query->whereNot('tgl_lunas', null)->whereNot('tgl_diterima', null);

                return $query;
            })
            ->columns([
                TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y, H:m'),
                TextColumn::make('metode'),
                TextColumn::make('total')->numeric()->prefix('Rp '),
                IconColumn::make('lunas')->boolean(),
                IconColumn::make('diterima')->boolean(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                ViewAction::make()
                    ->url(function (Pembayaran $record) {
                        return url('/order', $record->id);
                    })
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function render()
    {
        return view('livewire.list-orders');
    }
}
