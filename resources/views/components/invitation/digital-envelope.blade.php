@props(['settings'])

@php
    $bank1Name = $settings['envelope']['bank_1_name'] ?? 'BCA';
    $bank1Account = $settings['envelope']['bank_1_account'] ?? '1234567890';
    $bank1Holder = $settings['envelope']['bank_1_holder'] ?? 'Dede Sobariah';

    $bank2Name = $settings['envelope']['bank_2_name'] ?? 'Bank Mandiri / BSI';
    $bank2Account = $settings['envelope']['bank_2_account'] ?? '0987654321';
    $bank2Holder = $settings['envelope']['bank_2_holder'] ?? 'Ramazan Akcaalan';

    $giftAddress = $settings['envelope']['gift_address'] ?? 'Garut, Jawa Barat';
@endphp

<section class="py-16 px-6 max-w-2xl mx-auto text-center">
    <div class="mb-10" data-reveal="fade-down">
        <p class="text-xs uppercase tracking-[0.3em] text-[#a7742a] font-serif font-semibold mb-1">Wedding Gift</p>
        <h2 class="font-serif text-3xl sm:text-4xl font-bold text-[#192e26] mb-3">Tanda Kasih</h2>
        <div class="w-16 h-1 bg-gradient-to-r from-transparent via-[#c19036] to-transparent mx-auto rounded-full mt-2"></div>
        <p class="text-xs sm:text-sm text-[#6E675F] mt-4 max-w-md mx-auto font-sans" data-reveal="fade-up" data-reveal-delay="150">
            Do'a restu Anda merupakan karunia terindah bagi kami. Namun jika ingin memberikan tanda kasih secara digital, Anda dapat menggunakan rekening di bawah ini:
        </p>
    </div>

    <div class="space-y-6">
        <!-- Bank 1 -->
        <div class="bg-gradient-to-b from-white to-[#FAF6EE] border-2 border-[#e3c88e]/60 rounded-3xl p-6 shadow-[0_10px_30px_rgba(212,171,89,0.12)] transition hover:shadow-xl hover:border-[#c19036]"
             data-reveal="fade-up" data-reveal-delay="200">
            <div class="flex items-center justify-between mb-4">
                <span class="font-bold text-lg font-serif text-[#192e26]">{{ $bank1Name }}</span>
                <span class="text-xs font-semibold px-3 py-1 bg-[#c19036]/15 text-[#a7742a] rounded-full border border-[#d4ab59]/30">Transfer Bank</span>
            </div>
            <div class="text-left bg-white p-4 rounded-2xl border border-[#eedebd] mb-4 flex items-center justify-between gap-2 shadow-sm">
                <div>
                    <p class="font-mono font-bold text-base sm:text-lg text-[#2C2724] tracking-wider">{{ $bank1Account }}</p>
                    <p class="text-xs text-[#6E675F]">a.n. {{ $bank1Holder }}</p>
                </div>
                <button 
                    @click="window.copyToClipboard('{{ $bank1Account }}', 'Nomor rekening {{ $bank1Name }} berhasil disalin!')"
                    type="button"
                    class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#c19036] via-[#f5d38a] to-[#c19036] text-[#192e26] font-bold text-xs shadow transition hover:scale-105 shrink-0 cursor-pointer">
                    Salin No. Rekening
                </button>
            </div>
        </div>

        <!-- Bank 2 -->
        <div class="bg-gradient-to-b from-white to-[#FAF6EE] border-2 border-[#e3c88e]/60 rounded-3xl p-6 shadow-[0_10px_30px_rgba(212,171,89,0.12)] transition hover:shadow-xl hover:border-[#c19036]"
             data-reveal="fade-up" data-reveal-delay="300">
            <div class="flex items-center justify-between mb-4">
                <span class="font-bold text-lg font-serif text-[#192e26]">{{ $bank2Name }}</span>
                <span class="text-xs font-semibold px-3 py-1 bg-[#c19036]/15 text-[#a7742a] rounded-full border border-[#d4ab59]/30">Transfer Bank</span>
            </div>
            <div class="text-left bg-white p-4 rounded-2xl border border-[#eedebd] mb-4 flex items-center justify-between gap-2 shadow-sm">
                <div>
                    <p class="font-mono font-bold text-base sm:text-lg text-[#2C2724] tracking-wider">{{ $bank2Account }}</p>
                    <p class="text-xs text-[#6E675F]">a.n. {{ $bank2Holder }}</p>
                </div>
                <button 
                    @click="window.copyToClipboard('{{ $bank2Account }}', 'Nomor rekening {{ $bank2Name }} berhasil disalin!')"
                    type="button"
                    class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#c19036] via-[#f5d38a] to-[#c19036] text-[#192e26] font-bold text-xs shadow transition hover:scale-105 shrink-0 cursor-pointer">
                    Salin No. Rekening
                </button>
            </div>
        </div>

        <!-- Physical Gift Address -->
        <div class="bg-gradient-to-b from-white to-[#FAF6EE] border-2 border-[#e3c88e]/60 rounded-3xl p-6 shadow-[0_10px_30px_rgba(212,171,89,0.12)]"
             data-reveal="zoom-in" data-reveal-delay="400">
            <h4 class="font-serif font-bold text-sm text-[#192e26] mb-1">Kirim Kado Fisik</h4>
            <p class="text-xs text-[#6E675F] max-w-md mx-auto leading-relaxed mb-3">{{ $giftAddress }}</p>
            <button 
                @click="window.copyToClipboard('{{ $giftAddress }}', 'Alamat pengiriman kado berhasil disalin!')"
                type="button"
                class="inline-flex items-center gap-1.5 text-xs text-[#a7742a] hover:text-[#875724] font-serif font-bold underline cursor-pointer">
                Salin Alamat Lengkap
            </button>
        </div>
    </div>
</section>
