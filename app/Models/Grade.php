<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order',
        'level_id',
    ];

    public function academicGrades()
    {
        return $this->hasMany(AcademicGrade::class , 'grade_id');
    }
    public function sections()
    {
        return $this->hasMany(ClassSection::class);
    }
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

}
