<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        return view('admin.pengumuman.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'is_published' => 'boolean'
        ]);

        Announcement::create([
            'judul' => $request->judul,
            'konten' => $request->konten,
            'is_published' => $request->has('is_published') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function destroy($id)
    {
        Announcement::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}