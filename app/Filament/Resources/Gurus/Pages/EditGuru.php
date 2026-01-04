<?php

namespace App\Filament\Resources\Gurus\Pages;

use App\Filament\Resources\Gurus\GuruResource;
use App\Helper\RedirectToList;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGuru extends EditRecord
{
    use RedirectToList;
    protected static string $resource = GuruResource::class;

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
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
