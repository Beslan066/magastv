<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class VideoTransfer extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'preview',
        'video',
        'user_id',
        'transfer_id',
        'deleter_id',
        'views',
    ];

    protected $dates = ['created_at', 'deleted_at'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transfer()
    {
        return $this->belongsTo(Transfer::class, 'transfer_id', 'id');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleter_id', 'id');
    }
    public function incrementViews()
    {
        $this->newQuery()->where('id', $this->id)->increment('views');
        Cache::forget("video_views_{$this->id}");

    }
}
