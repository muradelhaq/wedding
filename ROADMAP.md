# 🗺️ Wedding Invitation Development Roadmap & Checklist

> Project tracking and development phases for the Digital Wedding Invitation platform.

---

## 📌 Phase 1: Environment & Database Foundation
- [x] Initialize Laravel 12 project structure.
- [x] Configure `.env` database connection (`DB_DATABASE=wedding_invitation`).
- [x] Create database migrations:
  - [x] `create_guests_table` (name, slug, category, phone, address, is_opened, opened_at, view_count)
  - [x] `create_rsvps_table` (guest_id, attendance, total_guest, notes)
  - [x] `create_guestbooks_table` (guest_id, name, message, is_approved)
  - [x] `create_settings_table` (key, value, group, type)
  - [x] `create_stories_table` (title, date_label, description, image_path, sort_order)
  - [x] `create_galleries_table` (title, file_path, media_type, sort_order, is_featured)
- [x] Create Eloquent Models & Relationships (`Guest`, `Rsvp`, `Guestbook`, `Setting`, `Story`, `Gallery`).
- [x] Implement `SettingSeeder` with official wedding data (Ramazan & Dede - Ağrı-Indo).
- [x] Seed default Admin user (`admin@wedding.com`) and sample guests.

---

## 📌 Phase 2: Service Layer & Admin Panel (Filament PHP)
- [x] Install & configure Filament PHP admin panel.
- [x] Build `SlugGeneratorService` (slugify name + 4-char unique entropy + collision check).
- [x] Build `WhatsappService` (format phone numbers to international standard + URL encode template message).
- [x] Build `GuestImportService` (bulk insert guests with unique slugs).
- [x] Create Filament Resources:
  - [x] `GuestResource` (table, quick actions: Copy Link, Send WhatsApp, Buka Undangan).
  - [x] `RsvpResource` (table filter by attendance, total pax counter).
  - [x] `GuestbookResource` (instant approval toggle, bulk delete).
  - [x] `SettingResource` (manage couple names, event dates, bank accounts, maps link).
  - [x] `StoryResource` (manage love story timeline).
  - [x] `GalleryResource` (manage photos & featured status).
- [x] Build `GenerateBulkLinks` page (batch input text/CSV with unique slug generator).
- [x] Build `StatsOverview` widget (total guests, opened rate, attending pax, total messages).

---

## 📌 Phase 3: Public Invitation Frontend (Blade + Alpine.js + Tailwind)
- [x] Set up layout `guest-layout.blade.php` with responsive viewport, OpenGraph tags, Google Fonts, and Toast system.
- [x] Build Cover / Hero component (`cover.blade.php`):
  - [x] Monogram / Couple names.
  - [x] Personalized greeting (`Kepada Yth. Bapak/Ibu/Saudara/i [Guest Name]`).
  - [x] "Buka Undangan" button with unlock animation & audio trigger.
- [x] Build Couple Profile section (`couple-profile.blade.php` - Ramazan & Dede).
- [x] Build Love Story / Timeline section (`love-story.blade.php`).
- [x] Build Event Detail & Countdown section (`event-detail.blade.php`, `countdown.blade.php`):
  - [x] Tasyakuran Pernikahan (Ahad, 20 September 2026, Eptilu Garut).
  - [x] "Simpan ke Google Calendar" action.
  - [x] Live Alpine.js countdown timer.
- [x] Build Google Maps section (`maps.blade.php`) with shortcut to native Google Maps.
- [x] Build Photo Gallery with Lightbox modal (`gallery.blade.php`).
- [x] Build Audio Player floating component (`music-player.blade.php`) with vinyl spin animation & mute toggle.
- [x] Build Custom 404 Fallback page (`404-invitation.blade.php`).

---

## 📌 Phase 4: Guest Interactions (RSVP & Guestbook)
- [x] Build RSVP Form (`rsvp-form.blade.php`):
  - [x] Asynchronous submission via Fetch/AJAX.
  - [x] Auto-lock to current guest if visiting via slug.
  - [x] Success state feedback and live toggle.
- [x] Build Digital Guestbook (`guestbook.blade.php`):
  - [x] Message submission form.
  - [x] Live card feed with immediate prepend.
- [x] Build Digital Envelope / Wedding Gift (`digital-envelope.blade.php`):
  - [x] Bank accounts with "Salin Nomor Rekening" copy-to-clipboard button.
  - [x] Physical gift mailing address with copy action.

---

## 📌 Phase 5: Tracking, WhatsApp & Analytics Integration
- [x] Implement guest tracking in `InvitationController` (`is_opened`, `opened_at`, `view_count`).
- [x] Implement WhatsApp direct invitation share URLs.
- [x] Bulk guest generation tested with auto slug collision handling.

---

## 📌 Phase 6: Optimization, Polish & Automated Testing
- [x] Automated Unit & Feature tests (`tests/Feature/InvitationAccessTest.php`, `RsvpSubmissionTest.php`, `GuestbookSubmissionTest.php`, `SlugGeneratorServiceTest.php`) — **9/9 tests passed, 32 assertions**.
- [x] Production asset build via Vite (`npm run build`).
- [x] Mobile-first UI/UX layout.
