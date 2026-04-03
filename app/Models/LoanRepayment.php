<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanRepayment extends Model
{
    protected $fillable = [
        'loan_id',
        'payroll_id',
        'amount',
        'payment_date',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
