<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryTemplate extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'description',
        'status',
    ];

    public function components()
    {
        return $this->belongsToMany(SalaryComponent::class, 'salary_template_components')
            ->withPivot('amount_type', 'amount_value');
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }
}
