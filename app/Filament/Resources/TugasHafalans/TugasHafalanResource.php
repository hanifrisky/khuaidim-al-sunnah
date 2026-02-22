<?php

namespace App\Filament\Resources\TugasHafalans;

use App\Filament\Resources\TugasHafalans\Pages\CreateTugasHafalan;
use App\Filament\Resources\TugasHafalans\Pages\EditTugasHafalan;
use App\Filament\Resources\TugasHafalans\Pages\ListTugasHafalans;
use App\Filament\Resources\TugasHafalans\Pages\ViewTugasHafalan;
use App\Filament\Resources\TugasHafalans\RelationManagers\SetoranHafalanRelationManager;
use App\Filament\Resources\TugasHafalans\Schemas\TugasHafalanForm;
use App\Filament\Resources\TugasHafalans\Tables\TugasHafalansTable;
use App\Helper\Authorization\AksesMenu;
use App\Models\TugasHafalan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class TugasHafalanResource extends Resource
{
    use AksesMenu;
    protected static ?string $model = TugasHafalan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::DocumentText;
    // protected static string | UnitEnum | null $navigationGroup = 'إدارة المهام';
    protected static ?string $label = 'تكاليف الحفظ';
    protected static ?string $pluralLabel = 'تكاليف الحفظ';
    protected static ?string $navigationLabel = 'تكاليف الحفظ';
    protected static ?int $navigationSort = 1;
    protected static string | UnitEnum | null $navigationGroup = 'إدارة المهام';

    public static function shouldRegisterNavigation(): bool
    {
        if (Auth()->user()->role == 'siswa') {
            return false;
        }
        return true;
    }

    protected static function menuRole(): array
    {
        return ['admin', 'guru', 'siswa'];
    }

    public static function canView(Model $record): bool
    {
        return true;
    }
    public static function form(Schema $schema): Schema
    {
        return TugasHafalanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TugasHafalansTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            'Unggahan' => SetoranHafalanRelationManager



            ::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTugasHafalans::route('/'),
            'create' => CreateTugasHafalan::route('/create'),
            'edit' => EditTugasHafalan::route('/{record}/edit'),
            'view' => ViewTugasHafalan::route('/{record}/view'),
        ];
    }
}
