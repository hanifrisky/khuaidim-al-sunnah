<?php

namespace App\Filament\Resources\Kitabs;

use App\Filament\Resources\Kitabs\Pages\CreateKitab;
use App\Filament\Resources\Kitabs\Pages\EditKitab;
use App\Filament\Resources\Kitabs\Pages\ListKitabs;
use App\Filament\Resources\Kitabs\Schemas\KitabForm;
use App\Filament\Resources\Kitabs\Tables\KitabsTable;
use App\Models\Kitab;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KitabResource extends Resource
{
    protected static ?string $model = Kitab::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return KitabForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KitabsTable::configure($table);
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
            'index' => ListKitabs::route('/'),
            'create' => CreateKitab::route('/create'),
            'edit' => EditKitab::route('/{record}/edit'),
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
