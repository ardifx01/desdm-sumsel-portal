<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StaticPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $static_pages = StaticPage::orderBy('title')->get();
        return view('admin.static_pages.index', compact('static_pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.static_pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        
        $validated['slug'] = Str::slug($request->title);
        StaticPage::create($validated);

        return redirect()->route('admin.static-pages.index')
                         ->with('success', 'Halaman statis berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StaticPage $staticPage)
    {
        return view('admin.static_pages.edit', compact('staticPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StaticPage $staticPage)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);
        
        if ($request->title !== $staticPage->title) {
            $validated['slug'] = Str::slug($request->title);
        }

        $staticPage->update($validated);

        return redirect()->route('admin.static-pages.index')
                         ->with('success', 'Halaman statis berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StaticPage $staticPage)
    {
        $staticPage->delete();
        return redirect()->route('admin.static-pages.index')
                         ->with('success', 'Halaman statis berhasil dihapus.');
    }
}