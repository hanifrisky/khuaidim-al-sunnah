<?php

namespace App\Filament\Resources\Soals\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SoalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('hadits_id')
                    ->label('Hadits')
                    ->relationship('hadits', 'name')
                    ->preload()
                    ->searchable(),
                Select::make('tipe')
                    ->options([
                        'melanjutkan' => 'Melanjutkan',
                        'pemahaman' => 'Pemahaman',
                    ])
                    ->label('Tipe Soal')
                    ->required()
                    ->default('melanjutkan'),
                Textarea::make('soal')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('media')
                    ->label('Soal Media')
                    ->disk('public')
                    ->directory('soalmedia'),
            ]);
    }
}
