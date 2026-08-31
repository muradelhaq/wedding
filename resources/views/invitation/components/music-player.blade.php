@props(['musicUrl' => 'https://assets.mixkit.co/music/preview/mixkit-romantic-wedding-641.mp3'])

<div 
    x-show="isOpened"
    x-transition:enter="transition ease-out duration-500 delay-300 transform"
    x-transition:enter-start="opacity-0 scale-50"
    x-transition:enter-end="opacity-100 scale-100"
    class="fixed bottom-6 right-6 z-40">

    <!-- Hidden Audio Element -->
    <audio 
        x-ref="audioPlayer" 
        src="{{ $musicUrl }}" 
        loop 
        preload="auto">
    </audio>

    <!-- Floating Audio Toggle Button -->
    <button 
        @click="toggleAudio()" 
        type="button"
        class="group relative w-12 h-12 rounded-full bg-[#233327] border-2 border-[#6F9575] text-[#B6CDB9] shadow-2xl flex items-center justify-center cursor-pointer transition transform hover:scale-110 active:scale-95">
        
        <!-- Spinning Vinyl Disk Animation -->
        <div class="absolute inset-0 rounded-full border border-[#6F9575]/40" :class="isPlaying ? 'animate-spin-slow' : ''"></div>

        <!-- Music Note / Playing Icon -->
        <svg x-show="isPlaying" class="w-5 h-5 text-[#B6CDB9]" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
        </svg>

        <!-- Muted Icon -->
        <svg x-show="!isPlaying" style="display: none;" class="w-5 h-5 text-[#D5E2D7]/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2" />
        </svg>
    </button>
</div>
