<?php

namespace App\Filament\Resources\Soals\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
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
                    ->label('الحديث')
                    ->relationship('hadits', 'name')
                    ->preload()
                    ->searchable(),
                Select::make('tipe')
                    ->label('نوع السؤال')
                    ->options([
                        'melanjutkan' => 'إكمال الحديث',
                        'pemahaman' => 'الاستيعاب',
                    ])
                    ->required()
                    ->live()
                    ->default('melanjutkan'),
                RichEditor::make('soal')
                    ->label('السؤال')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('petunjuk')
                    ->columnSpanFull()
                    ->visible(fn($get): bool => $get('tipe') !== 'melanjutkan'),
                Section::make('خيارات الإجابة')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('jawaban')
                            ->label('الإجابة')
                            ->relationship('jawaban')
                            ->reorderable()
                            ->orderColumn('sort')
                            ->defaultItems(4)
                            ->addActionLabel('إضافة إجابة')
                            ->schema([
                                TextInput::make('jawaban')
                                    ->label('الإجابة')
                                    ->placeholder('أدخل خيار الإجابة')
                                    ->required(),
                                Toggle::make('benar')
                                    ->visible(fn($get): bool => $get('../../tipe') !== 'melanjutkan')
                                    ->label('الإجابة الصحيحة')
                            ])

                    ])
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($data['tipe'] ?? null) === 'melanjutkan') {
            $data['petunjuk'] = $this->generatePetunjuk($data['jawaban'] ?? []);
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (($data['tipe'] ?? null) === 'melanjutkan') {
            $data['petunjuk'] = $this->generatePetunjuk($data['jawaban'] ?? []);
        }

        return $data;
    }

    private function generatePetunjuk(array $jawaban): string
    {
        $letters = range('A', 'Z');

        return collect($jawaban)
            ->keys()
            ->map(fn($index) => $letters[$index] ?? null)
            ->filter()
            ->implode('-');
    }
}
