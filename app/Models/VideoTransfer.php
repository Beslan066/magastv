<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;


class VideoTransfer extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'preview',
        'video',
        'user_id',
        'transfer_id',
        'deleter_id',
        'views',
        'published_at',
    ];

    protected $dates = ['published_at', 'created_at', 'deleted_at'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function transfer()
    {
        return $this->belongsTo(Transfer::class, 'transfer_id', 'id');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleter_id', 'id');
    }
    public function incrementViews()
    {
        $this->newQuery()->where('id', $this->id)->increment('views');
        Cache::forget("video_views_{$this->id}");

    }

    /**
     * Форматирование даты создания
     * @return string
     */
    public function getFormattedCreatedAtAttribute()
    {
        $date = $this->created_at;

        if (!$date) {
            return null;
        }

        $format = 'd M, H:i'; // Основной формат: "21 мар, 21:34"

        // Если дата не из текущего года, добавляем год
        if ($date->year !== Carbon::now()->year) {
            $format .= ', Y'; // Формат становится "21 мар, 21:34, 2023"
        }

        // Устанавливаем русскую локаль для месяцев
        Carbon::setLocale('ru');

        // Форматируем дату с первым буквой месяца в нижнем регистре
        $formatted = $date->translatedFormat($format);
        $formatted = mb_strtolower(mb_substr($formatted, 0, 1)) . mb_substr($formatted, 1);

        return $formatted;
    }

    /**
     * Форматирование даты удаления
     * @return string
     */
    public function getFormattedDeletedAtAttribute()
    {
        $date = $this->deleted_at;

        if (!$date) {
            return null;
        }

        $format = 'd M, H:i'; // Основной формат: "21 мар, 21:34"

        // Если дата не из текущего года, добавляем год
        if ($date->year !== Carbon::now()->year) {
            $format .= ', Y'; // Формат становится "21 мар, 21:34, 2023"
        }

        // Устанавливаем русскую локаль для месяцев
        Carbon::setLocale('ru');

        // Форматируем дату с первым буквой месяца в нижнем регистре
        $formatted = $date->translatedFormat($format);
        $formatted = mb_strtolower(mb_substr($formatted, 0, 1)) . mb_substr($formatted, 1);

        return $formatted;
    }
}
