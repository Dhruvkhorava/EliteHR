<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Application;

class RecruitmentJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'department',
        'location',
        'salary_range',
        'description',
        'required_skills',
        'status'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class, 'job_id');
    }
}
