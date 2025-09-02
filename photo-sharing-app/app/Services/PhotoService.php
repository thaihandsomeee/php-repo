<?php
namespace App\Services;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
class PhotoService {

    public function store(UploadedFile $file, Album $album, array $data): Photo {
        $path = $file->store('photos');

        return $album->photos()->create([
            'user_id' => auth()->id(),
            'path' => $path,
            'title' => $data['title'] ?? null,
        ]);
    }
    
    public function delete(Photo $photo): void {
        Storage::delete($photo->path);
        $photo->delete();
    }
}