<?php

namespace App\Filament\Resources\MutasiBarangResource\Pages;

use App\Filament\Resources\MutasiBarangResource;
use App\Models\Barang;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateMutasiBarang extends CreateRecord
{
    protected static string $resource = MutasiBarangResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function handleRecordCreation(array $data): Model
    {
        $record = parent::handleRecordCreation($data);

        // Update barang quantity based on mutasi type
        $barang = Barang::find($data['id_barang']);

        if ($barang) {
            if ($data['jenis_barang'] === 'masuk') {
                $barang->jumlah += $data['jumlah'];
            } elseif ($data['jenis_barang'] === 'keluar') {
                $barang->jumlah -= $data['jumlah'];
                // Ensure quantity doesn't go below zero
                if ($barang->jumlah < 0) {
                    $barang->jumlah = 0;
                }
            }

            $barang->save();
        }

        return $record;
    }
}
