<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Show events listing with search and filter
     */
    public function index(Request $request)
    {
        $query = Event::query();

        // Search by event title
        if ($request->filled('search')) {
            $query->where('event_title', 'like', '%' . $request->search . '%')
                  ->orWhere('event_description', 'like', '%' . $request->search . '%')
                  ->orWhere('venue_name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Sort
        $sort = $request->input('sort', 'newest');
        if ($sort === 'popular') {
            $query->orderBy('total_rsvps', 'desc');
        } elseif ($sort === 'oldest') {
            $query->orderBy('event_date', 'asc');
        } else {
            $query->orderBy('event_date', 'asc');
        }

        $events = $query->paginate(12);
        $categories = Event::distinct('category')->pluck('category')->filter()->values();

        return view('events', compact('events', 'categories'));
    }

    /**
     * Show event detail page
     */
    public function show($id)
    {
        $event = Event::with(['group', 'detail', 'attendees'])->findOrFail($id);
        $isAttending = Auth::check() ? $event->attendees()->where('id_member', Auth::user()->id_member)->exists() : false;
        $categories = Event::distinct('category')->pluck('category')->filter()->values();

        return view('event-detail', compact('event', 'isAttending', 'categories'));
    }

    /**
     * RSVP for an event
     */
    public function rsvp($id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $event = Event::findOrFail($id);
        $user = Auth::user();

        // Check if already attending
        if ($event->attendees()->where('id_member', $user->id_member)->exists()) {
            return back()->with('error', 'Anda sudah mendaftar untuk event ini.');
        }

        // Add attendee to event
        $event->attendees()->attach($user->id_member, [
            'rsvps_status' => 'going',
        ]);

        // Update RSVP count
        $event->increment('total_rsvps');
        $user->increment('member_ev_count');

        return back()->with('success', 'Berhasil mendaftar untuk event!');
    }

    /**
     * Cancel RSVP for an event
     */
    public function cancelRsvp($id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $event = Event::findOrFail($id);
        $user = Auth::user();

        // Check if attending
        if (!$event->attendees()->where('id_member', $user->id_member)->exists()) {
            return back()->with('error', 'Anda belum mendaftar untuk event ini.');
        }

        // Remove attendee from event
        $event->attendees()->detach($user->id_member);

        // Update RSVP count
        $event->decrement('total_rsvps');
        $user->decrement('member_ev_count');

        return back()->with('success', 'Berhasil membatalkan pendaftaran event!');
    }
}
