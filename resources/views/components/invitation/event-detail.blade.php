@props(['settings'])

@php
    $eventDate = $settings['event']['event_date'] ?? '2026-09-20';
    $eventTime = $settings['event']['event_time'] ?? '11.00 - 15.00 WIB';
    $venue = $settings['event']['event_venue'] ?? 'Rumah Makan dan Wisata Eptilu';
    $address = $settings['event']['event_address'] ?? 'Jl. Raya Garut - Cikajang No.KM. 24, Mekarsari, Kec. Cikajang, Kabupaten Garut, Jawa Barat 44171';
    $mapsUrl = $settings['event']['event_maps_url'] ?? 'https://bit.ly/4qGZHen';

    // Google Calendar Link generator (20260920T040000Z to 20260920T080000Z for UTC / 11:00-15:00 WIB)
    $calTitle = urlencode("Tasyakuran Pernikahan Ramazan & Dede");
    $calDetails = urlencode("Acara Tasyakuran Pernikahan Ramazan Akcaalan & Dede Sobariah di Eptilu Garut");
    $calLocation = urlencode("Rumah Makan dan Wisata Eptilu, Garut");
    $googleCalUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$calTitle}&dates=20260920T040000Z/20260920T080000Z&details={$calDetails}&location={$calLocation}";
@endphp

<section class="py-16 px-6 max-w-4xl mx-auto">
    <div class="text-center mb-12" data-reveal="fade-down">
        <p class="text-xs uppercase tracking-[0.3em] text-[#57795c] font-serif font-semibold mb-1">Save The Date</p>
        <h2 class="font-serif text-3xl sm:text-4xl font-bold text-[#233327] mb-3">Rangkaian Acara</h2>
        <div class="w-16 h-1 bg-gradient-to-r from-transparent via-[#6F9575] to-transparent mx-auto rounded-full mt-2"></div>
    </div>

    <!-- Countdown Timer Embed -->
    <div class="mb-12" data-reveal="zoom-in" data-reveal-delay="200">
        <x-invitation.countdown targetDate="2026-09-20T11:00:00+07:00" />
    </div>

    <!-- Event Card with Sage Botanical Theme -->
    <div class="relative bg-gradient-to-br from-[#162119] via-[#233327] to-[#162119] text-[#F4F7F4] rounded-3xl p-8 sm:p-12 shadow-2xl border-2 border-[#6F9575]/50 overflow-hidden text-center"
         data-reveal="fade-up" data-reveal-delay="300">
        <!-- Subtle Glowing Bokeh Background -->
        <div class="absolute inset-0 opacity-15 pointer-events-none bg-[radial-gradient(#6F9575_1px,transparent_1px)] [background-size:24px_24px]"></div>

        <div class="relative z-10 max-w-xl mx-auto">
            <span class="inline-block px-5 py-1.5 rounded-full bg-[#6F9575]/25 border border-[#6F9575]/50 text-[#B6CDB9] text-xs font-serif font-bold uppercase tracking-widest mb-6"
                  data-reveal="zoom-in" data-reveal-delay="350">
                Acara Utama
            </span>

            <h3 class="font-serif text-3xl sm:text-4xl font-bold text-[#F4F7F4] mb-4" data-reveal="fade-up" data-reveal-delay="400">
                {{ $settings['event']['event_title'] ?? 'Tasyakuran Pernikahan' }}
            </h3>

            <div class="w-16 h-[1px] bg-gradient-to-r from-transparent via-[#6F9575] to-transparent mx-auto mb-6"></div>

            <div class="space-y-3 mb-8" data-reveal="fade-up" data-reveal-delay="450">
                <p class="text-2xl sm:text-3xl font-serif font-bold text-gold-gradient">
                    {{ $settings['event']['event_day'] ?? 'Ahad' }}, {{ $settings['event']['event_date_formatted'] ?? '20 September 2026' }}
                </p>
                <p class="text-sm sm:text-base text-[#D5E2D7] font-sans">
                    Pukul {{ $eventTime }}
                </p>
            </div>

            <div class="border-t border-[#f4f7f4]/15 pt-6 mb-8" data-reveal="fade-up" data-reveal-delay="500">
                <p class="text-xs uppercase tracking-widest text-[#B6CDB9] font-serif font-medium mb-1">Bertempat di:</p>
                <h4 class="text-lg sm:text-xl font-bold font-serif text-[#F4F7F4] mb-2">{{ $venue }}</h4>
                <p class="text-xs sm:text-sm text-[#D5E2D7]/90 leading-relaxed font-sans max-w-md mx-auto">
                    {{ $address }}
                </p>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap justify-center gap-4" data-reveal="zoom-in" data-reveal-delay="550">
                <a href="{{ $googleCalUrl }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-gradient-to-r from-[#6F9575] via-[#85AB8B] to-[#57795C] text-white font-bold text-xs sm:text-sm shadow-lg transition duration-200 hover:scale-105">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Simpan ke Google Calendar</span>
                </a>

                <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-full border border-[#6F9575]/60 hover:bg-white/10 text-[#F4F7F4] font-bold text-xs sm:text-sm transition duration-200 hover:scale-105">
                    <svg class="w-4 h-4 text-[#B6CDB9]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>Buka Google Maps</span>
                </a>
            </div>
        </div>
    </div>
</section>
