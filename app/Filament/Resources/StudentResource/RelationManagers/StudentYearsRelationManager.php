<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Models\AcademicGrade;
use App\Models\AcademicYear;
use App\Models\ClassSection;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentYearsRelationManager extends RelationManager
{
    protected static string $relationship = 'studentYears';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()->columns(2)->schema([
                    Select::make('academic_year_id')
                        ->label('Año Académico')
                        ->options(function (callable $get) {
                            // Obtener el ID del estudiante actual desde el owner record
                            $studentId = $this->ownerRecord->id;

                            if (!$studentId) {
                                // Si no hay estudiante cargado, devolver todos los años académicos
                                return AcademicYear::pluck('name', 'id')->toArray();
                            }

                            // Obtener los IDs de los años académicos ya asociados al estudiante
                            $existingAcademicYears = \App\Models\StudentYear::where('student_id', $studentId)
                                ->join('grade_class_sections', 'student_years.grade_class_section_id', '=', 'grade_class_sections.id')
                                ->join('academic_grades', 'grade_class_sections.academic_grade_id', '=', 'academic_grades.id')
                                ->join('academic_levels', 'academic_grades.academic_level_id', '=', 'academic_levels.id')
                                ->pluck('academic_levels.academic_year_id')
                                ->toArray();

                            // Filtrar los años académicos excluyendo los ya asociados al estudiante
                            return AcademicYear::whereNotIn('id', $existingAcademicYears)
                                ->pluck('name', 'id')
                                ->toArray();
                        })
                        ->reactive()
                        ->required(),

                    Select::make('level_id')
                        ->label('Nivel')
                        ->options(function (callable $get) {
                            $academicYearId = $get('academic_year_id');
                            if (!$academicYearId) {
                                return [];
                            }
                            // Obtener los niveles asociados al año académico seleccionado
                            return \App\Models\AcademicLevel::where('academic_year_id', $academicYearId)
                                ->join('levels', 'academic_levels.level_id', '=', 'levels.id')
                                ->pluck('levels.name', 'levels.id')
                                ->toArray();
                        })
                        ->reactive()
                        ->required(),

                    Select::make('grade_id')
                        ->label('Grado')
                        ->options(function (callable $get) {
                            $levelId = $get('level_id');
                            $academicYearId = $get('academic_year_id');
                            if (!$levelId || !$academicYearId) {
                                return [];
                            }
                            // Obtener los grados asociados al nivel seleccionado y al año académico
                            return \App\Models\AcademicGrade::whereHas('academicLevel', function ($query) use ($levelId, $academicYearId) {
                                $query->where('level_id', $levelId)
                                    ->whereHas('academicYear', function($q) use ($academicYearId) {
                                        $q->where('id', $academicYearId);
                                    });
                            })
                                ->join('grades', 'academic_grades.grade_id', '=', 'grades.id')
                                ->pluck('grades.name', 'grades.id')
                                ->toArray();
                        })
                        ->reactive()
                        ->required(),

                    Select::make('grade_class_section_id')
                        ->label('Sección')
                        ->options(function (callable $get) {
                            $gradeId = $get('grade_id');
                            $academicYearId = $get('academic_year_id');
                            if (!$gradeId || !$academicYearId) {
                                return [];
                            }

                            // Buscar todas las AcademicGrades relacionadas con este grado y año académico
                            $academicGradeIds = \App\Models\AcademicGrade::whereHas('academicLevel', function ($query) use ($academicYearId) {
                                $query->where('academic_year_id', $academicYearId);
                            })
                                ->where('grade_id', $gradeId)
                                ->pluck('id')
                                ->toArray();

                            // Buscar todas las GradeClassSections relacionadas con esas AcademicGrades
                            return \App\Models\GradeClassSection::whereIn('academic_grade_id', $academicGradeIds)
                                ->join('class_sections', 'grade_class_sections.class_section_id', '=', 'class_sections.id')
                                ->select('grade_class_sections.id', 'class_sections.name')
                                ->pluck('class_sections.name', 'grade_class_sections.id')
                                ->toArray();
                        })
                        ->required(),

                    TextInput::make('classroom')
                        ->label('Aula')
                        ->placeholder('Ingrese el aula')
                        ->nullable(),

                    TextInput::make('order_no')
                        ->label('Número de Orden')
                        ->numeric()
                        ->placeholder('Ingrese el número de orden'),

                    Textarea::make('notes')
                        ->label('Notas')
                        ->nullable()
                        ->rows(3)
                        ->columnSpan(2),

                    TextInput::make('registration_discount')
                        ->label('Descuento de Inscripción')
                        ->numeric()
                        ->nullable(),

                    Radio::make('registration_discount_type')
                        ->label('Tipo de Descuento')
                        ->options([
                            'percentage' => 'Porciento',
                            'fixed' => 'Fijo',
                        ])
                        ->default('percentage')
                        ->required(),

                    TextInput::make('monthly_discount')
                        ->label('Descuento Cuota')
                        ->numeric()
                        ->nullable(),

                    Radio::make('monthly_discount_type')
                        ->label('Tipo de Descuento')
                        ->options([
                            'percentage' => 'Porciento',
                            'fixed' => 'Fijo',
                        ])
                        ->default('percentage')
                        ->required(),
                ]),

            ]);

    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('academic_year_id')
            ->columns([
                TextColumn::make('gradeClassSection.academicGrade.academicLevel.academicYear.name')
                    ->label('Año Académico')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('gradeClassSection.academicGrade.academicLevel.level.name')
                    ->label('Nivel')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('gradeClassSection.academicGrade.grade.name')
                    ->label('Grado')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('gradeClassSection.classSection.name')
                    ->label('Sección')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('order_no')
                    ->label('Orden')
                    ->sortable(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
