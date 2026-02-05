<?php

namespace App\Filament\Resources\TugasHafalans\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SetoranHafalanRelationManager extends RelationManager
{
    protected static string $relationship = 'SetoranHafalan';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('siswa.name')
                    ->label('Nama Siswa'),
                TextEntry::make('hadits.name')
                    ->label('Hadits'),

                FileUpload::make('media')
                    ->disabled()
                    ->directory('setoran-hafalan')
                    ->disk('public'),
                Select::make('status')
                    ->options([
                        'accepted' => 'Diterima',
                        'rejected' => 'Ditolak',
                    ])
                    ->required()
                    ->default('assigned'),
                Textarea::make('keterangan')
                    ->placeholder('Masukkan keterangan ditolak')
                    ->label('Keterangan ditolak')
                    ->columnSpanFull(),
            ]);
    }

    // public function infolist(Schema $schema): Schema
    // {
    //     return $schema
    //         ->components([
    //             TextEntry::make('siswa.name')
    //                 ->numeric()
    //                 ->placeholder('-'),
    //             TextEntry::make('media')
    //                 ->placeholder('-'),
    //             TextEntry::make('status'),
    //             TextEntry::make('keterangan')
    //                 ->placeholder('-')
    //                 ->columnSpanFull(),
    //             TextEntry::make('created_at')
    //                 ->dateTime()
    //                 ->placeholder('-'),
    //             TextEntry::make('updated_at')
    //                 ->dateTime()
    //                 ->placeholder('-'),
    //             TextEntry::make('hadit_id')
    //                 ->numeric()
    //                 ->placeholder('-'),
    //         ]);
    // }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('hadits_id')
            ->columns([
                TextColumn::make('siswa.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('hadits.name')
                    ->label('Hadits')
                    ->sortable(),
            ])
            ->modifyQueryUsing(function ($query) {
                return $query->where('status', '<>', 'assigned')->where('status', '<>', 'draft');
            })
            ->filters([
                //
            ])
            ->headerActions([
                // CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->recordActions([
                //ViewAction::make(),
                EditAction::make(),
                // DissociateAction::make(),
                // DeleteAction::make(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DissociateBulkAction::make(),
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
