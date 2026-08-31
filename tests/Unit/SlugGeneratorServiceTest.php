<?php

namespace Tests\Unit;

use App\Models\Guest;
use App\Services\SlugGeneratorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SlugGeneratorServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_slug_generator_creates_unique_slug_with_entropy(): void
    {
        $service = new SlugGeneratorService();

        $slug1 = $service->generate('Bpk. Dr. Endeng Zenal Arifin');
        $slug2 = $service->generate('Bpk. Dr. Endeng Zenal Arifin');

        $this->assertNotEmpty($slug1);
        $this->assertNotEmpty($slug2);
        $this->assertNotEquals($slug1, $slug2); // Unique entropy ensures different slugs
        $this->assertStringContainsString('endeng-zenal-arifin', $slug1);
    }
}
