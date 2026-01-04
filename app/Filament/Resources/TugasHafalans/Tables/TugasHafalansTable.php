<?php

namespace App\Filament\Resources\TugasHafalans\Tables;

use App\Helper\Authorization\AksesMenu;
use App\Models\Guru;
use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TugasHafalansTable
{
    use AksesMenu;
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                if (self::isRole('guru')) {
                    $query->where('guru_id', self::guruId())->with(['guru', 'kelas', 'siswa', 'hadits', 'bab']);
                } else {
                    $query->with(['guru', 'kelas', 'siswa', 'hadits', 'bab']);
                }
            })
            ->columns([
                TextColumn::make('title')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('siswa.name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('kelas.name')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('Dikirim ke')
                    ->default(function ($record) {
                        if ($record->siswa_id == null) {
                            return $record->kelas_name;
                        }
                        return $record->siswa_name;
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
                //
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
