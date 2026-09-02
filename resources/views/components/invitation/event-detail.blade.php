@props(['settings'])

@php
    $eventDate = $settings['event']['event_date'] ?? '2026-09-20';
    $eventDateFormatted = $settings['event']['event_date_formatted'] ?? '20 September 2026';
    $eventDay = $settings['event']['event_day'] ?? 'Ahad';
    $akadTitle = $settings['event']['akad_title'] ?? 'Akad Nikah';
    $akadTime = $settings['event']['akad_time'] ?? '10.00 - 11.00 WIB';
    $walimahTitle = $settings['event']['walimah_title'] ?? "Walimatul 'Urs";
    $walimahTime = $settings['event']['walimah_time'] ?? '11.00 - 15.00 WIB';
    $venue = $settings['event']['event_venue'] ?? 'Rumah Makan Leila';
    $address = $settings['event']['event_address'] ?? 'Jl. Raya Garut – Cikajang No. 22, Mekarsari, Kec. Cikajang, Kabupaten Garut, Jawa Barat 44171';
    $mapsUrl = $settings['event']['event_maps_url'] ?? 'https://share.google/yFV64kCwHfucu2xOl';

    // Google Calendar Link generator (20260920T030000Z to 20260920T080000Z for UTC / 10:00-15:00 WIB)
    $calTitle = urlencode("Pernikahan Ramazan & Dede");
    $calDetails = urlencode("Akad Nikah: {$akadTime}\nWalimatul 'Urs: {$walimahTime}\nBertempat di: {$venue}, {$address}");
    $calLocation = urlencode("{$venue}, {$address}");
    $googleCalUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$calTitle}&dates=20260920T030000Z/20260920T080000Z&details={$calDetails}&location={$calLocation}";
@endphp

