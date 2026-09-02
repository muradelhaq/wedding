@props(['settings'])

<section class="py-16 sm:py-20 px-6 max-w-3xl mx-auto text-center">
    <!-- Arabic Bismillah & Salam -->
    <div class="mb-8" data-reveal="fade-down">
        <h2 class="font-arabic text-3xl sm:text-4xl text-[#314736] leading-relaxed mb-3 drop-shadow-sm" data-reveal="zoom-in" data-reveal-delay="100">
            {{ $settings['quotes']['bismillah_text'] ?? 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ' }}
        </h2>
        <p class="font-arabic text-xl sm:text-2xl text-[#57795c] leading-relaxed" data-reveal="fade-up" data-reveal-delay="200">
            {{ $settings['quotes']['salam_text'] ?? 'السَّلاَمُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُهُ' }}
        </p>
    </div>

    <!-- Quranic Verse in Luxury Sage-White Card with Corner Botanical Accents -->
    <div class="relative bg-gradient-to-b from-white to-[#F4F7F4] border-2 border-[#D5E2D7] rounded-3xl p-6 sm:p-10 shadow-[0_10px_35px_rgba(111,149,117,0.12)] overflow-hidden" data-reveal="zoom-in" data-reveal-delay="300">
        <!-- Inner Subtle Contour -->
        <div class="absolute inset-2.5 rounded-2xl border border-[#6F9575]/15 pointer-events-none"></div>

        <!-- Corner Botanical Leaf Accents -->
        <svg class="absolute top-2 left-2 w-8 h-8 text-[#6F9575]/25 pointer-events-none" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17 8C8 10 5 16 5 21C10 21 16 18 18 9C18 8.6 17.5 8 17 8Z"/>
        </svg>
        <svg class="absolute bottom-2 right-2 w-8 h-8 text-[#6F9575]/25 pointer-events-none transform rotate-180" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17 8C8 10 5 16 5 21C10 21 16 18 18 9C18 8.6 17.5 8 17 8Z"/>
        </svg>

        <div class="w-16 h-1 bg-gradient-to-r from-transparent via-[#6F9575] to-transparent mx-auto mb-6 rounded-full"></div>

        <blockquote class="italic font-serif text-base sm:text-lg text-[#233327] leading-relaxed mb-4 relative z-10"
                    x-text="'“' + t('verse_quote') + '”'">
            "{{ $settings['quotes']['quote_text'] ?? 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan berpasang-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang...' }}"
        </blockquote>

        <p class="text-xs sm:text-sm font-semibold tracking-widest text-[#57795c] uppercase font-serif relative z-10"
           x-text="t('verse_surah')">
            {{ $settings['quotes']['quote_source'] ?? 'QS. Ar-Rum: 21' }}
        </p>
    </div>

    <!-- Invitation Message -->
    <p class="mt-8 text-sm sm:text-base text-[#425E47] leading-relaxed max-w-xl mx-auto font-sans" 
       data-reveal="fade-up" data-reveal-delay="400"
       x-text="t('invitation_intro')">
        Dengan memohon Rahmat & Ridho Allah Subhanahu Wata'ala, kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk menghadiri dan memberikan do'a restu pada acara Pernikahan kami:
    </p>
</section>
