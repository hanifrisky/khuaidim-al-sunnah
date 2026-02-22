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
                    ->label('الاسم')
                    ->required(),
                TextInput::make('user.email')
                    ->label('البريد الإلكتروني')
                    ->email()
                    ->unique(User::class, 'email', ignoreRecord: false, modifyRuleUsing: function (Unique $rule, $record) {
                        if (isset($record->user_id)) {
                            $rule->whereNot('id', $record->user_id);
                        }
                    })
                    ->required(),
                Select::make('kelas_id')
                    ->label('فصل')
                    ->searchable()
                    ->required()
                    ->preload()
                    ->relationship(
                        'kelas',
                        'name',
                        fn($query) => auth()->user()->role === 'guru'
                            ? $query->where('guru_id', auth()->user()->guru->id)
                            : $query
                    ),
                Select::make('jenis_kelamin')
                    ->label('جنس')
                    ->options([
                        'laki-laki' => 'رجل',
                        'perempuan' => 'امرأة',
                    ])
                    ->default('laki-laki'),
                TextInput::make('identitas')
                    ->label('هوية'),

                TextInput::make('telp')
                    ->label('هاتف')
                    ->tel(),

            ]);
    }
}
