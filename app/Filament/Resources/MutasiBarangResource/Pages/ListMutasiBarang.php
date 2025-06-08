<?php

namespace App\Filament\Resources\MutasiBarangResource\Pages;

use App\Filament\Resources\MutasiBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMutasiBarang extends ListRecords
{
    protected static string $resource = MutasiBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Mutasi'),
        ];
    }
}
