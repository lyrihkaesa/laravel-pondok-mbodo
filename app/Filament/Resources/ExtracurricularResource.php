<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExtracurricularResource\Pages;
use App\Filament\Resources\ExtracurricularResource\RelationManagers;
use App\Models\Extracurricular;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExtracurricularResource extends Resource
{
    protected static ?string $model = Extracurricular::class;
    protected static ?string $navigationIcon = 'heroicon-o-fire';
    protected static ?string $navigationGroup = 'Manajemen Akademik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Kegiatan')
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
                Forms\Components\TextInput::make('category')
                    ->label('Kategori'),
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->autosize(),
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
                    ->directory('extracurriculars/thumbnails'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListExtracurriculars::route('/'),
            'create' => Pages\CreateExtracurricular::route('/create'),
            'edit' => Pages\EditExtracurricular::route('/{record}/edit'),
        ];
    }
}
