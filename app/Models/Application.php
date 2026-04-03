<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RecruitmentJob;
use App\Models\Candidate;
use App\Models\Interview;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'job_id',
        'candidate_id',
        'status',
        'applied_at'
    ];

    protected $casts = [
        'applied_at' => 'datetime'
    ];

    public function job()
    {
        return $this->belongsTo(RecruitmentJob::class, 'job_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }
}
