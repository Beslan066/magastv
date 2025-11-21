<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany; // Добавьте этот use

class Audiobook extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'slug',
        'lead',
        'image',
        'author_id',
        'user_id',
        'deleter_id',
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

    // Добавьте это отношение
    public function files(): HasMany
    {
        return $this->hasMany(AudiobookFile::class, 'audiobook_id', 'id');
    }
}
