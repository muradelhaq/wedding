@props(['guest'])

<section id="rsvp-section" class="py-16 px-6 max-w-2xl mx-auto">
    <div class="text-center mb-10" data-reveal="fade-down">
        <h2 class="font-serif text-3xl sm:text-4xl font-bold text-[#233327] mb-3">Konfirmasi Kehadiran</h2>
        <p class="text-xs uppercase tracking-widest text-[#57795c] font-semibold">RSVP</p>
        <div class="w-16 h-1 bg-[#6F9575] mx-auto rounded-full mt-3"></div>
        <p class="text-xs sm:text-sm text-[#526356] mt-4 font-sans" data-reveal="fade-up" data-reveal-delay="150">
            Mohon konfirmasi kehadiran Bapak/Ibu/Saudara/i untuk membantu kelancaran persiapan acara.
        </p>
    </div>

    <div x-data="{
            guestId: {{ $guest->id ? $guest->id : 'null' }},
            guestName: '{{ addslashes($guest->name ?? '') }}',
            attendance: '{{ $guest->rsvp->attendance ?? 'hadir' }}',
            totalGuest: {{ $guest->rsvp->total_guest ?? 1 }},
            notes: '{{ addslashes($guest->rsvp->notes ?? '') }}',
            loading: false,
            submitted: {{ $guest->rsvp ? 'true' : 'false' }},
            statusMessage: '',
            async submitRsvp() {
                this.loading = true;
                try {
                    const res = await fetch('{{ route('rsvp.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            guest_id: this.guestId,
                            guest_name: this.guestName,
                            attendance: this.attendance,
                            total_guest: this.totalGuest,
                            notes: this.notes
                        })
                    });
                    const data = await res.json();
                    if (res.ok) {
                        this.submitted = true;
                        this.statusMessage = data.message;
                        window.showToast(data.message, 'success');
                    } else {
                        window.showToast('Gagal menyimpan konfirmasi: ' + (data.message || 'Error validasi'), 'error');
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
        class="bg-white border-2 border-[#D5E2D7] rounded-3xl p-6 sm:p-10 shadow-[0_10px_30px_rgba(111,149,117,0.12)]">

        <template x-if="submitted">
            <div class="text-center py-6" data-reveal="fade-up">
                <div class="w-16 h-16 bg-[#6F9575]/15 text-[#314736] rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-[#6F9575]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="font-serif text-2xl font-bold text-[#233327] mb-2">Konfirmasi Diterima</h3>
                <p class="text-sm text-[#526356] max-w-md mx-auto mb-6" x-text="statusMessage || 'Terima kasih atas konfirmasi kehadiran Anda.'"></p>
                <button 
                    @click="submitted = false"
                    type="button"
                    class="text-xs text-[#57795c] underline hover:text-[#314736] font-medium cursor-pointer">
                    Ubah Konfirmasi Kehadiran
                </button>
            </div>
        </template>

        <form x-show="!submitted" @submit.prevent="submitRsvp" class="space-y-6">
            <!-- Guest Name -->
            <div data-reveal="fade-up" data-reveal-delay="250">
                <label class="block text-xs uppercase tracking-wider font-semibold text-[#526356] mb-2">Nama Tamu</label>
                <input 
                    type="text" 
                    x-model="guestName" 
                    {{ $guest->id ? 'readonly' : 'required' }}
                    class="w-full px-4 py-3 rounded-xl border border-[#D5E2D7] bg-[#F4F7F4] text-[#233327] text-sm focus:outline-none focus:border-[#6F9575] focus:ring-1 focus:ring-[#6F9575] transition">
            </div>

            <!-- Attendance Radio -->
            <div data-reveal="fade-up" data-reveal-delay="300">
                <label class="block text-xs uppercase tracking-wider font-semibold text-[#526356] mb-2">Konfirmasi Kehadiran</label>
                <div class="grid grid-cols-3 gap-3">
                    <label class="flex flex-col items-center justify-center p-3 rounded-xl border cursor-pointer transition text-center"
                           :class="attendance === 'hadir' ? 'border-[#6F9575] bg-[#6F9575]/15 text-[#233327] font-bold shadow-sm' : 'border-[#D5E2D7] text-[#526356] bg-white'">
                        <input type="radio" value="hadir" x-model="attendance" class="sr-only">
                        <span class="text-sm">Hadir</span>
                    </label>

                    <label class="flex flex-col items-center justify-center p-3 rounded-xl border cursor-pointer transition text-center"
                           :class="attendance === 'tidak_hadir' ? 'border-[#6F9575] bg-[#6F9575]/15 text-[#233327] font-bold shadow-sm' : 'border-[#D5E2D7] text-[#526356] bg-white'">
                        <input type="radio" value="tidak_hadir" x-model="attendance" class="sr-only">
                        <span class="text-sm">Tidak Hadir</span>
                    </label>

                    <label class="flex flex-col items-center justify-center p-3 rounded-xl border cursor-pointer transition text-center"
                           :class="attendance === 'ragu' ? 'border-[#6F9575] bg-[#6F9575]/15 text-[#233327] font-bold shadow-sm' : 'border-[#D5E2D7] text-[#526356] bg-white'">
                        <input type="radio" value="ragu" x-model="attendance" class="sr-only">
                        <span class="text-sm">Masih Ragu</span>
                    </label>
                </div>
            </div>

            <!-- Total Guest (Pax) -->
            <div x-show="attendance === 'hadir'" data-reveal="fade-up" data-reveal-delay="350">
                <label class="block text-xs uppercase tracking-wider font-semibold text-[#526356] mb-2">Jumlah Tamu Hadir</label>
                <select x-model="totalGuest" class="w-full px-4 py-3 rounded-xl border border-[#D5E2D7] bg-[#F4F7F4] text-[#233327] text-sm focus:outline-none focus:border-[#6F9575]">
                    <option value="1">1 Orang</option>
                    <option value="2">2 Orang</option>
                    <option value="3">3 Orang</option>
                    <option value="4">4 Orang</option>
                    <option value="5">5 Orang</option>
                </select>
            </div>

            <!-- Notes -->
            <div data-reveal="fade-up" data-reveal-delay="400">
                <label class="block text-xs uppercase tracking-wider font-semibold text-[#526356] mb-2">Catatan Tambahan (Opsional)</label>
                <textarea 
                    x-model="notes" 
                    rows="3" 
                    placeholder="Contoh: Kami hadir sekeluarga pada pukul 12.00"
                    class="w-full px-4 py-3 rounded-xl border border-[#D5E2D7] bg-[#F4F7F4] text-[#233327] text-sm focus:outline-none focus:border-[#6F9575]"></textarea>
            </div>

            <!-- Submit Button -->
            <button 
                type="submit" 
                :disabled="loading"
                data-reveal="zoom-in"
                data-reveal-delay="450"
                class="w-full py-3.5 rounded-full bg-gradient-to-r from-[#6F9575] via-[#85AB8B] to-[#57795C] hover:from-[#57795C] hover:to-[#425E47] text-white font-bold text-sm shadow-md transition duration-200 flex items-center justify-center gap-2 cursor-pointer disabled:opacity-50">
                <svg x-show="loading" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>Kirim Konfirmasi Kehadiran</span>
            </button>
        </form>
    </div>
</section>
