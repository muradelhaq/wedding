<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Guest;
use App\Models\Guestbook;
use App\Models\Setting;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvitationController extends Controller
{
    /**
     * Display the invitation page for a specific guest slug or generic visitor.
     */
    public function show(?string $slug = null): View
    {
        $guest = null;

        if ($slug) {
            $guest = Guest::with('rsvp')->where('slug', $slug)->first();

            if (!$guest) {
                // If slug does not exist, return custom 404 with elegant wedding theme
                return view('invitation.errors.404-invitation', [
                    'invalidSlug' => $slug,
                    'settings' => Setting::getAllGrouped(),
                ]);
            }

            // Track first-time open and view count
            if (!$guest->is_opened) {
                $guest->update([
                    'is_opened' => true,
                    'opened_at' => now(),
                    'view_count' => $guest->view_count + 1,
                ]);
            } else {
                $guest->increment('view_count');
            }
        }

        // If no slug provided, instantiate a fallback dummy guest
        if (!$guest) {
            $guest = new Guest([
                'name' => 'Tamu Undangan & Kerabat',
                'category' => 'Tamu Kehormatan',
                'slug' => '',
            ]);
        }

        $settings = Setting::getAllGrouped();
        $stories = Story::orderBy('sort_order', 'asc')->get();
        $galleries = Gallery::orderBy('sort_order', 'asc')->get();
        $guestbooks = Guestbook::where('is_approved', true)->latest('id')->paginate(5);

        return view('invitation.index', compact('guest', 'settings', 'stories', 'galleries', 'guestbooks'));
    }
}
