<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

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
                                Select::make('kelurahan')
                                    ->options([
                                        'Abepura' => 'Abepura'
                                    ])
                                    ->default(Setting::where('key', 'kelurahan')->first()->value ?? '')
                                    ->required(),
                                Select::make('kecamatan')
                                    ->options([
                                        'Abepura' => 'Abepura'
                                    ])
                                    ->default(Setting::where('key', 'kecamatan')->first()->value ?? '')
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
                    ]),

                Section::make('Biaya')
                    ->aside()
                    ->description('Data ini digunakan untuk proses biaya  tambahan dalam pemesanan')
                    ->schema([
                        TextInput::make('ongkir')
                            ->label('Biaya Ongkir')
                            ->default(Setting::where('key', 'ongkir')->first()->value)
                            ->numeric()
                            ->step(1000)
                            ->prefix('Rp')
                            ->suffix('/Kg')
                            ->required(),

                        TextInput::make('denda')
                            ->label('Persentase Denda')
                            ->default(Setting::where('key', 'presentase_denda')->first()->value ?? 5)
                            ->numeric()
                            ->maxValue(100)
                            ->suffix('%')
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
                TextInput::make('password')->password()->hiddenOn('edit'),
                Select::make('role')->options([
                    'pelanggan' => 'pelanggan',
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
                TextColumn::make('role')->badge(),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                EditAction::make()->form($this->formUser())->hidden(auth()->user()->role != 'pimpinan'),
                DeleteAction::make()->hidden(auth()->user()->role != 'pimpinan'),
            ])
            ->headerActions([
                CreateAction::make()->form($this->formUser())->hidden(auth()->user()->role != 'pimpinan')
            ])
            ->bulkActions([
                // ...
            ]);
    }

    public function create(): void
    {
        dd($this->form->getState());
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
}
