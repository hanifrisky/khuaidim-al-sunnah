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
use Illuminate\Database\Eloquent\Builder;

class SoalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kitab_id')
                    ->label('الكتاب')
                    ->placeholder('اختر الكتاب')
                    ->searchPrompt('اكتب للبحث...')
                    ->loadingMessage('جاري التحميل...')
                    ->noSearchResultsMessage('لا توجد نتائج')
                    ->relationship('kitab', 'name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateHydrated(function (Select $component, $state, callable $get) {
                        if (blank($state) && !blank($get('hadits_id'))) {
                            $hadits = \App\Models\Hadits::find($get('hadits_id'));
                            if ($hadits) {
                                $component->state($hadits->kitab_id);
                            }
                        }
                    })
                    ->afterStateUpdated(function (callable $set) {
                        $set('bab_id', null);
                        $set('hadits_id', null);
                    }),
                Select::make('bab_id')
                    ->label('الباب')
                    ->placeholder('اختر الباب')
                    ->searchPrompt('اكتب للبحث...')
                    ->loadingMessage('جاري التحميل...')
                    ->noSearchResultsMessage('لا توجد نتائج')
                    ->relationship(
                        name: 'bab',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query, callable $get) => $query->where('kitab_id', $get('kitab_id'))
                    )
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateHydrated(function (Select $component, $state, callable $get) {
                        if (blank($state) && !blank($get('hadits_id'))) {
                            $hadits = \App\Models\Hadits::find($get('hadits_id'));
                            if ($hadits) {
                                $component->state($hadits->bab_id);
                            }
                        }
                    })
                    ->afterStateUpdated(function (callable $set) {
                        $set('hadits_id', null);
                    })
                    ->disabled(fn (callable $get) => empty($get('kitab_id'))),
                Select::make('hadits_id')
                    ->label('الحديث')
                    ->placeholder('اختر الحديث')
                    ->searchPrompt('اكتب للبحث...')
                    ->loadingMessage('جاري التحميل...')
                    ->noSearchResultsMessage('لا توجد نتائج')
                    ->relationship(
                        name: 'hadits',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query, callable $get) => $query->where('bab_id', $get('bab_id'))
                    )
                    ->searchable()
                    ->preload()
                    ->disabled(fn (callable $get) => empty($get('bab_id'))),
                Select::make('tipe')
                    ->label('نوع السؤال')
                    ->selectablePlaceholder(false)
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
