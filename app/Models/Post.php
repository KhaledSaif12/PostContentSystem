<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'content', 'category_id', 'user_id'];

    /**
     * Get the category that the post belongs to.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the media files associated with the post.
     */
    public function mediaFiles()
    {
        return $this->hasMany(MediaFile::class);
    }

    /**
     * Get the user who created the post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
