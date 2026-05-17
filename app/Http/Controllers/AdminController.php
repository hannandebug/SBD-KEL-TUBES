<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Event;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $limit = max(1, (int)$request->input('limit', 5));

        $allowedMemberSorts = ['member_gr_count', 'member_ev_count', 'member_name'];
        $sortMembers = in_array($request->input('sort_members'), $allowedMemberSorts) ? $request->input('sort_members') : 'member_gr_count';

        $allowedGroupSorts = ['average_rating', 'member_count', 'group_name'];
        $sortRated = in_array($request->input('sort_rated'), $allowedGroupSorts) ? $request->input('sort_rated') : 'average_rating';
        $sortMost = in_array($request->input('sort_most'), $allowedGroupSorts) ? $request->input('sort_most') : 'member_count';

        $topMembers = User::orderBy($sortMembers, $sortMembers === 'member_name' ? 'asc' : 'desc')->limit($limit)->get();
        $topRated = Group::orderBy($sortRated, $sortRated === 'group_name' ? 'asc' : 'desc')->limit($limit)->get();
        $mostMembers = Group::orderBy($sortMost, $sortMost === 'group_name' ? 'asc' : 'desc')->limit($limit)->get();
        $groups = Group::orderBy('id_group', 'desc')->paginate(10);
        $events = Event::orderBy('event_date', 'desc')->paginate(10);
        $stats = [
            'total_members' => User::count(),
            'total_groups' => Group::count(),
            'total_events' => Event::count(),
            'total_reviews' => Review::count(),
        ];

        return view('admin', compact('topMembers', 'topRated', 'mostMembers', 'groups', 'events', 'stats', 'limit', 'sortMembers', 'sortRated', 'sortMost'));
    }

    public function updateGroup(Request $request, $id)
    {
        $group = Group::findOrFail($id);
        $group->update($request->only(['group_name', 'group_description', 'group_photo', 'category', 'city', 'country']));
        return back()->with('success', 'Group updated successfully.');
    }

    public function updateEvent(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        $event->update($request->only(['event_title', 'event_description', 'event_type', 'event_date', 'venue_name', 'venue_city', 'venue_country', 'event_photo']));
        return back()->with('success', 'Event updated successfully.');
    }

    public function deleteGroup($id)
    {
        Group::findOrFail($id)->delete();
        return back()->with('success', 'Group deleted.');
    }

    public function deleteEvent($id)
    {
        Event::findOrFail($id)->delete();
        return back()->with('success', 'Event deleted.');
    }
}
