<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganizationResource\Pages;
use App\Filament\Resources\OrganizationResource\RelationManagers;
use App\Models\Organization;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Manajemen Akademik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Profile Organisasi')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->debounce()
                            ->minLength(1)
                            ->maxLength(255)
                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                if ($operation === 'edit') {
                                    return;
                                }

                                $set('slug', str()->slug($state));
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->minLength(1)
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->required(),
                        Forms\Components\MarkdownEditor::make('description')
                            ->label('Deskripsi')
                            ->disableToolbarButtons([
                                'attachFiles',
                            ]),
                        Forms\Components\Select::make('category')
                            ->label('Kategori')
                            ->required()
                            ->options([
                                'Sekolah Formal' => 'Sekolah Formal',
                                'Sekolah Madarasah' => 'Sekolah Madarasah',
                                'Program Jurusan' => 'Program Jurusan',
                                'Badan Lembaga' => 'Badan Lembaga',
                            ])
                            ->default('Badan Lembaga')
                            ->native(false),
                        Forms\Components\MarkdownEditor::make('vision')
                            ->label('Visi')
                            ->disableToolbarButtons([
                                'attachFiles',
                            ]),
                        Forms\Components\MarkdownEditor::make('mission')
                            ->label('Misi')
                            ->disableToolbarButtons([
                                'attachFiles',
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            RelationManagers\UsersRelationManager::class,
            RelationManagers\ProgramsRelationManager::class,
            RelationManagers\PackagesRelationManager::class,
            RelationManagers\ExtracurricularsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrganizations::route('/'),
            'create' => Pages\CreateOrganization::route('/create'),
            'edit' => Pages\EditOrganization::route('/{record}/edit'),
        ];
    }
}
