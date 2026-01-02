<?php

namespace App\Filament\Resources\Babs\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BabForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kitab_id')->relationship('kitab')
                    ->required(),

                TextInput::make('name')
                    ->required(),
                TextInput::make('description'),
                TextInput::make('media'),
            ]);
    }
}
