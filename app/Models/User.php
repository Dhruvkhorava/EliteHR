<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Added for Candidate and RecruitmentJob
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Scout\Searchable; // Added for Searchable trait
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['name', 'first_name', 'last_name', 'date_of_birth', 'gender', 'profile_image', 'address', 'city', 'state', 'country', 'pincode', 'email', 'pan_number', 'uan_number', 'esi_number', 'password', 'image', 'status', 'shift_id', 'designation_id', 'manager_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles, Searchable, SoftDeletes; // Added Searchable

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function leaveBalances()
    {
        return $this->hasMany(LeaveBalance::class);
    }

    public function salary()
    {
        return $this->hasOne(Salary::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function performances()
    {
        return $this->hasMany(Performance::class);
    }

    public function appraisals()
    {
        return $this->hasMany(Appraisal::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function loginHistories()
    {
        return $this->hasMany(LoginHistory::class);
    }
}
