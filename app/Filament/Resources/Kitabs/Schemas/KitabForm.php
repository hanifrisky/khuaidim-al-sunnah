<?php

namespace App\Filament\Resources\Kitabs\Schemas;

use App\Helper\Authorization\AksesMenu;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;

class KitabForm
{
    use AksesMenu;
    protected static function menuRole(): array
    {
        return ['admin', 'guru'];
    }
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->visible(fn(): bool => self::isRole('admin'))
                    ->required(),
                TextInput::make('author')
                    ->visible(fn(): bool => self::isRole('admin'))
                    ->required(),
                Textarea::make('description')
                    ->visible(fn(): bool => self::isRole('admin'))
                    ->required(),
                FileUpload::make('media')
                    ->visible(fn(): bool => self::isRole('admin'))
                    ->label('Cover Kitab')
                    ->disk('public')
                    ->directory('kitabs/cover')
                    ->image(),
            ]);
    }
}
