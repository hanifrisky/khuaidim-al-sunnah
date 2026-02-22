<?php

namespace App\Filament\Resources\Gurus\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GurusTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('الاسم')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('user.email')
                    ->label('البريد الإلكتروني')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('identitas')
                    ->placeholder('-')
                    ->label('هوية')
                    ->searchable(),
                TextColumn::make('telp')
                    ->label('هاتف')
                    ->placeholder('-')
                    ->searchable(),
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
