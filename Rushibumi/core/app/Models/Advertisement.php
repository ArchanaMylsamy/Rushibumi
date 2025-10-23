<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model {

    public function categories() {
        return $this->belongsToMany(Category::class);
    }


    public function storage(){
        return $this->belongsTo(Storage::class);
    }
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function advertisementAnalytics() {
        return $this->hasMany(AdvertisementAnalytics::class);
    }

    public function scopePending($query) {

        return $query->where('status', Status::ADVERTISEMENT_PENDING);
    }

    public function scopeRunning($query) {
        return $query->where('status', Status::RUNNING);
    }

    public function scopeStop($query) {
        return $query->where('status', Status::PAUSE);
    }

    public function scopeImpression($query) {
        return $query->where('ad_type', Status::IMPRESSION);
    }

    public function scopeClick($query) {
        return $query->where('ad_type', Status::CLICK);
    }

    public function scopeBoth($query) {
        return $query->where('ad_type', Status::BOTH);
    }

    public function statusBadge(): Attribute {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::RUNNING) {
                $html = '<span class="badge badge--success">' . trans('Running') . '</span>';
            } else if ($this->status == Status::PAUSE) {
                $html = '<span class="badge badge--danger">' . trans('Pause') . '</span>';
            } 
            
            return $html;
        });
    }

    public function paymentStatusBadge(): Attribute {
        return new Attribute(function () {
            $html = '';
         if ($this->payment_status == Status::PAYMENT_INITIATE){
                $html = '<span class="badge badge--dark">' . trans('Initiated') . '</span>';
            }else if($this->payment_status == Status::PAYMENT_PENDING){
                $html = '<span class="badge badge--warning">' . trans('Pending') . '</span>';
            }else if($this->payment_status == Status::PAYMENT_REJECT){
                $html = '<span class="badge badge--danger">' . trans('Reject') . '</span>';
            }  else if ($this->payment_status == Status::PAYMENT_SUCCESS){
                $html = '<span class="badge badge--success">' . trans('Success') . '</span>';
            }
            

            
            return $html;
        });
    }

    public function adTypeBadge(): Attribute {
        return new Attribute(function () {
            $html = '';
            if ($this->ad_type == Status::IMPRESSION) {
                $html = '<span class="badge badge--success">' . trans('Impression') . '</span>';
            } else if ($this->ad_type == Status::CLICK) {
                $html = '<span class="badge badge--dark">' . trans('Click') . '</span>';
            } else {
                $html = '<span class="badge badge--warning">' . trans('Both') . '</span>';
            }
            return $html;
        });
    }

}
