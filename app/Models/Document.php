<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category',
        'title',
        'file_path',
        'status',
        'remarks',
    ];

    const CATEGORY_PERSONAL = 'personal';
    const CATEGORY_EDUCATION = 'education';
    const CATEGORY_EMPLOYMENT = 'employment';
    const CATEGORY_PAYROLL = 'payroll';
    const CATEGORY_COMPLIANCE = 'compliance';
    const CATEGORY_LEAVE = 'leave';
    const CATEGORY_PERFORMANCE = 'performance';
    const CATEGORY_POLICY = 'policy';

    public static function getCategories()
    {
        return [
            self::CATEGORY_PERSONAL => 'Employee Personal Documents',
            self::CATEGORY_EDUCATION => 'Education Documents',
            self::CATEGORY_EMPLOYMENT => 'Employment Documents',
            self::CATEGORY_PAYROLL => 'Payroll & Financial Documents',
            self::CATEGORY_COMPLIANCE => 'Compliance & Legal Documents',
            self::CATEGORY_LEAVE => 'Leave & Attendance Documents',
            self::CATEGORY_PERFORMANCE => 'Performance & HR Documents',
            self::CATEGORY_POLICY => 'Company Policy Documents',
        ];
    }

    public static function getCategoryIcons()
    {
        return [
            self::CATEGORY_PERSONAL => 'user',
            self::CATEGORY_EDUCATION => 'book-open',
            self::CATEGORY_EMPLOYMENT => 'briefcase',
            self::CATEGORY_PAYROLL => 'dollar-sign',
            self::CATEGORY_COMPLIANCE => 'shield',
            self::CATEGORY_LEAVE => 'calendar',
            self::CATEGORY_PERFORMANCE => 'trending-up',
            self::CATEGORY_POLICY => 'file-text',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
