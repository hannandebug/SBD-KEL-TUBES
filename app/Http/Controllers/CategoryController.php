<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Topic;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Show groups by category
     */
    public function explore(Request $request, $category)
    {
        $query = Group::where('category', $category);

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('group_name', 'like', '%' . $request->search . '%')
                  ->orWhere('group_description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        if ($request->filled('country')) {
            $query->where('country', 'like', '%' . $request->country . '%');
        }

        $groups = $query->paginate(12);
        $categories = Group::distinct('category')->pluck('category')->filter()->values();

        return view('category-explore', compact('groups', 'category', 'categories'));
    }
}
