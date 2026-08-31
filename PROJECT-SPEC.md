# 💍 Digital Wedding Invitation — Project Specification

> Web undangan pernikahan digital dengan sistem **generate link personal per tamu** (per-guest personalized link), lengkap dengan RSVP, buku tamu, galeri, dan dashboard admin.

---

## 1. Ringkasan Proyek

Aplikasi web undangan pernikahan yang memungkinkan:
- Admin (mempelai/panitia) menambahkan daftar tamu melalui dashboard.
- Sistem **otomatis generate link unik** untuk setiap tamu (contoh: `https://undangan.com/u/aze8x1`).
- Saat tamu membuka link tersebut, halaman undangan menampilkan **nama tamu** secara personal ("Kepada Yth. Bapak/Ibu ...").
- Tamu dapat melakukan **RSVP** (konfirmasi hadir/tidak hadir + jumlah orang), mengisi **buku tamu/ucapan**, melihat **galeri foto**, **cerita pasangan**, **countdown**, **lokasi (Google Maps)**, dan **amplop digital**.
- Admin dapat memantau siapa saja yang sudah membuka undangan dan mengisi RSVP.

---

## 2. Target Pengguna

| Role | Deskripsi |
|---|---|
| **Admin / Mempelai** | Mengelola data tamu, generate link, melihat statistik RSVP & ucapan |
| **Tamu Undangan** | Membuka link personal, melihat undangan, mengisi RSVP & ucapan |

---

## 3. Fitur Utama

### 3.1 Fitur Tamu (Public/Guest Side)
- [ ] Halaman *cover* pembuka (tap to open) dengan nama tamu personal
- [ ] Menampilkan kutipan ayat / doa pembuka
- [ ] Profil mempelai (foto, nama lengkap, nama orang tua)
- [ ] Cerita pasangan / *love story* (timeline)
- [ ] Detail acara (akad/tasyakuran) — tanggal, waktu, tempat
- [ ] Countdown menuju hari-H
- [ ] Peta lokasi (Google Maps embed)
- [ ] Galeri foto/video prewedding
- [ ] Form RSVP (hadir/tidak hadir/ragu, jumlah tamu)
- [ ] Buku tamu digital / ucapan & doa (dengan nama otomatis terisi dari link)
- [ ] Amplop digital (info rekening / QRIS / e-wallet)
- [ ] Fitur *share* ke WhatsApp dengan pesan otomatis
- [ ] Musik latar (autoplay dengan tombol mute)
- [ ] Multi-bahasa (opsional: ID/EN/TR — relevan karena keluarga lintas negara)

### 3.2 Fitur Admin (Dashboard)
- [ ] CRUD data tamu (nama, kategori/grup, no. WhatsApp)
- [ ] Generate link otomatis per tamu (slug/token unik)
- [ ] Generate massal (import Excel/CSV → auto-generate semua link sekaligus)
- [ ] Kirim link otomatis via WhatsApp (template pesan + link personal)
- [ ] Tracking status: link dibuka / belum dibuka, RSVP hadir/tidak
- [ ] Rekap ucapan & RSVP (export ke Excel)
- [ ] Pengaturan konten undangan (tanggal, lokasi, galeri, dsb) tanpa ubah kode
- [ ] Statistik dashboard (jumlah tamu, jumlah hadir, jumlah dibuka)

---

## 4. Alur Sistem Generate Link

```
Admin input nama tamu "Bapak Endeng Zenal Arifin"
        │
        ▼
Sistem generate slug unik → "endeng-zenal-x8f2"
        │
        ▼
Link personal → https://undangan.com/endeng-zenal-x8f2
        │
        ▼
Tamu buka link → sistem cari data tamu via slug
        │
        ▼
Halaman undangan tampil dengan "Kepada Yth. Bapak Endeng Zenal Arifin"
        │
        ▼
Status "link_opened" & "opened_at" tercatat otomatis
```

**Alternatif format URL** (pilih salah satu saat development):
- `domain.com/{slug}` → paling clean, contoh: `domain.com/endeng-zenal-x8f2`
- `domain.com/?to={slug}` → lebih sederhana secara routing
- `domain.com/u/{token}` → token acak (tidak berbasis nama), lebih privat

---

## 5. Tech Stack (disesuaikan dengan stack yang sudah dikuasai)

| Layer | Teknologi |
|---|---|
| Backend | Laravel 12 |
| Admin Panel | Filament PHP v5 |
| Frontend Tamu | Blade + Alpine.js + Tailwind CSS |
| Database | MySQL |
| Notifikasi WA | Fonnte / WABlas / Wablas API (opsional, untuk kirim link otomatis) |
| Hosting | VPS / Shared hosting (support Laravel) |
| Asset Build | Vite |

> Catatan: stack ini mengikuti stack yang sudah biasa dipakai (Laravel + Filament + Tailwind + MySQL), supaya development lebih cepat karena tidak perlu belajar tools baru.

---

## 6. Struktur Database (Skema Awal)

### Table: `guests`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | primary key |
| name | varchar | nama tamu |
| slug | varchar unique | untuk URL personal |
| category | varchar | contoh: Keluarga, Kolega, Teman Kampus |
| phone | varchar nullable | nomor WhatsApp |
| is_opened | boolean | status sudah dibuka atau belum |
| opened_at | timestamp nullable | |
| created_at / updated_at | timestamp | |

### Table: `rsvps`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | |
| guest_id | foreign key → guests | |
| attendance | enum | hadir / tidak_hadir / ragu |
| total_guest | integer | jumlah orang yang hadir |
| created_at | timestamp | |

### Table: `guestbooks` (buku tamu / ucapan)
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | |
| guest_id | foreign key → guests (nullable, bisa juga guest umum) | |
| name | varchar | nama pengisi (auto dari slug atau manual) |
| message | text | isi ucapan/doa |
| created_at | timestamp | |

