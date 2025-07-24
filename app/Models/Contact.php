<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'content',
        'user_id',
        'deleter_id',
        'address',
        'phone',
        'fax',
        'email',
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
