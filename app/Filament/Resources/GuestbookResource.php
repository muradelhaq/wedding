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
                Forms\Components\Section::make('Detail Ucapan & Doa')
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
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('is_approved')
                            ->label('Status Tampil (Disetujui)')
                            ->default(true),
                    ])->columns(['default' => 1, 'sm' => 2]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Pengirim')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Guestbook $record): ?string => 
                        $record->guest ? 'Tamu: ' . $record->guest->name : ($record->created_at?->diffForHumans() ?? null)
                    ),

                Tables\Columns\TextColumn::make('message')
                    ->label('Ucapan / Doa')
                    ->searchable()
                    ->wrap()
                    ->limit(80),

                Tables\Columns\ToggleColumn::make('is_approved')
                    ->label('Tampil')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Dikirim')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->visibleFrom('md'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('Status Moderasi'),
            ])
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
            'index' => Pages\ListGuestbooks::route('/'),
            'create' => Pages\CreateGuestbook::route('/create'),
            'edit' => Pages\EditGuestbook::route('/{record}/edit'),
        ];
    }
}
