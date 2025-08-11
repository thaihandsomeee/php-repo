<?php

namespace App\Http\Controllers;
use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index() { 
        return redirect()->route('dashboard'); 
    }

    public function create() { 
        return view('albums.create'); 
    }

    public function store(Request $request) {
        $data = $request->validate(['title' => 'required|string|max:255', 'description' => 'nullable|string']);
        auth()->user()->albums()->create($data);
        return redirect()->route('dashboard')->with('success', 'Album created successfully!');
    }

    public function show(Album $album) {
        $this->authorize('view-album', $album);
        $album->load('photos.user');
        return view('albums.show', compact('album'));
    }

    public function edit(Album $album) {
        $this->authorize('manage-album', $album);
        return view('albums.edit', compact('album'));
    }

    public function update(Request $request, Album $album) {
        $this->authorize('manage-album', $album);
        $data = $request->validate(['title' => 'required|string|max:255', 'description' => 'nullable|string']);
        $album->update($data);
        return redirect()->route('albums.show', $album)->with('success', 'Album updated successfully!');
    }

    public function destroy(Album $album) {
        $this->authorize('manage-album', $album);
        // Logic xóa ảnh trong album...
        $album->delete();
        return redirect()->route('dashboard')->with('success', 'Album deleted successfully!');
    }

    public function share(Album $album) {
        $this->authorize('manage-album', $album);
        $users = User::where('id', '!=', auth()->id())->get();
        $sharedUsers = $album->sharedWithUsers()->pluck('users.id')->all();
        return view('albums.share', compact('album', 'users', 'sharedUsers'));
    }

    public function storeShare(Request $request, Album $album) {
        $this->authorize('manage-album', $album);
        $data = $request->validate(['users' => 'nullable|array']);
        $album->sharedWithUsers()->sync($data['users'] ?? []);
        return redirect()->route('albums.show', $album)->with('success', 'Sharing settings updated!');
    }
}
