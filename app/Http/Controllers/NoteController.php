<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $categories = $user->categories()->orderBy('order')->orderBy('name')->get();

        $categoryId = $request->query('category');
        $search = $request->query('search');

        // Default ke kategori pertama jika tidak ada
        if (!$categoryId && $categories->isNotEmpty()) {
            $categoryId = $categories->first()->id;
        }

        $activeCategory = $categories->firstWhere('id', $categoryId);

        $query = Note::where('user_id', $user->id)
            ->where('is_archived', false);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $sort = $request->query('sort', 'desc');
        $sortBy = $request->query('sort_by', 'created_at');
        $query->orderBy('is_pinned', 'desc')->orderBy($sortBy, $sort);

        $notes = $query->get();

        $layout = $request->query('layout', 'masonry');

        return view('notes.index', compact('categories', 'notes', 'activeCategory', 'search', 'sort', 'sortBy', 'layout', 'categoryId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'color'       => 'nullable|string|max:20',
        ]);

        // Pastikan category milik user
        $category = Category::where('id', $request->category_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $note = Note::create([
            'user_id'     => Auth::id(),
            'category_id' => $category->id,
            'title'       => $request->title,
            'description' => $request->description,
            'color'       => $request->color ?? '#FBBF24',
            'is_pinned'   => false,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'note'    => $note->load('category'),
                'message' => 'Catatan berhasil ditambahkan!',
            ]);
        }

        return redirect()->route('notes.index', ['category' => $category->id])
            ->with('success', 'Catatan berhasil ditambahkan!');
    }

    public function update(Request $request, Note $note)
    {
        // Pastikan note milik user
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'color'       => 'nullable|string|max:20',
        ]);

        $note->update([
            'title'       => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'color'       => $request->color ?? $note->color,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'note'    => $note->fresh()->load('category'),
                'message' => 'Catatan berhasil diperbarui!',
            ]);
        }

        return redirect()->back()->with('success', 'Catatan berhasil diperbarui!');
    }

    public function destroy(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $note->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Catatan berhasil dihapus!']);
        }

        return redirect()->back()->with('success', 'Catatan berhasil dihapus!');
    }

    public function togglePin(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            abort(403);
        }

        $note->update(['is_pinned' => !$note->is_pinned]);

        return response()->json([
            'success'   => true,
            'is_pinned' => $note->is_pinned,
            'message'   => $note->is_pinned ? 'Catatan disematkan!' : 'Sematkan dibatalkan!',
        ]);
    }

    public function getNotes(Request $request)
    {
        $user = Auth::user();
        $categoryId = $request->query('category');
        $search = $request->query('search');
        $sort = $request->query('sort', 'desc');
        $sortBy = $request->query('sort_by', 'created_at');

        $query = Note::where('user_id', $user->id)->where('is_archived', false);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $query->orderBy('is_pinned', 'desc')->orderBy($sortBy, $sort);
        $notes = $query->get();

        return response()->json(['success' => true, 'notes' => $notes->load('category')]);
    }
}
