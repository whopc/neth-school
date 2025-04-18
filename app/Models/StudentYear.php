<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentYear extends Model
{
    Use HasFactory;

    protected $fillable = [
        'student_id',
        'grade_class_section_id',
        'classroom',
        'order_no',
        'notes',
        'registration_discount',
        'registration_discount_type',
        'monthly_discount',
        'monthly_discount_type',
    ];
    protected $casts = [
        'registration_discount' => 'decimal:2',
        'monthly_discount' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function gradeClassSection()
    {
        return $this->belongsTo(GradeClassSection::class);
    }

}
