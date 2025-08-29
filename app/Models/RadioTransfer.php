<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadioTransfer extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'lead',
        'image',
        'user_id',
        'radio_show_type_id',
        'deleter_id',
    ];

    protected $dates = ['created_at', 'deleted_at'];

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
