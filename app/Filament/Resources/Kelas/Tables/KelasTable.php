<?php

namespace App\Filament\Resources\Kelas\Tables;

use App\Helper\Authorization\AksesMenu;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KelasTable
{
    use AksesMenu;
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                if (self::isRole('guru')) {
                    $query->where('guru_id', self::guruId())->with('guru');
                } else {
                    $query->with('guru');
                }
            })
            ->columns([
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),
                TextColumn::make('guru.name')
                    ->label('الأستاذ المشرف')
                    ->numeric()
                    ->hidden(fn(): bool => self::isRole('guru'))
                    ->sortable(),
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
