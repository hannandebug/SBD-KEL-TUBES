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
    public function explore($category)
    {
        $groups = Group::where('category', $category)
            ->paginate(12);
        $categories = Group::distinct('category')->pluck('category')->filter()->values();

        return view('category-explore', compact('groups', 'category', 'categories'));
    }
}
