<div class="fixed top-3 right-3 sm:top-4 sm:right-4 z-[75] flex items-center bg-[#162119]/85 backdrop-blur-md border border-[#6F9575]/60 rounded-full p-1 shadow-[0_4px_20px_rgba(0,0,0,0.35)] select-none">
    <button 
        type="button"
        @click="setLanguage('id')"
        :class="lang === 'id' ? 'bg-gradient-to-r from-[#6F9575] to-[#57795C] text-white font-bold shadow-xs scale-105' : 'text-[#D5E2D7] hover:text-white opacity-70 hover:opacity-100'"
        class="px-2 sm:px-2.5 py-1 rounded-full text-xs font-sans transition-all duration-200 flex items-center gap-1 cursor-pointer">
        <span class="text-xs">🇮🇩</span>
        <span class="text-[10px] sm:text-[11px] uppercase tracking-wider font-semibold">ID</span>
    </button>
    
    <button 
        type="button"
        @click="setLanguage('tr')"
        :class="lang === 'tr' ? 'bg-gradient-to-r from-[#6F9575] to-[#57795C] text-white font-bold shadow-xs scale-105' : 'text-[#D5E2D7] hover:text-white opacity-70 hover:opacity-100'"
        class="px-2 sm:px-2.5 py-1 rounded-full text-xs font-sans transition-all duration-200 flex items-center gap-1 cursor-pointer">
        <span class="text-xs">🇹🇷</span>
        <span class="text-[10px] sm:text-[11px] uppercase tracking-wider font-semibold">TR</span>
    </button>
    
    <button 
        type="button"
        @click="setLanguage('en')"
        :class="lang === 'en' ? 'bg-gradient-to-r from-[#6F9575] to-[#57795C] text-white font-bold shadow-xs scale-105' : 'text-[#D5E2D7] hover:text-white opacity-70 hover:opacity-100'"
        class="px-2 sm:px-2.5 py-1 rounded-full text-xs font-sans transition-all duration-200 flex items-center gap-1 cursor-pointer">
        <span class="text-xs">🇬🇧</span>
        <span class="text-[10px] sm:text-[11px] uppercase tracking-wider font-semibold">EN</span>
    </button>
</div>
