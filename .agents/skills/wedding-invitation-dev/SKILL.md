---
name: wedding-invitation-dev
description: >-
  Specialized skill for scaffolding, developing, testing, and managing the Digital Wedding Invitation platform
  using Laravel 12, Filament PHP v5, Blade, Alpine.js, and Tailwind CSS. Use this skill when implementing
  or refactoring wedding invitation features, slug generation, RSVP and guestbook handling, audio player components,
  or Filament admin resources.
---

# Wedding Invitation Development Skill

This skill provides step-by-step procedures, architectural best practices, and guidelines for developing and maintaining the Digital Wedding Invitation platform.

---

## 1. Project Overview & Architecture Reference

- **Design Document:** Refer to [DESIGN.md](../../DESIGN.md) for full database schemas, UI design tokens, component architecture, and WhatsApp integration flow.
- **Specification:** Refer to [PROJECT-SPEC.md](../../PROJECT-SPEC.md) for project requirements.
- **Roadmap:** Refer to [ROADMAP.md](../../ROADMAP.md) for phase-by-phase execution tracking.

---

## 2. Core Workflows & Procedures

### 2.1 Generating Guest Slugs (`SlugGeneratorService`)
When generating personalized guest slugs:
1. Strip leading and trailing honorifics if needed, or slugify the guest name using `Str::slug($name)`.
2. Append a random 4-character alphanumeric/hex string to guarantee uniqueness while keeping URLs short.
3. Validate against collision in `guests` table:
   ```php
   $baseSlug = Str::limit(Str::slug($name), 25, '');
   do {
       $slug = $baseSlug . '-' . Str::lower(Str::random(4));
   } while (Guest::where('slug', $slug)->exists());
   ```

### 2.2 Invitation Route & Middleware Flow
1. **Public Route (`/{slug}`):**
   - Query `Guest::where('slug', $slug)->first()`.
   - If not found, render a graceful custom 404 view (`invitation.errors.404-invitation`).
   - If found, mark `is_opened = true`, set `opened_at = now()` if null, increment `view_count`, and pass `$guest` to the view.
2. **Generic Fallback Route (`/`):**
   - Provide a dummy or default guest model with name `"Tamu Undangan & Kerabat"` to allow browsing without a personalized link.

### 2.3 Audio Autoplay & Cover Screen (Mobile Optimization)
Browser autoplay policies require user interaction to play audio. Implement the following pattern:
- The cover screen overlays the page on load (`z-50`).
- Clicking **"Buka Undangan"** triggers:
  1. `$refs.audioPlayer.play()` in Alpine.js.
  2. Smooth scroll or fade out of the cover screen.
  3. Setting `isOpened = true` in the Alpine component state.
  4. Displaying the floating audio controller.

### 2.4 Filament PHP v5 Admin Panel Configuration
- Ensure Filament Resources are registered:
  - `GuestResource`: with bulk actions (bulk export, bulk delete), single actions (WhatsApp share URL, copy link).
  - `RsvpResource`: with badge columns for `attendance` (`hadir` = success, `tidak_hadir` = danger, `ragu` = warning).
  - `GuestbookResource`: with approval toggle action.
  - `SettingResource`: managing wedding date, couple details, bank accounts, and maps embeds.

---

## 3. Validation & Testing Checklist

- [ ] `php artisan migrate:status` indicates all migrations applied.
- [ ] Personalized URL `/{slug}` loads guest name dynamically in cover and invitation sections.
- [ ] RSVP submission updates or creates `rsvps` record and locks/links to `guest_id`.
- [ ] Guestbook submission immediately appears in the message list.
- [ ] Copy-to-clipboard works cleanly on mobile for digital envelope bank accounts.
- [ ] WhatsApp generator properly formats `wa.me/62...` international numbers.
