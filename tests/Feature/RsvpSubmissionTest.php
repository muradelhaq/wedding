<?php

namespace Tests\Feature;

use App\Models\Guest;
use App\Models\Rsvp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RsvpSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_registered_guest_can_submit_rsvp(): void
    {
        $guest = Guest::create([
            'name' => 'Bpk. Endeng Zenal Arifin',
            'slug' => 'endeng-zenal',
            'category' => 'Keluarga',
        ]);

        $response = $this->postJson('/rsvp', [
            'guest_id' => $guest->id,
            'attendance' => 'hadir',
            'total_guest' => 3,
            'notes' => 'Hadir bersama keluarga.',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('status', 'success');

        $this->assertDatabaseHas('rsvps', [
            'guest_id' => $guest->id,
            'attendance' => 'hadir',
            'total_guest' => 3,
        ]);
    }

    public function test_anonymous_guest_can_submit_rsvp_with_auto_guest_creation(): void
    {
        $response = $this->postJson('/rsvp', [
            'guest_name' => 'Tamu Istimewa Garut',
            'attendance' => 'hadir',
            'total_guest' => 2,
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('status', 'success');

        $this->assertDatabaseHas('guests', [
            'name' => 'Tamu Istimewa Garut',
        ]);
        $this->assertDatabaseHas('rsvps', [
            'attendance' => 'hadir',
            'total_guest' => 2,
        ]);
    }
}
