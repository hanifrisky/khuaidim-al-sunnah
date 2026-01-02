<?php

namespace App\Filament\Resources\SetoranHafalans\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SetoranHafalanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('tugas_hafalan_id')
                    ->numeric(),
                TextInput::make('siswa_id')
                    ->numeric(),
                TextInput::make('media'),
                TextInput::make('status')
                    ->required()
                    ->default('draft'),
                Textarea::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }
}
