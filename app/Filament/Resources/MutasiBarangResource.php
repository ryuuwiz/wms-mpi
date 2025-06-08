<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MutasiBarangResource\Pages;
use App\Models\MutasiBarang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MutasiBarangResource extends Resource
{
    protected static ?string $model = MutasiBarang::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    protected static ?string $navigationGroup = 'Manajemen Barang';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Mutasi Barang';

    protected static ?string $modelLabel = 'Mutasi Barang';

    protected static ?string $pluralModelLabel = 'Mutasi Barang';

    protected static ?string $slug = 'mutasi-barang';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Mutasi')
                    ->schema([
                        Forms\Components\Select::make('id_user')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('id_barang')
                            ->label('Barang')
                            ->relationship('barang', 'nama')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\Select::make('jenis_barang')
                            ->label('Jenis Mutasi')
                            ->options([
                                'masuk' => 'Barang Masuk',
                                'keluar' => 'Barang Keluar',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->suffix('unit'),

                        Forms\Components\Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->rows(3)
                            ->placeholder('Masukkan keterangan mutasi (opsional)'),

                        Forms\Components\DateTimePicker::make('tanggal')
                            ->label('Tanggal Mutasi')
                            ->required()
                            ->default(now())
                            ->native(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('barang.nama')
                    ->label('Nama Barang')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jenis_barang')
                    ->label('Jenis')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'masuk' => 'success',
                        'keluar' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'masuk' => 'Masuk',
                        'keluar' => 'Keluar',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->numeric()
                    ->suffix(' unit')
                    ->alignEnd()
                    ->sortable(),

                Tables\Columns\TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(50)
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 50) {
                            return null;
                        }
                        return $state;
                    }),

                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),

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
                Tables\Filters\SelectFilter::make('jenis_barang')
                    ->label('Jenis Mutasi')
                    ->options([
                        'masuk' => 'Barang Masuk',
                        'keluar' => 'Barang Keluar',
                    ])
                    ->native(false),

                Tables\Filters\Filter::make('tanggal')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query
                            ->when($data['dari_tanggal'], fn(Builder $query, $date) => $query->whereDate('tanggal', '>=', $date))
                            ->when($data['sampai_tanggal'], fn(Builder $query, $date) => $query->whereDate('tanggal', '<=', $date));
                    }),
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
            ->defaultSort('tanggal', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMutasiBarang::route('/'),
            'create' => Pages\CreateMutasiBarang::route('/create'),
            'view' => Pages\ViewMutasiBarang::route('/{record}'),
            'edit' => Pages\EditMutasiBarang::route('/{record}/edit'),
        ];
    }
}
