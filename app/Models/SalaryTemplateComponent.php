<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryTemplateComponent extends Model
{
    protected $fillable = [
        'salary_template_id',
        'salary_component_id',
        'amount_type',
        'amount_value',
    ];

    public function template()
    {
        return $this->belongsTo(SalaryTemplate::class);
    }

    public function component()
    {
        return $this->belongsTo(SalaryComponent::class);
    }
}
