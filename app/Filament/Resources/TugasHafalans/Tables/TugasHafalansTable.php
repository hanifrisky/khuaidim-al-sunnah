<?php

namespace App\Filament\Resources\TugasHafalans\Tables;

use App\Helper\Authorization\AksesMenu;
use App\Models\Guru;
use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TugasHafalansTable
{
    use AksesMenu;
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                if (self::isRole('guru')) {
                    $query->where('guru_id', self::guruId())->with(['bab']);
                } else {
                    $query->with(['bab']);
                }
            })
            ->columns([
                TextColumn::make('title')
                    ->wrap()
                    ->searchable(),
                // TextColumn::make('siswa.name')
                //     ->toggleable(isToggledHiddenByDefault: true)
                //     ->searchable(),
                TextColumn::make('bab.name')
                    ->searchable(),
                TextColumn::make('kelas.name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('Dikirim ke')
                    ->label('Kelas')
                    ->default(function ($record) {
                        return $record->kelas_name;
                    }),
                TextColumn::make('guru.name')
                    ->label('Guru')
                    ->searchable()
                    ->hidden(fn(): bool => self::isRole('guru')),
                TextColumn::make('deadline')
                    ->date()
                    ->formatStateUsing(function ($state) {
                        return Carbon::parse($state)->format('d M Y');
                    })
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'publish' => 'success',
                        'archieve' => 'warning',
                        default => 'primary',
                    }),
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
                SelectFilter::make('bab_id')
                    ->label('Bab')
                    ->options(function () {
                        return \App\Models\Bab::pluck('name', 'id')->toArray();
                    })
                    ->searchable(),

                // Filter berdasarkan Guru (hanya untuk admin / bukan guru)
                // SelectFilter::make('guru_id')
                //     ->label('Guru')
                //     ->visible(fn(): bool => self::isRole('admin'))
                //     ->options(function () {
                //         return \App\Models\Guru::pluck('name', 'id')->toArray();
                //     })
                //     ->hidden(fn(): bool => self::isRole('guru'))
                //     ->searchable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
