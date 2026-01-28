<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Model;

class VideoAd extends Model
{
    protected $fillable = [
        'title',
        'video',
        'thumbnail',
        'url',
        'ad_type',
        'skip_after',
        'status',
        'clicks',
        'impressions',
        'plays',
    ];

    protected $casts = [
        'status' => 'integer',
        'ad_type' => 'integer',
        'skip_after' => 'integer',
        'clicks' => 'integer',
        'impressions' => 'integer',
        'plays' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', Status::ENABLE);
    }

    public function scopePreRoll($query)
    {
        return $query->where('ad_type', 1);
    }

    public function scopeMidRoll($query)
    {
        return $query->where('ad_type', 2);
    }

    public function scopePostRoll($query)
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

    public function incrementPlays()
    {
        $this->increment('plays');
    }
}
