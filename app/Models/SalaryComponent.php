<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryComponent extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'type',
        'is_taxable',
        'is_reimbursement',
        'is_one_time',
        'is_recurring',
        'carry_forward',
        'status',
    ];

    public function templates()
    {
        return $this->belongsToMany(SalaryTemplate::class, 'salary_template_components')
            ->withPivot('amount_type', 'amount_value');
    }
}
