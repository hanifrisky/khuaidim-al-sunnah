<?php

namespace App\Filament\Resources\TugasHafalans\Schemas;

use App\Helper\Authorization\AksesMenu;
use App\Models\Kelas;
use App\Models\Siswa;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class TugasHafalanForm
{
    use AksesMenu;
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Select::make('assign')
                //     ->label('Dikirim ke')
                //     ->options([
                //         'individu' => 'Individu',
                //         'kelas' => 'Kelas',
                //     ])
                //     ->live()
                //     ->formatStateUsing(function ($get) {
                //         if ($get('siswa_id') != null) {
                //             return 'individu';
                //         }
                //         return 'kelas';
                //     })
                //     ->default('kelas'),

                // Select::make('siswa_id')
                //     ->label('Siswa')
                //     ->searchable()
                //     ->preload()
                //     ->visible(fn($get) => $get('assign') === 'individu')
                //     ->required(fn($get) => $get('assign') === 'individu')
                //     ->options(function () {
                //         if (self::isRole('guru')) {
                //             $kelasIds = Kelas::where('guru_id', self::guruId())
                //                 ->pluck('id');

                //             return Siswa::whereIn('kelas_id', $kelasIds)
                //                 ->get()
                //                 ->mapWithKeys(fn($siswa) => [
                //                     $siswa->id => $siswa->user->name,
                //                 ]);
                //         }

                //         return Siswa::with('user')
                //             ->get()
                //             ->mapWithKeys(fn($siswa) => [
                //                 $siswa->id => $siswa->user->name,
                //             ]);
                //     }),
                Select::make('kelas_id')
                    ->label('الفصل')
                    ->required()
                    // ->visible(fn($get) => $get('assign') === 'kelas')
                    // ->required(fn($get) => $get('assign') === 'kelas')
                    ->options(function () {
                        if (self::isRole('guru')) {
                            return Kelas::where('guru_id', self::guruId())
                                ->pluck('name', 'id');
                        }
                        return Kelas::all()->pluck('name', 'id');
                    })
                    ->searchable()
                    ->preload(),
                Select::make('kitab_id')
                    ->label('الكتاب')
                    ->placeholder('اختر الكتاب')
                    ->searchPrompt('اكتب للبحث...')
                    ->loadingMessage('جاري التحميل...')
                    ->noSearchResultsMessage('لا توجد نتائج')
                    ->options(\App\Models\Kitab::pluck('name', 'id'))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->dehydrated(false)
                    ->afterStateHydrated(function (Select $component, $state, callable $get) {
                        if (blank($state) && !blank($get('bab_id'))) {
                            $bab = \App\Models\Bab::find($get('bab_id'));
                            if ($bab) {
                                $component->state($bab->kitab_id);
                            }
                        }
                    })
                    ->afterStateUpdated(function (callable $set) {
                        $set('bab_id', null);
                    }),
                Select::make('bab_id')
                    ->searchable()
                    ->label('الباب')
                    ->placeholder('اختر الباب')
                    ->searchPrompt('اكتب للبحث...')
                    ->loadingMessage('جاري التحميل...')
                    ->noSearchResultsMessage('لا توجد نتائج')
                    ->preload()
                    ->required()
                    ->relationship(
                        name: 'bab',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query, callable $get) => $query->where('kitab_id', $get('kitab_id'))
                    )
                    ->disabled(fn (callable $get) => empty($get('kitab_id'))),
                Textarea::make('description')
                    ->label('Keterangan')
                    ->label('الوصف')
                    ->columnSpanFull(),
                // Select::make('type')
                //     ->options([
                //         'hadits' => 'Hadits',
                //         'bab' => 'Bab',
                //     ])
                //     ->live()
                //     ->formatStateUsing(function ($get) {
                //         if ($get('hadits_id') != null) {
                //             return 'hadits';
                //         }
                //         return 'bab';
                //     })
                //     ->default('bab'),
                // Select::make('hadits_id')
                //     ->searchable()
                //     ->preload()
                //     ->visible(fn($get) => $get('type') === 'hadits')
                //     ->required(fn($get) => $get('type') === 'hadits')
                //     ->relationship('hadits', 'name'),

                DatePicker::make('deadline')
                    ->label('الموعد النهائي')
                    ->default(now()),
                Select::make('status')
                    ->label('الحالة')
                    ->required()
                    ->options([
                        'draft' => __('Draft'),
                        'publish' => __('Publish'),
                        'archieve' => __('Archieve'),
                    ])
                    ->selectablePlaceholder(false)
                    ->default('draft'),
            ]);
    }
}
