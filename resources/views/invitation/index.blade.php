<x-invitation.layouts.guest-layout :settings="$settings">
    <div x-data="{
            isOpened: false,
            isCurtainOpening: false,
            isPlaying: false,
            lightboxActive: false,
            lightboxImg: '',
            lightboxTitle: '',
            openInvitation() {
                if (this.isCurtainOpening) return;
                this.isCurtainOpening = true;

                // 1. Play Background Music
                const audio = this.$refs.musicPlayer?.$refs?.audioPlayer || document.querySelector('audio');
                if (audio) {
                    audio.play().then(() => {
                        this.isPlaying = true;
                    }).catch(e => {
                        console.log('Audio autoplay prevented:', e);
                    });
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
                const audio = document.querySelector('audio');
                if (!audio) return;
                if (this.isPlaying) {
                    audio.pause();
                    this.isPlaying = false;
                } else {
                    audio.play();
                    this.isPlaying = true;
                }
            },
            openLightbox(url, title = '') {
                this.lightboxImg = url;
                this.lightboxTitle = title;
                this.lightboxActive = true;
            },
            closeLightbox() {
                this.lightboxActive = false;
                this.lightboxImg = '';
            }
         }"
          class="relative min-h-screen bg-[#F4F7F4]">

        <!-- 1. Cover Overlay Section (Curtain Opening Animation on Click) -->
        <x-invitation.cover :guest="$guest" :settings="$settings" />

        <!-- 2. Main Invitation Content Flow (Revealed after curtains open) -->
        <main x-show="isOpened" 
              x-transition:enter="transition ease-out duration-700"
              x-transition:enter-start="opacity-0"
              x-transition:enter-end="opacity-100"
              class="relative z-10">

            <!-- Hero Section: Fullscreen 100vh Identical in Size, Perspective & High Contrast -->
            <section class="relative w-full h-[100dvh] min-h-[100dvh] max-w-[430px] mx-auto flex flex-col justify-between items-center text-center p-6 sm:p-8 overflow-hidden bg-cover bg-center shadow-2xl bg-[#162119]"
                     style="background-image: url('{{ asset('images/cartoon_couple_cover.jpg') }}');">
                
                <!-- Ambient Dark Vignette for High Text Contrast with Sage Tint -->
                <div class="absolute inset-0 bg-gradient-to-b from-[#162119]/60 via-[#162119]/25 to-[#162119]/80 pointer-events-none"></div>
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,rgba(22,33,25,0.45)_0%,rgba(22,33,25,0.1)_55%,rgba(22,33,25,0.65)_100%)] pointer-events-none"></div>
                <div class="sunlight-overlay absolute inset-0 pointer-events-none"
                     style="background: radial-gradient(circle at 50% 25%, rgba(244, 247, 244, 0.2) 0%, rgba(111, 149, 117, 0.15) 60%, rgba(22,33,25,0.3) 100%);"></div>

                <!-- Top Subtitle -->
                <div class="relative z-10 pt-6">
                    <p class="font-display text-[0.85rem] sm:text-[0.95rem] tracking-[6px] uppercase text-[#F4F7F4] font-bold text-sage-shadow">
                        The Wedding of
                    </p>
                </div>

                <!-- Center Couple Names & Date (Vivid High Contrast Gradient) -->
                <div class="relative z-10 my-auto text-center w-full px-2">
                    <h1 class="font-script text-6xl sm:text-7xl md:text-8xl font-bold leading-[1.15] text-gold-gradient py-1">
                        {{ $settings['couple']['groom_nickname'] ?? 'Ramazan' }}
                    </h1>
                    <span class="font-display text-2xl sm:text-3xl text-[#F4F7F4] my-[-4px] block font-light italic text-sage-shadow">
                        &
                    </span>
                    <h1 class="font-script text-6xl sm:text-7xl md:text-8xl font-bold leading-[1.15] text-gold-gradient py-1">
                        {{ $settings['couple']['bride_nickname'] ?? 'Dede' }}
                    </h1>

                    <div class="inline-block font-display text-xs sm:text-[0.85rem] tracking-[3px] py-1.5 px-5 rounded-full bg-[#162119]/70 backdrop-blur-md border border-[#6F9575]/80 text-[#F4F7F4] font-bold mt-4 uppercase shadow-lg text-sage-shadow">
                        {{ $settings['event']['event_day'] ?? 'AHAD' }}, {{ strtoupper($settings['event']['event_date_formatted'] ?? '20 SEPTEMBER 2026') }}
                    </div>
                </div>

                <!-- Bottom Floating High-Contrast Scroll Indicator Capsule -->
                <div class="relative z-10 pb-8 flex flex-col items-center gap-1.5 animate-bounce opacity-95 pointer-events-none">
                    <div class="px-5 py-2 rounded-full bg-[#162119]/75 backdrop-blur-md border border-[#6F9575]/80 text-[#F4F7F4] text-xs font-serif font-bold uppercase tracking-[0.25em] shadow-[0_4px_20px_rgba(0,0,0,0.6)] flex items-center gap-2 text-sage-shadow">
                        <span>Scroll ke bawah</span>
                        <svg class="w-4 h-4 text-[#B6CDB9]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                    </div>
                </div>
            </section>

            <!-- Remaining Invitation Sections (Visible upon scrolling down) -->
            <div class="space-y-6">
                <!-- Bismillah & Ayat -->
                <x-invitation.bismillah :settings="$settings" />

                <!-- Profile Pasangan (Kartun) -->
                <x-invitation.couple-profile :settings="$settings" />

                <!-- Rangkaian Acara & Countdown -->
                <x-invitation.event-detail :settings="$settings" />

                <!-- Peta Lokasi Google Maps -->
                <x-invitation.maps :settings="$settings" />

                <!-- Galeri Foto -->
                <x-invitation.gallery :galleries="$galleries" />

                <!-- Form RSVP -->
                <x-invitation.rsvp-form :guest="$guest" />

                <!-- Buku Tamu / Ucapan -->
                <x-invitation.guestbook :guest="$guest" :guestbooks="$guestbooks" />

                <!-- Footer -->
                <x-invitation.footer :settings="$settings" />
            </div>
        </main>

        <!-- Floating Music Player Button -->
        <x-invitation.music-player :musicUrl="$settings['general']['music_url'] ?? 'https://assets.mixkit.co/music/preview/mixkit-romantic-wedding-641.mp3'" />

        <!-- Image Lightbox Modal -->
        <div x-show="lightboxActive"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @keydown.escape.window="closeLightbox()"
             style="display: none;"
             class="fixed inset-0 z-50 bg-black/90 backdrop-blur-md flex flex-col items-center justify-center p-4">
            
            <button 
                @click="closeLightbox()"
                type="button"
                class="absolute top-6 right-6 text-white hover:text-[#d4ab59] transition p-2 cursor-pointer">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <img :src="lightboxImg" class="max-w-full max-h-[85vh] object-contain rounded-2xl shadow-2xl" alt="Preview">
            <p x-show="lightboxTitle" x-text="lightboxTitle" class="mt-4 text-xs text-white/80 font-sans"></p>
        </div>
    </div>
</x-invitation.layouts.guest-layout>
