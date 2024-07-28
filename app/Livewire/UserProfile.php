<?php

namespace App\Livewire;

use App\Models\Instansi;
use App\Models\Pelanggan;
use App\Models\User;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class UserProfile extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public $record;

    public function mount(Pelanggan $pelanggan): void
    {
        $this->record = $pelanggan->where('user_id', auth()->id())->first();

        if ($this->record) {
            $this->form->fill($this->record->toArray());
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->fill()
            ->schema([
                \Filament\Forms\Components\Section::make('Data Instansi')
                    ->description('Harap daftarkan instansi untuk dapat melakukan pemesanan. proses verifikasi paling lama 2 × 24 jam.')
                    ->aside()
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('instansi')
                            ->required(),
                        \Filament\Forms\Components\Select::make('kecamatan')
                            ->native(false)
->live() 
                            ->options(function () {
                                $data = File::json('kotajayapura.json');
                                foreach ($data as $key => $value) {
                                    $options[$key] = $key;
                                }
                                return $options;
                            })
                            ->required(),
                        \Filament\Forms\Components\Select::make('kelurahan')
                            ->native(false)
                            ->options(function (Get $get) {
                                $kecamatan = $get('kecamatan');
                                $data = File::json('kotajayapura.json');
                                if (!$kecamatan) {
                                    return [];
                                }

                                foreach ($data[$kecamatan] as $item) {
                                    $options[$item] = $item;
                                }
                                return $options;
                            })
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('alamat_kantor')
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('email_kantor')
                            ->email()
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('telp_kantor')
                            ->tel()
                            ->required(),
                    ])
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function create(): void
    {
        if (!$this->record) {
            $pelanggan = Pelanggan::create($this->form->getState());
            $pelanggan->user_id = auth()->id();
            $pelanggan->save();
        } else {
            $this->record->update($this->form->getState());
        }

        \Filament\Notifications\Notification::make()
            ->success()
            ->title('Data berhasil disimpan')
            ->send();
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
