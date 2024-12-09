<?php

namespace App\Models;
use app\Models\GradeSection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'grade_id'

    ];

    public function gradeSection()
    {
        return $this->hasMany(GradeSection::class , 'section_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    /**
     * Regla de validación para evitar duplicados de nombre y grado.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public static function validateSection($data)
    {
        return \Validator::make($data, [
            'name' => [
                'required',
                Rule::unique('sections')->where(function ($query) use ($data) {
                    return $query->where('grade_id', $data['grade_id']);
                }),
            ],
            'grade_id' => 'required|exists:grades,id', // Se asegura de que el grade_id sea válido
        ]);
    }

}

