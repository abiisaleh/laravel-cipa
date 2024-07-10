<?php

namespace App\Filament\Resources\TabungResource\Pages;

use App\Filament\Resources\TabungResource;
use App\Filament\Resources\TabungResource\Widgets\TabungOverview;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTabungs extends ListRecords
{
    protected static string $resource = TabungResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            TabungOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
