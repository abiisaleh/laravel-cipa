<?php

namespace App\Livewire\Order;

use App\Models\Pesanan;
use App\Models\StokTabung;
use App\Models\Tabung;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class CreateOrder extends Component implements HasForms, HasActions
{
    use InteractsWithForms;
    use InteractsWithActions;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('Pesanan')
                        ->icon('heroicon-m-shopping-bag')
                        ->schema([
                            Repeater::make('items')
                                ->reorderable(false)
                                ->hiddenLabel()
                                ->columns(2)
                                ->schema([
                                    Select::make('tabung')
                                        ->searchable()
                                        ->required()
                                        ->live()
                                        ->options(function (): array {
                                            return Tabung::all()->pluck('nama', 'id')->toArray();
                                        }),

                                    Select::make('isi')
                                        ->required()
                                        ->disabled(fn (Get $get) => $get('tabung') == null)
                                        ->options([
                                            'full' => 'Full',
                                            'refill' => 'Refill',
                                            'kosong' => 'Kosong'
                                        ])
                                        ->live()
                                        ->afterStateUpdated(function (Get $get, Set $set, string $state) {

                                            match ($state) {
                                                'full' => $harga = Tabung::find($get('tabung'))->harga_full,
                                                'refill' => $harga = Tabung::find($get('tabung'))->harga_refill,
                                                'kosong' => $harga = Tabung::find($get('tabung'))->harga_kosong
                                            };

                                            $set('subtotal', $harga);
                                            $set('harga', $harga);
                                        }),

                                    Fieldset::make()
                                        ->columns(3)
                                        ->schema([
                                            TextInput::make('harga')
                                                ->default(0)
                                                ->prefix('Rp')
                                                ->disabled(),

                                            TextInput::make('qty')
                                                ->live()
                                                ->afterStateUpdated(fn (Get $get, Set $set, int|null $state) => $set('subtotal', $get('harga') * $state ?? 1))
                                                ->required()
                                                ->numeric()
                                                ->default(0)
                                                ->minValue(1)
                                                ->maxValue(fn (Get $get) => Tabung::find($get('tabung'))->stok ?? 0)
                                                ->hint(function (Get $get) {
                                                    if ($get('isi') == 'refill')
                                                        return;
                                                    $stokTersedia = Tabung::find($get('tabung'))->stok ?? 0;
                                                    return "stok {$stokTersedia}";
                                                }),

                                            TextInput::make('subtotal')
                                                ->default(0)
                                                ->prefix('Rp')
                                                ->disabled()
                                        ])
                                ])
                                ->afterStateUpdated(function (Set $set, array $state) {
                                    $subtotalItems = 0;
                                    $ongkir = 0;
                                    $hargaOngkir = \App\Models\Setting::where('key', 'ongkir')->first()->value;

                                    foreach ($state as $item) {
                                        $qty = $item['qty'] == null ? 1 : $item['qty'];
                                        $subtotalItems += $item['harga'] * $qty;
                                        $beratTabung = Tabung::find($item['tabung'])->ukuranTabung->berat ?? 0;
                                        $ongkir += $beratTabung * $hargaOngkir * $qty;
                                    }

                                    $set('subtotal_items', $subtotalItems);
                                    $set('ongkos_kirim', $ongkir);
                                    $set('total', $subtotalItems + $ongkir);
                                }),
                        ]),
                    Step::make('Pembayaran')
                        ->icon('heroicon-m-credit-card')
                        ->schema([
                            TextInput::make('subtotal_items')->inlineLabel()->disabled()->prefix('Rp'),
                            TextInput::make('ongkos_kirim')->inlineLabel()->disabled()->prefix('Rp'),
                            TextInput::make('total')->inlineLabel()->disabled()->prefix('Rp'),
                            ToggleButtons::make('metode_pembayaran')
                                ->inline()
                                ->inlineLabel()
                                ->required()
                                ->options(
                                    [
                                        'BCA' => 'BCA',
                                        'BNI' => 'BNI',
                                        'BRI' => 'BRI',
                                        'Mandiri' => 'Mandiri',
                                        'tunai' => 'Tunai',
                                    ]

                                )
                        ])

                ])->submitAction($this->checkout())
            ])
            ->statePath('data');
    }

    public function checkout(): Action
    {
        return Action::make('checkout')->extraAttributes(['type' => 'submit']);
    }

    public function create()
    {
        $pembayaran = \App\Models\Pembayaran::create([
            'user_id' => auth()->id(),
            'metode' => $this->data['metode_pembayaran'],
            'subtotal' => $this->data['subtotal_items'],
            'ongkir' => $this->data['ongkos_kirim'],
        ]);

        foreach ($this->data['items'] as $item) {

            $tabung = Tabung::find($item['tabung']);
            $stokTabung = StokTabung::whereBelongsTo($tabung)->where('digunakan', false)->get();
            $kodeTabung = [];

            for ($i = 0; $i < $item['qty']; $i++) {
                $stokTabung[$i]->digunakan = true;
                $stokTabung[$i]->save();
                $kodeTabung[] = $stokTabung[$i]->kode;
            }

            $isi = $item['isi'];

            Pesanan::create([
                'tabung_id' => $tabung->id,
                'pembayaran_id' => $pembayaran->id,
                'tabung' => "{$tabung->nama} {$isi}",
                'kode_tabung' => $kodeTabung,
                'harga' => $item['harga'],
                'qty' => $item['qty'],
            ]);
        }

        if ($this->data['metode_pembayaran'] != 'tunai') {
            $createVA = Http::withHeader('content-type', 'application/json')
                ->withBasicAuth(env('XENDIT_API_KEY'), '')
                ->post('https://api.xendit.co/callback_virtual_accounts', [
                    "external_id" => "$pembayaran->id",
                    "bank_code" => str_replace(' ', '_', strtoupper($this->data['metode_pembayaran'])),
                    "name" => auth()->user()->name,
                    "is_single_use" => true,
                    "is_closed" => true,
                    "expected_amount" => $pembayaran->total,
                    "expiration_date" => now()->addDay(),
                ])->json();

            $pembayaran->va_id = $createVA['id'];
            $pembayaran->save();
        }

        Notification::make()
            ->title('Pesanan dibuat')
            ->body(function () use ($pembayaran) {
                $penerima = $pembayaran->user->pelanggan->instansi;
                $total = number_format($pembayaran->total);
                return "Total pesanan Rp {$total} oleh {$penerima}";
            })
            ->sendToDatabase(User::where('role', '!=', 'pelanggan')->get());

        return redirect(url('/checkout', $pembayaran->id));
    }

    public function render()
    {
        return view('livewire.order.create-order');
    }
}
