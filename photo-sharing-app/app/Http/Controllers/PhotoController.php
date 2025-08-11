<?php

namespace App\Http\Controllers;
use App\Models\Album;
use App\Models\Photo;
use App\Services\PhotoService;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    protected $photoService;

    public function __construct(PhotoService $photoService) { 
        $this->photoService = $photoService; 
    }

    public function show(Photo $photo) {
        $this->authorize('view-photo', $photo);
        $photo->load('comments.user');
        return view('photos.show', compact('photo'));
    }

    public function store(Request $request, Album $album) {
        $this->authorize('manage-album', $album);
        $data = $request->validate(['photo' => 'required|image|max:10240', 'title' => 'nullable|string|max:255']);
        $this->photoService->store($request->file('photo'), $album, $data);
        return back()->with('success', 'Photo uploaded!');
    }

    public function destroy(Photo $photo) {
        $this->authorize('manage-photo', $photo);
        $album = $photo->album;
        $this->photoService->delete($photo);
        return redirect()->route('albums.show', $album)->with('success', 'Photo deleted!');
    }
}
