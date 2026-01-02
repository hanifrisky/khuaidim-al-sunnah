<?php

namespace App\Filament\Resources\TugasHafalans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TugasHafalanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('siswa_id')
                    ->numeric(),
                TextInput::make('kelas_id')
                    ->numeric(),
                TextInput::make('hadits_id')
                    ->numeric(),
                TextInput::make('guru_id')
                    ->numeric(),
                DatePicker::make('deadline'),
                TextInput::make('status')
                    ->required()
                    ->default('draft'),
            ]);
    }
}
