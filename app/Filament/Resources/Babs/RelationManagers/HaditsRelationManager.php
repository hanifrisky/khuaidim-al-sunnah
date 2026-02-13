<?php

namespace App\Filament\Resources\Babs\RelationManagers;

use App\Models\Hadits;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Support\Enums\FontWeight;

class HaditsRelationManager extends RelationManager
{
    protected static string $relationship = 'hadits';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('kitab_id')
                    ->default($this->ownerRecord->kitab_id),
                TextInput::make('name')
                    ->label('Nama Hadits')
                    ->columnSpanFull()
                    ->required(),
                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull()
                    ->extraInputAttributes(['style' => 'min-height: 20rem; max-height: 50vh; overflow-y: auto;']),
                TextInput::make('keterangan'),
                TextInput::make('source'),
                RichEditor::make('translate')
                    ->extraInputAttributes(['style' => 'min-height: 20rem; max-height: 50vh; overflow-y: auto;'])
                    ->columnSpanFull(),
                FileUpload::make('media')
                    ->label('Hadist Media')
                    ->columnSpanFull()
                    ->directory('hadits'),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('content')
                    ->columnSpanFull(),
                TextEntry::make('keterangan')
                    ->placeholder('-'),
                TextEntry::make('source')
                    ->placeholder('-'),
                TextEntry::make('translate')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('media')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn(Hadits $record): bool => $record->trashed()),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Stack::make([
                    TextColumn::make('name')
                        ->alignCenter()
                        ->weight(FontWeight::Bold)
                        ->searchable(),
                    TextColumn::make('content')
                        ->searchable()
                        ->html(),
                    TextColumn::make('translate')
                        ->searchable()
                        ->html(),
                    TextColumn::make('keterangan')
                        ->searchable(),
                    TextColumn::make('source')
                        ->searchable()
                        ->alignCenter(),
                ]),
                // TextColumn::make('name')
                //     ->searchable(),
                // TextColumn::make('keterangan')
                //     ->searchable(),
                // TextColumn::make('source')
                //     ->searchable(),
                // TextColumn::make('media')
                //     ->searchable(),
                // TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('deleted_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->contentGrid([
                'md' => 1,
                'xl' => 1,
            ])
            // ->filters([
            //     TrashedFilter::make(),
            // ])
            ->headerActions([
                CreateAction::make()
                    ->createAnother(false)
                    ->modalWidth('xl'),
            ])
            ->recordActions([
                // ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
