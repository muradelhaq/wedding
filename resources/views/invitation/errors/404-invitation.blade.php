@props(['invalidSlug' => '', 'settings' => []])

<x-invitation.layouts.guest-layout :settings="$settings">
    <div class="min-h-screen flex flex-col items-center justify-center p-6 text-center bg-gradient-to-b from-[#192e26] to-[#0f1c17] text-[#fdfbf7]">
        <div class="max-w-md w-full bg-white/10 backdrop-blur-md border border-[#d4ab59]/30 rounded-3xl p-8 shadow-2xl">
            <span class="font-serif text-6xl font-bold text-[#d4ab59] block mb-4">404</span>
            
            <h1 class="font-serif text-2xl font-bold text-[#fdfbf7] mb-2">Undangan Tidak Ditemukan</h1>
            
            <p class="text-xs sm:text-sm text-[#eedebd]/80 leading-relaxed font-sans mb-8">
                Mohon maaf, tautan undangan personal yang Anda tuju <span class="font-mono text-[#d4ab59]">({{ $invalidSlug }})</span> tidak terdaftar atau telah dipindahkan.
            </p>

            <a href="{{ route('invitation.home') }}" 
               class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-gradient-to-r from-[#c19036] via-[#d4ab59] to-[#c19036] text-[#192e26] font-bold text-xs sm:text-sm shadow-lg hover:shadow-[#c19036]/50 transition duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span>Buka Undangan Umum</span>
            </a>
        </div>
    </div>
</x-invitation.layouts.guest-layout>