<section class="py-16 px-4 sm:px-6 max-w-5xl mx-auto">
    <div class="text-center mb-10" data-reveal="fade-down">
        <p class="text-xs uppercase tracking-[0.3em] text-[#57795c] font-serif font-semibold mb-1" x-text="t('save_the_date')">Save The Date</p>
        <h2 class="font-serif text-3xl sm:text-4xl font-bold text-[#233327] mb-3" x-text="t('event_title')">Rangkaian Acara</h2>
        <div class="w-16 h-1 bg-gradient-to-r from-transparent via-[#6F9575] to-transparent mx-auto rounded-full mt-2"></div>
    </div>

    <!-- Countdown Timer Embed (Countdown to Akad start at 10:00 WIB) -->
    <div class="mb-12" data-reveal="zoom-in" data-reveal-delay="200">
        <x-invitation.countdown targetDate="2026-09-20T10:00:00+07:00" />
    </div>

    <!-- Dual Event Cards Grid (Akad Nikah & Walimatul 'Urs) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 mb-10">
        
        <!-- 1. Card Akad Nikah -->
        <div class="relative bg-gradient-to-b from-white to-[#F4F7F4] border-2 border-[#D5E2D7] rounded-3xl p-6 sm:p-8 shadow-[0_10px_35px_rgba(111,149,117,0.12)] hover:border-[#6F9575] hover:shadow-xl transition duration-300 overflow-hidden text-center flex flex-col justify-between"
             data-reveal="fade-right" data-reveal-delay="300">
            <!-- Subtle Inner Arch Contour -->
            <div class="absolute inset-2.5 rounded-2xl border border-[#6F9575]/15 pointer-events-none"></div>

            <div class="relative z-10">
                <!-- Icon Badge -->
                <div class="w-14 h-14 rounded-full bg-[#6F9575]/15 border border-[#6F9575]/30 flex items-center justify-center mx-auto mb-3 text-2xl shadow-sm">
                    💍
                </div>

                <span class="inline-block px-4 py-1 rounded-full bg-[#6F9575]/15 border border-[#6F9575]/30 text-[#314736] text-[11px] font-serif font-bold uppercase tracking-widest mb-2"
                      x-text="t('akad_badge')">
                    Akad Nikah
                </span>

                <h3 class="font-serif text-2xl sm:text-3xl font-bold text-[#233327] mb-2" x-text="t('akad_title')">
                    {{ $akadTitle }}
                </h3>

                <div class="w-12 h-1 bg-gradient-to-r from-transparent via-[#6F9575] to-transparent mx-auto mb-5 rounded-full"></div>

                <div class="space-y-3 mb-6">
                    <p class="text-xl sm:text-2xl font-serif font-bold text-[#233327]" x-text="t('event_date_badge')">
                        {{ $eventDay }}, {{ $eventDateFormatted }}
                    </p>
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#6F9575]/15 border border-[#6F9575]/30 text-xs sm:text-sm font-semibold text-[#233327] font-sans">
                        <svg class="w-4 h-4 text-[#57795c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span x-text="t('akad_time')">Pukul {{ $akadTime }}</span>
                    </div>
                </div>

                <div class="border-t border-[#D5E2D7] pt-5 text-center">
                    <p class="text-[11px] uppercase tracking-widest text-[#57795c] font-serif font-bold mb-1" x-text="t('venue_label')">Bertempat di:</p>
                    <h4 class="text-base sm:text-lg font-bold font-serif text-[#233327] mb-1.5">{{ $venue }}</h4>
                    <p class="text-xs sm:text-sm text-[#526356] leading-relaxed font-sans max-w-xs mx-auto">
                        {{ $address }}
                    </p>
                </div>
            </div>
        </div>

        <!-- 2. Card Walimatul 'Urs -->
        <div class="relative bg-gradient-to-b from-white to-[#F4F7F4] border-2 border-[#D5E2D7] rounded-3xl p-6 sm:p-8 shadow-[0_10px_35px_rgba(111,149,117,0.12)] hover:border-[#6F9575] hover:shadow-xl transition duration-300 overflow-hidden text-center flex flex-col justify-between"
             data-reveal="fade-left" data-reveal-delay="400">
            <!-- Subtle Inner Arch Contour -->
            <div class="absolute inset-2.5 rounded-2xl border border-[#6F9575]/15 pointer-events-none"></div>

            <div class="relative z-10">
                <!-- Icon Badge -->
                <div class="w-14 h-14 rounded-full bg-[#6F9575]/15 border border-[#6F9575]/30 flex items-center justify-center mx-auto mb-3 text-2xl shadow-sm">
                    🌸
                </div>

                <span class="inline-block px-4 py-1 rounded-full bg-[#6F9575]/15 border border-[#6F9575]/30 text-[#314736] text-[11px] font-serif font-bold uppercase tracking-widest mb-2"
                      x-text="t('walimah_badge')">
                    Walimah / Resepsi
                </span>

                <h3 class="font-serif text-2xl sm:text-3xl font-bold text-[#233327] mb-2" x-text="t('walimah_title')">
                    {{ $walimahTitle }}
                </h3>

                <div class="w-12 h-1 bg-gradient-to-r from-transparent via-[#6F9575] to-transparent mx-auto mb-5 rounded-full"></div>

                <div class="space-y-3 mb-6">
                    <p class="text-xl sm:text-2xl font-serif font-bold text-[#233327]" x-text="t('event_date_badge')">
                        {{ $eventDay }}, {{ $eventDateFormatted }}
                    </p>
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#6F9575]/15 border border-[#6F9575]/30 text-xs sm:text-sm font-semibold text-[#233327] font-sans">
                        <svg class="w-4 h-4 text-[#57795c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span x-text="t('walimah_time')">Pukul {{ $walimahTime }}</span>
                    </div>
                </div>

                <div class="border-t border-[#D5E2D7] pt-5 text-center">
                    <p class="text-[11px] uppercase tracking-widest text-[#57795c] font-serif font-bold mb-1" x-text="t('venue_label')">Bertempat di:</p>
                    <h4 class="text-base sm:text-lg font-bold font-serif text-[#233327] mb-1.5">{{ $venue }}</h4>
                    <p class="text-xs sm:text-sm text-[#526356] leading-relaxed font-sans max-w-xs mx-auto">
                        {{ $address }}
                    </p>
                </div>
            </div>
        </div>

    </div>

    <!-- Actions Bar -->
    <div class="flex flex-wrap justify-center gap-4" data-reveal="zoom-in" data-reveal-delay="500">
        <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 px-6 py-3.5 rounded-full bg-gradient-to-r from-[#6F9575] via-[#85AB8B] to-[#57795C] hover:from-[#57795C] hover:to-[#425E47] text-white font-bold text-xs sm:text-sm shadow-md hover:shadow-lg transition duration-200 hover:scale-105">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span x-text="t('cal_btn')">Simpan ke Google Calendar</span>
        </a>

        <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer"
           class="inline-flex items-center gap-2 px-6 py-3.5 rounded-full bg-white border-2 border-[#6F9575] hover:bg-[#6F9575]/10 text-[#233327] font-bold text-xs sm:text-sm shadow-md transition duration-200 hover:scale-105">
            <svg class="w-4 h-4 text-[#57795c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span x-text="t('maps_btn')">Buka Google Maps</span>
        </a>
    </div>
</section>

