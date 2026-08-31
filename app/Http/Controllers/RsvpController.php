<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Rsvp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RsvpController extends Controller
{
    /**
     * Store or update an RSVP submission.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'guest_id' => 'nullable|exists:guests,id',
            'guest_name' => 'required_without:guest_id|string|max:255',
            'attendance' => 'required|in:hadir,tidak_hadir,ragu',
            'total_guest' => 'required|integer|min:1|max:10',
            'notes' => 'nullable|string|max:1000',
        ]);

        $guestId = $validated['guest_id'] ?? null;

        // If no guest_id, create or find guest by name
        if (!$guestId && !empty($validated['guest_name'])) {
            $slugService = app(\App\Services\SlugGeneratorService::class);
            $slug = $slugService->generate($validated['guest_name']);

            $guest = Guest::create([
                'name' => $validated['guest_name'],
                'slug' => $slug,
                'category' => 'Umum (RSVP)',
                'is_opened' => true,
                'opened_at' => now(),
            ]);

            $guestId = $guest->id;
        }

        $rsvp = Rsvp::updateOrCreate(
            ['guest_id' => $guestId],
            [
                'attendance' => $validated['attendance'],
                'total_guest' => $validated['total_guest'],
                'notes' => $validated['notes'] ?? null,
            ]
        );

        $message = match ($validated['attendance']) {
            'hadir' => 'Terima kasih atas konfirmasi kehadiran Anda. Sampai jumpa di hari bahagia kami!',
            'tidak_hadir' => 'Terima kasih atas konfirmasinya. Doa restu Anda sangat berarti bagi kami.',
            'ragu' => 'Terima kasih telah mengonfirmasi. Kami tunggu kepastian kehadiran Anda.',
        };

        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $rsvp,
        ]);
    }
}
