<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Candidate extends Model
{
    use HasFactory, Searchable;

    public function toSearchableArray(): array
    {
        return [
            'id' => (int) $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    protected $fillable = [
        'name',
        'email',
        'phone',
        'resume',
        'experience',
        'skills'
    ];

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
