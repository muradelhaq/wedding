<?php

namespace Tests\Feature;

use App\Models\Guestbook;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestbookSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_submit_message_to_guestbook(): void
    {
        $response = $this->postJson('/guestbook', [
            'name' => 'Keluarga Ağrı',
            'message' => 'Barakallahu lakuma wa baraka alaikuma! Selamat menempuh hidup baru.',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('status', 'success');
        $response->assertJsonPath('data.name', 'Keluarga Ağrı');

        $this->assertDatabaseHas('guestbooks', [
            'name' => 'Keluarga Ağrı',
            'is_approved' => true,
        ]);
    }

    public function test_guest_can_fetch_paginated_guestbook_messages_5_per_page(): void
    {
        for ($i = 1; $i <= 12; $i++) {
            Guestbook::create([
                'name' => "Tamu {$i}",
                'message' => "Doa restu dari tamu ke-{$i}",
                'is_approved' => true,
                'created_at' => now()->subMinutes(15 - $i),
            ]);
        }

        // Unapproved message should not appear
        Guestbook::create([
            'name' => 'Spam Bot',
            'message' => 'Spam message',
            'is_approved' => false,
        ]);

        // Page 1
        $response = $this->getJson('/guestbook?page=1');
        $response->assertStatus(200);
        $response->assertJsonPath('current_page', 1);
        $response->assertJsonPath('last_page', 3);
        $response->assertJsonPath('total', 12);
        $response->assertJsonPath('per_page', 5);
        $response->assertJsonCount(5, 'data');
        $response->assertJsonPath('data.0.name', 'Tamu 12');

        // Page 2
        $response2 = $this->getJson('/guestbook?page=2');
        $response2->assertStatus(200);
        $response2->assertJsonPath('current_page', 2);
        $response2->assertJsonCount(5, 'data');
        $response2->assertJsonPath('data.0.name', 'Tamu 7');

        // Page 3
        $response3 = $this->getJson('/guestbook?page=3');
        $response3->assertStatus(200);
        $response3->assertJsonPath('current_page', 3);
        $response3->assertJsonCount(2, 'data');
    }
}

