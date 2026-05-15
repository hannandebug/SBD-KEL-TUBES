<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Show groups listing with search and filter
     */
    public function index(Request $request)
    {
        $query = Group::query();

        // Search by group name
        if ($request->filled('search')) {
            $query->where('group_name', 'like', '%' . $request->search . '%')
                  ->orWhere('group_description', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }

        // Sort
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

    /**
     * Show group detail page
     */
    public function show($id)
    {
        $group = Group::with(['members', 'topics', 'events'])->findOrFail($id);
        $isJoined = Auth::check() ? $group->members()->where('id_member', Auth::user()->id_member)->exists() : false;
        $categories = Group::distinct('category')->pluck('category')->filter()->values();

        return view('group-detail', compact('group', 'isJoined', 'categories'));
    }

    /**
     * Join a group
     */
    public function join($id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $group = Group::findOrFail($id);
        $user = Auth::user();

        // Check if already member
        if ($group->members()->where('id_member', $user->id_member)->exists()) {
            return back()->with('error', 'Anda sudah bergabung dengan grup ini.');
        }

        // Add member to group
        $group->members()->attach($user->id_member, [
            'role' => 'member',
            'joined_at' => now(),
        ]);

        // Update member count
        $group->increment('member_count');
        $user->increment('member_gr_count');

        return back()->with('success', 'Berhasil bergabung dengan grup!');
    }

    /**
     * Leave a group
     */
    public function leave($id)
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        $group = Group::findOrFail($id);
        $user = Auth::user();

        // Check if member
        if (!$group->members()->where('id_member', $user->id_member)->exists()) {
            return back()->with('error', 'Anda bukan anggota dari grup ini.');
        }

        // Remove member from group
        $group->members()->detach($user->id_member);

        // Update member count
        $group->decrement('member_count');
        $user->decrement('member_gr_count');

        return back()->with('success', 'Berhasil keluar dari grup!');
    }
}
