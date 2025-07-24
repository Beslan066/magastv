<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RadioNews extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'title',
        'slug',
        'lead',
        'content',
        'image',
        'status',
        'user_id',
        'in_air',
        'deleter_id',
        'published_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleter_id', 'id');
    }

    public function getFormattedPublishedAtAttribute()
    {
        if (!$this->published_at) {
            return null;
        }

        $date = Carbon::parse($this->published_at);
        $currentYear = Carbon::now()->year;
        $format = 'd M, H:i'; // 27 мар, 23:53

        // Если год не текущий, добавляем год
        if ($date->year != $currentYear) {
            $format = 'd M Y, H:i'; // 27 мар 2023, 23:53
        }

        // Устанавливаем локаль на русский для корректного отображения месяца
        $currentLocale = app()->getLocale();
        app()->setLocale('ru');
        $formattedDate = $date->translatedFormat($format);
        app()->setLocale($currentLocale);

        return $formattedDate;
    }
}
