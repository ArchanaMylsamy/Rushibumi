<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoTag extends Model
{
    protected $fillable = ['video_id', 'tag', 'subject'];
    
    public function video()
    {
        return $this->belongsTo(Video::class);
    }
}
