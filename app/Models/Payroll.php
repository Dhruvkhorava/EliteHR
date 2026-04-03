<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'month',
        'year',
        'basic',
        'hra',
        'allowance',
        'bonus',
        'total_deduction',
        'net_salary',
        'status',
        'bank_transfer_batch_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(PayrollDetail::class);
    }

    public function bankBatch()
    {
        return $this->belongsTo(BankTransferBatch::class, 'bank_transfer_batch_id');
    }

    public function loanRepayments()
    {
        return $this->hasMany(LoanRepayment::class);
    }
}
