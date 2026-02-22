<?php

namespace App\Filament\Resources\Kitabs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class KitabsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // ->extraAttributes([
            //     'class' => 'card-glass-record'
            // ])
            ->columns([
                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),
                TextColumn::make('author')
                    ->label('المؤلف')
                    ->searchable(),
                // Stack::make([
                //     // TextColumn::make('name')
                //     //     ->searchable(),
                //     // TextColumn::make('author')
                //     //     ->searchable(),
                //     // TextColumn::make('created_at')
                //     //     ->dateTime()
                //     //     ->sortable()
                //     //     ->toggleable(isToggledHiddenByDefault: true),
                //     // TextColumn::make('updated_at')
                //     //     ->dateTime()
                //     //     ->sortable()
                //     //     ->toggleable(isToggledHiddenByDefault: true),
                //     // TextColumn::make('deleted_at')
                //     //     ->dateTime()
                //     //     ->sortable()
                //     //     ->toggleable(isToggledHiddenByDefault: true),
                // ])->extraAttributes(['class' => 'card-hidden-content']),
                // View::make('filament.components.card')
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    // ForceDeleteBulkAction::make(),
                    // RestoreBulkAction::make(),
                ]),
            ])
            ->contentGrid([
                'sm' => 2,
                'md' => 3,
                'xl' => 4,
                '2xl' => 4
            ]);
    }
}
