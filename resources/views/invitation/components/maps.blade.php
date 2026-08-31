@props(['settings'])

@php
    $mapsEmbed = $settings['event']['event_maps_embed'] ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.1706606041695!2d107.7854611!3d-7.3347101!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68ba9b8c66e2c3%3A0xe54ef90eaee60107!2sWisata%20Eptilu!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid';
    $mapsUrl = $settings['event']['event_maps_url'] ?? 'https://bit.ly/4qGZHen';
    $venue = $settings['event']['event_venue'] ?? 'Rumah Makan dan Wisata Eptilu, Garut';
    $address = $settings['event']['event_address'] ?? 'Jl. Raya Garut - Cikajang No.KM. 24, Mekarsari, Kec. Cikajang, Kabupaten Garut, Jawa Barat 44171';
@endphp

<section class="py-16 px-6 max-w-4xl mx-auto">
    <div class="text-center mb-10" data-reveal="fade-down">
        <h2 class="font-serif text-3xl sm:text-4xl font-bold text-[#233327] mb-3">Peta Lokasi</h2>
        <p class="text-xs uppercase tracking-widest text-[#57795c] font-semibold">Location & Directions</p>
        <div class="w-16 h-1 bg-[#6F9575] mx-auto rounded-full mt-3"></div>
    </div>

    <div class="bg-white border-2 border-[#D5E2D7] rounded-3xl p-4 sm:p-6 shadow-[0_10px_30px_rgba(111,149,117,0.12)] overflow-hidden"
         data-reveal="zoom-in" data-reveal-delay="200">
        <!-- Google Maps Iframe Container -->
        <div class="relative w-full h-72 sm:h-96 rounded-2xl overflow-hidden shadow-inner mb-6 bg-gray-100"
             data-reveal="fade-up" data-reveal-delay="300">
            <iframe 
                src="{{ $mapsEmbed }}" 
                class="absolute inset-0 w-full h-full border-0" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-2"
             data-reveal="fade-up" data-reveal-delay="400">
            <div class="text-center sm:text-left">
                <h4 class="font-bold text-[#233327] text-base">{{ $venue }}</h4>
                <p class="text-xs text-[#526356] max-w-md">{{ $address }}</p>
            </div>

            <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-gradient-to-r from-[#6F9575] via-[#85AB8B] to-[#57795C] hover:from-[#57795C] hover:to-[#425E47] text-white text-xs font-semibold shadow-md transition duration-200 shrink-0">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                </svg>
                <span>Petunjuk Arah (Google Maps)</span>
            </a>
        </div>
    </div>
</section>
