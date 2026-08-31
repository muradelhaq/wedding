<?php

namespace Database\Seeders;

use App\Models\Guest;
use App\Models\Guestbook;
use App\Models\Rsvp;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Admin User for Filament
        User::firstOrCreate(
            ['email' => 'admin@wedding.com'],
            [
                'name' => 'Admin Mempelai',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Run Settings, Stories & Galleries Seeder
        $this->call(SettingSeeder::class);

        // 3. Create Seed Guests
        $guests = [
            [
                'name' => 'Keluarga Ağrı-Indo',
                'slug' => 'keluarga-agri-indo',
                'category' => 'Keluarga Besar',
                'phone' => '081234567890',
                'address' => 'Turki & Indonesia',
            ],
            [
                'name' => 'Bpk. Endeng Zenal Arifin & Keluarga',
                'slug' => 'endeng-zenal-arifin-x8f2',
                'category' => 'Keluarga',
                'phone' => '081298765432',
                'address' => 'Garut',
            ],
            [
                'name' => 'Bpk. Ismail Akcaalan & Keluarga',
                'slug' => 'ismail-akcaalan-t4m2',
                'category' => 'Keluarga',
                'phone' => '081345678901',
                'address' => 'Ağrı, Turki',
            ],
            [
                'name' => 'Sahabat & Kerabat Tercinta',
                'slug' => 'sahabat-kerabat-w3x9',
                'category' => 'Sahabat',
                'phone' => null,
                'address' => 'Bandung & Jakarta',
            ],
        ];

        foreach ($guests as $data) {
            $guest = Guest::updateOrCreate(['slug' => $data['slug']], $data);

            // Sample Guestbook
            Guestbook::firstOrCreate(
                ['guest_id' => $guest->id],
                [
                    'name' => $guest->name,
                    'message' => 'Selamat menempuh hidup baru untuk Ramazan & Dede! Semoga menjadi keluarga yang sakinah, mawaddah, warahmah. Barakallahu lakuma wa baraka alaikuma wa jama\'a bainakuma fii khair.',
                    'is_approved' => true,
                ]
            );

            // Sample RSVP for the first guest
            if ($guest->slug === 'keluarga-agri-indo') {
                Rsvp::firstOrCreate(
                    ['guest_id' => $guest->id],
                    [
                        'attendance' => 'hadir',
                        'total_guest' => 4,
                        'notes' => 'InsyaAllah kami sekeluarga hadir mendoakan.',
                    ]
                );
            }
        }
    }
}
