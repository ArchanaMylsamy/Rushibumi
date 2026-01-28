<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;

class FeedAd extends Model
{
    protected $fillable = [
        'title',
        'image',
        'video',
        'url',
        'ad_type',
        'position',
        'status',
        'priority',
        'clicks',
        'impressions',
    ];

    protected $casts = [
        'status' => 'integer',
        'ad_type' => 'integer',
        'position' => 'integer',
        'priority' => 'integer',
        'clicks' => 'integer',
        'impressions' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', Status::ENABLE);
    }

    public function scopeFeed($query)
    {
        return $query->where('position', 1);
    }

    public function scopeTop($query)
    {
        return $query->where('position', 2);
    }

    public function scopeImage($query)
    {
        return $query->where('ad_type', 1);
    }

    public function scopeGif($query)
    {
        return $query->where('ad_type', 2);
    }

    public function scopeVideo($query)
    {
        return $query->where('ad_type', 3);
    }

    public function incrementClicks()
    {
        $this->increment('clicks');
    }

    public function incrementImpressions()
    {
        $this->increment('impressions');
    }
}
