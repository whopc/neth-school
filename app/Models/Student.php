<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'family_id',
        'minerd_id',
        'email',
        'admission_date',
        'enrollment_year',
        'enrollment_no',
        'first_last_name',
        'second_last_name',
        'first_name',
        'full_last_name',
        'full_name',
        'place_of_birth',
        'dob',
        'gender',
        'nationality',
        'phone',
        'secondary_phone',
        'previous_school',
        'circular',
        'secondary_circular',
        'picture_path',
        'comments',
        'status',
        'document',
        'is_returning',
        'is_enrolled',
        'ncf_type',
        'rnc',
        'company',
        'activity',
        'skill',
        'difficulty',
        'health_status',
        'illness',
        'allergies',
        'accidents',
        'doctor',
        'clinic',
        'phone_no',
        'vaccinations',
        'blood_type',


    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function studentYears()
    {
        return $this->hasMany(StudentYear::class, 'student_id');
    }


//    public function fee()
//    {
//        return $this->hasMany(fees::class , 'student_id');
//    }

    protected $casts = [
        'admission_date' => 'date',
        'dob' => 'date',
        'enrollment_year' => 'integer',
        'is_returning' => 'boolean',
        'is_enrolled' => 'boolean',
    ];
    protected static function booted()
    {

        static::created(function ($student) {
            $user = \App\Models\User::create([
                'type_id'           => Type::STUDENT, // Rol Teacher
                'name'              => $student->first_name . ' ' . $student->last_name,
                'email'             => $student->email,
                'password'          => bcrypt(date('Ymd', strtotime($student->dob))), // AñoMesDía como contraseña
                'email_verified_at' => now(),
            ]);

            // Asignar el ID del usuario recién creado al student
            $student->save();
        });
    }
    public static function generateEnrollmentNumber(): string
    {
        $year = date('Y'); // Current year
        $lastStudent = self::orderBy('id', 'desc')->first(); // Get the last student
        $uniqueId = $lastStudent ? $lastStudent->id + 1 : 1; // Generate unique ID

        // Pad the unique ID with leading zeros to ensure it's always 3 digits
        $paddedUniqueId = str_pad($uniqueId, 4, '0', STR_PAD_LEFT);

        return "{$year}{$paddedUniqueId}"; // Format: 20240001
    }

}
