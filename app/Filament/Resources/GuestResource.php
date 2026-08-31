<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuestResource\Pages;
use App\Models\Guest;
use App\Services\SlugGeneratorService;
use App\Services\WhatsappService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class GuestResource extends Resource
{
    protected static ?string $model = Guest::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Manajemen Undangan';

    protected static ?string $navigationLabel = 'Daftar Tamu';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Tamu')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Tamu / Keluarga')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, ?string $state, ?string $operation) {
                                if ($operation === 'create' && filled($state)) {
                                    $set('slug', app(SlugGeneratorService::class)->generate($state));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug / URL Unik')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(100)
                            ->helperText('Akan digunakan untuk URL: domain.com/{slug}'),

                        Forms\Components\TextInput::make('category')
                            ->label('Kategori Tamu')
                            ->default('Umum')
                            ->maxLength(100)
                            ->datalist([
                                'Keluarga Ağrı-Indo',
                                'Keluarga',
                                'Sahabat',
                                'Kolega',
                                'Alumni',
                                'VIP',
                                'Umum',
                            ]),

                        Forms\Components\TextInput::make('phone')
                            ->label('Nomor WhatsApp')
                            ->tel()
                            ->maxLength(50)
                            ->helperText('Format: 0812xxxx atau 62812xxxx'),

                        Forms\Components\TextInput::make('address')
                            ->label('Domisili / Alamat')
                            ->maxLength(255),

                        Forms\Components\Toggle::make('is_opened')
                            ->label('Status Undangan Telah Dibuka')
                            ->disabled()
                            ->dehydrated(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Tamu')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug Link')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Link slug berhasil disalin!')
                    ->fontFamily('mono')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('phone')
                    ->label('No. WhatsApp')
                    ->searchable()
                    ->placeholder('-'),

                Tables\Columns\IconColumn::make('is_opened')
                    ->label('Dibuka')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray')
                    ->sortable(),

                Tables\Columns\TextColumn::make('rsvp.attendance')
                    ->label('Status RSVP')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'hadir' => 'success',
                        'tidak_hadir' => 'danger',
                        'ragu' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'hadir' => 'Hadir',
                        'tidak_hadir' => 'Tidak Hadir',
                        'ragu' => 'Ragu-ragu',
                        default => 'Belum RSVP',
                    }),

                Tables\Columns\TextColumn::make('opened_at')
                    ->label('Waktu Dibuka')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Filter Kategori')
                    ->options([
                        'Keluarga Ağrı-Indo' => 'Keluarga Ağrı-Indo',
                        'Keluarga' => 'Keluarga',
                        'Sahabat' => 'Sahabat',
                        'Kolega' => 'Kolega',
                        'Alumni' => 'Alumni',
                        'VIP' => 'VIP',
                        'Umum' => 'Umum',
                    ]),
                Tables\Filters\TernaryFilter::make('is_opened')
                    ->label('Filter Dibuka'),
            ])
            ->actions([
                Tables\Actions\Action::make('send_wa')
                    ->label('Kirim WA')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('success')
                    ->url(fn (Guest $record): string => app(WhatsappService::class)->generateShareUrl($record))
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('preview_invitation')
                    ->label('Buka')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->color('primary')
                    ->url(fn (Guest $record): string => url('/' . $record->slug))
                    ->openUrlInNewTab(),

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
            'index' => Pages\ListGuests::route('/'),
            'create' => Pages\CreateGuest::route('/create'),
            'edit' => Pages\EditGuest::route('/{record}/edit'),
        ];
    }
}
