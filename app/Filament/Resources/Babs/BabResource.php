<?php

namespace App\Filament\Resources\Babs;

use App\Filament\Resources\Babs\Pages\CreateBab;
use App\Filament\Resources\Babs\Pages\EditBab;
use App\Filament\Resources\Babs\Pages\ListBabs;
use App\Filament\Resources\Babs\Pages\ViewBabs;
use App\Filament\Resources\Babs\RelationManagers\HaditsRelationManager;
use App\Filament\Resources\Babs\Schemas\BabForm;
use App\Filament\Resources\Babs\Tables\BabsTable;
use App\Helper\Authorization\AksesMenu;
use App\Models\Bab;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class BabResource extends Resource
{
    use AksesMenu;
    protected static ?string $model = Bab::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'Manajemen Hadits';

    protected static ?int $navigationSort = 2;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BabForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BabsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            "hadits" => HaditsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBabs::route('/'),
            'create' => CreateBab::route('/create'),
            'edit' => EditBab::route('/{record}/edit'),
            'view' => ViewBabs::route('/{record}'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
