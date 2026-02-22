<?php

namespace App\Filament\Resources\Kelas\RelationManagers;

use App\Models\Siswa;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Unique;

class SiswaRelationManager extends RelationManager
{
    protected static string $relationship = 'siswa';
    protected static ?string $title = 'طالب';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Hidden::make('user_id'),
                TextInput::make('user.name')
                    ->label('الاسم')
                    ->required(),
                TextInput::make('user.email')
                    ->email()
                    ->label('البريد الإلكتروني')
                    ->unique(User::class, 'email', ignoreRecord: false, modifyRuleUsing: function (Unique $rule, $record) {
                        if (!isset($record->user_id)) {
                            return $rule;
                        }
                        $user_id = $record->user_id;
                        return $rule->whereNot('id', $user_id);
                    })
                    ->required(),
                TextInput::make('identitas')
                    ->label('هوية'),
                Select::make('jenis_kelamin')
                    ->label('جنس')
                    ->options([
                        'laki-laki' => 'رجل',
                        'perempuan' => 'امرأة',
                    ]),
                TextInput::make('telp')
                    ->label('هاتف')
                    ->tel(),
                Select::make('kelas_id')
                    ->label('فصل')
                    ->searchable()
                    ->required()
                    ->preload()
                    ->relationship('kelas', 'name'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->emptyStateHeading('لا يوجد طلاب')
            ->emptyStateDescription('يرجى إدخال أسماء الطلاب أو إضافة طلاب جدد')
            ->columns([
                TextColumn::make('user.name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('identitas')
                    ->label('هوية')
                    ->searchable(),
                TextColumn::make('jenis_kelamin')
                    ->label('جنس')
                    ->searchable(),
                TextColumn::make('telp')
                    ->label('هاتف')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('MasukkanSiswa')
                    ->color('info')
                    ->button()
                    ->modalWidth('md')
                    ->label('أدخل الطلاب')
                    ->schema([
                        Select::make('siswa')
                            ->searchable()
                            ->options(Siswa::all()->pluck('name', 'id'))
                    ])
                    ->action(function (array $data) {
                        $siswa = Siswa::find($data['siswa']);
                        $owner = $this->ownerRecord;
                        $siswa->update([
                            'kelas_id' => $owner->id
                        ]);
                    })
                    ->modalSubmitActionLabel('يضيف')
                    ->modalCancelActionLabel('تم الإلغاء'),
                CreateAction::make()
                    ->label('إضافة طالب')
                    ->schema(fn(Schema $schema) => $this->form($schema))
                    ->action(function ($record, array $data) {
                        $user = User::create([
                            'name' => $data['user']['name'],
                            'email' => $data['user']['email'],
                            'password' => bcrypt('password'),
                            'role' => 'siswa',
                        ]);
                        unset($data['user']);
                        $data['user_id'] = $user->id;
                        Siswa::create($data);
                    }),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('يتغير')
                    ->modalHeading('تغيير الطالب')
                    ->modalSubmitActionLabel('يحفظ')
                    ->modalCancelActionLabel('تم الإلغاء')
                    ->schema(fn(Schema $schema) => $this->form($schema))
                    ->fillForm(function ($data, $record) {
                        $data = $record->toArray();
                        $user = User::find($record->user_id);
                        $data['user'] = [
                            'name' => $user->name,
                            'email' => $user->email,
                        ];
                        return $data;
                    })
                    ->action(function ($record, array $data) {
                        $user = User::find($record->user_id);
                        $user->name = $data['user']['name'];
                        $user->email = $data['user']['email'];
                        $user->save();
                        unset($data['user']);
                        $record->update($data);
                    }),
                //DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //DeleteBulkAction::make(),
                ]),
            ]);
    }
}
