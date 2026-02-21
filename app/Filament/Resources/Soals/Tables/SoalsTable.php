<?php

namespace App\Filament\Resources\Soals\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SoalsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('soal')
                    ->label('Soal')
                    ->limit(50)
                    ->tooltip(fn($record) => $record->soal)
                    ->wrap()
                    ->searchable(),
                TextColumn::make('kitab.name')
                    ->numeric()
                    ->searchable()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('hadits.name')
                    ->numeric()
                    ->searchable()
                    ->placeholder('-')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('kitab_id')
                    ->label('Kitab')
                    ->relationship('kitab', 'name')
                    ->searchable()
                    ->preload(),
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
