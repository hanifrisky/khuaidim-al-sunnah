<?php

namespace App\Filament\Resources\Quotes\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QuoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                RichEditor::make('konten')
                    ->columnSpanFull()
                    ->required()
                    ->placeholder('Tulis quote disini')
            ]);
    }
}
