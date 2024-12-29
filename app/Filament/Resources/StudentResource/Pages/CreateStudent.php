<?php

namespace App\Filament\Resources\StudentResource\Pages;

use App\Filament\Resources\StudentResource;
use Filament\Actions;
use App\Models\Student;
use App\Models\StudentYear;
use Filament\Resources\Pages\CreateRecord;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['enrollment_no'] = Student::generateEnrollmentNumber();
        $data['email'] = "{$data['enrollment_no']}@cefodipf.edu.do"; // Set email using enrollment_no
        $studentYearData = $data['student_year'] ?? null;
        unset($data['student_year']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $studentYearData = $this->data['student_year'] ?? null;

        if ($studentYearData) {
            // Create the StudentYear record
            $this->record->studentYears()->create($studentYearData);
        }

//        $academicYearData = [
//            'student_id' => $this->record->id, // Get the created student's ID
//            'academic_year_id' => $this->data['academic_year_id'], // Get the academic year ID from the form data
//            'level_id' => $this->data['level_id'],
//            'grade_id' => $this->data['grade_id'],
//            'section_id' => $this->data['section_id'],
//            'classroom' => $this->data['classroom'],
//            'order_no' => $this->data['order_no'],
//            'notes' => $this->data['notes'],
//            'registration_discount' => $this->data['registration_discount'],
//            'registration_discount_type' => $this->data['registration_discount_type'],
//            'monthly_discount' => $this->data['monthly_discount'],
//            'monthly_discount_type' => $this->data['monthly_discount_type'],
//
//
//        ];
//        $studentYear = StudentYear::updateOrCreate(
//            ['student_id' => $this->record->id],
//            $academicYearData
//        );

    }
}
