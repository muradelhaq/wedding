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
}
