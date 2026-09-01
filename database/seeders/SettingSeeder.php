<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\Story;
use App\Models\Gallery;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'invitation_title', 'value' => 'The Wedding of Ramazan & Dede', 'group' => 'general', 'type' => 'text'],
            ['key' => 'app_theme', 'value' => 'sage-white', 'group' => 'general', 'type' => 'text'],
            ['key' => 'music_url', 'value' => '/audio/wedding-nasheed.mp3', 'group' => 'general', 'type' => 'text'],
            ['key' => 'music_title', 'value' => 'Wedding Nasheed - Muhammad Al Muqit', 'group' => 'general', 'type' => 'text'],

            // Quotes
            ['key' => 'bismillah_text', 'value' => 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ', 'group' => 'quotes', 'type' => 'text'],
            ['key' => 'salam_text', 'value' => 'السَّلاَمُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُهُ', 'group' => 'quotes', 'type' => 'text'],
            ['key' => 'quote_source', 'value' => 'QS. Ar-Rum: 21', 'group' => 'quotes', 'type' => 'text'],
            ['key' => 'quote_text', 'value' => 'Dan di antara tanda-tanda (kebesaran)-Nya ialah Dia menciptakan berpasang-pasangan untukmu dari jenismu sendiri, agar kamu cenderung dan merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang...', 'group' => 'quotes', 'type' => 'textarea'],
            ['key' => 'closing_prayer', 'value' => 'Jazakumullahu khairan Katsiran', 'group' => 'quotes', 'type' => 'text'],

            // Groom
            ['key' => 'groom_name', 'value' => 'Ramazan Akcaalan', 'group' => 'couple', 'type' => 'text'],
            ['key' => 'groom_nickname', 'value' => 'Ramazan', 'group' => 'couple', 'type' => 'text'],
            ['key' => 'groom_father', 'value' => 'Bpk. Ismail Akcaalan', 'group' => 'couple', 'type' => 'text'],
            ['key' => 'groom_mother', 'value' => 'Ibu Aysel Akcaalan', 'group' => 'couple', 'type' => 'text'],
            ['key' => 'groom_origin', 'value' => 'Ağrı, Turki', 'group' => 'couple', 'type' => 'text'],
            ['key' => 'groom_photo', 'value' => '/images/cartoon_groom.webp', 'group' => 'couple', 'type' => 'image'],
            ['key' => 'groom_instagram', 'value' => 'ramazanakcaalan', 'group' => 'couple', 'type' => 'text'],

            // Bride
            ['key' => 'bride_name', 'value' => 'Dede Sobariah', 'group' => 'couple', 'type' => 'text'],
            ['key' => 'bride_nickname', 'value' => 'Dede', 'group' => 'couple', 'type' => 'text'],
            ['key' => 'bride_father', 'value' => 'Bpk. Endeng Zenal Arifin', 'group' => 'couple', 'type' => 'text'],
            ['key' => 'bride_mother', 'value' => 'Ibu Ipah Saripah', 'group' => 'couple', 'type' => 'text'],
            ['key' => 'bride_origin', 'value' => 'Garut, Indonesia', 'group' => 'couple', 'type' => 'text'],
            ['key' => 'bride_photo', 'value' => '/images/cartoon_bride.webp', 'group' => 'couple', 'type' => 'image'],
            ['key' => 'bride_instagram', 'value' => 'dedesobariah', 'group' => 'couple', 'type' => 'text'],

            // Event 1: Tasyakuran Pernikahan (Main Event)
            ['key' => 'event_title', 'value' => 'Tasyakuran Pernikahan', 'group' => 'event', 'type' => 'text'],
            ['key' => 'event_day', 'value' => 'Ahad', 'group' => 'event', 'type' => 'text'],
            ['key' => 'event_date', 'value' => '2026-09-20', 'group' => 'event', 'type' => 'text'],
            ['key' => 'event_date_formatted', 'value' => '20 September 2026', 'group' => 'event', 'type' => 'text'],
            ['key' => 'event_time', 'value' => '11.00 - 15.00 WIB', 'group' => 'event', 'type' => 'text'],
            ['key' => 'event_venue', 'value' => 'Rumah Makan dan Wisata Eptilu', 'group' => 'event', 'type' => 'text'],
            ['key' => 'event_address', 'value' => 'Jl. Raya Garut - Cikajang No.KM. 24, Mekarsari, Kec. Cikajang, Kabupaten Garut, Jawa Barat 44171', 'group' => 'event', 'type' => 'textarea'],
            ['key' => 'event_maps_url', 'value' => 'https://bit.ly/4qGZHen', 'group' => 'event', 'type' => 'text'],
            ['key' => 'event_maps_embed', 'value' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.1706606041695!2d107.7854611!3d-7.3347101!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68ba9b8c66e2c3%3A0xe54ef90eaee60107!2sWisata%20Eptilu!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid', 'group' => 'event', 'type' => 'textarea'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }

        // Default Galleries with Cartoon Artwork (Optimized WebP)
        Gallery::truncate();
        $photos = [
            ['/images/cartoon_couple_cover.webp', 'The Wedding of Ramazan & Dede', true],
            ['/images/cartoon_moment_1.webp', 'Momen Bahagia 1', false],
            ['/images/cartoon_moment_2.webp', 'Momen Bahagia 2', false],
            ['/images/cartoon_groom.webp', 'Mempelai Pria - Ramazan', false],
            ['/images/cartoon_bride.webp', 'Mempelai Wanita - Dede', false],
        ];

        foreach ($photos as $i => [$url, $title, $featured]) {
            Gallery::create([
                'title' => $title,
                'file_path' => $url,
                'media_type' => 'image',
                'sort_order' => $i + 1,
                'is_featured' => $featured,
            ]);
        }
    }
}
