<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function getDataForUser(User $user): array
    {
        $myAlbums = $user->albums()->with('photos')->latest()->get(); 
        $sharedAlbums = $user->sharedAlbums()->with('photos')->latest()->get();

        return [
            'myAlbums' => $myAlbums,
            'sharedAlbums' => $sharedAlbums,
        ];
    }
}