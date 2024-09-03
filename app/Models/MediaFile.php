<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaFile extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'file_name', 'file_path', 'file_type'];

    /**
     * Get the post that the media file belongs to.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
