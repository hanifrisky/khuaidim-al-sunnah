<?php

namespace App\Filament\Resources\TugasHafalans;

use App\Filament\Resources\TugasHafalans\Pages\CreateTugasHafalan;
use App\Filament\Resources\TugasHafalans\Pages\EditTugasHafalan;
use App\Filament\Resources\TugasHafalans\Pages\ListTugasHafalans;
use App\Filament\Resources\TugasHafalans\Schemas\TugasHafalanForm;
use App\Filament\Resources\TugasHafalans\Tables\TugasHafalansTable;
use App\Models\TugasHafalan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TugasHafalanResource extends Resource
{
    protected static ?string $model = TugasHafalan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTugasHafalans::route('/'),
            'create' => CreateTugasHafalan::route('/create'),
            'edit' => EditTugasHafalan::route('/{record}/edit'),
        ];
    }
}
