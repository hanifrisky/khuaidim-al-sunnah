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
                    ->label('العنوان')
                    ->required(),
                RichEditor::make('konten')
                    ->columnSpanFull()
                    ->label('المحتوى')
                    ->required()
                    ->placeholder('اكتب الاقتباس هنا')
            ]);
    }
}
