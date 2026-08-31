@props(['settings'])

<section class="py-12 px-6 max-w-4xl mx-auto">
    <div class="text-center mb-12" data-reveal="fade-down">
        <p class="text-xs uppercase tracking-[0.3em] text-[#57795c] font-serif font-semibold mb-1">Maha Suci Allah yang Menciptakan Pasangan</p>
        <h2 class="font-serif text-3xl sm:text-4xl font-bold text-[#233327] mb-3">Kedua Mempelai</h2>
        <div class="w-16 h-1 bg-gradient-to-r from-transparent via-[#6F9575] to-transparent mx-auto rounded-full"></div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
        <!-- Groom Card -->
        <div class="bg-gradient-to-b from-white to-[#F4F7F4] border-2 border-[#D5E2D7] rounded-3xl p-8 text-center shadow-[0_10px_30px_rgba(111,149,117,0.12)] transition duration-300 hover:shadow-xl hover:border-[#6F9575]" 
             data-reveal="fade-right" data-reveal-delay="150">
            <div class="relative w-48 h-48 mx-auto mb-6" data-reveal="zoom-in" data-reveal-delay="250">
                <!-- Sage Floral Ring Halo -->
                <div class="absolute inset-0 rounded-full border-2 border-dashed border-[#6F9575]/60 animate-spin-slow"></div>
                <div class="absolute inset-2 rounded-full bg-gradient-to-tr from-[#6F9575] via-[#B6CDB9] to-[#314736] p-1 shadow-lg">
                    <img 
                        src="{{ $settings['couple']['groom_photo'] ?? asset('images/cartoon_groom.jpg') }}" 
                        alt="{{ $settings['couple']['groom_name'] ?? 'Ramazan Akcaalan' }}" 
                        class="w-full h-full object-cover rounded-full shadow-inner"
                        loading="lazy">
                </div>
            </div>

            <h3 class="font-serif text-2xl sm:text-3xl font-bold text-[#233327] mb-1" data-reveal="fade-up" data-reveal-delay="300">
                {{ $settings['couple']['groom_name'] ?? 'Ramazan Akcaalan' }}
            </h3>
            
            <p class="text-xs font-semibold uppercase tracking-widest text-[#57795c] mb-4 font-serif" data-reveal="fade-up" data-reveal-delay="350">
                — Mempelai Pria —
            </p>

            <div class="text-sm text-[#526356] space-y-1 mb-6" data-reveal="fade-up" data-reveal-delay="400">
                <p class="text-xs">Putra tercinta dari:</p>
                <p class="font-bold text-[#233327]">{{ $settings['couple']['groom_father'] ?? 'Bpk. Ismail Akcaalan' }}</p>
                <p class="text-xs text-[#6F9575] font-serif italic">&</p>
                <p class="font-bold text-[#233327]">{{ $settings['couple']['groom_mother'] ?? 'Ibu Aysel Akcaalan' }}</p>
                <p class="text-xs text-[#314736] font-medium mt-2 bg-[#6F9575]/15 py-1 px-3 rounded-full inline-block">Keluarga {{ $settings['couple']['groom_origin'] ?? 'Ağrı, Turki' }}</p>
            </div>

            @if(!empty($settings['couple']['groom_instagram']))
                <a href="https://instagram.com/{{ $settings['couple']['groom_instagram'] }}" target="_blank" rel="noopener noreferrer" 
                    data-reveal="zoom-in" data-reveal-delay="450"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-[#D5E2D7] bg-white text-xs font-medium text-[#425E47] hover:text-[#233327] hover:border-[#6F9575] shadow-sm transition">
                    <svg class="w-4 h-4 text-[#6F9575]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    <span>&#64;{{ $settings['couple']['groom_instagram'] }}</span>
                </a>
            @endif
        </div>

        <!-- Bride Card -->
        <div class="bg-gradient-to-b from-white to-[#F4F7F4] border-2 border-[#D5E2D7] rounded-3xl p-8 text-center shadow-[0_10px_30px_rgba(111,149,117,0.12)] transition duration-300 hover:shadow-xl hover:border-[#6F9575]"
             data-reveal="fade-left" data-reveal-delay="200">
            <div class="relative w-48 h-48 mx-auto mb-6" data-reveal="zoom-in" data-reveal-delay="300">
                <!-- Sage Floral Ring Halo -->
                <div class="absolute inset-0 rounded-full border-2 border-dashed border-[#6F9575]/60 animate-spin-slow"></div>
                <div class="absolute inset-2 rounded-full bg-gradient-to-tr from-[#314736] via-[#B6CDB9] to-[#6F9575] p-1 shadow-lg">
                    <img 
                        src="{{ $settings['couple']['bride_photo'] ?? asset('images/cartoon_bride.jpg') }}" 
                        alt="{{ $settings['couple']['bride_name'] ?? 'Dede Sobariah' }}" 
                        class="w-full h-full object-cover rounded-full shadow-inner"
                        loading="lazy">
                </div>
            </div>

            <h3 class="font-serif text-2xl sm:text-3xl font-bold text-[#233327] mb-1" data-reveal="fade-up" data-reveal-delay="350">
                {{ $settings['couple']['bride_name'] ?? 'Dede Sobariah' }}
            </h3>
            
            <p class="text-xs font-semibold uppercase tracking-widest text-[#57795c] mb-4 font-serif" data-reveal="fade-up" data-reveal-delay="400">
                — Mempelai Wanita —
            </p>

            <div class="text-sm text-[#526356] space-y-1 mb-6" data-reveal="fade-up" data-reveal-delay="450">
                <p class="text-xs">Putri tercinta dari:</p>
                <p class="font-bold text-[#233327]">{{ $settings['couple']['bride_father'] ?? 'Bpk. Endeng Zenal Arifin' }}</p>
                <p class="text-xs text-[#6F9575] font-serif italic">&</p>
                <p class="font-bold text-[#233327]">{{ $settings['couple']['bride_mother'] ?? 'Ibu Ipah Saripah' }}</p>
                <p class="text-xs text-[#314736] font-medium mt-2 bg-[#6F9575]/15 py-1 px-3 rounded-full inline-block">Keluarga {{ $settings['couple']['bride_origin'] ?? 'Garut, Indonesia' }}</p>
            </div>

            @if(!empty($settings['couple']['bride_instagram']))
                <a href="https://instagram.com/{{ $settings['couple']['bride_instagram'] }}" target="_blank" rel="noopener noreferrer" 
                    data-reveal="zoom-in" data-reveal-delay="500"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-[#D5E2D7] bg-white text-xs font-medium text-[#425E47] hover:text-[#233327] hover:border-[#6F9575] shadow-sm transition">
                    <svg class="w-4 h-4 text-[#6F9575]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    <span>&#64;{{ $settings['couple']['bride_instagram'] }}</span>
                </a>
            @endif
        </div>
    </div>
</section>
