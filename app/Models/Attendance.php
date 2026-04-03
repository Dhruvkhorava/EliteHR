<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'date', 'check_in', 'check_out', 'status', 'last_latitude', 'last_longitude', 'working_hours', 'overtime', 'notes', 'is_on_break', 'current_break_start', 'total_break_seconds'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function locationLogs()
    {
        return $this->hasMany(AttendanceLocationLog::class);
    }
}
