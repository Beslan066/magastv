<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Audiobook extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'slug',
        'lead',
        'image',
        'audio',
        'author_id',
        'user_id',
        'deleter_id',
        'image_author',
        'image_description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id', 'id');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleter_id', 'id');
    }
}
