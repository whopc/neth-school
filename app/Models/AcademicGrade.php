<?php

namespace App\Models;
use App\Models\AcademicLevel;
use App\Models\Grade;
use App\Models\GradeSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_level_id',
        'grade_id',
        'fee_cuota',
        'platform',
    ];

    public function academicLevel()
    {
        return $this->belongsTo(AcademicLevel::class);
    }

    public function grade()
    {
        return $this->belongsTo(\App\Models\Grade::class);
    }

    public function gradeSections()
    {
        return $this->hasMany(GradeSection::class , 'academic_grade_id');
    }

}