### Table: `settings`
| Kolom | Tipe | Keterangan |
|---|---|---|
| id | bigint | |
| key | varchar | contoh: `groom_name`, `bride_name`, `event_date`, `location`, `maps_url`, `bank_account` |
| value | text | |

---

## 7. Struktur Folder Proyek (Laravel + Filament)

```
wedding-invitation/
├── app/
│   ├── Filament/
│   │   ├── Resources/
│   │   │   ├── GuestResource.php
│   │   │   │   ├── Pages/
│   │   │   │   │   ├── ListGuests.php
│   │   │   │   │   ├── CreateGuest.php
│   │   │   │   │   └── EditGuest.php
│   │   │   ├── RsvpResource.php
│   │   │   ├── GuestbookResource.php
│   │   │   └── SettingResource.php
│   │   ├── Widgets/
│   │   │   ├── StatsOverview.php          # jumlah tamu, hadir, dibuka
│   │   │   └── RsvpChart.php
│   │   └── Pages/
│   │       └── GenerateBulkLinks.php      # generate link massal (import excel)
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── InvitationController.php   # tampilkan halaman undangan per slug
│   │   │   ├── RsvpController.php
│   │   │   └── GuestbookController.php
│   │   └── Middleware/
│   │       └── TrackInvitationOpen.php    # catat status is_opened
│   │
│   ├── Models/
│   │   ├── Guest.php
│   │   ├── Rsvp.php
│   │   ├── Guestbook.php
│   │   └── Setting.php
│   │
│   ├── Services/
│   │   ├── SlugGeneratorService.php       # generate slug unik per tamu
│   │   ├── WhatsappService.php            # kirim link via WA API
│   │   └── GuestImportService.php         # import excel massal
│   │
│   └── Imports/
│       └── GuestsImport.php               # Laravel Excel import class
│
├── database/
│   ├── migrations/
│   │   ├── xxxx_create_guests_table.php
│   │   ├── xxxx_create_rsvps_table.php
│   │   ├── xxxx_create_guestbooks_table.php
│   │   └── xxxx_create_settings_table.php
│   ├── seeders/
│   │   └── SettingSeeder.php
│   └── factories/
│       └── GuestFactory.php
│
├── resources/
│   ├── views/
│   │   ├── invitation/
│   │   │   ├── index.blade.php            # halaman utama undangan
│   │   │   ├── components/
│   │   │   │   ├── cover.blade.php        # tap to open + nama tamu
│   │   │   │   ├── couple-profile.blade.php
│   │   │   │   ├── love-story.blade.php
│   │   │   │   ├── event-detail.blade.php
│   │   │   │   ├── countdown.blade.php
│   │   │   │   ├── gallery.blade.php
│   │   │   │   ├── maps.blade.php
│   │   │   │   ├── rsvp-form.blade.php
│   │   │   │   ├── guestbook.blade.php
│   │   │   │   ├── digital-envelope.blade.php
│   │   │   │   └── music-player.blade.php
│   │   │   └── layouts/
│   │   │       └── guest-layout.blade.php
│   │   └── errors/
│   │       └── 404-invitation.blade.php   # jika slug tidak ditemukan
│   │
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   ├── app.js
│   │   └── alpine-components/
│   │       ├── countdown.js
│   │       └── music-player.js
│   └── audio/
│       └── background-music.mp3
│
├── routes/
│   ├── web.php                            # route: /{slug} → InvitationController
│   └── console.php
│
├── public/
│   ├── images/
│   │   ├── gallery/
│   │   ├── couple/
│   │   └── og-image.jpg                   # untuk preview link share WA
│   └── favicon.ico
│
├── config/
│   └── whatsapp.php                       # config API WA gateway
│
├── tests/
│   ├── Feature/
│   │   ├── InvitationAccessTest.php
│   │   ├── RsvpSubmissionTest.php
│   │   └── SlugGenerationTest.php
│   └── Unit/
│       └── SlugGeneratorServiceTest.php
│
├── .env.example
├── composer.json
├── package.json
├── vite.config.js
└── README.md
```

---

## 8. Roadmap Pengembangan

| Fase | Deliverable |
|---|---|
| **Fase 1 — Setup & Database** | Install Laravel + Filament, buat migration & model (`guests`, `rsvps`, `guestbooks`, `settings`) |
| **Fase 2 — Admin Panel** | Filament Resource untuk CRUD tamu, generate slug otomatis, import Excel massal |
| **Fase 3 — Halaman Undangan Publik** | Routing per slug, tampilkan nama tamu dinamis, semua section (cover, profil, cerita, acara, galeri, maps) |
| **Fase 4 — Interaksi Tamu** | Form RSVP, buku tamu/ucapan, tracking status dibuka |
| **Fase 5 — Integrasi Tambahan** | Kirim link otomatis via WhatsApp API, amplop digital, statistik dashboard |
| **Fase 6 — Polish & Deploy** | Optimasi tampilan mobile, OG image untuk preview link, deploy ke hosting |

---

## 9. Catatan UI/UX

- Desain **mobile-first** — mayoritas tamu membuka undangan dari WhatsApp di HP.
- Gunakan animasi halus (fade/slide) antar section agar terasa elegan, tapi tetap ringan (hindari animasi berat yang bikin loading lama).
- Tombol "Buka Undangan" di halaman cover penting untuk trigger autoplay musik (karena browser memblokir autoplay tanpa interaksi user).
- Sediakan *fallback* jika slug tidak ditemukan (halaman 404 custom yang tetap terasa bagian dari tema undangan).
- Warna & tipografi disesuaikan tema pernikahan (islami/elegan/rustic — tinggal disesuaikan di tahap desain).
