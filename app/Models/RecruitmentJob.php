<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Application;
use Laravel\Scout\Searchable;

class RecruitmentJob extends Model
{
    use HasFactory, Searchable;

    public function toSearchableArray(): array
    {
        return [
            'id' => (int) $this->id,
            'title' => $this->title,
            'department' => $this->department,
        ];
    }

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
