@props(['guest', 'settings'])

<section 
    x-show="!isOpened"
    x-transition:leave="transition ease-in-out duration-700"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center select-none overflow-hidden bg-[#162119]">

    <!-- Frame Wrapper Mobile View (Ukuran 9:16 Responsif) -->
    <div class="wedding-card relative w-full max-w-[430px] h-full max-h-[932px] overflow-hidden shadow-2xl rounded-none sm:rounded-2xl flex flex-col justify-between items-center bg-[#162119]">
        
        <!-- 1. Background Cartoon Couple Cover Layer -->
        <div class="bg-palace absolute inset-0 z-1 bg-cover bg-center pointer-events-none transition-transform duration-1000"
             :class="isCurtainOpening ? 'scale-105' : ''"
             style="background-image: url('{{ asset('images/cartoon_couple_cover.webp') }}');">
            <!-- Dark Vignette for High Text Readability -->
            <div class="absolute inset-0 bg-gradient-to-b from-[#162119]/60 via-[#162119]/25 to-[#162119]/80"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(22,33,25,0.45)_0%,rgba(22,33,25,0.1)_55%,rgba(22,33,25,0.65)_100%)]"></div>
        </div>

        <!-- 2. Sunlight Glow Overlay -->
        <div class="sunlight-overlay absolute inset-0 z-2 pointer-events-none"
             style="background: radial-gradient(circle at 50% 25%, rgba(244, 247, 244, 0.25) 0%, rgba(111, 149, 117, 0.15) 60%, rgba(22,33,25,0.3) 100%);">
        </div>

        <!-- 3. Luxury Top Corner Draperies (Tirai Atas Kiri & Kanan) -->
        <!-- Left Top Curtain -->
        <div class="curtain curtain-left absolute top-0 left-0 w-[45%] h-[35%] z-20 pointer-events-none transition-all duration-1000 ease-[cubic-bezier(0.25,1,0.5,1)]"
             :style="isCurtainOpening ? 'transform: translate(-100%, -100%) scale(0.5) !important; opacity: 0;' : 'background: radial-gradient(ellipse at top left, rgba(255,255,255,0.8), rgba(213,226,215,0.4) 70%, transparent 100%); backdrop-filter: blur(2px); border-bottom-right-radius: 100% 90%; transform: translateX(-5%); animation: curtainWaveLeft 6s ease-in-out infinite alternate;'">
        </div>

        <!-- Right Top Curtain -->
        <div class="curtain curtain-right absolute top-0 right-0 w-[45%] h-[35%] z-20 pointer-events-none transition-all duration-1000 ease-[cubic-bezier(0.25,1,0.5,1)]"
             :style="isCurtainOpening ? 'transform: translate(100%, -100%) scale(0.5) !important; opacity: 0;' : 'background: radial-gradient(ellipse at top right, rgba(255,255,255,0.8), rgba(213,226,215,0.4) 70%, transparent 100%); backdrop-filter: blur(2px); border-bottom-left-radius: 100% 90%; transform: translateX(5%); animation: curtainWaveRight 6s ease-in-out infinite alternate;'">
        </div>

        <!-- 4. Lengkungan Bunga & Pilar (Floral Arch Frame) -->
        <div class="arch-frame absolute inset-x-[5%] top-[5%] bottom-0 border-2 border-[#6F9575]/50 border-b-0 rounded-t-[180px] z-4 pointer-events-none shadow-[inset_0_0_20px_rgba(255,255,255,0.3)] transition-all duration-1000"
             :class="isCurtainOpening ? 'opacity-0 scale-105' : 'opacity-100'">
        </div>

        <!-- 5. Merpati Terbang (Doves) -->
        <div class="dove-container absolute top-[6%] left-1/2 -translate-x-1/2 z-6 flex gap-8 pointer-events-none transition-all duration-700"
             :class="isCurtainOpening ? 'opacity-0 -translate-y-10' : 'opacity-100'"
             style="animation: doveFly 5s ease-in-out infinite alternate;">
            <span class="dove text-2xl filter drop-shadow-[0_4px_8px_rgba(0,0,0,0.8)]">🕊️</span>
            <span class="dove text-2xl filter drop-shadow-[0_4px_8px_rgba(0,0,0,0.8)] transform scale-x-[-1]">🕊️</span>
        </div>

        <!-- 6. Lampu / Lantern di Kiri & Kanan Bawah -->
        <div class="lantern lantern-left absolute bottom-[55px] left-4 w-11 h-20 z-7 flex flex-col items-center pointer-events-none transition-all duration-700"
             :class="isCurtainOpening ? 'opacity-0 -translate-x-10' : 'opacity-100'"
             style="animation: floatLantern 4s ease-in-out infinite alternate;">
            <div class="lantern-bulb w-6 h-9 bg-[#f4f7f4] rounded-t-xl rounded-b-md shadow-[0_0_25px_12px_rgba(182,205,185,0.8),0_0_50px_20px_rgba(111,149,117,0.4)]"
                 style="animation: pulseGlow 2.5s infinite alternate;"></div>
            <div class="lantern-stand w-[3px] h-11 bg-gradient-to-b from-[#6F9575] to-[#233327]"></div>
        </div>

        <div class="lantern lantern-right absolute bottom-[55px] right-4 w-11 h-20 z-7 flex flex-col items-center pointer-events-none transition-all duration-700"
             :class="isCurtainOpening ? 'opacity-0 translate-x-10' : 'opacity-100'"
             style="animation: floatLantern 4s ease-in-out infinite alternate; animation-delay: -2s;">
            <div class="lantern-bulb w-6 h-9 bg-[#f4f7f4] rounded-t-xl rounded-b-md shadow-[0_0_25px_12px_rgba(182,205,185,0.8),0_0_50px_20px_rgba(111,149,117,0.4)]"
                 style="animation: pulseGlow 2.5s infinite alternate;"></div>
            <div class="lantern-stand w-[3px] h-11 bg-gradient-to-b from-[#6F9575] to-[#233327]"></div>
        </div>

        <!-- 7. KONTEN UTAMA: Nama di Tengah (Center), Tanggal & Tamu di Bawah (Bottom) -->
        <div class="content relative inset-0 z-10 flex flex-col justify-between items-center text-center p-4 sm:p-6 w-full h-full text-[#F4F7F4] pointer-events-auto">
            
            <!-- BAGIAN TENGAH: Sub-Title & Nama Mempelai di Tengah Layar (Diturunkan lebih nyaman di area bebas) -->
            <div class="middle-section my-auto flex flex-col items-center justify-center pt-20 sm:pt-24 translate-y-8 sm:translate-y-12">
                <!-- Sub-Title -->
                <p class="sub-title font-display text-[0.85rem] sm:text-[0.95rem] tracking-[6px] uppercase text-[#F4F7F4] font-bold mb-1 text-sage-shadow"
                   style="animation: fadeInUp 1.2s 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;">
                    <span x-text="t('cover_sub')">The Wedding of</span>
                </p>
                
                <!-- Names Wrapper (Vivid High-Contrast Sage-Gold Gradient) -->
                <div class="names-wrapper my-1"
                     style="animation: fadeInUpScale 1.4s 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;">
                    <h1 class="name font-script text-6xl sm:text-7xl md:text-8xl font-bold leading-[1.15] text-gold-gradient py-1">
                        {{ $settings['couple']['groom_nickname'] ?? 'Ramazan' }}
                    </h1>
                    <span class="ampersand font-display text-2xl sm:text-3xl text-[#F4F7F4] my-[-4px] block font-light italic text-sage-shadow">
                        &
                    </span>
                    <h1 class="name font-script text-6xl sm:text-7xl md:text-8xl font-bold leading-[1.15] text-gold-gradient py-1">
                        {{ $settings['couple']['bride_nickname'] ?? 'Dede' }}
                    </h1>
                </div>
            </div>

            <!-- BAGIAN BAWAH: Tanggal Acara, Kartu Tamu & Tombol Buka Undangan -->
            <div class="bottom-section pb-6 sm:pb-8 w-full flex flex-col items-center gap-2">
                <!-- Date Badge (High Contrast Pill) -->
                <div class="date-badge font-display text-xs sm:text-[0.85rem] tracking-[3px] py-1.5 px-5 rounded-full bg-[#162119]/75 backdrop-blur-md border border-[#6F9575]/80 text-[#F4F7F4] font-bold uppercase shadow-lg text-sage-shadow"
                     style="animation: fadeIn 1.2s 1.2s forwards;">
                    <span x-text="t('event_date_badge')">{{ $settings['event']['event_day'] ?? 'AHAD' }}, {{ strtoupper($settings['event']['event_date_formatted'] ?? '20 SEPTEMBER 2026') }}</span>
                </div>

                <!-- Guest Card -->
                <div class="w-[90%] max-w-xs bg-[#162119]/75 backdrop-blur-md border border-[#6F9575]/70 rounded-2xl p-3 my-0.5 shadow-2xl transition-all duration-700"
                     :class="isCurtainOpening ? 'opacity-0 translate-y-6 pointer-events-none' : 'opacity-100'"
                     style="animation: fadeInUp 1.2s 1.3s forwards;">
                    <p class="text-[10px] text-[#B6CDB9] uppercase tracking-wider font-sans font-semibold mb-0.5">
                        <span x-text="t('dear')">Kepada Yth. Bapak/Ibu/Saudara/i:</span>
                    </p>
                    <h3 class="text-base sm:text-lg font-serif font-bold text-[#F4F7F4] text-sage-shadow"
                        x-text="guestName && guestName !== 'Tamu Undangan & Kerabat' ? guestName : t('dear_fallback')">
                        {{ $guest->name ?? 'Tamu Undangan & Kerabat' }}
                    </h3>
                </div>

                <!-- Interactive Open Button -->
                <button 
                    @click="openInvitation()"
                    type="button"
                    :disabled="isCurtainOpening"
                    class="btn-open font-display tracking-[2px] text-xs font-bold uppercase py-3 px-8 bg-gradient-to-r from-[#6F9575] via-[#85AB8B] to-[#57795C] text-white border-none rounded-full cursor-pointer shadow-[0_0_30px_rgba(111,149,117,0.7)] hover:shadow-[0_0_40px_rgba(182,205,185,0.9)] hover:scale-105 active:scale-95 transition-all duration-300 flex items-center gap-2 mt-1 disabled:opacity-50"
                    :class="isCurtainOpening ? 'opacity-0 translate-y-8 pointer-events-none' : 'opacity-100'"
                    style="animation: fadeInUp 1.2s 1.5s forwards;">
                    <span>✉️</span> <span x-text="t('open_invitation')">Buka Undangan</span>
                </button>
            </div>
        </div>

    </div>
</section>
