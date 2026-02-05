<?php

namespace App\Filament\Resources\NilaiSoals\Tables;

use App\Helper\Authorization\AksesMenu;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class NilaiSoalsTable
{
    use AksesMenu;
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('siswa.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nilai')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('kitab.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('siswa.kelas.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter berdasarkan Kelas
                SelectFilter::make('kelas_id')
                    ->label('Kelas')
                    ->options(function () {
                        if (self::isRole('guru')) {
                            return \App\Models\Kelas::where('guru_id', self::guruId())->pluck('name', 'id')->toArray();
                        }
                        return \App\Models\Kelas::pluck('name', 'id')->toArray();
                    })
                    ->searchable(),

                // Filter berdasarkan Bab
                SelectFilter::make('kitab_id')
                    ->label('Kitab')
                    ->options(function () {
                        return \App\Models\Kitab::pluck('name', 'id')->toArray();
                    })
                    ->searchable(),
            ])
            ->recordActions([
                //EditAction::make(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
