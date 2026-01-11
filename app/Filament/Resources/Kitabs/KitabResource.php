<?php

namespace App\Filament\Resources\Kitabs;

use App\Filament\Resources\Kitabs\Pages\CreateKitab;
use App\Filament\Resources\Kitabs\Pages\EditKitab;
use App\Filament\Resources\Kitabs\Pages\ListKitabs;
use App\Filament\Resources\Kitabs\Pages\MengerjakanSoal;
use App\Filament\Resources\Kitabs\Pages\ViewKitab;
use App\Filament\Resources\Kitabs\RelationManagers\BabsRelationManager;
use App\Filament\Resources\Kitabs\Schemas\KitabForm;
use App\Filament\Resources\Kitabs\Tables\KitabsTable;
use App\Helper\Authorization\AksesMenu;
use App\Models\Kitab;
use App\Models\Soal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class KitabResource extends Resource
{
    protected static ?string $model = Kitab::class;

    protected static ?string $navigationLabel = 'Kitab';

    // protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = "heroicon-s-book-open";

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return KitabForm::configure($schema);
    }
    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function table(Table $table): Table
    {
        return KitabsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            BabsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListKitabs::route('/'),
            'create' => CreateKitab::route('/create'),
            'edit' => EditKitab::route('/{record}/edit'),
            'view' => ViewKitab::route('/{record}'),
            'soal' => MengerjakanSoal::route('/{record}/soal'),
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
