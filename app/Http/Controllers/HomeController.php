<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Event;
use App\Models\Topic;
use App\Models\Review;

class HomeController extends Controller
{
    /**
     * Show the home page with featured groups and events
     */
    public function index()
    {
        // Get featured groups (with highest ratings)
        $featuredGroups = Group::orderBy('average_rating', 'desc')
            ->limit(6)
            ->get();

        // Get upcoming events
        $upcomingEvents = Event::where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->limit(8)
            ->get();

        // Get new groups
        $newGroups = Group::where('is_newgroup', true)
            ->orderBy('id_group', 'desc')
            ->limit(6)
            ->get();

        // Get popular topics
        $popularTopics = Topic::withCount('groups')
            ->orderBy('groups_count', 'desc')
            ->limit(5)
            ->get();

        // Get statistics
        $stats = [
            'total_members' => User::count(),
            'total_groups' => Group::count(),
            'total_events' => Event::count(),
            'total_reviews' => Review::count(),
        ];

        return view('index', compact(
            'featuredGroups',
            'upcomingEvents',
            'newGroups',
            'popularTopics',
            'stats'
        ));
    }

    /**
     * Show groups listing page
     */
    public function groups()
    {
        $groups = Group::paginate(12);
        $topics = Topic::all();

        return view('groups', compact('groups', 'topics'));
    }

    /**
     * Show events listing page
     */
    public function events()
    {
        $events = Event::orderBy('event_date', 'asc')->paginate(12);

        return view('events', compact('events'));
    }

    /**
     * Show reviews listing page
     */
    public function reviews()
    {
        $reviews = Review::with(['member', 'event', 'group'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('reviews', compact('reviews'));
    }
}
