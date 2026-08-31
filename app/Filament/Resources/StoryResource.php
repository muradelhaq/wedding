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
                    ->url()
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('date_label')
                    ->label('Label Tanggal')
                    ->badge(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Isi')
                    ->limit(60),
            ])
            ->defaultSort('sort_order', 'asc')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
