<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoFile extends Model {



    protected $hidden = [
        'file'
    ];

    protected $fillable = ['id', 'video_id', 'file_name', 'quality', 'width', 'height', 'bitrate'];


    public function video(){
        return $this->belongsTo(Video::class);
    }

}

