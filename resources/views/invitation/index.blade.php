<x-invitation.layouts.guest-layout :settings="$settings">
    <div x-data="{
            isOpened: false,
            isCurtainOpening: false,
            isPlaying: false,
            lang: window.detectWeddingLanguage ? window.detectWeddingLanguage() : 'id',
            guestName: '{{ addslashes($guest->name ?? '') }}',
            setLanguage(newLang) {
                this.lang = newLang;
                try {
                    localStorage.setItem('wedding_lang', newLang);
                } catch(e) {}
            },
            t(key) {
                if (window.weddingTranslations && window.weddingTranslations[this.lang] && window.weddingTranslations[this.lang][key]) {
                    return window.weddingTranslations[this.lang][key];
                }
                if (window.weddingTranslations && window.weddingTranslations['id'] && window.weddingTranslations['id'][key]) {
                    return window.weddingTranslations['id'][key];
                }
                return key;
            },
            init() {
                const params = new URLSearchParams(window.location.search);
                const toParam = params.get('to');
                if (toParam && (!this.guestName || this.guestName === 'Tamu Undangan & Kerabat')) {
                    this.guestName = toParam;
                }

                const audio = document.getElementById('wedding-audio') || document.querySelector('audio');
                if (audio) {
                    audio.addEventListener('play', () => { this.isPlaying = true; });
                    audio.addEventListener('pause', () => { this.isPlaying = false; });
                    audio.addEventListener('ended', () => { this.isPlaying = false; });
                }
            },
            openInvitation() {
                if (this.isCurtainOpening) return;
                this.isCurtainOpening = true;

                // 1. Play Background Music immediately upon user gesture click
                const audio = document.getElementById('wedding-audio') || document.querySelector('audio');
                if (audio) {
                    audio.muted = false;
                    const playPromise = audio.play();
                    if (playPromise !== undefined) {
                        playPromise.then(() => {
                            this.isPlaying = true;
                        }).catch(e => {
                            console.warn('Playback error or waiting interaction:', e);
                            const resumeOnInteraction = () => {
                                audio.play().then(() => {
                                    this.isPlaying = true;
                                }).catch(() => {});
                                document.removeEventListener('click', resumeOnInteraction);
                                document.removeEventListener('touchstart', resumeOnInteraction);
                            };
                            document.addEventListener('click', resumeOnInteraction, { once: true });
                            document.addEventListener('touchstart', resumeOnInteraction, { once: true });
                        });
                    }
                }

                // 2. Theatrical Curtain Opening duration (1.2s), then reveal main content
                setTimeout(() => {
                    this.isOpened = true;
                    // Initialize scroll reveal observer for freshly revealed content
                    this.$nextTick(() => {
                        if (window.initScrollReveal) {
                            window.initScrollReveal();
                        }
                    });
                    // Ensure starts at top of hero
                    window.scrollTo({ top: 0, behavior: 'instant' });
                }, 1200);
            },
            toggleAudio() {
                const audio = document.getElementById('wedding-audio') || document.querySelector('audio');
                if (!audio) return;
                if (this.isPlaying) {
                    audio.pause();
                    this.isPlaying = false;
                } else {
                    audio.play().then(() => {
                        this.isPlaying = true;
                    }).catch(e => {
                        console.warn('Audio play error:', e);
                    });
                }
            }
         }"
          class="relative min-h-screen bg-[#F4F7F4]">

        <!-- Floating Language Switcher (Always available on Cover and Main page) -->
        <x-invitation.language-switcher />

        <!-- 1. Cover Overlay Section (Curtain Opening Animation on Click) -->
        <x-invitation.cover :guest="$guest" :settings="$settings" />

        <!-- 2. Main Invitation Content Flow (Revealed after curtains open) -->
        <main x-show="isOpened" 
              x-transition:enter="transition ease-out duration-700"
              x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100"
              class="relative z-10">

            <!-- Hero Section: Identik Sama Persis dengan Cover Undangan (Membedakan hanya Scroll Indicator di Bawah) -->
            <section class="relative w-full max-w-[430px] h-[100dvh] min-h-[100dvh] max-h-[932px] mx-auto flex flex-col justify-between items-center text-center p-4 sm:p-6 overflow-hidden bg-cover bg-center shadow-2xl rounded-none sm:rounded-2xl bg-[#162119]">
                
                <!-- 1. Background Cartoon Couple Cover Layer -->
                <div class="bg-palace absolute inset-0 z-1 bg-cover bg-center pointer-events-none"
                     style="background-image: url('{{ asset('images/cartoon_couple_cover.webp') }}');">
                    <!-- Dark Vignette for High Text Readability -->
                    <div class="absolute inset-0 bg-gradient-to-b from-[#162119]/60 via-[#162119]/25 to-[#162119]/80"></div>
                    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(22,33,25,0.45)_0%,rgba(22,33,25,0.1)_55%,rgba(22,33,25,0.65)_100%)]"></div>
                </div>

                <!-- 2. Sunlight Glow Overlay -->
                <div class="sunlight-overlay absolute inset-0 z-2 pointer-events-none"
                     style="background: radial-gradient(circle at 50% 25%, rgba(244, 247, 244, 0.25) 0%, rgba(111, 149, 117, 0.15) 60%, rgba(22,33,25,0.3) 100%);">
                </div>

                <!-- 3. Lengkungan Bunga & Pilar (Floral Arch Frame) Identik dengan Cover -->
                <div class="arch-frame absolute inset-x-[5%] top-[5%] bottom-0 border-2 border-[#6F9575]/50 border-b-0 rounded-t-[180px] z-4 pointer-events-none shadow-[inset_0_0_20px_rgba(255,255,255,0.3)]"></div>

                <!-- 4. Merpati Terbang (Doves) -->
                <div class="dove-container absolute top-[6%] left-1/2 -translate-x-1/2 z-6 flex gap-8 pointer-events-none"
                     style="animation: doveFly 5s ease-in-out infinite alternate;">
                    <span class="dove text-2xl filter drop-shadow-[0_4px_8px_rgba(0,0,0,0.8)]">🕊️</span>
                    <span class="dove text-2xl filter drop-shadow-[0_4px_8px_rgba(0,0,0,0.8)] transform scale-x-[-1]">🕊️</span>
                </div>

                <!-- 5. Lampu / Lantern di Kiri & Kanan Bawah -->
                <div class="lantern lantern-left absolute bottom-[55px] left-4 w-11 h-20 z-7 flex flex-col items-center pointer-events-none"
                     style="animation: floatLantern 4s ease-in-out infinite alternate;">
                    <div class="lantern-bulb w-6 h-9 bg-[#f4f7f4] rounded-t-xl rounded-b-md shadow-[0_0_25px_12px_rgba(182,205,185,0.8),0_0_50px_20px_rgba(111,149,117,0.4)]"
                         style="animation: pulseGlow 2.5s infinite alternate;"></div>
                    <div class="lantern-stand w-[3px] h-11 bg-gradient-to-b from-[#6F9575] to-[#233327]"></div>
                </div>

                <div class="lantern lantern-right absolute bottom-[55px] right-4 w-11 h-20 z-7 flex flex-col items-center pointer-events-none"
                     style="animation: floatLantern 4s ease-in-out infinite alternate; animation-delay: -2s;">
                    <div class="lantern-bulb w-6 h-9 bg-[#f4f7f4] rounded-t-xl rounded-b-md shadow-[0_0_25px_12px_rgba(182,205,185,0.8),0_0_50px_20px_rgba(111,149,117,0.4)]"
                         style="animation: pulseGlow 2.5s infinite alternate;"></div>
                    <div class="lantern-stand w-[3px] h-11 bg-gradient-to-b from-[#6F9575] to-[#233327]"></div>
                </div>

                <!-- 6. KONTEN UTAMA: Nama di Tengah (Center), Tanggal & Scroll di Bawah (Bottom) -->
                <div class="content relative inset-0 z-10 flex flex-col justify-between items-center text-center w-full h-full text-[#F4F7F4] pointer-events-auto">
                    
                    <!-- BAGIAN TENGAH: Sub-Title & Nama Mempelai di Tengah Layar (Identik Persis dengan Cover) -->
                    <div class="middle-section my-auto flex flex-col items-center justify-center pt-20 sm:pt-24 translate-y-8 sm:translate-y-12">
                        <!-- Sub-Title -->
                        <p class="sub-title font-display text-[0.85rem] sm:text-[0.95rem] tracking-[6px] uppercase text-[#F4F7F4] font-bold mb-1 text-sage-shadow">
                            <span x-text="t('cover_sub')">The Wedding of</span>
                        </p>
                        
                        <!-- Names Wrapper (Vivid High-Contrast Sage-Gold Gradient) -->
                        <div class="names-wrapper my-1">
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

                    <!-- BAGIAN BAWAH: Tanggal Acara & Indikator Scroll ke Bawah -->
                    <div class="bottom-section pb-6 sm:pb-8 w-full flex flex-col items-center gap-3">
                        <!-- Date Badge (Identik dengan Cover) -->
                        <div class="date-badge font-display text-xs sm:text-[0.85rem] tracking-[3px] py-1.5 px-5 rounded-full bg-[#162119]/75 backdrop-blur-md border border-[#6F9575]/80 text-[#F4F7F4] font-bold uppercase shadow-lg text-sage-shadow">
                            <span x-text="t('event_date_badge')">{{ $settings['event']['event_day'] ?? 'AHAD' }}, {{ strtoupper($settings['event']['event_date_formatted'] ?? '20 SEPTEMBER 2026') }}</span>
                        </div>

                        <!-- Bottom Floating Dainty Scroll Indicator Capsule -->
                        <div class="relative z-10 animate-bounce opacity-90 pointer-events-none mt-1">
                            <div class="px-3.5 py-1 rounded-full bg-[#162119]/60 backdrop-blur-sm border border-[#6F9575]/60 text-[#F4F7F4] text-[10px] font-sans font-medium uppercase tracking-[0.15em] shadow-md flex items-center gap-1.5 text-sage-shadow">
                                <span x-text="t('scroll_down')">Scroll ke bawah</span>
                                <svg class="w-3 h-3 text-[#B6CDB9]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Remaining Invitation Sections (Enhanced with Paper Texture, Botanical Watermark & Ambient Glow Orbs) -->
            <div class="bg-wedding-paper bg-botanical-pattern relative overflow-hidden py-8">
                <!-- Ambient Glow Orbs for Soft 3D Lighting & Dimension -->
                <div class="absolute -top-16 -left-16 w-80 h-80 rounded-full bg-[#B6CDB9]/35 blur-3xl pointer-events-none"></div>
                <div class="absolute top-[18%] -right-20 w-96 h-96 rounded-full bg-[#6F9575]/15 blur-3xl pointer-events-none"></div>
                <div class="absolute top-[38%] -left-20 w-96 h-96 rounded-full bg-[#D5E2D7]/40 blur-3xl pointer-events-none"></div>
                <div class="absolute top-[58%] -right-20 w-96 h-96 rounded-full bg-[#B6CDB9]/25 blur-3xl pointer-events-none"></div>
                <div class="absolute top-[78%] -left-20 w-96 h-96 rounded-full bg-[#6F9575]/15 blur-3xl pointer-events-none"></div>

                <div class="relative z-10 space-y-4">
                    <!-- Bismillah & Ayat -->
                    <x-invitation.bismillah :settings="$settings" />

                    <!-- Section Divider -->
                    <x-invitation.section-divider />

                    <!-- Profile Pasangan (Kartun) -->
                    <x-invitation.couple-profile :settings="$settings" />

                    <!-- Section Divider -->
                    <x-invitation.section-divider />

                    <!-- Rangkaian Acara & Countdown -->
                    <x-invitation.event-detail :settings="$settings" />

                    <!-- Section Divider -->
                    <x-invitation.section-divider />

                    <!-- Peta Lokasi Google Maps -->
                    <x-invitation.maps :settings="$settings" />

                    <!-- Section Divider -->
                    <x-invitation.section-divider />

                    <!-- Form RSVP -->
                    <x-invitation.rsvp-form :guest="$guest" />

                    <!-- Section Divider -->
                    <x-invitation.section-divider />

                    <!-- Buku Tamu / Ucapan -->
                    <x-invitation.guestbook :guest="$guest" :guestbooks="$guestbooks" />

                    <!-- Footer -->
                    <x-invitation.footer :settings="$settings" />
                </div>
            </div>
        </main>

        <!-- Floating Music Player Button -->
        <x-invitation.music-player :musicUrl="$settings['general']['music_url'] ?? asset('audio/wedding-nasheed.mp3')" />
    </div>
</x-invitation.layouts.guest-layout>
