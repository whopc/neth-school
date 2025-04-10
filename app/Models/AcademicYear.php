<?php

namespace App\Models;
use App\Models\AcademicLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'start_date',
        'end_date',
        'status',
    ];

    public function academicLevels()
    {
        return $this->hasMany(AcademicLevel::class, 'academic_year_id');
    }
    public function levels()
    {
        return $this->hasManyThrough(Level::class, AcademicLevel::class, 'academic_year_id', 'id', 'id', 'level_id');
    }

}
