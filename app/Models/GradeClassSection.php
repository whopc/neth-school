<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class GradeClassSection extends Model
{


    protected $fillable = [
        'academic_grade_id',
        'class_section_id',
        'main_teacher_id',
    ];

    public function academicGrade() // Singular
    {
        return $this->belongsTo(AcademicGrade::class, 'academic_grade_id');
    }

    public function classSection()
    {
        return $this->belongsTo(ClassSection::class, 'class_section_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'main_teacher_id');
    }

}
