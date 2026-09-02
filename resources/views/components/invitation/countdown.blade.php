@props(['targetDate' => '2026-09-20T11:00:00+07:00'])

<div x-data="{
        target: new Date('{{ $targetDate }}').getTime(),
        days: 0,
        hours: 0,
        minutes: 0,
        seconds: 0,
        isExpired: false,
        updateCountdown() {
            const now = new Date().getTime();
            const distance = this.target - now;

            if (distance < 0) {
                this.isExpired = true;
                this.days = 0;
                this.hours = 0;
                this.minutes = 0;
                this.seconds = 0;
                return;
            }

            this.days = Math.floor(distance / (1000 * 60 * 60 * 24));
            this.hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            this.minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            this.seconds = Math.floor((distance % (1000 * 60)) / 1000);
        },
        init() {
            this.updateCountdown();
            setInterval(() => this.updateCountdown(), 1000);
        }
    }"
    class="max-w-md mx-auto">
    
    <div class="grid grid-cols-4 gap-2 sm:gap-4 text-center">
        <!-- Days -->
        <div class="bg-gradient-to-b from-white to-[#F4F7F4] border-2 border-[#D5E2D7] rounded-2xl p-3 sm:p-4 shadow-[0_4px_15px_rgba(111,149,117,0.15)] transform transition duration-300 hover:scale-105"
             data-reveal="zoom-in" data-reveal-delay="100">
            <span class="block font-serif text-2xl sm:text-3xl font-bold text-[#233327]" x-text="days">0</span>
            <span class="text-[10px] sm:text-xs uppercase tracking-widest text-[#57795c] font-serif font-semibold" x-text="t('days')">Hari</span>
        </div>

        <!-- Hours -->
        <div class="bg-gradient-to-b from-white to-[#F4F7F4] border-2 border-[#D5E2D7] rounded-2xl p-3 sm:p-4 shadow-[0_4px_15px_rgba(111,149,117,0.15)] transform transition duration-300 hover:scale-105"
             data-reveal="zoom-in" data-reveal-delay="200">
            <span class="block font-serif text-2xl sm:text-3xl font-bold text-[#233327]" x-text="hours">0</span>
            <span class="text-[10px] sm:text-xs uppercase tracking-widest text-[#57795c] font-serif font-semibold" x-text="t('hours')">Jam</span>
        </div>

        <!-- Minutes -->
        <div class="bg-gradient-to-b from-white to-[#F4F7F4] border-2 border-[#D5E2D7] rounded-2xl p-3 sm:p-4 shadow-[0_4px_15px_rgba(111,149,117,0.15)] transform transition duration-300 hover:scale-105"
             data-reveal="zoom-in" data-reveal-delay="300">
            <span class="block font-serif text-2xl sm:text-3xl font-bold text-[#233327]" x-text="minutes">0</span>
            <span class="text-[10px] sm:text-xs uppercase tracking-widest text-[#57795c] font-serif font-semibold" x-text="t('minutes')">Menit</span>
        </div>

        <!-- Seconds -->
        <div class="bg-gradient-to-b from-white to-[#F4F7F4] border-2 border-[#D5E2D7] rounded-2xl p-3 sm:p-4 shadow-[0_4px_15px_rgba(111,149,117,0.15)] transform transition duration-300 hover:scale-105"
             data-reveal="zoom-in" data-reveal-delay="400">
            <span class="block font-serif text-2xl sm:text-3xl font-bold text-[#233327]" x-text="seconds">0</span>
            <span class="text-[10px] sm:text-xs uppercase tracking-widest text-[#57795c] font-serif font-semibold" x-text="t('seconds')">Detik</span>
        </div>
    </div>
</div>
