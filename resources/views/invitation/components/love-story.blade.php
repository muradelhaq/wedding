@props(['stories'])

@if($stories->isNotEmpty())
<section class="py-16 px-6 max-w-3xl mx-auto">
    <div class="text-center mb-12" data-reveal="fade-down">
        <h2 class="font-serif text-3xl sm:text-4xl font-bold text-[#192e26] mb-3">Cerita Cinta</h2>
        <p class="text-xs uppercase tracking-widest text-[#a7742a] font-semibold">Our Love Story</p>
        <div class="w-16 h-1 bg-[#c19036] mx-auto rounded-full mt-3"></div>
    </div>

    <!-- Timeline Container -->
    <div class="relative border-l-2 border-[#eedebd] ml-4 sm:ml-32 space-y-10">
        @foreach($stories as $i => $story)
            <div class="relative pl-6 sm:pl-8 group" 
                 data-reveal="fade-up" 
                 data-reveal-delay="{{ ($i % 3 + 1) * 150 }}">
                <!-- Timeline Dot -->
                <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full bg-[#c19036] border-4 border-[#FDFBF7] shadow-sm transition group-hover:scale-125"></div>

                <!-- Date Badge for larger screens -->
                @if($story->date_label)
                    <div class="sm:absolute sm:-left-32 sm:top-1 text-xs sm:text-sm font-bold text-[#a7742a] mb-1 sm:mb-0 sm:text-right sm:w-24"
                         data-reveal="fade-right" data-reveal-delay="{{ ($i % 3 + 1) * 150 }}">
                        {{ $story->date_label }}
                    </div>
                @endif

                <div class="bg-white/90 backdrop-blur-sm border border-[#eedebd] rounded-2xl p-5 shadow-sm transition hover:shadow-md hover:border-[#c19036]"
                     data-reveal="zoom-in" data-reveal-delay="{{ ($i % 3 + 1) * 150 + 100 }}">
                    @if($story->image_path)
                        <img src="{{ $story->image_path }}" alt="{{ $story->title }}" class="w-full h-44 object-cover rounded-xl mb-4" loading="lazy">
                    @endif
                    <h3 class="font-serif text-lg font-bold text-[#192e26] mb-2">{{ $story->title }}</h3>
                    <p class="text-xs sm:text-sm text-[#6E675F] leading-relaxed font-sans">{{ $story->description }}</p>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif
