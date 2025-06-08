<?php

namespace App\Filament\Widgets;

use App\Models\MutasiBarang;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentMutasiBarangWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading('Mutasi Barang Terbaru')
            ->query(
                MutasiBarang::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('barang.nama')
                    ->label('Nama Barang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_barang')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'masuk' => 'success',
                        'keluar' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->suffix(' unit'),
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ]);
    }
}
