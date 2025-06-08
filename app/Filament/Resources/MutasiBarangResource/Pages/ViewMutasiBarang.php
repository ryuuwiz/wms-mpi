<?php

namespace App\Filament\Resources\MutasiBarangResource\Pages;

use App\Filament\Resources\MutasiBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewMutasiBarang extends ViewRecord
{
    protected static string $resource = MutasiBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}