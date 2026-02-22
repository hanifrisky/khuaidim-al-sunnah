<?php

namespace App\Filament\Resources\Siswas\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiswasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                $guru = auth()->user()->guru;

                if (auth()->user()->role == 'guru') {
                    return $query->whereHas('kelas', function ($q) use ($guru) {
                        $q->where('guru_id', $guru->id);
                    });
                } else {
                    return $query;
                }
            })
            ->columns([
                TextColumn::make('user.name')
                    ->label('الاسم')
                    ->sortable(),
                TextColumn::make('kelas.name')
                    ->label('فصل')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('البريد الإلكتروني')
                    ->searchable(),
                TextColumn::make('identitas')
                    ->label('هوية')
                    ->searchable(),
                TextColumn::make('jenis_kelamin')
                    ->label('جنس')
                    ->searchable(),
                TextColumn::make('telp')
                    ->label('هاتف')
                    ->searchable(),
                TextColumn::make('kelas.guru.name')
                    ->label('المعلم')
                    ->visible(fn(): bool => auth()->user()->role == 'admin')
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
