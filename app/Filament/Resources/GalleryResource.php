<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Pengaturan Undangan';

    protected static ?string $navigationLabel = 'Galeri Foto';

    protected static ?int $navigationSort = 12;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail Galeri Media')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul / Keterangan')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('file_path')
                            ->label('URL Foto / Media')
                            ->required()
                            ->maxLength(500),

                        Forms\Components\Select::make('media_type')
                            ->label('Tipe Media')
                            ->options([
                                'image' => 'Foto (Gambar)',
                                'video' => 'Video (URL)',
                            ])
                            ->default('image')
                            ->required(),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan Tampil')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_featured')
                            ->label('Tampilkan sebagai Foto Utama Cover'),
                    ])->columns(['default' => 1, 'sm' => 2]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file_path')
                    ->label('Preview')
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Media')
                    ->searchable()
                    ->placeholder('-')
                    ->description(fn (Gallery $record): string => "Urutan: {$record->sort_order}" . ($record->is_featured ? ' • Featured ⭐' : '')),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->visibleFrom('md'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->visibleFrom('sm'),
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
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}
