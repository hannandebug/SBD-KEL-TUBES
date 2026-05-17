<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group;
use App\Models\Event;
use App\Models\Topic;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $location = $request->input('location', '');

        $featuredGroups = Group::orderBy('average_rating', 'desc');

        $upcomingEvents = Event::where('event_date', '>=', now())
            ->orderBy('event_date', 'asc');

        if ($location) {
            $featuredGroups->where(function($q) use ($location) {
                $q->where('city', 'like', '%' . $location . '%')
                  ->orWhere('country', 'like', '%' . $location . '%');
            });
            $upcomingEvents->where(function($q) use ($location) {
                $q->where('venue_city', 'like', '%' . $location . '%')
                  ->orWhere('venue_country', 'like', '%' . $location . '%');
            });
        }

        $featuredGroups = $featuredGroups->limit(6)->get();
        $upcomingEvents = $upcomingEvents->limit(8)->get();

        $newGroups = Group::where('is_newgroup', true)
            ->orderBy('id_group', 'desc')
            ->limit(6)
            ->get();

        $popularTopics = Topic::withCount('groups')
            ->orderBy('groups_count', 'desc')
            ->limit(5)
            ->get();

        $stats = [
            'total_members' => User::count(),
            'total_groups' => Group::count(),
            'total_events' => Event::count(),
            'total_reviews' => Review::count(),
        ];

        $categories = Group::distinct('category')->pluck('category')->filter()->values();

        return view('index', compact(
            'featuredGroups',
            'upcomingEvents',
            'newGroups',
            'popularTopics',
            'stats',
            'categories',
            'location'
        ));
    }

    public function reviews()
    {
        $reviews = Review::with(['member', 'event', 'group'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $categories = Group::distinct('category')->pluck('category')->filter()->values();

        return view('reviews', compact('reviews', 'categories'));
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'rating_given' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
            'id_group' => 'nullable|integer',
            'id_event' => 'nullable|integer',
        ]);

        $id = mt_rand(100000000, 999999999);
        while (Review::where('id_review', $id)->exists()) {
            $id = mt_rand(100000000, 999999999);
        }

        Review::create([
            'id_review' => $id,
            'id_member' => Auth::user()->id_member,
            'id_group' => $request->id_group,
            'id_event' => $request->id_event,
            'rating_given' => $request->rating_given,
            'review_text' => $request->review_text,
            'created_at' => now(),
        ]);

        return back()->with('success', 'Review berhasil dikirim!');
    }

    public function profile()
    {
        $user = Auth::user();
        $user->load(['groups', 'events', 'reviews']);
        $categories = Group::distinct('category')->pluck('category')->filter()->values();

        return view('profile', compact('user', 'categories'));
    }

    public function profileById($id)
    {
        $user = User::with(['groups', 'events', 'reviews'])->findOrFail($id);
        $categories = Group::distinct('category')->pluck('category')->filter()->values();

        return view('profile', compact('user', 'categories'));
    }

    public function search(Request $request)
    {
        $q = $request->input('q');
        $location = $request->input('location', '');

        $groups = Group::query();
        $events = Event::query();

        if ($q) {
            $groups->where(function($query) use ($q) {
                $query->where('group_name', 'like', '%' . $q . '%')
                      ->orWhere('group_description', 'like', '%' . $q . '%')
                      ->orWhere('category', 'like', '%' . $q . '%');
            });
            $events->where(function($query) use ($q) {
                $query->where('event_title', 'like', '%' . $q . '%')
                      ->orWhere('event_description', 'like', '%' . $q . '%')
                      ->orWhere('category', 'like', '%' . $q . '%');
            });
        }

        if ($location) {
            $groups->where(function($query) use ($location) {
                $query->where('city', 'like', '%' . $location . '%')
                      ->orWhere('country', 'like', '%' . $location . '%');
            });
            $events->where(function($query) use ($location) {
                $query->where('venue_city', 'like', '%' . $location . '%')
                      ->orWhere('venue_country', 'like', '%' . $location . '%');
            });
        }

        $groups = $groups->orderBy('average_rating', 'desc')->limit(12)->get();
        $events = $events->where('event_date', '>=', now())->orderBy('event_date', 'asc')->limit(12)->get();
        $categories = Group::distinct('category')->pluck('category')->filter()->values();

        return view('search-results', compact('groups', 'events', 'q', 'location', 'categories'));
    }
}
