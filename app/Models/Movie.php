<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Movie extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'runtime',
        'imdb_rating',
        'published_at',
        'image'
    ];

    public function author() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function getMovieById($id) {
        return Movie::with('author')->where('id', $id)->first();
    } 
}
