<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class Teacher extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

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
        'user_email',
        'user_id',
    ];

    // Sobrescribimos el método newQuery para filtrar solo los profesores
//    public function newQuery($excludeDeleted = true): Builder
//    {
//        return parent::newQuery($excludeDeleted)
//            ->whereHas('user', function ($query) {
//                $query->where('role_id', Type::TEACHER);
//            });
//    }

    // Ámbito global para filtrar solo los profesores
    protected static function booted()
    {
//        static::addGlobalScope('teacher-role', function (Builder $builder) {
//            $builder->whereHas('user', function ($q) {
//                $q->whereHas('role', function($query) {
//                    $query->where('id', Type::TEACHER);
//                });
//                // O directamente si user tiene un role_id
//                // $q->where('role_id', Type::TEACHER);
//            });
//        });

        // Crear un nuevo usuario al crear un Teacher
        static::created(function ($teacher) {
            $user = \App\Models\User::create([
                'type_id'           => Type::TEACHER, // Asignar el rol de teacher
                'name'              => $teacher->first_name . ' ' . $teacher->last_name,
                'email'             => $teacher->user_email,
                'password'          => bcrypt(str_replace('-', '', $teacher->id_number)), // Cifrar contraseña
                'email_verified_at' => now(),
            ]);

            // Asignar el ID del usuario recién creado al Teacher
            $teacher->user_id = $user->id;
            $teacher->save();
        });
    }

    // Relación con GradeClassSection
    public function gradeSections()
    {
        return $this->hasMany(GradeClassSection::class);
    }

    // Relación con User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
