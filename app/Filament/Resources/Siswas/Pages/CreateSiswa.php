<?php

namespace App\Filament\Resources\Siswas\Pages;

use App\Filament\Resources\Siswas\SiswaResource;
use App\Helper\RedirectToList;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;

class CreateSiswa extends CreateRecord
{
    use RedirectToList;
    protected static string $resource = SiswaResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = User::create([
            'name' => $data['user']['name'],
            'email' => $data['user']['email'],
            'password' => bcrypt('password'),
            'role' => 'siswa',
        ]);
        $data['user_id'] = $user->id;
        $data['name'] = $data['user']['name'];
        unset($data['user']);
        return $data;
    }
}
