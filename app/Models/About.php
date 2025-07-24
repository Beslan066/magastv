<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'lead',
        'content',
        'image',
        'user_id',
        'deleter_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleter_id', 'id');
    }
}
