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
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Manajemen Konten';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('Title'))
                            ->required()
                            ->minLength(1)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('path')
                            ->label(__('Path'))
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
                        // SLIDER
                        Forms\Components\Builder\Block::make('slider')
                            ->label(__('Slider'))
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

                        // TEAM
                        Forms\Components\Builder\Block::make('team')
                            ->label(__('Team'))
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

                        // POST
                        Forms\Components\Builder\Block::make('post')
                            ->label(__('Random Posts'))
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

                        // ARTICLE
                        Forms\Components\Builder\Block::make('article')
                            ->label(__('Article Single Markdown'))
                            ->schema([
                                Forms\Components\TextInput::make('title'),
                                Forms\Components\Textarea::make('sub_title'),
                                Forms\Components\FileUpload::make('url')
                                    ->label(__('Image'))
                                    ->image()
                                    ->downloadable()
                                    ->openable()
                                    ->directory('pages'),
                                Forms\Components\TextInput::make('alt')
                                    ->label(__('Alt text')),
                                Forms\Components\MarkdownEditor::make('body'),
                            ]),

                        // HERO
                        Forms\Components\Builder\Block::make('hero')
                            ->label(__('Hero'))
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Group::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->label(__('Title')),
                                                Forms\Components\TextInput::make('span_title')
                                                    ->label(__('Blue Title')),
                                                Forms\Components\Textarea::make('description')
                                                    ->label(__('Description')),
                                            ]),
                                        Forms\Components\Group::make()
                                            ->schema([
                                                Forms\Components\FileUpload::make('image')
                                                    ->label(__('Image'))
                                                    ->image()
                                                    ->downloadable()
                                                    ->openable()
                                                    ->directory('pages'),
                                                Forms\Components\TextInput::make('image_alt')
                                                    ->label(__('Alt text')),
                                            ])
                                    ])
                                    ->columns(2),
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('primary_button')
                                            ->label(__('Primary Button')),
                                        Forms\Components\TextInput::make('primary_button_url')
                                            ->label(__('Primary Button URL')),
                                    ])
                                    ->columns(2),
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('secondary_button')
                                            ->label(__('Secondary Button')),
                                        Forms\Components\TextInput::make('secondary_button_url')
                                            ->label(__('Secondary Button URL')),
                                    ])
                                    ->columns(2),
                            ]),

                        // ARTICLE_A
                        Forms\Components\Builder\Block::make('article-a')
                            ->label(__('Article Dual Markdown'))
                            ->schema([
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('title_left'),
                                        Forms\Components\MarkdownEditor::make('body_left'),
                                    ]),
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('title_right'),
                                        Forms\Components\MarkdownEditor::make('body_right'),
                                    ]),
                            ])
                            ->columns(2),

                        // TEAM_B
                        Forms\Components\Builder\Block::make('team-b')
                            ->label(__('Team Type-B'))
                            ->schema([
                                Forms\Components\TextInput::make('title'),
                                Forms\Components\Textarea::make('description'),
                                Forms\Components\Select::make('member_id')
                                    ->label(__('Members'))
                                    ->options(\App\Models\User::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->multiple(),
                            ]),

                        // MANY TABLE PACKAGE
                        Forms\Components\Builder\Block::make('many-table-packages')
                            ->label(__('Many Table Packages'))
                            ->schema([
                                Forms\Components\TextInput::make('title'),
                                Forms\Components\Textarea::make('description'),
                                Forms\Components\Select::make('package_ids')
                                    ->label(__('Packages'))
                                    ->options(\App\Models\Package::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->multiple(),
                            ]),

                        // FILAMENT SECTION
                        Forms\Components\Builder\Block::make('filament-section')
                            ->label(__('Filament Section'))
                            ->schema([
                                Forms\Components\Group::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('section_heading')
                                            ->label(__('Section Heading')),
                                        Forms\Components\Group::make()
                                            ->schema([
                                                Forms\Components\Toggle::make('aside')
                                                    ->inline(false)
                                                    ->onColor('success')
                                                    ->offColor('danger')
                                                    ->default(true),
                                                Forms\Components\Toggle::make('collapsible')
                                                    ->inline(false)
                                                    ->onColor('success')
                                                    ->offColor('danger')
                                                    ->default(true),
                                                Forms\Components\Toggle::make('divinder')
                                                    ->inline(false)
                                                    ->onColor('success')
                                                    ->offColor('danger')
                                                    ->default(true),
                                            ])
                                            ->columns(3),
                                    ])
                                    ->columns(2),
                                Forms\Components\Builder::make('body')
                                    ->schema([
                                        Forms\Components\Builder\Block::make('markdown')
                                            ->schema([
                                                Forms\Components\MarkdownEditor::make('content')
                                                    ->label(__('Markdown')),
                                            ]),
                                        Forms\Components\Builder\Block::make('team-c')
                                            ->schema([
                                                Forms\Components\TextInput::make('title')
                                                    ->label(__('Title')),
                                                Forms\Components\Textarea::make('description')
                                                    ->label(__('Description')),
                                                Forms\Components\Select::make('member_id')
                                                    ->label(__('Members'))
                                                    ->options(\App\Models\User::all()->pluck('name', 'id'))
                                                    ->searchable()
                                                    ->multiple(),
                                                Forms\Components\TextInput::make('whatsapp_message')
                                                    ->label(__('Whatsapp Message')),
                                            ])
                                    ]),
                            ]),


                        // Forms\Components\Builder\Block::make('heading')
                        //     ->schema([
                        //         Forms\Components\TextInput::make('content')
                        //             ->label('Heading')
                        //             ->required(),
                        //         Forms\Components\Select::make('level')
                        //             ->options([
                        //                 'h1' => 'Heading 1',
                        //                 'h2' => 'Heading 2',
                        //                 'h3' => 'Heading 3',
                        //                 'h4' => 'Heading 4',
                        //                 'h5' => 'Heading 5',
                        //                 'h6' => 'Heading 6',
                        //             ])
                        //             ->required(),
                        //     ])
                        //     ->columns(2),
                        // Forms\Components\Builder\Block::make('paragraph')
                        //     ->schema([
                        //         Forms\Components\Textarea::make('content')
                        //             ->label('Paragraph')
                        //             ->required(),
                        //     ]),
                        // Forms\Components\Builder\Block::make('image')
                        //     ->schema([
                        //         Forms\Components\FileUpload::make('url')
                        //             ->label('Image')
                        //             ->image()
                        //             ->required(),
                        //         Forms\Components\TextInput::make('alt')
                        //             ->label('Alt text')
                        //             ->required(),
                        //     ]),
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
                Tables\Columns\TextColumn::make('path')
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
