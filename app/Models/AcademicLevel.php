<?php

namespace App\Models;

use App\Models\AcademicGrade;
use App\Models\Level;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AcademicLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_id',
        'level_id',
        'admission_fees',
        'materials_fees',
        'cuota',
    ];
    protected $casts = [
        'cuota' => 'boolean',
    ];

    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    public function academicGrades()
    {
        return $this->hasMany(AcademicGrade::class , 'academic_level_id');
    }
    public function grades()
    {
        return $this->hasManyThrough(
            Grade::class,               // Modelo final (Grade)
            AcademicGrade::class,       // Modelo intermedio (AcademicGrade)
            'academic_level_id',        // Clave foránea en AcademicGrade que apunta a AcademicLevel
            'id',                       // Clave foránea en Grade
            'id',                       // Clave primaria en AcademicLevel
            'grade_id'                  // Clave primaria en AcademicGrade que apunta a Grade
        );
    }



}
