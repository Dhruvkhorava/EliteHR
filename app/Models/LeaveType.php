<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'days_allowed',
        'is_paid',
        'carry_forward',
    ];

    protected $casts = [
        'carry_forward' => 'boolean',
        'is_paid' => 'boolean',
    ];

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }
}
