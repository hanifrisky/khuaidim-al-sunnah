<?php

namespace App\Filament\Resources\Babs\Schemas;

use App\Helper\Authorization\AksesMenu;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;

class BabForm
{
    use AksesMenu;
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('kitab_id')
                    ->visible(fn(): bool => self::isRole('admin'))
                    ->relationship('kitab', 'name')
                    ->searchable()
                    ->required()
                    ->preload(),
                TextInput::make('name')
                    ->visible(fn(): bool => self::isRole('admin'))
                    ->required(),
                Textarea::make('description')
                    ->visible(fn(): bool => self::isRole('admin')),
                FileUpload::make('media')
                    ->visible(fn(): bool => self::isRole('admin'))
                    ->label('Bab Cover')
                    ->disk('public')
                    ->directory('kitabs/bab')
                    ->image(),
            ]);
    }
}
