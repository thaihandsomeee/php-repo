<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = ['album_id', 'user_id', 'path', 'title'];
    
    public function album() {
        return $this->belongsTo(Album::class); 
    }
    
    public function user() { 
        return $this->belongsTo(User::class); 
    }
    
    public function comments() { 
        return $this->hasMany(Comment::class)->latest(); 
    }
}
