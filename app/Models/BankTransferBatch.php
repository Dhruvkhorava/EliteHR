<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankTransferBatch extends Model
{
    protected $fillable = [
        'batch_no',
        'total_amount',
        'employee_count',
        'bank_name',
        'status',
    ];

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
}
