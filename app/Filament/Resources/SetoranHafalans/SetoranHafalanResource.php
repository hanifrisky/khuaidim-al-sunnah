<?php

namespace App\Filament\Resources\SetoranHafalans;

use App\Filament\Resources\SetoranHafalans\Pages\CreateSetoranHafalan;
use App\Filament\Resources\SetoranHafalans\Pages\EditSetoranHafalan;
use App\Filament\Resources\SetoranHafalans\Pages\ListSetoranHafalans;
use App\Filament\Resources\SetoranHafalans\Schemas\SetoranHafalanForm;
use App\Filament\Resources\SetoranHafalans\Tables\SetoranHafalansTable;
use App\Helper\Authorization\AksesMenu;
use App\Models\SetoranHafalan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SetoranHafalanResource extends Resource
{
    use AksesMenu;
    protected static ?string $model = SetoranHafalan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    // protected static string | UnitEnum | null $navigationGroup = 'Manajemen Tugas';
    //protected static bool $shouldRegisterNavigation = false;
    protected static ?string $label = 'Setoran Hafalan';
    protected static ?string $pluralLabel = 'Setoran Hafalan';
    protected static ?string $navigationLabel = 'Setoran Hafalan';
    protected static ?int $navigationSort = 2;
    protected static string | UnitEnum | null $navigationGroup = 'Manajemen Tugas';
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return SetoranHafalanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SetoranHafalansTable::configure($table);
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
            'index' => ListSetoranHafalans::route('/'),
            'create' => CreateSetoranHafalan::route('/create'),
            'edit' => EditSetoranHafalan::route('/{record}/edit'),
        ];
    }
}
