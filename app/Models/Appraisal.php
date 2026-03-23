<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appraisal extends Model
{
    protected $fillable = [
        'user_id',
        'performance_id',
        'rating',
        'increment_percentage',
        'previous_salary',
        'new_salary',
        'effective_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function performance()
    {
        return $this->belongsTo(Performance::class);
    }
}
