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
    protected static ?string $navigationIcon = 'icon-working-parents';

    public static function getNavigationGroup(): ?string
    {
        return __('Manage Members');
    }

    public static function getNavigationSort(): ?int
    {
        return \App\Utilities\FilamentUtility::getNavigationSort(__('Guardian'));
    }

    public static function getPluralModelLabel(): string
    {
        return __('Guardian');
    }

    public static function getModelLabel(): string
    {
        return __('Guardian');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->placeholder('Bambang Susanto')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('relationship')
                    ->label('Hubungan Keluarga')
                    ->options([
                        'Ayah' => '<span class="text-blue-600 dark:text-blue-400">Ayah</span>',
                        'Ibu' => '<span class="text-pink-600 dark:text-pink-400">Ibu</span>',
                        'Saudara Laki-Laki' => '<span class="text-amber-600 dark:text-amber-400">Saudara Laki-Laki</span>',
                        'Saudara Perempuan' => '<span class="text-red-600 dark:text-red-400">Saudara Perempuan</span>',
                    ])
                    ->native(false)
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
                Forms\Components\TextInput::make('nik')
                    ->label('NIK')
                    ->placeholder('331504090919990001')
                    ->required()
                    ->length(16),

                Forms\Components\TextInput::make('job')
                    ->label('Pekerjaan')
                    ->placeholder('Petani/Wiraswasta/Wirausaha/dll')
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->label('Nomor Telepon (Whatsapp)')
                    ->tel()
                    ->required()
                    ->placeholder('6281234567890')
                    ->helperText('Ganti awalan 0 menjadi 62. Seperti nomor 08123456789 ke 628123456789.')
                    ->maxLength(255),
                Forms\Components\Textarea::make('address')
                    ->label('Alamat Lengkap')
                    ->placeholder('Jl. Senangsari, Dusun Sendangsari, RT 005, RW 007, Desa Tambirejo, Kec. Toroh, Kab. Grobogan, Prov. Jawa Tengah.')
                    ->autosize()
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
                // Tables\Actions\ViewAction::make(),
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
            RelationManagers\StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGuardians::route('/'),
            'create' => Pages\CreateGuardian::route('/create'),
            // 'view' => Pages\ViewGuardian::route('/{record}'),
            'edit' => Pages\EditGuardian::route('/{record}/edit'),
        ];
    }
}
