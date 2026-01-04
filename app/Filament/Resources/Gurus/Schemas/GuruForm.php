<?php

namespace App\Filament\Resources\Gurus\Schemas;

use App\Models\User;
use Dom\Text;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Illuminate\Validation\Rules\Unique;

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
                    ->unique(User::class, 'email', ignoreRecord: false, modifyRuleUsing: function (Unique $rule, $record) {
                        $rule->whereNot('id', $record->user_id);
                    })
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
