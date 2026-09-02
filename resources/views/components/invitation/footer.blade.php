@props(['settings'])

<footer class="py-20 px-6 bg-gradient-to-t from-[#162119] via-[#233327] to-[#F4F7F4] text-[#F4F7F4] text-center mt-20 relative overflow-hidden">
    <div class="max-w-xl mx-auto relative z-10 pt-10">
        <p class="font-arabic text-2xl sm:text-3xl text-gold-gradient mb-4" data-reveal="zoom-in" data-reveal-delay="100">
            جَزَاكُمُ اللَّهُ خَيْرًا كَثِيرًا
        </p>

        <p class="font-serif text-base sm:text-lg italic text-[#D5E2D7] mb-8 leading-relaxed" 
           data-reveal="fade-up" data-reveal-delay="200"
           x-text="'“' + t('closing_prayer') + '”'">
            "{{ $settings['quotes']['closing_prayer'] ?? 'Jazakumullahu khairan Katsiran' }}"
        </p>

        <p class="text-xs uppercase tracking-[0.25em] text-[#B6CDB9] font-serif font-semibold mb-3" 
           data-reveal="fade-up" data-reveal-delay="250"
           x-text="t('happy_family')">
            Kami yang berbahagia,
        </p>

        <div class="space-y-1 text-xs sm:text-sm text-[#D5E2D7] mb-8 font-serif" data-reveal="fade-up" data-reveal-delay="300">
            <p class="font-bold text-[#F4F7F4]" x-text="t('groom_family')">Keluarga Bpk. Ismail Akcaalan & Ibu Aysel Akcaalan</p>
            <p class="text-xs text-[#B6CDB9] italic">&</p>
            <p class="font-bold text-[#F4F7F4]" x-text="t('bride_family')">Keluarga Bpk. Endeng Zenal Arifin & Ibu Ipah Saripah</p>
        </div>

        <h3 class="font-script text-6xl sm:text-7xl text-gold-gradient mb-8 drop-shadow-md" data-reveal="zoom-in" data-reveal-delay="350">
            {{ $settings['couple']['groom_nickname'] ?? 'Ramazan' }} & {{ $settings['couple']['bride_nickname'] ?? 'Dede' }}
        </h3>

        <div class="border-t border-[#f4f7f4]/15 pt-6 text-[10px] sm:text-xs text-[#D5E2D7]/60 font-sans">
            &copy; {{ date('Y') }} The Wedding of Ramazan & Dede. All rights reserved.
        </div>
    </div>
</footer>
