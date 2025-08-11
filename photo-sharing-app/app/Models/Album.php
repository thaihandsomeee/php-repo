<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description'];

    public function user() { 
        return $this->belongsTo(User::class); 
    }
    
    public function photos() { 
        return $this->hasMany(Photo::class); 
    }
    
    public function sharedWithUsers() { 
        return $this->belongsToMany(User::class, 'album_user', 'album_id', 'user_id'); 
    }
}
