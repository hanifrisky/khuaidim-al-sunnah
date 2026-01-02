<?php

namespace App\Filament\Resources\Hadits;

use App\Filament\Resources\Hadits\Pages\CreateHadits;
use App\Filament\Resources\Hadits\Pages\EditHadits;
use App\Filament\Resources\Hadits\Pages\ListHadits;
use App\Filament\Resources\Hadits\Schemas\HaditsForm;
use App\Filament\Resources\Hadits\Tables\HaditsTable;
use App\Models\Hadits;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class HaditsResource extends Resource
{
    protected static ?string $model = Hadits::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static string | UnitEnum | null $navigationGroup = 'Manajemen Hadits';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return HaditsForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HaditsTable::configure($table);
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
            'index' => ListHadits::route('/'),
            'create' => CreateHadits::route('/create'),
            'edit' => EditHadits::route('/{record}/edit'),
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
