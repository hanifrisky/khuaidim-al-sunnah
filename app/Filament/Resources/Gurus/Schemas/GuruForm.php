<?php

namespace App\Filament\Resources\Gurus\Schemas;

use Dom\Text;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class GuruForm
{
    public static function configure(Schema $schema): Schema
    {


        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->required(),
                TextInput::make('identitas'),
                Select::make('jenis_kelamin')->options([
                    'laki-laki' => 'Pria',
                    'perempuan' => 'Wanita',
                ]),
                TextInput::make('telp')
                    ->tel(),
            ]);
    }
}
