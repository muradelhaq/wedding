<?php

namespace App\Http\Controllers;

use App\Models\Guestbook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GuestbookController extends Controller
{
    /**
     * Store a new guestbook message.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'guest_id' => 'nullable|exists:guests,id',
            'name' => 'required|string|max:255',
            'message' => 'required|string|min:3|max:1000',
        ]);

        $guestbook = Guestbook::create([
            'guest_id' => $validated['guest_id'] ?? null,
            'name' => strip_tags(trim($validated['name'])),
            'message' => strip_tags(trim($validated['message'])),
            'is_approved' => true,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Ucapan dan doa restu Anda berhasil dikirimkan. Terima kasih!',
            'data' => [
                'id' => $guestbook->id,
                'name' => e($guestbook->name),
                'message' => e($guestbook->message),
                'time_ago' => 'Baru saja',
            ],
        ]);
    }
}
