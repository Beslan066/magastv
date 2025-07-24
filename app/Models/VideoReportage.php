<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VideoReportage extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'lead',
        'content',
        'preview',
        'video',
        'status',
        'user_id',
        'category_id',
        'deleter_id',
        'published_at',
        'main_material',
        'views'
    ];

    protected $dates = ['published_at', 'deleted_at'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleter_id', 'id');
    }

    public function incrementViews()
    {
        $this->timestamps = false;
        $this->increment('views');
        $this->timestamps = true;
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
