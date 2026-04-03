<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['attendance_id', 'latitude', 'longitude', 'recorded_at'])]
class AttendanceLocationLog extends Model
{
    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}
