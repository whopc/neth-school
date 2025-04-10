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

    protected static function booted()
    {
        static::created(function ($family) {
            $mother = $family->mother;

            if ($mother && $mother->id_number) {
                // Eliminar guiones del id_number
                $cleanIdNumber = str_replace('-', '', $mother->id_number);

                // Crear el usuario
                $user = \App\Models\User::create([
                    'type_id'           => Type::FAMILY, // Rol Family
                    'name'              => $family->last_name,
                    'email'             => 'fam' . $family->id . '@cefodipf.edu.do',
                    'password'          => bcrypt($cleanIdNumber),
                    'email_verified_at' => now(),
                ]);

                // Asignar el ID del usuario recién creado a la familia
                $family->user_id = $user->id;
                $family->save();
            }
        });
    }

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
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
