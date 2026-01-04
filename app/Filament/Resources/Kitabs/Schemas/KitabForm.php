<?php

namespace App\Filament\Resources\Kitabs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;

class KitabForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('author')
                    ->required(),
                Textarea::make('description')
                    ->required(),
                FileUpload::make('media')
                    ->label('Cover Kitab')
                    ->disk('public')
                    ->directory('kitabs/cover')
                    ->image(),
            ]);
    }
}
