<?php

namespace App\Filament\Pages;

use App\Models\Ongkir;
use App\Models\Setting;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Facades\File;

class Settings extends Page implements HasForms, HasActions, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    use InteractsWithActions;

    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';

    protected static string $view = 'filament.pages.settings';

    protected static ?int $navigationSort = 10;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Contact Kantor')
                    ->aside()
                    ->description('Data ini akan di tampilkan di halaman web sebagai kontak dan akan muncul di laporan sebagai kop surat')
                    ->schema([
                        Fieldset::make('Alamat Kantor')
                            ->schema([
                                TextInput::make('alamat')
                                    ->placeholder('masukkan nama jalan atau nomor bangunan')
                                    ->required()
                                    ->default(Setting::where('key', 'alamat')->first()->value ?? '')
                                    ->columnSpanFull(),
                                Select::make('kecamatan')
                                    ->options(function () {
                                        $data = File::json('kotajayapura.json');
                                        foreach ($data as $key => $value) {
                                            $options[$key] = $key;
                                        }
                                        return $options;
                                    })
                                    ->native(false)
                                    ->default(Setting::where('key', 'kecamatan')->first()->value ?? '')
                                    ->required(),
                                Select::make('kelurahan')
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
                                    ->native(false)
                                    ->default(Setting::where('key', 'kelurahan')->first()->value ?? '')
                                    ->required(),
                                TextInput::make('kode_pos')
                                    ->maxLength(6)
                                    ->default(Setting::where('key', 'kode_pos')->first()->value ?? '')
                                    ->numeric()
                                    ->required(),
                            ])
                            ->columns(3),

                        TextInput::make('telp')
                            ->label('Telp Kantor')
                            ->default(Setting::where('key', 'telp')->first()->value ?? '')
                            ->tel()
                            ->required(),

                        TextInput::make('email')
                            ->label('Email Kantor')
                            ->default(Setting::where('key', 'email')->first()->value ?? '')
                            ->email()
                            ->required(),
                    ])->disabled(auth()->user()->role == 'petugas'),

                Section::make('Biaya')
                    ->aside()
                    ->description('Data ini digunakan untuk proses biaya  tambahan dalam pemesanan')
                    ->schema([
                        TextInput::make('denda')
                            ->label('Persentase Denda')
                            ->default(Setting::where('key', 'presentase_denda')->first()->value ?? 5)
                            ->numeric()
                            ->maxValue(100)
                            ->suffix('%')
                            ->helperText(str('Total denda yang akan didapatkan pelanggan **Jumlah Bulan Terlewat × Jumlah Denda**, jumlah suatu denda ditentukan dari besar **Presentase Denda × Total Pembayaran**.')
                                ->inlineMarkdown()
                                ->toHtmlString())
                            ->required(),
                    ])

            ])
            ->statePath('data');
    }

    public function formUser(): array
    {
        return [
            Grid::make()->schema([
                TextInput::make('name'),
                TextInput::make('email'),
                TextInput::make('password')->password()->hiddenOn('edit')->revealable(),
                Select::make('role')->options([
                    'karyawan' => 'karyawan',
                    'petugas' => 'petugas',
                    'pimpinan' => 'pimpinan',
                ]),
            ])
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Pengguna')
            ->query(User::query()->whereNot('role', 'pelanggan'))
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('email'),
                TextColumn::make('role')->badge()->color(function ($state) {
                    if ($state == 'pimpinan')
                        return 'success';
                    if ($state == 'petugas')
                        return 'primary';
                    if ($state == 'karyawan')
                        return 'danger';
                }),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make()->form($this->formUser()),
                DeleteAction::make(),
            ])
            ->headerActions([
                CreateAction::make()->form($this->formUser())
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function saveAction(): Action
    {
        return Action::make('save')
            ->label('Simpan Perubahan')
            ->action(function (Setting $setting) {
                foreach ($this->form->getState() as $key => $value) {
                    $setting->where('key', $key)->update(['value' => $value]);
                }

                Notification::make()
                    ->title('Success')
                    ->success()
                    ->send();
            });
    }

    public static function canAccess(): bool
    {
        return auth()->user()->role == 'karyawan';
    }
}
