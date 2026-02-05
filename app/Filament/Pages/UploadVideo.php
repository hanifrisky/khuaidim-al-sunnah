<?php

namespace App\Filament\Pages;

use App\Models\Hadits;
use App\Models\SetoranHafalan;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\HasUnsavedDataChangesAlert;
use Filament\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class UploadVideo extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected string $view = 'filament.resources.babs.pages.upload-video';
    protected static ?string $slug = 'video-bab/upload';

    public ?array $data = [];

    protected static bool $shouldRegisterNavigation = false;

    public static function getUrl(array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?Model $tenant = null): string
    {
        return route('filament.admin.pages.video-bab.upload', ['id' => $parameters['id'] ?? 0]);
    }

    public function mount()
    {
        // Ambil siswa dari user login
        $user = auth()->user()->siswa;
        if ($user == null) return abort(404);
        $siswa_id = $user->id;
        $kelas_id = $user->kelas_id;

        // Ambil bab_id dari URL /app/babs/{id}/upload
        $bab_id = (int) request()->query('id', 0);

        if ($bab_id == 0) {
            return abort(404);
        }
        // Ambil semua Hadits di bab ini
        $hadits = Hadits::where('bab_id', $bab_id)->get();


        $dataRepeater = [];
        //$setoran =  SetoranHafalan::where('bab_id', $bab_id)->where('siswa_id', $siswa_id)->get();

        foreach ($hadits as $itemHadits) {
            $setoran = SetoranHafalan::where('hadit_id', $itemHadits->id)->first();
            //dd($setoran, $kelas_id, $siswa_id, $itemHadits);
            if (!$setoran) {
                $setoran = SetoranHafalan::create([
                    'hadit_id' => $itemHadits->id,
                    'siswa_id' => $siswa_id,
                    'kelas_id' => $kelas_id,
                    'bab_id' => $bab_id
                ]);
            }
            $dataRepeater[] = [
                'id' => $setoran->id,
                'media' => $setoran->media,
                'hadits_name' => $itemHadits->name,
            ];
        }

        $this->form->fill(['setoran' => $dataRepeater]);
    }

    public function getTitle(): string|Htmlable
    {
        return '';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Repeater::make('setoran')
                    ->deletable(false)
                    ->addable(false)
                    ->reorderable(false)
                    ->label('Upload Video Hafalan')
                    ->schema([
                        Hidden::make('id'),
                        TextEntry::make('hadits_name')
                            ->label('Hadits'),
                        FileUpload::make('media')
                            ->label('Video Hafalan')
                            ->disk('public')
                            ->directory('setoran-hafalan')
                            ->acceptedFileTypes(['video/mp4', 'video/mkv'])
                            ->required(),
                    ])
                    ->columns(1),
                Select::make('status')
                    ->default('draft')
                    ->required()
                    ->options([
                        'draft' => 'Draft',
                        'publish' => 'Publish'
                    ])
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $this->validate();
        $data = $this->form->getState();
        $status = $data['status'];

        foreach ($data['setoran'] as $item) {
            SetoranHafalan::where('id', $item['id'])->update([
                'media' => $item['media'],
                'status' => $status
            ]);
        }

        Notification::make()
            ->title('Berhasil!')
            ->body('Video hafalan berhasil disimpan')
            ->success()
            ->send();
        //
    }
}
