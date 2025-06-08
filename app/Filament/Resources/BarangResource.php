<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Models\Barang;
use App\KondisiBarang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Manajemen Barang';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Barang';

    protected static ?string $modelLabel = 'Barang';

    protected static ?string $pluralModelLabel = 'Barang';

    protected static ?string $slug = 'barang';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Barang')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Barang')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Masukkan nama barang'),

                        Forms\Components\Select::make('kondisi')
                            ->label('Kondisi Barang')
                            ->options([
                                KondisiBarang::BAIK->value => 'Baik',
                                KondisiBarang::RUSAK->value => 'Rusak',
                                KondisiBarang::BARU->value => 'Baru',
                            ])
                            ->required()
                            ->native(false)
                            ->placeholder('Pilih kondisi barang'),

                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->placeholder('Masukkan jumlah barang')
                            ->suffix('unit'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('kondisi')
                    ->label('Kondisi')
                    ->badge()
                    ->color(fn(KondisiBarang $state): string => match ($state) {
                        KondisiBarang::BAIK => 'primary',
                        KondisiBarang::RUSAK => 'danger',
                        KondisiBarang::BARU => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(KondisiBarang $state): string => match ($state) {
                        KondisiBarang::BAIK => 'Baik',
                        KondisiBarang::RUSAK => 'Rusak',
                        KondisiBarang::BARU => 'Baru',
                        default => $state->value,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->sortable()
                    ->suffix(' unit')
                    ->alignEnd(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kondisi')
                    ->label('Kondisi')
                    ->options([
                        'baru' => 'Baru',
                        'baik' => 'Baik',
                        'rusak' => 'Rusak',
                    ])
                    ->native(false),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Barang')
                    ->schema([
                        Infolists\Components\TextEntry::make('nama')
                            ->label('Nama Barang'),

                        Infolists\Components\TextEntry::make('kondisi')
                            ->label('Kondisi')
                            ->badge()
                            ->color(fn(KondisiBarang $state): string => match ($state) {
                                KondisiBarang::BARU => 'success',
                                KondisiBarang::BAIK => 'primary',
                                KondisiBarang::RUSAK => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn(KondisiBarang $state): string => match ($state) {
                                KondisiBarang::BARU => 'Baru',
                                KondisiBarang::BAIK => 'Baik',
                                KondisiBarang::RUSAK => 'Rusak',
                                default => $state->value,
                            }),

                        Infolists\Components\TextEntry::make('jumlah')
                            ->label('Jumlah')
                            ->suffix(' unit'),

                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Dibuat')
                            ->dateTime('d/m/Y H:i'),

                        Infolists\Components\TextEntry::make('updated_at')
                            ->label('Diperbarui')
                            ->dateTime('d/m/Y H:i'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MutasiBarangRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarang::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'view' => Pages\ViewBarang::route('/{record}'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
