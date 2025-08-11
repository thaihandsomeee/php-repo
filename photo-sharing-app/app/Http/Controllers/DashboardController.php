<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $user = Auth::user();
        $myAlbums = $user->albums()->latest()->get();
        $sharedAlbums = $user->sharedAlbums()->latest()->get();
        return view('dashboard', compact('myAlbums', 'sharedAlbums'));
    }
}
