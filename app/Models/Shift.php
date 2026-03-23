<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name', 'start_time', 'end_time', 'grace_period'])]
class Shift extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
