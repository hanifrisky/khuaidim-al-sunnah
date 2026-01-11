<?php

namespace App\Filament\Resources\Soals\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SoalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('hadits_id')
                    ->label('Hadits')
                    ->relationship('hadits', 'name')
                    ->preload()
                    ->searchable(),
                Select::make('tipe')
                    ->options([
                        'melanjutkan' => 'Melanjutkan',
                        'pemahaman' => 'Pemahaman',
                    ])
                    ->label('Tipe Soal')
                    ->required()
                    ->default('melanjutkan'),
                Textarea::make('soal')
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('media')
                    ->label('Soal Media')
                    ->disk('public')
                    ->columnSpanFull()
                    ->directory('soalmedia'),
                Section::make('Pilihan Jawaban')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('jawaban')
                            ->relationship('jawaban')
                            ->label('')
                            ->reorderable(false)
                            ->defaultItems(4)
                            ->addActionLabel('Tambah Jawaban')
                            ->schema([
                                TextInput::make('jawaban')
                                    ->placeholder('Masukkan Pilihan Jawaban')
                                    ->required(),
                                Toggle::make('benar')
                                    ->label('Jawaban Benar')
                            ])

                    ])
            ]);
    }
}
