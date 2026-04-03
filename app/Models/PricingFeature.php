<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PricingFeature extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'pricing_id',
        'feature_name',
        'status'
    ];

    public function pricing()
    {
        return $this->belongsTo(Pricing::class);
    }
}
