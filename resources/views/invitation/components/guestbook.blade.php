@props(['guest', 'guestbooks'])

<section class="py-16 px-6 max-w-2xl mx-auto">
    <div class="text-center mb-10" data-reveal="fade-down">
        <h2 class="font-serif text-3xl sm:text-4xl font-bold text-[#233327] mb-3">Buku Tamu & Ucapan</h2>
        <p class="text-xs uppercase tracking-widest text-[#57795c] font-semibold">Wishes & Prayers</p>
        <div class="w-16 h-1 bg-[#6F9575] mx-auto rounded-full mt-3"></div>
        <p class="text-xs sm:text-sm text-[#526356] mt-4 font-sans" data-reveal="fade-up" data-reveal-delay="150">
            Tinggalkan do'a dan ucapan selamat bagi kedua mempelai.
        </p>
    </div>

    <div x-data="{
            guestId: {{ $guest->id ? $guest->id : 'null' }},
            name: '{{ addslashes($guest->name ?? '') }}',
            message: '',
            loading: false,
            items: [
                @foreach($guestbooks as $item)
                {
                    id: {{ $item->id }},
                    name: '{{ addslashes($item->name) }}',
                    message: '{{ addslashes($item->message) }}',
                    time_ago: '{{ $item->created_at->diffForHumans() }}'
                },
                @endforeach
            ],
            async submitMessage() {
                if (!this.name.trim() || !this.message.trim()) {
                    window.showToast('Nama dan pesan tidak boleh kosong.', 'error');
                    return;
                }
                this.loading = true;
                try {
                    const res = await fetch('{{ route('guestbook.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            guest_id: this.guestId,
                            name: this.name,
                            message: this.message
                        })
                    });
                    const data = await res.json();
                    if (res.ok) {
                        this.items.unshift(data.data);
                        this.message = '';
                        window.showToast(data.message, 'success');
                    } else {
                        window.showToast('Gagal mengirim pesan: ' + (data.message || 'Error validasi'), 'error');
                    }
                } catch (e) {
                    window.showToast('Terjadi kesalahan jaringan.', 'error');
                } finally {
                    this.loading = false;
                }
            }
        }"
        data-reveal="zoom-in"
        data-reveal-delay="200"
        class="bg-white border-2 border-[#D5E2D7] rounded-3xl p-6 sm:p-8 shadow-[0_10px_30px_rgba(111,149,117,0.12)]">

        <!-- Form Submission -->
        <form @submit.prevent="submitMessage" class="space-y-4 mb-8 pb-8 border-b border-[#D5E2D7]">
            <div data-reveal="fade-up" data-reveal-delay="250">
                <label class="block text-xs uppercase tracking-wider font-semibold text-[#526356] mb-1">Nama Anda</label>
                <input 
                    type="text" 
                    x-model="name" 
                    placeholder="Nama Anda / Keluarga"
                    required
                    class="w-full px-4 py-2.5 rounded-xl border border-[#D5E2D7] bg-[#F4F7F4] text-[#233327] text-sm focus:outline-none focus:border-[#6F9575]">
            </div>

            <div data-reveal="fade-up" data-reveal-delay="300">
                <label class="block text-xs uppercase tracking-wider font-semibold text-[#526356] mb-1">Pesan & Do'a Restu</label>
                <textarea 
                    x-model="message" 
                    rows="3" 
                    placeholder="Tuliskan ucapan dan do'a Anda di sini..."
                    required
                    class="w-full px-4 py-2.5 rounded-xl border border-[#D5E2D7] bg-[#F4F7F4] text-[#233327] text-sm focus:outline-none focus:border-[#6F9575]"></textarea>
            </div>

            <button 
                type="submit" 
                :disabled="loading"
                data-reveal="zoom-in"
                data-reveal-delay="350"
                class="w-full py-3 rounded-full bg-gradient-to-r from-[#6F9575] via-[#85AB8B] to-[#57795C] hover:from-[#57795C] hover:to-[#425E47] text-white font-bold text-xs sm:text-sm shadow-md transition duration-200 flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50">
                <svg x-show="loading" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Kirim Do'a & Ucapan</span>
            </button>
        </form>

        <!-- Messages Feed List -->
        <div class="space-y-4 max-h-96 overflow-y-auto pr-2">
            <template x-for="item in items" :key="item.id">
                <div class="bg-[#F4F7F4] border border-[#D5E2D7] rounded-2xl p-4 transition hover:border-[#6F9575]"
                     data-reveal="fade-up">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <h4 class="font-bold text-sm text-[#233327]" x-text="item.name"></h4>
                        <span class="text-[10px] text-[#57795c]" x-text="item.time_ago"></span>
                    </div>
                    <p class="text-xs sm:text-sm text-[#526356] leading-relaxed font-sans" x-text="item.message"></p>
                </div>
            </template>

            <template x-if="items.length === 0">
                <div class="text-center py-6 text-xs text-[#526356]">
                    Belum ada ucapan. Jadilah yang pertama memberikan ucapan dan do'a restu!
                </div>
            </template>
        </div>
    </div>
</section>
