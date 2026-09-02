<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoryResource\Pages;
use App\Models\Story;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StoryResource extends Resource
{
    protected static ?string $model = Story::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $navigationGroup = 'Pengaturan Undangan';

    protected static ?string $navigationLabel = 'Love Story / Cerita';

    protected static ?int $navigationSort = 11;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Love Story')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Cerita')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('date_label')
                            ->label('Label Tanggal / Waktu')
                            ->placeholder('Contoh: 2024 / Awal Mula')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('image_path')
                            ->label('URL Foto Cerita')
                            ->maxLength(500),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Textarea::make('description')
                            ->label('Isi Cerita')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),
                    ])->columns(['default' => 1, 'sm' => 2]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable()
                    ->visibleFrom('md'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Cerita')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn (Story $record): ?string => $record->date_label ? "Periode: {$record->date_label}" : null),

                Tables\Columns\TextColumn::make('date_label')
                    ->label('Label Waktu')
                    ->badge()
                    ->visibleFrom('sm'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Isi Cerita')
                    ->limit(50)
                    ->visibleFrom('lg'),
            ])
            ->defaultSort('sort_order', 'asc')
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
                ->tooltip('Aksi'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStories::route('/'),
            'create' => Pages\CreateStory::route('/create'),
            'edit' => Pages\EditStory::route('/{record}/edit'),
        ];
    }
}
