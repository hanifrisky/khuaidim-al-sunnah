<?php

namespace App\Filament\Resources\NilaiSoals;

use App\Filament\Resources\NilaiSoals\Pages\CreateNilaiSoal;
use App\Filament\Resources\NilaiSoals\Pages\EditNilaiSoal;
use App\Filament\Resources\NilaiSoals\Pages\ListNilaiSoals;
use App\Filament\Resources\NilaiSoals\Schemas\NilaiSoalForm;
use App\Filament\Resources\NilaiSoals\Tables\NilaiSoalsTable;
use App\Helper\Authorization\AksesMenu;
use App\Models\NilaiSoal;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class NilaiSoalResource extends Resource
{
    use AksesMenu;
    protected static ?string $model = NilaiSoal::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static string|UnitEnum|null $navigationGroup = 'إدارة المهام';

    protected static ?string $label = 'درجات الاختبارات';
    protected static ?string $pluralLabel = 'درجات الاختبارات';
    protected static ?string $navigationLabel = 'درجات الاختبارات';

    protected static function menuRole(): array
    {
        return ['admin', 'guru'];
    }

    public static function form(Schema $schema): Schema
    {
        return NilaiSoalForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NilaiSoalsTable::configure($table);
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
            'index' => ListNilaiSoals::route('/'),
            // 'create' => CreateNilaiSoal::route('/create'),
            // 'edit' => EditNilaiSoal::route('/{record}/edit'),
        ];
    }
}
