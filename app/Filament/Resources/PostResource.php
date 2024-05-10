<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Manajemen Konten';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Main'))
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Title')
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
                        Forms\Components\MarkdownEditor::make('content')
                            ->label(__('Content'))
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2),
                Forms\Components\Section::make(__('Meta'))
                    ->schema([
                        Forms\Components\Select::make('author_id')
                            ->label(__('Author'))
                            ->relationship('author', 'name')
                            ->disabled()
                            ->default(auth()->id()),
                        Forms\Components\Select::make('editor_id')
                            ->label(__('Editor'))
                            ->relationship('editor', 'name')
                            ->preload()
                            ->searchable()
                            ->default(auth()->id()),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label(__('Published At')),
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
                            ->directory('posts/thumbnails'),
                    ])
                    ->columnSpan(1),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label(__('Thumbnail'))
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('title')
                    ->label(__('Title'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label(__('Slug'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('author.name')
                    ->label(__('Author'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('editor.name')
                    ->label(__('Editor'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('published_at')
                    ->label(__('Published At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
