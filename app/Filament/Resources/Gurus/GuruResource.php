<?php

namespace App\Filament\Resources\Gurus;

use App\Filament\Resources\Gurus\Pages\CreateGuru;
use App\Filament\Resources\Gurus\Pages\EditGuru;
use App\Filament\Resources\Gurus\Pages\ListGurus;
use App\Filament\Resources\Gurus\Schemas\GuruForm;
use App\Filament\Resources\Gurus\Tables\GurusTable;
use App\Helper\Authorization\AksesMenu;
use App\Helper\Authorization\MenuAdmin;
use App\Helper\Authorization\MenuGuru;
use App\Helper\Authorization\MenuSiswa;
use App\Models\Guru;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class GuruResource extends Resource
{
    use AksesMenu;

    protected static ?string $model = Guru::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;
    protected static string | UnitEnum | null $navigationGroup = 'إدارة المستخدمين';
    protected static ?string $label = 'المعلمون';
    protected static ?string $pluralLabel = 'المعلمون';
    protected static ?string $navigationLabel = 'المعلمون';

    protected static function menuRole(): array
    {
        return ['admin'];
    }

    public static function form(Schema $schema): Schema
    {
        return GuruForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GurusTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGurus::route('/'),
            'create' => CreateGuru::route('/create'),
            'edit' => EditGuru::route('/{record}/edit'),
        ];
    }
}
