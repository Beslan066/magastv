<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    protected $fillable = ['title', 'path', 'type', 'mime_type', 'size'];

    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }
}
