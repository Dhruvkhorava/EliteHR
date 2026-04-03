<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'target',
        'deadline',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
