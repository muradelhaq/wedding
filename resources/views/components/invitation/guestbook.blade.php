@props(['guest', 'guestbooks'])

<section class="py-16 px-6 max-w-2xl mx-auto">
    <div class="text-center mb-10" data-reveal="fade-down">
        <h2 class="font-serif text-3xl sm:text-4xl font-bold text-[#233327] mb-3" x-text="t('gb_title')">Buku Tamu & Ucapan</h2>
        <p class="text-xs uppercase tracking-widest text-[#57795c] font-semibold" x-text="t('gb_subtitle')">Wishes & Prayers</p>
        <div class="w-16 h-1 bg-[#6F9575] mx-auto rounded-full mt-3"></div>
        <p class="text-xs sm:text-sm text-[#526356] mt-4 font-sans" data-reveal="fade-up" data-reveal-delay="150" x-text="t('gb_desc')">
            Tinggalkan do'a dan ucapan selamat bagi kedua mempelai.
        </p>
    </div>

    <div x-data="{
            guestId: {{ $guest->id ? $guest->id : 'null' }},
            name: '{{ addslashes($guest->name ?? '') }}',
            message: '',
            loading: false,
            loadingPage: false,
            currentPage: {{ $guestbooks->currentPage() }},
            lastPage: {{ $guestbooks->lastPage() }},
            total: {{ $guestbooks->total() }},
            items: [
                @foreach($guestbooks as $item)
                {
                    id: {{ $item->id }},
                    name: '{{ addslashes(e($item->name)) }}',
                    message: '{{ addslashes(e($item->message)) }}',
                    time_ago: '{{ $item->created_at->diffForHumans() }}'
                },
                @endforeach
            ],
            init() {
                if (!this.name && this.guestName && this.guestName !== 'Tamu Undangan & Kerabat') {
                    this.name = this.guestName;
                }
            },
            get visiblePages() {
                const pages = [];
                const total = this.lastPage;
                const current = this.currentPage;
                if (total <= 5) {
                    for (let i = 1; i <= total; i++) pages.push(i);
                } else {
                    if (current <= 3) {
                        pages.push(1, 2, 3, 4, '...', total);
                    } else if (current >= total - 2) {
                        pages.push(1, '...', total - 3, total - 2, total - 1, total);
                    } else {
                        pages.push(1, '...', current - 1, current, current + 1, '...', total);
                    }
                }
                return pages;
            },
            async goToPage(page, force = false) {
                if ((page < 1 || page > this.lastPage || page === this.currentPage) && !force) return;
                if (this.loadingPage) return;
                this.loadingPage = true;
                try {
                    const res = await fetch(`{{ route('guestbook.index') }}?page=${page}`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    const json = await res.json();
                    this.items = json.data;
                    this.currentPage = json.current_page;
                    this.lastPage = json.last_page;
                    this.total = json.total;
                } catch (e) {
                    window.showToast('Gagal memuat halaman ucapan.', 'error');
                } finally {
                    this.loadingPage = false;
                }
            },
            async submitMessage() {
                if (!this.name.trim() || !this.message.trim()) {
                    window.showToast(this.t('gb_name_label') + ' & ' + this.t('gb_msg_label') + ' wajib diisi.', 'error');
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
                        this.message = '';
                        window.showToast(data.message, 'success');
                        await this.goToPage(1, true);
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
                <label class="block text-xs uppercase tracking-wider font-semibold text-[#526356] mb-1" x-text="t('gb_name_label')">Nama Anda</label>
                <input 
                    type="text" 
                    x-model="name" 
                    :placeholder="t('gb_name_placeholder')"
                    required
                    class="w-full px-4 py-2.5 rounded-xl border border-[#D5E2D7] bg-[#F4F7F4] text-[#233327] text-sm focus:outline-none focus:border-[#6F9575]">
            </div>

            <div data-reveal="fade-up" data-reveal-delay="300">
                <label class="block text-xs uppercase tracking-wider font-semibold text-[#526356] mb-1" x-text="t('gb_msg_label')">Pesan & Do'a Restu</label>
                <textarea 
                    x-model="message" 
                    rows="3" 
                    :placeholder="t('gb_msg_placeholder')"
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
                <span x-text="t('gb_submit')">Kirim Do'a & Ucapan</span>
            </button>
        </form>

        <!-- Messages Feed Header -->
        <div class="flex items-center justify-between mb-4 pb-2 border-b border-[#D5E2D7]/60">
            <div class="flex items-center gap-2">
                <span class="text-xs font-semibold uppercase tracking-wider text-[#3B5A40]" x-text="t('gb_feed_title')">Daftar Do'a & Ucapan</span>
                <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-[#E5EFE7] text-[#3B5A40]" x-text="total + ' ' + t('gb_wishes_count')"></span>
            </div>
            <div x-show="lastPage > 1" class="text-[11px] text-[#57795C] font-medium">
                <span x-text="t('gb_page')">Halaman</span> <span class="font-bold" x-text="currentPage"></span> <span x-text="t('gb_of')">dari</span> <span class="font-bold" x-text="lastPage"></span>
            </div>
        </div>

        <!-- Messages Feed List Container -->
        <div class="relative min-h-[120px]">
            <!-- Loading overlay when changing page -->
            <div x-show="loadingPage" 
                 x-transition
                 class="absolute inset-0 bg-white/75 backdrop-blur-[2px] z-10 flex items-center justify-center rounded-2xl">
                <div class="flex items-center gap-2 text-xs font-medium text-[#3B5A40]">
                    <svg class="animate-spin h-5 w-5 text-[#6F9575]" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span x-text="t('gb_loading')">Memuat ucapan...</span>
                </div>
            </div>

            <!-- Messages List (5 items per page) -->
            <div class="space-y-3.5" :class="loadingPage ? 'opacity-30' : 'opacity-100 transition-opacity duration-200'">
                <template x-for="item in items" :key="item.id">
                    <div class="bg-[#F4F7F4] border border-[#D5E2D7] rounded-2xl p-4 transition duration-200 hover:border-[#6F9575] hover:shadow-xs">
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-7 h-7 rounded-full bg-gradient-to-br from-[#6F9575] to-[#425E47] text-white flex items-center justify-center font-bold text-xs shrink-0 shadow-xs"
                                     x-text="item.name ? item.name.charAt(0).toUpperCase() : '?'"></div>
                                <h4 class="font-bold text-sm text-[#233327] truncate" x-text="item.name"></h4>
                            </div>
                            <span class="text-[10px] text-[#57795c] whitespace-nowrap shrink-0 font-medium" x-text="item.time_ago"></span>
                        </div>
                        <p class="text-xs sm:text-sm text-[#526356] leading-relaxed font-sans pl-9" x-text="item.message"></p>
                    </div>
                </template>

                <template x-if="items.length === 0 && !loadingPage">
                    <div class="text-center py-8 text-xs text-[#526356] bg-[#F4F7F4] rounded-2xl border border-dashed border-[#D5E2D7]"
                         x-text="t('gb_empty')">
                        Belum ada ucapan. Jadilah yang pertama memberikan ucapan dan do'a restu!
                    </div>
                </template>
            </div>
        </div>

        <!-- Pagination Controls -->
        <div x-show="lastPage > 1" class="mt-6 pt-5 border-t border-[#D5E2D7] flex flex-wrap items-center justify-between gap-3">
            <!-- Tombol Halaman Sebelumnya -->
            <button 
                type="button"
                @click="goToPage(currentPage - 1)"
                :disabled="currentPage <= 1 || loadingPage"
                class="px-3.5 py-1.5 rounded-full border border-[#D5E2D7] bg-white hover:bg-[#F4F7F4] text-[#233327] text-xs font-semibold transition disabled:opacity-35 disabled:cursor-not-allowed disabled:hover:bg-white flex items-center gap-1.5 shadow-xs cursor-pointer">
                <svg class="w-3.5 h-3.5 text-[#57795C]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                <span x-text="t('gb_prev')">Sebelumnya</span>
            </button>

            <!-- Quick Jump Page Number Buttons -->
            <div class="flex items-center gap-1">
                <template x-for="(p, idx) in visiblePages" :key="idx">
                    <div class="inline-flex">
                        <template x-if="p === '...'">
                            <span class="w-7 h-7 flex items-center justify-center text-xs text-[#526356]">...</span>
                        </template>
                        <template x-if="p !== '...'">
                            <button 
                                type="button"
                                @click="goToPage(p)"
                                :disabled="loadingPage"
                                :class="p === currentPage 
                                    ? 'bg-gradient-to-r from-[#6F9575] to-[#57795C] text-white font-bold shadow-xs' 
                                    : 'bg-white border border-[#D5E2D7] text-[#526356] hover:bg-[#F4F7F4] font-medium'"
                                class="w-7 h-7 rounded-full text-xs transition flex items-center justify-center cursor-pointer"
                                x-text="p">
                            </button>
                        </template>
                    </div>
                </template>
            </div>

            <!-- Tombol Buka Paginasi Berikutnya -->
            <button 
                type="button"
                @click="goToPage(currentPage + 1)"
                :disabled="currentPage >= lastPage || loadingPage"
                class="px-4 py-1.5 rounded-full bg-gradient-to-r from-[#6F9575] to-[#57795C] hover:from-[#57795C] hover:to-[#425E47] text-white text-xs font-semibold transition disabled:opacity-35 disabled:cursor-not-allowed shadow-xs flex items-center gap-1.5 cursor-pointer">
                <span x-text="t('gb_next')">Berikutnya</span>
                <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>
</section>

