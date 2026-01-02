<?php

namespace App\Filament\Resources\Babs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;

class BabForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kitab_id')
                    ->relationship('kitab', 'name')
                    ->searchable()
                    ->required()
                    ->preload(),
                TextInput::make('name')
                    ->required(),
                Textarea::make('description'),
                FileUpload::make('media')
                    ->label('Bab Cover')
                    ->directory('kitabs/babs')
                    ->image(),
            ]);
    }
}
