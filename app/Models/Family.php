<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'father_id',
        'mother_id',
        'last_name',
        'is_separated_parents',
        'no_father_data',
        'tutor_enabled',
        't_name',
        't_last_name',
        't_address',
        't_telephone',
        'kinship',
    ];

    // Relación con el progenitor father
    public function father()
    {
        return $this->belongsTo(Progenitor::class, 'father_id')->where('role', 'father');
    }

    // Relación con el progenitor mother
    public function mother()
    {
        return $this->belongsTo(Progenitor::class, 'mother_id')->where('role', 'mother');
    }
    public function students()
    {
        return $this->hasMany(Student::class, 'family_id');
    }


}
