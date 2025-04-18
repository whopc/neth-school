<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class AcademicYear extends Model
{
    use  HasRelationships;


    protected $fillable = [
        'name',
        'is_registration_active',
        'short_name',
        'start_date',
        'end_date',
        'status',
    ];
    protected $casts = [
        'status' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];


    public function academicLevels()
    {
        return $this->hasMany(AcademicLevel::class, 'academic_year_id');
    }
    public function academicGrades()
    {
        return $this->hasManyThrough(
            AcademicGrade::class,    // Modelo final
            AcademicLevel::class,    // Modelo intermedio
            'academic_year_id',      // Clave foránea en AcademicLevel
            'academic_level_id',     // Clave foránea en AcademicGrade
            'id',                    // Clave primaria en AcademicYear
            'id'                     // Clave primaria en AcademicLevel
        );
    }


    public function levels()
    {
        return $this->hasManyThrough(Level::class, AcademicLevel::class, 'academic_year_id', 'id', 'id', 'level_id');
    }
    public function grades()
    {
        return $this->hasManyThrough(
            AcademicGrade::class, // Modelo final al que queremos acceder
            AcademicLevel::class, // Modelo intermedio
            'academic_year_id', // Foreign key en AcademicLevel que referencia a AcademicYear
            'academic_level_id', // Foreign key en AcademicGrade que referencia a AcademicLevel
            'id', // Primary key en AcademicYear
            'id' // Primary key en AcademicLevel
        );
    }
    public function gradeClassSections()
    {
        return $this->hasManyDeep(
            GradeClassSection::class,
            [AcademicLevel::class, AcademicGrade::class],
            [
                'academic_year_id',   // FK en AcademicLevel que referencia a AcademicYear
                'academic_level_id',  // FK en AcademicGrade que referencia a AcademicLevel
                'academic_grade_id',  // FK en GradeClassSection que referencia a AcademicGrade
            ],
            [
                'id',                 // PK en AcademicYear
                'id',                 // PK en AcademicLevel
                'id',                 // PK en AcademicGrade
            ]
        );
    }


    // Redefine la relación sections usando hasManyDeep

//    public function classSections()
//    {
//        return $this->hasManyDeep(
//            ClassSection::class,
//            [AcademicLevel::class, AcademicGrade::class, GradeClassSection::class],
//            [
//                'academic_year_id',   // FK en AcademicLevel que referencia a AcademicYear
//                'academic_level_id',  // FK en AcademicGrade que referencia a AcademicLevel
//                'academic_grade_id',  // FK en GradeClassSection que referencia a AcademicGrade
//                'class_section_id'    // FK en GradeClassSection que referencia a ClassSection
//            ],
//            [
//                'id',                 // PK en AcademicYear
//                'id',                 // PK en AcademicLevel
//                'id',                 // PK en AcademicGrade
//                'id'                  // PK en ClassSection
//            ]
//        )->distinct();
//
//
//
//}
//    public function getClassSectionsAttribute()
//    {
//        return ClassSection::select('class_sections.*')
//            ->join('grade_class_sections', 'class_sections.id', '=', 'grade_class_sections.class_section_id')
//            ->join('academic_grades', 'grade_class_sections.academic_grade_id', '=', 'academic_grades.id')
//            ->join('academic_levels', 'academic_grades.academic_level_id', '=', 'academic_levels.id')
//            ->where('academic_levels.academic_year_id', $this->id)
//            ->distinct()
//            ->get();
//    }

    public function classSections()
    {
        return $this->hasManyDeep(
            ClassSection::class,
            [AcademicLevel::class, AcademicGrade::class, GradeClassSection::class],
            [
                'academic_year_id',   // FK en AcademicLevel que referencia a AcademicYear
                'academic_level_id',  // FK en AcademicGrade que referencia a AcademicLevel
                'academic_grade_id',  // FK en GradeClassSection que referencia a AcademicGrade
                'id'                 // PK en ClassSection (esto es lo que cambió)
            ],
            [
                'id',                 // PK en AcademicYear
                'id',                 // PK en AcademicLevel
                'id',                 // PK en AcademicGrade
                'class_section_id'   // FK en GradeClassSection que referencia a ClassSection
            ]
        )->distinct();
    }





}


