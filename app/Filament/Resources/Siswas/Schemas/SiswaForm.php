<?php

namespace App\Filament\Resources\Siswas\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SiswaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('identitas'),
                TextInput::make('jenis_kelamin'),
                TextInput::make('telp')
                    ->tel(),
                TextInput::make('kelas_id')
                    ->required()
                    ->numeric(),
            ]);
    }
}
