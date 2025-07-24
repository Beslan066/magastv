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
        'radio_show_type_id',
        'deleter_id',
        'published_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function radioShowType()
    {
        return $this->belongsTo(RadioShowType::class, 'radio_show_type_id', 'id');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleter_id', 'id');
    }


}
