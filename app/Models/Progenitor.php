<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Progenitor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'first_last_name',
        'second_last_name',
        'id_type',
        'id_number',
        'email',
        'address',
        'home_phone',
        'mobile_phone',
        'place_of_work',
        'work_phone',
        'role',
    ];

    // Relación con las familias donde es father
    public function familiesAsFather()
    {
        return $this->hasMany(Family::class, 'father_id');
    }

    // Relación con las familias donde es mother
    public function familiesAsMother()
    {
        return $this->hasMany(Family::class, 'mother_id');
    }

    // Accesor para el name completo con identificación
    public function getFullNameWithIdAttribute()
    {
        return "{$this->name} {$this->first_last_name} ({$this->id_number})";
    }
}
