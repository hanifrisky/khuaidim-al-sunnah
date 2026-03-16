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
                    ->label('الفصل')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('البريد الإلكتروني')
                    ->searchable(),
                TextColumn::make('identitas')
                    ->label('الرقم التعريفي')
                    ->searchable(),
                TextColumn::make('jenis_kelamin')
                    ->label('الجنس')
                    ->searchable()
                    ->formatStateUsing(fn($state) => match ($state) {
                        'laki-laki' => 'رجل',
                        'perempuan' => 'امرأة',
                        default => $state,
                    }),
                TextColumn::make('telp')
                    ->label('رقم الهاتف')
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
