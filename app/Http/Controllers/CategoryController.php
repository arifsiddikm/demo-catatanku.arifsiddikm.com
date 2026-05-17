<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);

        // Cek duplikat nama kategori untuk user ini
        $exists = Category::where('user_id', Auth::id())
            ->where('name', $request->name)
            ->exists();

        if ($exists) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Kategori dengan nama ini sudah ada!'], 422);
            }
            return back()->withErrors(['name' => 'Kategori sudah ada.']);
        }

        $category = Category::create([
            'user_id' => Auth::id(),
            'name'    => $request->name,
            'color'   => $request->color ?? '#FBBF24',
            'order'   => Category::where('user_id', Auth::id())->max('order') + 1,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'category' => $category, 'message' => 'Kategori berhasil ditambahkan!']);
        }

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name'  => 'required|string|max:100',
            'color' => 'nullable|string|max:20',
        ]);

        $category->update([
            'name'  => $request->name,
            'color' => $request->color ?? $category->color,
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'category' => $category, 'message' => 'Kategori berhasil diperbarui!']);
        }

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        if ($category->user_id !== Auth::id()) {
            abort(403);
        }

        // Jangan hapus jika hanya 1 kategori tersisa
        $count = Category::where('user_id', Auth::id())->count();
        if ($count <= 1) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Minimal harus ada 1 kategori!'], 422);
            }
            return back()->withErrors(['category' => 'Minimal harus ada 1 kategori.']);
        }

        $category->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus!']);
        }

        return redirect()->route('notes.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
