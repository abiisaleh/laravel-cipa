<?php

namespace App\Livewire\Order;

use App\Models\Pembayaran;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Table;
use Livewire\Component;

class ListOrder extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $countBelumBayar = '';
    public $countSudahBayar = '';

    public ?string $activeTab = 'semua';

    public function mount()
    {
        $pesanan = Pembayaran::query()->whereHas(
            'pesanan',
            fn ($query) => $query->where('user_id', auth()->id())
        );

        $this->countBelumBayar = $pesanan->where('tgl_lunas', null)->count();
        $this->countSudahBayar = $pesanan->whereNot('tgl_lunas', null)->where('tgl_diterima', null)->count();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Pembayaran::query()->whereHas(
                'pesanan',
                fn ($query) => $query->where('user_id', auth()->id())
            ))
            ->modifyQueryUsing(function ($query) {
                if ($this->activeTab === 'belumBayar')
                    $query->where('tgl_lunas', null);

                if ($this->activeTab === 'sudahBayar')
                    $query->whereNot('tgl_lunas', null)->where('tgl_diterima', null);

                if ($this->activeTab === 'selesai')
                    $query->whereNot('tgl_lunas', null)->whereNot('tgl_diterima', null);

                if ($this->activeTab === 'batal')
                    $query->withTrashed()->onlyTrashed();

                return $query;
            })
            ->columns([
                TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y, H:m')->since(),
                TextColumn::make('metode')->badge()->color(fn (string $state) => $state == 'cash' ? 'success' : 'primary'),
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
        return view('livewire.order.list-order');
    }
}
