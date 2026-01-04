<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pengguna')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->placeholder('Nama lengkap'),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->placeholder('Masukkan email')
                            ->unique(ignoreRecord: true)
                            ->required(),
                        TextInput::make('password')
                            ->password()
                            ->placeholder(function ($context) {
                                return $context === 'edit' ? 'Kosongkan jika menggunakan password lama' : 'Masukkan Password';
                            })
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->dehydrated(fn($state) => filled($state))
                            ->required(fn(string $context): bool => $context === 'create'),
                        Select::make('role')
                            ->options([
                                'admin' => 'Admin',
                                'guru' => 'Guru',
                                'siswa' => 'Siswa',
                            ])
                            ->placeholder('Pilih jenis pengguna')
                            ->required(),
                    ]),
            ]);
    }
}
