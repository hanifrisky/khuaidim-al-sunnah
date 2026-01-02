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
                TextInput::make('name')
                    ->required()
                    ->default(function ($get) {
                        $user = User::find($get('user_id'));
                        return $user ? $user->name : '';
                    }),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->default(function ($get) {
                        $user = User::find($get('user_id'));
                        return $user ? $user->email : '';
                    }),
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
