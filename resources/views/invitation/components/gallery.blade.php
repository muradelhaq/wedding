@props(['galleries'])

@if($galleries->isNotEmpty())
<section class="py-16 px-6 max-w-5xl mx-auto">
    <div class="text-center mb-12" data-reveal="fade-down">
        <h2 class="font-serif text-3xl sm:text-4xl font-bold text-[#233327] mb-3">Galeri Momen</h2>
        <p class="text-xs uppercase tracking-widest text-[#57795c] font-semibold">Prewedding Moments</p>
        <div class="w-16 h-1 bg-[#6F9575] mx-auto rounded-full mt-3"></div>
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 sm:gap-6">
        @foreach($galleries as $i => $gallery)
            <div 
                @click="openLightbox('{{ $gallery->file_path }}', '{{ $gallery->title ?? '' }}')"
                data-reveal="zoom-in"
                data-reveal-delay="{{ ($i % 3 + 1) * 150 }}"
                class="relative group aspect-square rounded-2xl overflow-hidden shadow-md cursor-pointer border-2 border-[#D5E2D7] hover:border-[#6F9575] bg-gray-100 transition duration-300">
                
                <img 
                    src="{{ $gallery->file_path }}" 
                    alt="{{ $gallery->title ?? 'Gallery Photo' }}" 
                    class="w-full h-full object-cover transition duration-500 group-hover:scale-110"
                    loading="lazy">

                <!-- Hover Overlay -->
                <div class="absolute inset-0 bg-[#162119]/45 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                    <div class="w-10 h-10 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center text-[#233327] shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif
