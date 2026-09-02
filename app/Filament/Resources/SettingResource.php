<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Pengaturan Undangan';

    protected static ?string $navigationLabel = 'Konten & Pengaturan';

    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Konfigurasi Konten')
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->label('Kunci Pengaturan')
                            ->required()
                            ->maxLength(100)
                            ->disabled(fn (?Setting $record) => $record !== null),

                        Forms\Components\Select::make('group')
                            ->label('Grup')
                            ->options([
                                'general' => 'Umum',
                                'quotes' => 'Kutipan & Doa',
                                'couple' => 'Profil Mempelai',
                                'event' => 'Detail Acara',
                                'envelope' => 'Amplop Digital',
                            ])
                            ->required(),

                        Forms\Components\Select::make('type')
                            ->label('Tipe Form')
                            ->options([
                                'text' => 'Teks Pendek',
                                'textarea' => 'Teks Panjang',
                                'image' => 'URL Gambar',
                            ])
                            ->required(),

                        Forms\Components\Textarea::make('value')
                            ->label('Isi Nilai / Konten')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])->columns(['default' => 1, 'sm' => 2]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Kunci Pengaturan')
                    ->searchable()
                    ->sortable()
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->description(fn (Setting $record): string => "Grup: {$record->group}"),

                Tables\Columns\TextColumn::make('group')
                    ->label('Grup')
                    ->badge()
                    ->sortable()
                    ->visibleFrom('md'),

                Tables\Columns\TextColumn::make('value')
                    ->label('Nilai Konten')
                    ->limit(50)
                    ->searchable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->visibleFrom('lg'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->label('Filter Grup')
                    ->options([
                        'general' => 'Umum',
                        'quotes' => 'Kutipan & Doa',
                        'couple' => 'Profil Mempelai',
                        'event' => 'Detail Acara',
                        'envelope' => 'Amplop Digital',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit'),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
