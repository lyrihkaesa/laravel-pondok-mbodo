<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Organization;
use Filament\Resources\Resource;
use App\Enums\OrganizationCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrganizationResource\Pages;
use App\Filament\Resources\OrganizationResource\RelationManagers;

class OrganizationResource extends Resource
{
    protected static ?string $model = Organization::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = 'Manajemen Yayasan';
    protected static ?string $label = 'Badan Lembaga';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Profile')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->live(onBlur: true)
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
                        Forms\Components\MarkdownEditor::make('vision')
                            ->label('Visi')
                            ->disableToolbarButtons([
                                'attachFiles',
                            ])
                            ->columnSpanFull(),
                        Forms\Components\MarkdownEditor::make('mission')
                            ->label('Misi')
                            ->disableToolbarButtons([
                                'attachFiles',
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpan(2),
                Forms\Components\Section::make('Metadata')
                    ->schema([
                        Forms\Components\Select::make('category')
                            ->label('Kategori')
                            ->required()
                            ->options(OrganizationCategory::class)
                            ->default(OrganizationCategory::BADAN_LEMBAGA)
                            ->native(false),
                        Forms\Components\TextInput::make('email')
                            ->label('Email'),
                        Forms\Components\TextInput::make('phone')
                            ->label('Phone'),
                        Forms\Components\Textarea::make('address')
                            ->label('Full Address')
                            ->autoSize(),
                        Forms\Components\MarkdownEditor::make('description')
                            ->label('Deskripsi')
                            ->disableToolbarButtons([
                                'attachFiles',
                            ])
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label('Gambar Thumbnail')
                            ->helperText(\App\Utilities\FileUtility::getImageHelperText(suffix: ''))
                            ->getUploadedFileNameForStorageUsing(
                                function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                    return \App\Utilities\FileUtility::generateFileName($get('slug'), $file->getFileName());
                                }
                            )
                            ->image()
                            ->downloadable()
                            ->openable()
                            ->directory('organizations/thumbnails'),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('slug')
                    ->badge()
                    ->color('neutral')
                    ->copyable(),
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
            RelationManagers\FacilitiesRelationManager::class,
            RelationManagers\ClassroomsRelationManager::class,
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
