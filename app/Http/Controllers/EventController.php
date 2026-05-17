<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('event_title', 'like', '%' . $search . '%')
                  ->orWhere('event_description', 'like', '%' . $search . '%')
                  ->orWhere('venue_name', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('city')) {
            $query->where('venue_city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('country')) {
            $query->where('venue_country', 'like', '%' . $request->country . '%');
        }

        if ($request->filled('type') && $request->type !== 'all') {
            $query->where('event_type', $request->type);
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->input('filter') === 'joined' && Auth::check()) {
            $joinedIds = Auth::user()->events()->pluck('events.id_event');
            $query->whereIn('id_event', $joinedIds);
        }

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

    public function create()
    {
        $categories = Event::distinct('category')->pluck('category')->filter()->values();
        $groups = Auth::check() ? Auth::user()->groups : collect();
        return view('event-create', compact('categories', 'groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_title' => 'required|string|max:255',
            'event_description' => 'required|string',
            'event_type' => 'required|in:online,in_person',
            'event_date' => 'required|date|after:now',
            'venue_name' => 'required|string|max:255',
            'venue_city' => 'required|string|max:255',
            'venue_country' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'id_group' => 'required|integer|exists:group_list,id_group',
            'event_photo' => 'nullable|url|max:500',
        ]);

        $id = mt_rand(100000000, 999999999);
        while (Event::where('id_event', $id)->exists()) {
            $id = mt_rand(100000000, 999999999);
        }

        $event = Event::create([
            'id_event' => $id,
            'event_title' => $request->event_title,
            'event_description' => $request->event_description,
            'event_type' => $request->event_type,
            'event_date' => $request->event_date,
            'venue_name' => $request->venue_name,
            'venue_city' => $request->venue_city,
            'venue_country' => $request->venue_country,
            'category' => $request->category,
            'id_group' => $request->id_group,
            'event_photo' => $request->event_photo,
            'total_rsvps' => 0,
        ]);

        $event->hosts()->attach(Auth::user()->id_member, [
            'role' => 'organizer',
        ]);

        return redirect()->route('event.detail', $event->id_event)->with('success', 'Event berhasil dibuat!');
    }

    public function show($id)
    {
        $event = Event::with(['group', 'detail', 'attendees', 'hosts'])->findOrFail($id);
        $isAttending = Auth::check() ? $event->attendees()->where('users.id_member', Auth::user()->id_member)->exists() : false;
        $categories = Event::distinct('category')->pluck('category')->filter()->values();
        $reviews = Review::where('id_event', $id)->with('member')->orderBy('created_at', 'desc')->get();

        $isJoinedGroup = false;
        if (Auth::check() && $event->group) {
            $isJoinedGroup = $event->group->members()->where('users.id_member', Auth::user()->id_member)->exists();
        }

        return view('event-detail', compact(
            'event', 'isAttending', 'categories', 'reviews', 'isJoinedGroup'
        ));
    }

    public function rsvp($id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $event = Event::findOrFail($id);
        $user = Auth::user();

        if ($event->attendees()->where('users.id_member', $user->id_member)->exists()) {
            return back()->with('error', 'Anda sudah mendaftar untuk event ini.');
        }

        $event->attendees()->attach($user->id_member, [
            'rsvps_status' => 'going',
        ]);

        $event->increment('total_rsvps');
        $user->increment('member_ev_count');

        return back()->with('success', 'Berhasil mendaftar untuk event!');
    }

    public function cancelRsvp($id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $event = Event::findOrFail($id);
        $user = Auth::user();

        if (!$event->attendees()->where('users.id_member', $user->id_member)->exists()) {
            return back()->with('error', 'Anda belum mendaftar untuk event ini.');
        }

        $event->attendees()->detach($user->id_member);
        $event->decrement('total_rsvps');
        $user->decrement('member_ev_count');

        return back()->with('success', 'Berhasil membatalkan pendaftaran event!');
    }

    public function myEvents()
    {
        $user = Auth::user();
        $events = $user->events()->orderBy('event_attendance.created_at', 'desc')->with('group')->paginate(12);
        $categories = Event::distinct('category')->pluck('category')->filter()->values();

        return view('my-events', compact('events', 'categories'));
    }
}
