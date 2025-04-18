<?php

namespace App\Models;
use App\Models\AcademicLevel;
use App\Models\Grade;
use App\Models\GradeClassSection;
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
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function gradeClassSections()
    {
        return $this->hasMany(GradeClassSection::class , 'academic_grade_id');
    }
    protected function resolveItemLabel(array $state, string $modelClass, string $fieldKey, string $labelField): ?string
    {
        if (isset($state[$fieldKey])) {
            $model = $modelClass::find($state[$fieldKey]);
            return $model ? $model->$labelField : null;
        }
        return null;
    }

}
