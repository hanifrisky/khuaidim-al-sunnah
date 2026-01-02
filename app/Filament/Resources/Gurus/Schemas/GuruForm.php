<?php

namespace App\Filament\Resources\Gurus\Schemas;

use App\Models\User;
use Dom\Text;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class GuruForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id'),
                TextInput::make('user.name')
                    ->required(),
                TextInput::make('user.email')
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
