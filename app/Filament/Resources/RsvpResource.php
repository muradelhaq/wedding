<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RsvpResource\Pages;
use App\Models\Rsvp;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RsvpResource extends Resource
{
    protected static ?string $model = Rsvp::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-badge';

    protected static ?string $navigationGroup = 'Manajemen Undangan';

    protected static ?string $navigationLabel = 'Konfirmasi RSVP';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Detail RSVP')
                    ->schema([
                        Forms\Components\Select::make('guest_id')
                            ->relationship('guest', 'name')
                            ->label('Tamu Undangan')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('attendance')
                            ->label('Konfirmasi Kehadiran')
                            ->options([
                                'hadir' => 'Hadir',
                                'tidak_hadir' => 'Tidak Hadir',
                                'ragu' => 'Masih Ragu',
                            ])
                            ->required(),

                        Forms\Components\TextInput::make('total_guest')
                            ->label('Jumlah Tamu Hadir')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->maxValue(10)
                            ->required(),

                        Forms\Components\Textarea::make('notes')
                            ->label('Catatan Tambahan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(['default' => 1, 'sm' => 2]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('guest.name')
                    ->label('Nama Tamu')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Rsvp $record): ?string => 
                        ($record->guest?->category ?? 'Umum') . 
                        ($record->notes ? ' • Catatan: ' . \Illuminate\Support\Str::limit($record->notes, 30) : '')
                    ),

                Tables\Columns\TextColumn::make('guest.category')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->visibleFrom('md'),

                Tables\Columns\TextColumn::make('attendance')
                    ->label('Kehadiran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'hadir' => 'success',
                        'tidak_hadir' => 'danger',
                        'ragu' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'hadir' => 'Hadir',
                        'tidak_hadir' => 'Tidak Hadir',
                        'ragu' => 'Ragu',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_guest')
                    ->label('Pax')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('notes')
                    ->label('Catatan')
                    ->limit(30)
                    ->placeholder('-')
                    ->visibleFrom('lg'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Konfirmasi')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->visibleFrom('md'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('attendance')
                    ->label('Status Kehadiran')
                    ->options([
                        'hadir' => 'Hadir',
                        'tidak_hadir' => 'Tidak Hadir',
                        'ragu' => 'Ragu-ragu',
                    ]),
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
            'index' => Pages\ListRsvps::route('/'),
            'create' => Pages\CreateRsvp::route('/create'),
            'edit' => Pages\EditRsvp::route('/{record}/edit'),
        ];
    }
}
