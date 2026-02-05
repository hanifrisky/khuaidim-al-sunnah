<?php

namespace App\Filament\Resources\Gurus\Pages;

use App\Filament\Resources\Gurus\GuruResource;
use App\Helper\RedirectToList;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateGuru extends CreateRecord
{
    use RedirectToList;
    protected static string $resource = GuruResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = User::create([
            'name' => $data['user']['name'],
            'email' => $data['user']['email'],
            'password' => bcrypt('password'),
            'role' => 'guru',
        ]);

        $data['user_id'] = $user->id;
        $data['name'] = $data['user']['name'];
        unset($data['user']);
        return $data;
    }
}
