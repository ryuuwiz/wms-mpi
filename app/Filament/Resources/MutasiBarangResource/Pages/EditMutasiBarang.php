<?php

namespace App\Filament\Resources\MutasiBarangResource\Pages;

use App\Filament\Resources\MutasiBarangResource;
use App\Models\Barang;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditMutasiBarang extends EditRecord
{
    protected static string $resource = MutasiBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Get the original data before update
        $originalJenisBarang = $record->jenis_barang;
        $originalJumlah = $record->jumlah;
        
        // Update the record
        $record = parent::handleRecordUpdate($record, $data);
        
        // Update barang quantity based on changes
        $barang = Barang::find($data['id_barang']);
        
        if ($barang) {
            // Revert the original transaction
            if ($originalJenisBarang === 'masuk') {
                $barang->jumlah -= $originalJumlah;
            } elseif ($originalJenisBarang === 'keluar') {
                $barang->jumlah += $originalJumlah;
            }
            
            // Apply the new transaction
            if ($data['jenis_barang'] === 'masuk') {
                $barang->jumlah += $data['jumlah'];
            } elseif ($data['jenis_barang'] === 'keluar') {
                $barang->jumlah -= $data['jumlah'];
            }
            
            // Ensure quantity doesn't go below zero
            if ($barang->jumlah < 0) {
                $barang->jumlah = 0;
            }
            
            $barang->save();
        }
        
        return $record;
    }
}