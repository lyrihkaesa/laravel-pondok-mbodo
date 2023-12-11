<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuardianResource\Pages;
use App\Filament\Resources\GuardianResource\RelationManagers;
use App\Models\Guardian;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Blade;

class GuardianResource extends Resource
{
    protected static ?string $model = Guardian::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Manajemen Anggota';
    protected static ?int $navigationSort = -2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('student')
                    ->label('Santri')
                    ->relationship('student', 'name')
                    ->searchable()
                    ->required()
                    ->hiddenOn(StudentResource\RelationManagers\GuardiansRelationManager::class),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('relationship')
                    ->label('Hubungan Keluarga')
                    ->native(false)
                    ->options([
                        'Ayah' => Blade::render('<span class="text-blue-600 dark:text-blue-400">Ayah</span>'),
                        'Ibu' => Blade::render('<span class="text-pink-600 dark:text-pink-400">Ibu</span>'),
                    ])
                    ->allowHtml(true)
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Hubungan Keluarga')
                            ->required()
                            ->placeholder('Paman / Bude / Kakek / Nenek')
                            ->maxLength(255),
                    ])
                    ->createOptionUsing(function (array $data) {
                        if (!isset($data['name'])) {
                            return 'Ayah';
                        }
                        return ucwords($data['name']);
                    })
                    ->required(),
                Forms\Components\Textarea::make('address')
                    ->default(function ($livewire) {
                        if (isset($livewire->ownerRecord->address)) {
                            return $livewire->ownerRecord->address;
                        }
                    })
                    ->label('Alamat')
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label('Nomor Telepon')
                    ->tel()
                    ->required()
                    ->placeholder('081234567890')
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('relationship')
                    ->label('Hubungan'),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Nomor Telepon')
                    ->copyable()
                    ->copyMessage('Nomor Telepon Telah Disalin'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListGuardians::route('/'),
            'create' => Pages\CreateGuardian::route('/create'),
            'view' => Pages\ViewGuardian::route('/{record}'),
            'edit' => Pages\EditGuardian::route('/{record}/edit'),
        ];
    }

    public static function getPluralModelLabel(): string
    {
        return 'Orang Tua/Wali';
    }

    public static function getModelLabel(): string
    {
        return 'Orang Tua/Wali';
    }
}
