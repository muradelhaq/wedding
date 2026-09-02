<?php

namespace Tests\Feature;

use App\Models\Guest;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvitationAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_generic_invitation_page_loads_successfully(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Akad Nikah');
        $response->assertSee('Walimatul');
        $response->assertSee('Ramazan');
        $response->assertSee('Dede');
    }

    public function test_personalized_invitation_displays_guest_name_and_updates_opened_status(): void
    {
        $guest = Guest::create([
            'name' => 'Keluarga Besar Ağrı-Indo',
            'slug' => 'agri-indo-test',
            'category' => 'Keluarga',
            'is_opened' => false,
        ]);

        $this->assertFalse($guest->is_opened);
        $this->assertNull($guest->opened_at);

        $response = $this->get('/agri-indo-test');

        $response->assertStatus(200);
        $response->assertSee('Keluarga Besar Ağrı-Indo');
        $response->assertSee('Keluarga');

        $guest->refresh();
        $this->assertTrue($guest->is_opened);
        $this->assertNotNull($guest->opened_at);
        $this->assertEquals(1, $guest->view_count);
    }

    public function test_invalid_slug_returns_custom_404_view(): void
    {
        $response = $this->get('/slug-yang-pasti-tidak-ada-999');

        $response->assertStatus(200); // Renders friendly custom wedding 404 view
        $response->assertSee('Undangan Tidak Ditemukan');
        $response->assertSee('slug-yang-pasti-tidak-ada-999');
    }
}
