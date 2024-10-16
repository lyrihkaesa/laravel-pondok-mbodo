<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Organization;
use Filament\Resources\Resource;
use App\Enums\SocialMediaPlatform;
use App\Enums\OrganizationCategory;
use App\Enums\SocialMediaVisibility;
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
                Forms\Components\Section::make(__('Basic Information'))
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(__('Name'))
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
                            ->label(__('Slug'))
                            ->minLength(1)
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->required(),
                        Forms\Components\MarkdownEditor::make('vision')
                            ->label(__('Vision'))
                            ->disableToolbarButtons([
                                'attachFiles',
                            ])
                            ->columnSpanFull(),
                        Forms\Components\MarkdownEditor::make('mission')
                            ->label(__('Mission'))
                            ->disableToolbarButtons([
                                'attachFiles',
                            ])
                            ->columnSpanFull(),
                        Forms\Components\MarkdownEditor::make('description')
                            ->label(__('Description'))
                            ->disableToolbarButtons([
                                'attachFiles',
                            ])
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('thumbnail')
                            ->label(__('Thumbnail'))
                            ->helperText(\App\Utilities\FileUtility::getImageHelperText(suffix: ''))
                            ->getUploadedFileNameForStorageUsing(
                                function (\Livewire\Features\SupportFileUploads\TemporaryUploadedFile $file, Forms\Get $get): string {
                                    return \App\Utilities\FileUtility::generateFileName($get('slug'), $file->getFileName());
                                }
                            )
                            ->image()
                            ->downloadable()
                            ->openable()
                            ->directory('organizations/thumbnails')
                            ->columnSpanFull(),
                        Forms\Components\Repeater::make('socialMediaLinks')
                            ->relationship('socialMediaLinks')
                            ->label(__('Social Media Links'))
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label(__('Name')),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Select::make('platform')
                                            ->label(__('Platform'))
                                            ->options(SocialMediaPlatform::class)
                                            ->live(onBlur: true)
                                            ->required(),
                                        Forms\Components\TextInput::make('url')
                                            ->label(__('URL'))
                                            ->placeholder(__('URL Placeholder'))
                                            ->url()
                                            ->columnSpan(2),
                                    ])
                                    ->columns(3),
                                Forms\Components\ToggleButtons::make('visibility')
                                    ->label(__('Visibility'))
                                    ->debounce(delay: 200)
                                    ->inline()
                                    ->options(SocialMediaVisibility::class)
                                    ->default(SocialMediaVisibility::PUBLIC)
                                    ->helperText(fn($state) => str((($state instanceof SocialMediaVisibility) ? $state : SocialMediaVisibility::from($state))->getDescription())->markdown()->toHtmlString())
                                    ->required(),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpan(2),
                Forms\Components\Section::make(__('Metadata'))
                    ->schema([
                        Forms\Components\TextInput::make('code')
                            ->label(__('Code'))
                            ->required(),
                        Forms\Components\Select::make('category')
                            ->label(__('Category'))
                            ->required()
                            ->options(OrganizationCategory::class)
                            ->default(OrganizationCategory::BADAN_LEMBAGA)
                            ->native(false),
                        Forms\Components\TextInput::make('email')
                            ->label(__('Email')),
                        Forms\Components\TextInput::make('phone')
                            ->label(__('Phone')),
                        Forms\Components\Textarea::make('address')
                            ->label(__('Address'))
                            ->autoSize(),
                        Forms\Components\TextInput::make('npsn')
                            ->label(__('NPSN')),
                        Forms\Components\TextInput::make('nsm')
                            ->label(__('NSM')),
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
                    ->label(__('Name')),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('Slug'))
                    ->badge()
                    ->color('neutral')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('category')
                    ->label(__('Category'))
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('publicShow')
                    ->label(__('Public Show'))
                    ->icon('heroicon-o-eye')
                    ->color('info')
                    ->url(function (Organization $record) {
                        return route('organizations.show', [
                            'slug' => $record->slug,
                        ]);
                    })
                    ->openUrlInNewTab(),
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
