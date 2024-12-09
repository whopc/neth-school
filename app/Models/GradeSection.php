<?php

namespace App\Models;
use App\Models\AcademicGrade;
use App\Models\Section;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_grade_id',
        'section_id',
        'main_teacher_id',
    ];

    public function academicGrades()
    {
        return $this->belongsTo(AcademicGrade::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function Teacher()
    {
        return $this->belongsTo(Teacher::class, 'main_teacher_id');
    }
}
