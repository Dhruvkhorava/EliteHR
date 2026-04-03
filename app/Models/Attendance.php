<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['user_id', 'date', 'check_in', 'check_out', 'status', 'working_hours', 'overtime', 'notes', 'is_on_break', 'current_break_start', 'total_break_seconds'])]
class Attendance extends Model
{
    use SoftDeletes;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
