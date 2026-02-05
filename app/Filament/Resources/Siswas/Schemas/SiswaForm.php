<?php

namespace App\Filament\Resources\Siswas\Schemas;

use App\Models\User;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Unique;

class SiswaForm
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
                        if (isset($record->user_id)) {
                            $rule->whereNot('id', $record->user_id);
                        }
                    })
                    ->required(),
                TextInput::make('identitas'),
                Select::make('jenis_kelamin')
                    ->options([
                        'laki-laki' => 'Pria',
                        'perempuan' => 'Wanita',
                    ])
                    ->default('laki-laki'),
                TextInput::make('telp')
                    ->tel(),
                Select::make('kelas_id')
                    ->searchable()
                    ->required()
                    ->preload()
                    ->relationship('kelas', 'name'),
            ]);
    }
}
