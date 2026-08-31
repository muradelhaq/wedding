<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuestbookResource\Pages;
use App\Models\Guestbook;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GuestbookResource extends Resource
{
    protected static ?string $model = Guestbook::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Manajemen Undangan';

    protected static ?string $navigationLabel = 'Buku Tamu / Ucapan';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('guest_id')
                    ->relationship('guest', 'name')
                    ->label('Tamu Terkait')
                    ->searchable()
                    ->nullable(),

                Forms\Components\TextInput::make('name')
                    ->label('Nama Pengirim')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('message')
                    ->label('Pesan / Doa Restu')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_approved')
                    ->label('Status Tampil (Disetujui)')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pengirim')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('message')
                    ->label('Ucapan / Doa')
                    ->searchable()
                    ->wrap()
                    ->limit(100),

                Tables\Columns\ToggleColumn::make('is_approved')
                    ->label('Tampilkan')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Dikirim')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('Status Moderasi'),
            ])
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
            'index' => Pages\ListGuestbooks::route('/'),
            'create' => Pages\CreateGuestbook::route('/create'),
            'edit' => Pages\EditGuestbook::route('/{record}/edit'),
        ];
    }
}
