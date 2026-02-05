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
                    ->label('Kelas')
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
                Select::make('bab_id')
                    ->searchable()
                    ->preload()
                    ->required()
                    //->visible(fn($get) => $get('type') === 'bab')
                    //->required(fn($get) => $get('type') === 'bab')
                    ->relationship('bab', 'name'),
                Textarea::make('description')
                    ->label('Keterangan')
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
                    ->default(now()),
                Select::make('status')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'publish' => 'Publish',
                        'archieve' => 'Archieve',
                    ])
                    ->default('draft'),
            ]);
    }
}
