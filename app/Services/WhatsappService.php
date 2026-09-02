<?php

namespace App\Services;

use App\Models\Guest;
use App\Models\Setting;
use Illuminate\Support\Str;

class WhatsappService
{
    /**
     * Build the WhatsApp intent URL for sending an invitation.
     */
    public function generateShareUrl(Guest $guest): string
    {
        $phone = $this->formatPhoneNumber($guest->phone ?? '');
        $message = $this->buildMessage($guest);

        if ($phone) {
            return 'https://api.whatsapp.com/send?phone=' . $phone . '&text=' . rawurlencode($message);
        }

        return 'https://api.whatsapp.com/send?text=' . rawurlencode($message);
    }

    /**
     * Generate the invitation message string.
     */
    public function buildMessage(Guest $guest): string
    {
        $groom = Setting::get('groom_nickname', 'Ramazan');
        $bride = Setting::get('bride_nickname', 'Dede');
        $day = Setting::get('event_day', 'Ahad');
        $date = Setting::get('event_date_formatted', '20 September 2026');
        $akadTime = Setting::get('akad_time', '10.00 - 11.00 WIB');
        $walimahTime = Setting::get('walimah_time', '11.00 - 15.00 WIB');
        $venue = Setting::get('event_venue', 'Rumah Makan Leila, Garut');
        $url = $guest->personal_url;

        return <<<TEXT
*Yth. {$guest->name}*

بسم اللّه الرّحمن الرّحيم 
ٱلسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ ٱللَّٰهِ وَبَرَكَاتُهُ

Dengan memohon Rahmat & Ridho Allah Subhanahu Wata'ala, kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara Pernikahan kami:

✨ *{$groom} & {$bride}* ✨

📅 *Hari/Tanggal:* {$day}, {$date}
💍 *Akad Nikah:* {$akadTime}
🌸 *Walimatul 'Urs:* {$walimahTime}
📍 *Tempat:* {$venue}

Untuk informasi detail acara, lokasi, dan konfirmasi kehadiran (RSVP), silakan kunjungi link undangan personal Anda melalui tautan berikut:
👉 {$url}

Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan do'a restu.

_Jazakumullahu khairan katsiran_
ٱلسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ ٱللَّٰهِ وَبَرَكَاتُهُ
TEXT;
    }

    /**
     * Convert standard local phone to international format (e.g. 0812... -> 62812...).
     */
    public function formatPhoneNumber(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }

        $clean = preg_replace('/[^0-9]/', '', $phone);

        if (Str::startsWith($clean, '0')) {
            $clean = '62' . substr($clean, 1);
        }

        return $clean;
    }
}
