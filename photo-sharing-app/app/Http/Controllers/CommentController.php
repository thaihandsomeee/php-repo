<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Request $request, Photo $photo) {
        $this->authorize('view-photo', $photo);
        $data = $request->validate(['body' => 'required|string']);
        $photo->comments()->create(['user_id' => auth()->id(), 'body' => $data['body']]);
        return back()->with('success', 'Comment posted!');
    }
    
    public function destroy(Comment $comment) {
        $this->authorize('manage-comment', $comment);
        $comment->delete();
        return back()->with('success', 'Comment deleted!');
    }
}
