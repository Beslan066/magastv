<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Добавьте этот use

class AudiobookFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'audio',
        'audiobook_id',
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

    // Добавьте обратное отношение к аудиокниге
    public function audiobook(): BelongsTo
    {
        return $this->belongsTo(Audiobook::class, 'audiobook_id', 'id');
    }
}
