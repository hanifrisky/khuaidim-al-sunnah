<?php

namespace App\Filament\Resources\Hadits\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class HaditsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('bab_id')
                    ->relationship('bab', 'name')
                    ->searchable()
                    ->required()
                    ->preload(),
                Textarea::make('name')
                    ->required(),
                Textarea::make('content')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('keterangan'),
                TextInput::make('source'),
                Textarea::make('translate')
                    ->columnSpanFull(),
                FileUpload::make('media')
                    ->label('Hadist Media')
                    ->directory('hadits'),
            ]);
    }
}
