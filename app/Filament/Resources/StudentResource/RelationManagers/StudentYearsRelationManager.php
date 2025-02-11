<?php

namespace App\Filament\Resources\StudentResource\RelationManagers;

use App\Models\AcademicGrade;
use App\Models\AcademicYear;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
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
//                    Select::make('academic_year_id')
//                        ->label('Año Académico')
//                        ->options(AcademicYear::pluck('name', 'id')->toArray())
//                        ->reactive()
//                        ->required(),
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
                                ->pluck('academic_year_id')
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
                                ->join('levels', 'academic_levels.level_id', '=', 'levels.id') // Unir con la tabla 'levels'
                                ->pluck('levels.name', 'levels.id') // Obtener 'name' e 'id' de 'levels'
                                ->toArray();
                        })
                        ->reactive()
                        ->required(),

                    Select::make('grade_id')
                        ->label('Grado')
                        ->options(function (callable $get) {
                            $levelId = $get('level_id');
                            if (!$levelId) {
                                return [];
                            }
                            // Obtener los grados asociados al nivel seleccionado
                            return \App\Models\AcademicGrade::whereHas('academicLevel', function ($query) use ($levelId) {
                                $query->where('level_id', $levelId);
                            })
                                ->join('grades', 'academic_grades.grade_id', '=', 'grades.id') // Unir con la tabla 'grades'
                                ->pluck('grades.name', 'grades.id') // Obtener 'name' e 'id' de 'grades'
                                ->toArray();
                        })
                        ->reactive()
                        ->required(),

                    Select::make('section_id')
                        ->label('Sección')
                        ->options(function (callable $get) {
                            $gradeId = $get('grade_id');
                            if (!$gradeId) {
                                return [];
                            }
                            return Section::where('grade_id', $gradeId)
                                ->pluck('name', 'id')
                                ->toArray();
                        })
                        ->required(),

                    TextInput::make('classroom')
                        ->label('Aula')
                        ->placeholder('Enter the classroom')
                        ->nullable(),

                    TextInput::make('order_no')
                        ->label('Numero de Orden')
                        ->numeric()
                        ->placeholder('Enter the order number')
                        ->required(),

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
                            'percentage' => 'v',
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
                Tables\Columns\TextColumn::make('academicYear.name')
                    ->label('Año Académico')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('level.name')
                    ->label('Nivel')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('section.grade.name')
                    ->label('Grado')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('section.name')
                    ->label('Sección')
                    ->sortable()
                    ->searchable(),
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
