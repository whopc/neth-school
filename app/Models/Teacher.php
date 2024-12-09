<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'id_number',
        'dob',
        'gender',
        'address',
        'phone',
        'email',
        'specialization',
        'academic_degree',
        'hire_date',
        'status',
        'contract_type',
        'salary',
    ];

    public function GradeSections()
    {
        return $this->hasMany(GradeSection::class);
    }
}
