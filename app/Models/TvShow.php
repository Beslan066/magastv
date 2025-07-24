<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TvShow extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'time_range',
        'program_date',
        'image',
        'description',
        'user_id',
        'tv_show_type_id',
        'age_restriction',
        'top_show',
    ];

    protected $casts = [
        'program_date' => 'date:Y-m-d',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tvShowType()
    {
        return $this->belongsTo(TvShowType::class);
    }

    // Получаем только время (часы:минуты)
    public function getTimeAttribute()
    {
        return \Carbon\Carbon::parse($this->time_range)->format('H:i');
    }

    // Получаем полную дату и время
    public function getDateTimeAttribute()
    {
        return $this->program_date->format('Y-m-d') . ' ' . $this->time;
    }

    public function getStartTimeAttribute()
    {
        [$start, $end] = explode('-', $this->time_range);
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i', $this->program_date->format('Y-m-d') . ' ' . trim($start));
    }

    public function getEndTimeAttribute()
    {
        [$start, $end] = explode('-', $this->time_range);
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i', $this->program_date->format('Y-m-d') . ' ' . trim($end));
    }

    public function getIsActiveAttribute()
    {
        $now = \Carbon\Carbon::now();
        return $now->between($this->start_time, $this->end_time);
    }

    public function getIsPastAttribute()
    {
        return \Carbon\Carbon::now()->gt($this->end_time);
    }

}
