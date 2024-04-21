<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LawResource\Pages;
use App\Filament\Resources\LawResource\RelationManagers;
use App\Models\Law;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LawResource extends Resource
{
    protected static ?string $model = Law::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Metadata')
                    ->compact()
                    ->schema([
                        Forms\Components\Section::make()
                            ->compact()
                            ->schema([
                                Forms\Components\TextInput::make('chapter')
                                    ->label('BAB')
                                    ->required()
                                    ->numeric()
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('chapter_title')
                                    ->label('Judul BAB')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),
                            ])
                            ->columns([
                                'default' => 3,
                            ])
                            ->columnSpan(1),
                        Forms\Components\Section::make()
                            ->compact()
                            ->schema([
                                Forms\Components\TextInput::make('section')
                                    ->label('PASAL')
                                    ->required()
                                    ->numeric()
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('section_title')
                                    ->label('Judul PASAL')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(2),
                            ])
                            ->columns([
                                'default' => 3,
                            ])
                            ->columnSpan(1),
                    ])->columns(2),

                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Group::make()
                            ->schema([
                                Forms\Components\TextInput::make('article')
                                    ->label('AYAT')
                                    ->required()
                                    ->numeric(),
                                Forms\Components\TextInput::make('point')
                                    ->label('Poin')
                                    ->required()
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->columns([
                                'default' => 2,
                            ])
                            ->columnSpan([
                                'default' => 'full'
                            ]),
                        Forms\Components\Textarea::make('content')
                            ->label('Keterangan')
                            ->required()
                            ->autoSize()
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 2,
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('law_short_details')
                    ->label('Detail Singkat')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('law_details')
                    ->label('Detail')
                    ->badge()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('chapter')
                    ->label('Nomor BAB')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('chapter_title')
                    ->label('Judul BAB')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('section')
                    ->label('Nomor PASAL')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('section_title')
                    ->label('Judul PASAL')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('article')
                    ->label('Nomor AYAT')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('content')
                    ->searchable(),
                Tables\Columns\TextColumn::make('point')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListLaws::route('/'),
            'create' => Pages\CreateLaw::route('/create'),
            'edit' => Pages\EditLaw::route('/{record}/edit'),
        ];
    }
}
