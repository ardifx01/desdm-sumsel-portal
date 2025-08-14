<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate; 

class StaticPageController extends Controller
{
    public function __construct()
    {
        // Menerapkan Policy ke semua method resource controller secara otomatis
        $this->authorizeResource(StaticPage::class, 'static_page');
    }

    public function index()
    {
        $static_pages = StaticPage::orderBy('title')->get();
        return view('admin.static_pages.index', compact('static_pages'));
    }

    public function create()
    {
        return view('admin.static_pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:static_pages,title',
            'content' => 'required|string',
        ]);
        
        // Slug dibuat sekali dan tidak akan berubah
        $validated['slug'] = Str::slug($request->title);
        StaticPage::create($validated);

        return redirect()->route('admin.static-pages.index')
                         ->with('success', 'Halaman statis "' . $validated['title'] . '" berhasil ditambahkan.');
    }

    public function edit(StaticPage $staticPage)
    {
        return view('admin.static_pages.edit', compact('staticPage'));
    }

    public function update(Request $request, StaticPage $staticPage)
    {
        $validated = $request->validate([
            // Judul tidak harus unik terhadap dirinya sendiri saat update
            'title' => 'required|string|max:255|unique:static_pages,title,' . $staticPage->id,
            'content' => 'required|string',
        ]);
        
        // PERBAIKAN: Slug tidak diubah saat update untuk menjaga URL tetap stabil
        // if ($request->title !== $staticPage->title) {
        //     $validated['slug'] = Str::slug($request->title);
        // }

        $staticPage->update($validated);

        return redirect()->route('admin.static-pages.index')
                         ->with('success', 'Halaman statis "' . $staticPage->title . '" berhasil diperbarui.');
    }

    public function destroy(StaticPage $staticPage)
    {
        $pageTitle = $staticPage->title;
        $staticPage->delete();
        return redirect()->route('admin.static-pages.index')
                         ->with('success', 'Halaman statis "' . $pageTitle . '" berhasil dihapus.');
    }
}