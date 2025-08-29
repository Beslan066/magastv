<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RadioBroadcast extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'title',
        'slug',
        'lead',
        'content',
        'image',
        'status',
        'audio',
        'user_id',
        'radio_transfer_id',
        'deleter_id',
        'published_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transfer()
    {
        return $this->belongsTo(RadioTransfer::class, 'radio_transfer_id', 'id');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleter_id', 'id');
    }


}
