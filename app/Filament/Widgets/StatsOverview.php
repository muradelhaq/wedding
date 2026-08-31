<?php

namespace App\Filament\Widgets;

use App\Models\Guest;
use App\Models\Guestbook;
use App\Models\Rsvp;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalGuests = Guest::count();
        $openedGuests = Guest::where('is_opened', true)->count();
        $openPercentage = $totalGuests > 0 ? round(($openedGuests / $totalGuests) * 100, 1) : 0;

        $totalHadirPax = Rsvp::where('attendance', 'hadir')->sum('total_guest');
        $totalRsvpResponses = Rsvp::count();
        $totalGuestbooks = Guestbook::count();

        return [
            Stat::make('Total Tamu Terdaftar', $totalGuests)
                ->description('Jumlah penerima link unik')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            Stat::make('Undangan Dibuka', "{$openedGuests} ({$openPercentage}%)")
                ->description('Tamu yang telah membuka undangan')
                ->descriptionIcon('heroicon-m-eye')
                ->color('success'),

            Stat::make('Konfirmasi Hadir (Pax)', $totalHadirPax)
                ->description("{$totalRsvpResponses} tamu telah mengisi RSVP")
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('warning'),

            Stat::make('Doa & Ucapan Masuk', $totalGuestbooks)
                ->description('Ucapan di buku tamu digital')
                ->descriptionIcon('heroicon-m-chat-bubble-bottom-center-text')
                ->color('info'),
        ];
    }
}
