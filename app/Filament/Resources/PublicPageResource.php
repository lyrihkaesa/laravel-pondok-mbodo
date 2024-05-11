<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicPageResource\Pages;
use App\Filament\Resources\PublicPageResource\RelationManagers;
use App\Models\PublicPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PublicPageResource extends Resource
{
    protected static ?string $model = PublicPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('Title'))
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
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label(__('Published At')),
                    ])
                    ->columns(3),
                Forms\Components\Builder::make('content')
                    ->label(__('Content'))
                    ->blocks([
                        Forms\Components\Builder\Block::make('slider')
                            ->schema([
                                Forms\Components\Repeater::make('slides')
                                    ->schema([
                                        Forms\Components\FileUpload::make('url')
                                            ->label(__('Image'))
                                            ->image()
                                            ->downloadable()
                                            ->openable()
                                            ->required()
                                            ->directory('pages'),
                                        Forms\Components\TextInput::make('alt')
                                            ->label('Alt text')
                                            ->required(),
                                    ])
                                    ->grid(2),
                            ]),
                        Forms\Components\Builder\Block::make('team')
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('title'),
                                        Forms\Components\Textarea::make('description'),
                                    ]),
                                Forms\Components\Repeater::make('teams')
                                    ->schema([
                                        Forms\Components\FileUpload::make('url')
                                            ->label(__('Image'))
                                            ->image()
                                            ->downloadable()
                                            ->openable()
                                            ->required()
                                            ->directory('pages'),
                                        Forms\Components\TextInput::make('alt')
                                            ->label('Alt text')
                                            ->required(),
                                        Forms\Components\TextInput::make('name')
                                            ->label(__('Name')),
                                        Forms\Components\TextInput::make('role')
                                            ->label(__('Role')),
                                    ])
                                    ->grid(2),
                            ]),
                        Forms\Components\Builder\Block::make('post')
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('title'),
                                        Forms\Components\TextInput::make('take')
                                            ->label(__('Take'))
                                            ->numeric()
                                            ->minValue(1)
                                            ->maxValue(10)
                                            ->required()
                                            ->default(3),
                                    ]),
                                Forms\Components\Textarea::make('description'),
                            ]),
                        Forms\Components\Builder\Block::make('heading')
                            ->schema([
                                Forms\Components\TextInput::make('content')
                                    ->label('Heading')
                                    ->required(),
                                Forms\Components\Select::make('level')
                                    ->options([
                                        'h1' => 'Heading 1',
                                        'h2' => 'Heading 2',
                                        'h3' => 'Heading 3',
                                        'h4' => 'Heading 4',
                                        'h5' => 'Heading 5',
                                        'h6' => 'Heading 6',
                                    ])
                                    ->required(),
                            ])
                            ->columns(2),
                        Forms\Components\Builder\Block::make('paragraph')
                            ->schema([
                                Forms\Components\Textarea::make('content')
                                    ->label('Paragraph')
                                    ->required(),
                            ]),
                        Forms\Components\Builder\Block::make('image')
                            ->schema([
                                Forms\Components\FileUpload::make('url')
                                    ->label('Image')
                                    ->image()
                                    ->required(),
                                Forms\Components\TextInput::make('alt')
                                    ->label('Alt text')
                                    ->required(),
                            ]),
                    ])
                    ->collapsible()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
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
            'index' => Pages\ListPublicPages::route('/'),
            'create' => Pages\CreatePublicPage::route('/create'),
            'edit' => Pages\EditPublicPage::route('/{record}/edit'),
        ];
    }
}
