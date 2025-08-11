<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'title', 'description', 'completed', 'due_date'];
    protected $casts = ['due_date' => 'datetime', 'completed' => 'boolean'];
    public function user() {
        return $this->belongsTo(User::class);
    }
}
