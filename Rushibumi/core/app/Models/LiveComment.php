<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveComment extends Model
{
    protected $fillable = [
        'live_stream_id',
        'user_id',
        'comment',
    ];

    public function liveStream()
    {
        return $this->belongsTo(LiveStream::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

