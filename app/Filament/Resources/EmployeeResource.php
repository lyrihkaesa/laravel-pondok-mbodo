<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Spatie\Permission\Models\Role;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Section::make('Informasi pribadi')
                    ->description('Informasi pribadi yang dimiliki oleh santri')
                    ->schema([
                        Components\TextInput::make('name')->required(),
                        Components\TextInput::make('address')->required(),
                        Components\Radio::make('gender')->label('Jenis Kelamin')->options(['Laki-Laki' => 'Laki-Laki', 'Perempuan' => 'Perempuan'])->required()->default('Laki-Laki'),
                        Components\DatePicker::make('birth_date')->required(),
                    ])->columns(2),
                Components\Section::make('Kontak dan keamanan')->schema([
                    Components\TextInput::make('phone')->required()->placeholder('Contoh: 628123456789')->unique(ignoreRecord: true),
                    Components\TextInput::make('email')->email()->unique(ignoreRecord: true),
                    Components\TextInput::make('password')->password(),
                    Components\Select::make('roles')
                        ->options(Role::whereNotIn('name', ['Super Admin', 'Santri'])->pluck('name', 'id'))
                        ->searchable()->multiple()->label('Peran')->preload(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Nama')->searchable(),
                TextColumn::make('user.phone')->label('Nomor Telepon')->searchable(),
                TextColumn::make('user.roles.name')->label('Peran'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->modifyQueryUsing(function (Builder $query) {
                $query->whereHas('user', function (Builder $query) {
                    $query->whereHas('roles', function (Builder $query) {
                        $query->whereNotIn('name', ['Super Admin', 'Santri']);
                    });
                });
            });
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return 'Pengurus';
    }

    public static function getModelLabel(): string
    {
        return 'Pengurus';
    }
}
