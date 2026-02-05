<?php

namespace App\Filament\Pages;

use App\Helper\Authorization\AksesMenu;
use App\Models\Hadits;
use App\Models\SetoranHafalan;
use App\Models\User;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Unique;

class ProfileUser extends Page implements HasSchemas
{
    use InteractsWithSchemas;
    use AksesMenu;
    protected string $view = 'filament.pages.profile';
    protected static ?string $slug = 'profile';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::User;
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Profil';

    public ?array $data = [];

    protected static bool $shouldRegisterNavigation = true;


    protected static function menuRole(): array
    {
        return ['admin', 'guru', 'siswa'];
    }
    public function mount()
    {
        // Ambil siswa dari user login
        $user = auth()->user() ?? abort(404);

        $data = $user->siswa ?? $user->guru;

        $data = $data ? $data->toArray() : null;

        $data['user_id'] = $user->id;

        $data['user'] = [
            'name' => $user->name,
            'email' => $user->email,
        ];

        $this->form->fill($data);
    }

    public function getTitle(): string|Htmlable
    {
        return '';
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id'),
                TextInput::make('user.name')
                    ->required(),
                TextInput::make('user.email')
                    ->email()
                    ->required(),
                TextInput::make('identitas')
                    ->hidden(fn(): bool => self::isRole('admin')),
                Select::make('jenis_kelamin')
                    ->hidden(fn(): bool => self::isRole('admin'))
                    ->options([
                        'laki-laki' => 'Pria',
                        'perempuan' => 'Wanita',
                    ])
                    ->default('laki-laki'),
                TextInput::make('telp')
                    ->hidden(fn(): bool => self::isRole('admin'))
                    ->tel(),
                TextInput::make('user.password')
                    ->label('Kata Sandi Baru')
                    ->password()
                    ->dehydrateStateUsing(fn($state): string => Hash::make($state))

            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();
        $user = auth()->user();
        $isExist = User::where('email', $data['user']['email'])->whereNot('id', $user->id)->exists();
        if ($isExist) {
            Notification::make()
                ->title('Gagal!')
                ->body('Email yang dimasukkan sudah ada')
                ->danger()
                ->send();
            return;
        }

        $user->name = $data['user']['name'];
        $user->email = $data['user']['email'];
        if ($data['user']['password'] != null) {
            $user->password = $data['user']['password'];
        }
        $user->save();


        if ($user->role == 'siswa') {
            $data['name'] = $data['user']['name'];
            unset($data['user']);
            $siswa = $user->siswa;
            $siswa->update($data);
        } else if ($user->role == 'guru') {
            $data['name'] = $data['user']['name'];
            unset($data['user']);
            $guru = $user->guru;
            $guru->update($data);
        }

        Notification::make()
            ->title('Berhasil!')
            ->body('Video hafalan berhasil disimpan')
            ->success()
            ->send();
        //
    }
}
