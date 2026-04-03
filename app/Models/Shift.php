<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'start_time', 'end_time', 'grace_period'])]
class Shift extends Model
{
    use SoftDeletes;
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
