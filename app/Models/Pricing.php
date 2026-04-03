<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pricing extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'price',
        'currency',
        'duration',
        'status',
        'is_featured'
    ];

    protected $casts = [
        'status' => 'boolean',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function features()
    {
        return $this->hasMany(PricingFeature::class);
    }
}
