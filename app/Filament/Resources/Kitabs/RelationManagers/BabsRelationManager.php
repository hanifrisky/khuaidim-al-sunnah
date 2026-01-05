<?php

namespace App\Filament\Resources\Kitabs\RelationManagers;

use App\Models\Bab;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BabsRelationManager extends RelationManager
{
    protected static string $relationship = 'babs';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description'),
                FileUpload::make('media')
                    ->label('Bab Cover')
                    ->disk('public')
                    ->directory('kitabs/bab')
                    ->image(),
            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->extraAttributes([
                'class' => 'card-glass-record'
            ])
            ->columns([
                Stack::make([
                    TextColumn::make('name')
                        ->searchable(),
                    TextColumn::make('description')
                        ->searchable()
                        ->placeholder('-'),
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
                ])->extraAttributes(['class' => 'card-hidden-content']),
                View::make('filament.components.card')
            ])
            ->recordUrl(fn(Bab $record): string => route('filament.admin.resources.babs.edit', $record))
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
                '2xl' => 4
            ])
            ->filters([
                //TrashedFilter::make(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->modalWidth('md'),
            ])
            ->recordActions([
                // Action::make('view')
                //     ->label('View')
                //     ->color('secondary')
                //     ->icon('heroicon-o-eye')
                //     ->url(fn(Bab $record): string => route('filament.admin.resources.babs.edit', $record)),
                // EditAction::make(),
                // DeleteAction::make(),
                // ForceDeleteAction::make(),
                // RestoreAction::make(),
            ])
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                //     ForceDeleteBulkAction::make(),
                //     RestoreBulkAction::make(),
                // ]),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]));
    }
}
