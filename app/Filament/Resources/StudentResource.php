<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rules\Unique;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi pribadi')
                    ->description('Informasi pribadi yang dimiliki oleh santri')
                    ->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('address')->required(),
                        Radio::make('gender')->label('Jenis Kelamin')->options(['Laki-Laki' => 'Laki-Laki', 'Perempuan' => 'Perempuan'])->required()->default('Laki-Laki'),
                        DatePicker::make('birth_date')->required(),
                    ])->columns(2),
                Section::make('Kontak dan keamanan')->schema([
                    TextInput::make('phone')->required()->placeholder('Contoh: 628123456789')->unique(ignoreRecord: true),
                    TextInput::make('email')->email()->unique(ignoreRecord: true),
                    TextInput::make('password')->password(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('Nama')->searchable(),
                TextColumn::make('gender')->label('Jenis Kelamin'),
                // TextColumn::make('birth_date')->date('d/m/Y')->label('Tanggal Lahir'),
                // TextColumn::make('address')->label('Alamat'),
                TextColumn::make('user.phone')->label('Nomor Telepon')->searchable(),
                TextColumn::make('user.email')->label('Email')->searchable(),
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
            ]);
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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return 'Santri';
    }

    public static function getModelLabel(): string
    {
        return 'Santri';
    }
}
