<?php

namespace App\Filament\Resources\Siswas;

use App\Filament\Resources\Siswas\Pages\CreateSiswa;
use App\Filament\Resources\Siswas\Pages\EditSiswa;
use App\Filament\Resources\Siswas\Pages\ListSiswas;
use App\Filament\Resources\Siswas\Schemas\SiswaForm;
use App\Filament\Resources\Siswas\Tables\SiswasTable;
use App\Helper\Authorization\AksesMenu;
use App\Models\Siswa;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SiswaResource extends Resource
{
    use AksesMenu;
    protected static ?string $model = Siswa::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::AcademicCap;
    protected static string | UnitEnum | null $navigationGroup = 'إدارة المستخدمين';
    protected static ?string $label = 'الطلاب';
    protected static ?string $pluralLabel = 'الطلاب';
    protected static ?string $navigationLabel = 'الطلاب';
    protected static ?int $navigationSort = 3;

    protected static function menuRole(): array
    {
        return ['admin', 'guru'];
    }

    public static function form(Schema $schema): Schema
    {
        return SiswaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SiswasTable::configure($table);
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
            'index' => ListSiswas::route('/'),
            'create' => CreateSiswa::route('/create'),
            'edit' => EditSiswa::route('/{record}/edit'),
        ];
    }
}
