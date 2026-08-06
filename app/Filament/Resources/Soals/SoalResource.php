<?php

namespace App\Filament\Resources\Soals;

use App\Filament\Resources\Soals\Pages\CreateSoal;
use App\Filament\Resources\Soals\Pages\EditSoal;
use App\Filament\Resources\Soals\Pages\ListSoals;
use App\Filament\Resources\Soals\RelationManagers\PilihanJawabanRelationManager;
use App\Filament\Resources\Soals\Schemas\SoalForm;
use App\Filament\Resources\Soals\Tables\SoalsTable;
use App\Helper\Authorization\AksesMenu;
use App\Models\Soal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class SoalResource extends Resource
{
    use AksesMenu;
    protected static ?string $model = Soal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ClipboardDocumentList;
    public static function getNavigationGroup(): ?string
    {
        return __('Task Management');
    }

    public static function getModelLabel(): string
    {
        return __('Question Bank');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Question Bank');
    }

    public static function getNavigationLabel(): string
    {
        return __('Question Bank');
    }

    protected static function menuRole(): array
    {
        return ['admin', 'guru'];
    }

    public static function form(Schema $schema): Schema
    {
        return SoalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SoalsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            // "pilihanJawaban" => PilihanJawabanRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSoals::route('/'),
            'create' => CreateSoal::route('/create'),
            'edit' => EditSoal::route('/{record}/edit'),
        ];
    }
}
