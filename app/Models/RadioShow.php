<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RadioShow extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'time_range',
        'program_date',
        'image',
        'description',
        'user_id',
        'radio_show_type_id',
    ];

    protected $casts = [
        'program_date' => 'date:Y-m-d',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function radioShowType() {
        return $this->belongsTo(RadioShowType::class);
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
