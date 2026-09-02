<?php

namespace Tests\Unit;

use App\Models\Guest;
use App\Models\Setting;
use App\Services\WhatsappService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WhatsappServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_it_generates_whatsapp_message_with_akad_and_walimah(): void
    {
        $guest = Guest::create([
            'name' => 'Fulan bin Fulan',
            'slug' => 'fulan-1234',
            'phone' => '08123456789',
        ]);

        $service = new WhatsappService();
        $message = $service->buildMessage($guest);

        $this->assertStringContainsString('Fulan bin Fulan', $message);
        $this->assertStringContainsString('Akad Nikah', $message);
        $this->assertStringContainsString('10.00 - 11.00 WIB', $message);
        $this->assertStringContainsString("Walimatul 'Urs", $message);
        $this->assertStringContainsString('11.00 - 15.00 WIB', $message);
    }

    public function test_it_formats_phone_number_correctly(): void
    {
        $service = new WhatsappService();
        $this->assertEquals('6281234567890', $service->formatPhoneNumber('081234567890'));
        $this->assertEquals('6281234567890', $service->formatPhoneNumber('+6281234567890'));
    }
}
