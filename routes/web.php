<?php

use App\Http\Controllers\GuestbookController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\RsvpController;
use Illuminate\Support\Facades\Route;

// Interactive Submissions
Route::get('/guestbook', [GuestbookController::class, 'index'])->name('guestbook.index');
Route::post('/rsvp', [RsvpController::class, 'store'])->name('rsvp.store');
Route::post('/guestbook', [GuestbookController::class, 'store'])->name('guestbook.store');

// Public Invitation Routes
Route::get('/', [InvitationController::class, 'show'])->name('invitation.home');
Route::get('/{slug}', [InvitationController::class, 'show'])->where('slug', '[a-zA-Z0-9\-_]+')->name('invitation.personal');


