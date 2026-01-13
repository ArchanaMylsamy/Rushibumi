<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LiveStream extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'thumbnail',
        'stream_key',
        'status',
        'visibility',
        'scheduled_at',
        'started_at',
        'ended_at',
        'viewers_count',
        'peak_viewers',
        'recorded_video',
        'recorded_duration',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(LiveComment::class)->latest();
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeEnded($query)
    {
        return $query->where('status', 'ended');
    }

    public function isLive()
    {
        return $this->status === 'live';
    }

    public function isScheduled()
    {
        return $this->status === 'scheduled';
    }

    public function isEnded()
    {
        return $this->status === 'ended';
    }

    public function canBeWatched()
    {
        // Stream owner can always watch their own stream
        if (auth()->check() && auth()->id() === $this->user_id) {
            return true;
        }

        // Public streams - anyone can watch
        if ($this->visibility === 'public') {
            return true;
        }

        // Unlisted streams - anyone with the link can watch (like YouTube)
        if ($this->visibility === 'unlisted') {
            return true;
        }

        // Private streams - only owner can watch (already handled above)
        if ($this->visibility === 'private') {
            return false;
        }

        return false;
    }

    public static function generateStreamKey()
    {
        do {
            $key = Str::random(32);
        } while (self::where('stream_key', $key)->exists());

        return $key;
    }

    public static function generateSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (self::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}

