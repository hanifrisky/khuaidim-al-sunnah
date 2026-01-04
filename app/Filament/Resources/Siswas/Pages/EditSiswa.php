<?php

namespace App\Filament\Resources\Siswas\Pages;

use App\Filament\Resources\Siswas\SiswaResource;
use App\Helper\RedirectToList;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSiswa extends EditRecord
{
    use RedirectToList;
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['user'] = [
            'name' => $this->record->user->name,
            'email' => $this->record->user->email,
        ];
        return $data;
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $user = User::find($this->record->user_id);
        $user->name = $data['user']['name'];
        $user->email = $data['user']['email'];
        $user->save();
        $data['name'] = $data['user']['name'];
        unset($data['user']);
        return $data;
    }
}
