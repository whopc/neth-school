<?php

namespace App\Models;
use App\Models\AcademicGrade;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order'
    ];

    public function academicGrades()
    {
        return $this->hasMany(AcademicGrade::class , 'grade_id');
    }
    public function sections()
    {
        return $this->hasMany(Section::class);
    }
}
