<?php

namespace App\Filament\Resources\Kelas;

use App\Filament\Resources\Kelas\Pages\CreateKelas;
use App\Filament\Resources\Kelas\Pages\EditKelas;
use App\Filament\Resources\Kelas\Pages\ListKelas;
use App\Filament\Resources\Kelas\RelationManagers\SiswaRelationManager;
use App\Filament\Resources\Kelas\Schemas\KelasForm;
use App\Filament\Resources\Kelas\Tables\KelasTable;
use App\Helper\Authorization\AksesMenu;
use App\Models\Kelas;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class KelasResource extends Resource
{
    use AksesMenu;
    protected static ?string $model = Kelas::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::BuildingOffice2;
    protected static ?string $label = 'الفصول';
    protected static ?string $pluralLabel = 'الفصول';
    protected static ?string $navigationLabel = 'الفصول';
    protected static ?string $recordTitleAttribute = 'name';
    protected static string|UnitEnum|null $navigationGroup = "إدارة المستخدمين";
    protected static ?int $navigationSort = 2;

    protected static function menuRole(): array
    {
        return ['admin', 'guru'];
    }

    public static function form(Schema $schema): Schema
    {
        return KelasForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KelasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            'siswa' => SiswaRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKelas::route('/'),
            'create' => CreateKelas::route('/create'),
            'edit' => EditKelas::route('/{record}/edit'),
        ];
    }
}
