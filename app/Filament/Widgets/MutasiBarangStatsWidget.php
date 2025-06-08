<?php

namespace App\Filament\Widgets;

use App\Models\Barang;
use App\Models\MutasiBarang;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class MutasiBarangStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Get total items in inventory
        $totalItems = Barang::sum('jumlah');

        // Get total incoming items today
        $incomingToday = MutasiBarang::where('jenis_barang', 'masuk')
            ->whereDate('tanggal', Carbon::today())
            ->sum('jumlah');

        // Get total outgoing items today
        $outgoingToday = MutasiBarang::where('jenis_barang', 'keluar')
            ->whereDate('tanggal', Carbon::today())
            ->sum('jumlah');

        // Get total incoming items this month
        $incomingThisMonth = MutasiBarang::where('jenis_barang', 'masuk')
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->sum('jumlah');

        // Get total outgoing items this month
        $outgoingThisMonth = MutasiBarang::where('jenis_barang', 'keluar')
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->sum('jumlah');

        return [
            Stat::make('Total Stok Barang', $totalItems . ' unit')
                ->description('Jumlah seluruh barang dalam inventaris')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),

            Stat::make('Barang Masuk Hari Ini', $incomingToday . ' unit')
                ->description('Total barang masuk hari ini')
                ->descriptionIcon('heroicon-m-arrow-down-tray')
                ->color('success')
                ->chart([
                    $incomingThisMonth > 0 ? $incomingThisMonth / 30 : 0,
                    $incomingThisMonth > 0 ? $incomingThisMonth / 20 : 0,
                    $incomingThisMonth > 0 ? $incomingThisMonth / 10 : 0,
                    $incomingToday
                ]),

            Stat::make('Barang Keluar Hari Ini', $outgoingToday . ' unit')
                ->description('Total barang keluar hari ini')
                ->descriptionIcon('heroicon-m-arrow-up-tray')
                ->color('danger')
                ->chart([
                    $outgoingThisMonth > 0 ? $outgoingThisMonth / 30 : 0,
                    $outgoingThisMonth > 0 ? $outgoingThisMonth / 20 : 0,
                    $outgoingThisMonth > 0 ? $outgoingThisMonth / 10 : 0,
                    $outgoingToday
                ]),
        ];
    }
}
