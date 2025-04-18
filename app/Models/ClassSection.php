<?php

namespace App\Models;
use app\Models\GradeClassSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
class ClassSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'grade_id'

    ];

    public function gradeClassSections()
    {
        return $this->hasMany(GradeClassSection::class, 'class_section_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public static function validateSection($data)
    {
        return \Validator::make($data, [
            'name' => [
                'required',
                Rule::unique('class_sections')->where(function ($query) use ($data) {
                    return $query->where('grade_id', $data['grade_id']);
                }),
            ],
            'grade_id' => 'required|exists:grades,id', // Se asegura de que el grade_id sea válido
        ]);
    }

}

