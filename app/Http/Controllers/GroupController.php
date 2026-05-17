<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Topic;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    public function index(Request $request)
    {
        $query = Group::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('group_name', 'like', '%' . $search . '%')
                  ->orWhere('group_description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('country')) {
            $query->where('country', 'like', '%' . $request->country . '%');
        }

        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        if ($request->input('filter') === 'joined' && Auth::check()) {
            $joinedIds = Auth::user()->groups()->pluck('groups.id_group');
            $query->whereIn('id_group', $joinedIds);
        }

        $sort = $request->input('sort', 'newest');
        if ($sort === 'popular') {
            $query->orderBy('member_count', 'desc');
        } elseif ($sort === 'rating') {
            $query->orderBy('average_rating', 'desc');
        } else {
            $query->orderBy('id_group', 'desc');
        }

        $groups = $query->paginate(12);
        $topics = Topic::all();
        $categories = Group::distinct('category')->pluck('category')->filter()->values();

        return view('groups', compact('groups', 'topics', 'categories'));
    }

    public function create()
    {
        $categories = Group::distinct('category')->pluck('category')->filter()->values();
        return view('group-create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_name' => 'required|string|max:255',
            'group_description' => 'required|string',
            'category' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'group_photo' => 'nullable|url|max:500',
        ]);

        $id = mt_rand(100000000, 999999999);
        while (Group::where('id_group', $id)->exists()) {
            $id = mt_rand(100000000, 999999999);
        }

        $group = Group::create([
            'id_group' => $id,
            'group_name' => $request->group_name,
            'group_description' => $request->group_description,
            'category' => $request->category,
            'city' => $request->city,
            'country' => $request->country,
            'group_photo' => $request->group_photo,
            'member_count' => 1,
            'average_rating' => 0,
            'is_newgroup' => true,
        ]);

        $group->members()->attach(Auth::user()->id_member, [
            'role' => 'organizer',
            'joined_at' => now(),
        ]);

        Auth::user()->increment('member_gr_count');

        return redirect()->route('group.detail', $group->id_group)->with('success', 'Grup berhasil dibuat!');
    }

    public function show($id)
    {
        $group = Group::with(['members', 'topics', 'events', 'reviews', 'detail'])->findOrFail($id);
        $isJoined = Auth::check() ? $group->members()->where('users.id_member', Auth::user()->id_member)->exists() : false;
        $categories = Group::distinct('category')->pluck('category')->filter()->values();

        $organizer = $group->members()->wherePivot('role', 'organizer')->first();
        $coOrganizers = $group->members()->wherePivot('role', 'co-organizer')->get();
        $eventOrganizers = $group->members()->wherePivot('role', 'event_organizer')->get();
        $members = $group->members()->wherePivot('role', 'member')->get();

        $albumPhotos = [];
        if ($group->detail && $group->detail->photo_album) {
            $albumPhotos = json_decode($group->detail->photo_album, true) ?? [];
        }

        $reviews = Review::where('id_group', $id)->with('member')->orderBy('created_at', 'desc')->get();

        return view('group-detail', compact(
            'group', 'isJoined', 'categories',
            'organizer', 'coOrganizers', 'eventOrganizers', 'members',
            'albumPhotos', 'reviews'
        ));
    }

    public function album($id)
    {
        $group = Group::with('detail')->findOrFail($id);
        $albumPhotos = [];
        if ($group->detail && $group->detail->photo_album) {
            $albumPhotos = json_decode($group->detail->photo_album, true) ?? [];
        }
        return view('group-album', compact('group', 'albumPhotos'));
    }

    public function searchByTopic($topic)
    {
        $topicModel = Topic::where('topic_name', $topic)->first();
        if (!$topicModel) {
            return redirect()->route('groups')->with('error', 'Topic not found.');
        }
        $groups = $topicModel->groups()->paginate(12);
        $topics = Topic::all();
        $categories = Group::distinct('category')->pluck('category')->filter()->values();

        return view('groups', compact('groups', 'topics', 'categories'));
    }

    public function join($id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $group = Group::findOrFail($id);
        $user = Auth::user();

        if ($group->members()->where('users.id_member', $user->id_member)->exists()) {
            return back()->with('error', 'Anda sudah bergabung dengan grup ini.');
        }

        $group->members()->attach($user->id_member, [
            'role' => 'member',
            'joined_at' => now(),
        ]);

        $group->increment('member_count');
        $user->increment('member_gr_count');

        return back()->with('success', 'Berhasil bergabung dengan grup!');
    }

    public function leave($id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $group = Group::findOrFail($id);
        $user = Auth::user();

        if (!$group->members()->where('users.id_member', $user->id_member)->exists()) {
            return back()->with('error', 'Anda bukan anggota dari grup ini.');
        }

        $group->members()->detach($user->id_member);
        $group->decrement('member_count');
        $user->decrement('member_gr_count');

        return back()->with('success', 'Berhasil keluar dari grup!');
    }

    public function myGroups()
    {
        $user = Auth::user();
        $groups = $user->groups()->orderBy('member_group.joined_at', 'desc')->paginate(12);
        $categories = Group::distinct('category')->pluck('category')->filter()->values();
        $topics = Topic::all();

        return view('my-groups', compact('groups', 'categories', 'topics'));
    }
}
