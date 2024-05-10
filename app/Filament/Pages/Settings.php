<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
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
                    ->default(5)
                    ->numeric()
                    ->maxValue(100)
                    ->suffix('%')
                    ->required(),
            ])
            ->inlineLabel()
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
        return Action::make('simpan')
            ->action(fn () => $this->post->delete());
    }
}
