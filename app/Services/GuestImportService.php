<?php

namespace App\Services;

use App\Models\Guest;
use Illuminate\Support\Collection;

class GuestImportService
{
    public function __construct(
        protected SlugGeneratorService $slugGenerator
    ) {}

    /**
     * Import guests from CSV string or array data.
     * Expected columns: name, category, phone, address
     */
    public function importFromRows(array $rows): array
    {
        $created = 0;
        $skipped = 0;
        $errors = [];

        foreach ($rows as $index => $row) {
            $name = trim($row['name'] ?? $row[0] ?? '');
            $category = trim($row['category'] ?? $row[1] ?? 'Umum') ?: 'Umum';
            $phone = trim($row['phone'] ?? $row[2] ?? '');
            $address = trim($row['address'] ?? $row[3] ?? '');

            if (empty($name) || strtolower($name) === 'nama' || strtolower($name) === 'name') {
                continue; // Skip header or empty
            }

            try {
                $slug = $this->slugGenerator->generate($name);

                Guest::create([
                    'name' => $name,
                    'slug' => $slug,
                    'category' => $category,
                    'phone' => $phone ?: null,
                    'address' => $address ?: null,
                ]);

                $created++;
            } catch (\Exception $e) {
                $skipped++;
                $errors[] = "Baris " . ($index + 1) . ": " . $e->getMessage();
            }
        }

        return [
            'created' => $created,
            'skipped' => $skipped,
            'errors' => $errors,
        ];
    }
}
