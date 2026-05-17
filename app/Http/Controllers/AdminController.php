<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Note;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalNotes = Note::count();
        $totalCategories = Category::count();
        $recentUsers = User::where('role', 'user')
            ->withCount(['notes', 'categories'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.dashboard', compact('totalUsers', 'totalNotes', 'totalCategories', 'recentUsers'));
    }
}
