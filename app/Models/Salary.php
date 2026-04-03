<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Salary extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'salary_template_id',
        'ctc',
        'basic',
        'hra',
        'allowance',
        'bank_name',
        'account_number',
        'ifsc_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(SalaryTemplate::class, 'salary_template_id');
    }
}
