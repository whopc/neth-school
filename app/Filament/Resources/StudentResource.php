<?php

namespace App\Filament\Resources;

use App\Models\AcademicYear;
use App\Models\Family;
use App\Models\Progenitor;
use App\Models\ClassSection;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Tables;
use App\Models\Student;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\StudentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\AcademicGrade;
use App\Models\AcademicLevel;
use App\Models\GradeClassSection;


class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'fas-user-graduate';

    protected static ?string $navigationLabel = 'Estudiantes';
    protected static ?string $navigationGroup = 'Comunidad Académica';

    protected static ?string $pluralModelLabel = 'Estudiantes';
    protected static ?string $modelLabel = 'Estudiante';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Forms\Components\Wizard\Step::make('Información del Estudiante')
                        ->schema([
                            Grid::make()->columns(2)->schema([

                                Hidden::make('email'),
                                Select::make('family_id')
                                    ->label('Familia')
                                    ->relationship('family', 'last_name')
                                    ->searchable()
                                    ->disabled(fn ($record) => $record !== null)
                                    ->reactive()
                                    ->required()
                                    ->getSearchResultsUsing(function (string $searchQuery) {
                                        return Family::where(function ($query) use ($searchQuery) {
                                            $query->where('last_name', 'like', "%$searchQuery%")
                                                ->orWhere('id', 'like', "%$searchQuery%");
                                        })
                                            ->get()
                                            ->mapWithKeys(fn($family) => [
                                                $family->id => "({$family->id}) {$family->last_name}"
                                            ]);
                                    })
                                    ->getOptionLabelUsing(fn($value) => Family::find($value)?->last_name . ' (' . Family::find($value)?->id . ')')
                                    ->afterStateUpdated(function ($set, $state) {
                                        // Buscar la familia seleccionada con sus relaciones
                                        $family = Family::with(['father', 'mother'])->find($state);

                                        if ($family) {
                                            // Si hay padre, usar su apellido para 'first_last_name'
                                            if ($family->father) {
                                                $set('first_last_name', $family->father->first_last_name);
                                            } elseif ($family->mother) {
                                                // Si no hay padre, usar el apellido de la madre para 'first_last_name'
                                                $set('first_last_name', $family->mother->first_last_name);
                                                // También actualiza 'second_last_name'
                                            }
                                        } else {
                                            // Si no hay familia seleccionada, limpiar ambos campos
                                            $set('first_last_name', '');
                                            $set('second_last_name', '');
                                        }
                                    })
                                    ->afterStateUpdated(function ($set, $state) {
                                        // Buscar la familia seleccionada con sus relaciones
                                        $family = Family::with(['father', 'mother'])->find($state);

                                        if ($family) {
                                            // Si hay padre, usar su apellido para 'first_last_name'
                                            if ($family->father) {
                                                $set('second_last_name', $family->mother->first_last_name);
                                            }
                                        }
                                    })
                                    ->afterStateUpdated(function ($set, $state, $get) {
                                        $set('full_last_name', trim(($get('first_last_name') ?? '') . ' ' . ($get('second_last_name') ?? '')));
                                    }),
                                TextInput::make('enrollment_no')
                                    ->label('Matricula')
                                    ->required()
//                                    ->afterStateHydrated(function (callable $set, $state, ?\App\Models\Student $record) {
//                                        // Si no hay registro (creando) y el campo está vacío, generar el enrollment_no
//                                        if (!$record && empty($state)) {
//                                            $set('enrollment_no', \App\Models\Student::generateEnrollmentNumber());
//                                        }
//                                    })
//                                    ->disabled()
// esta comentado hasta que se registren todas las matriculas de los estudiantes viejos ...

                                    ->numeric(),

                                Hidden::make('admission_date')
                                    ->default(now()) // Set the default to the current date
                                    ->required(),
                                Hidden::make('is_enrolled')
                                    ->default(0) // Set the default to the current date
                                    ->required(),
                                Hidden::make('enrollment_year')
                                    ->default(now()->year) // Set the default to the current year
                                    ->required(),
                                Select::make('status')
                                    ->label('Estatus')
                                    ->options([
                                        'nuevo' => 'Nuevo',
                                        'normal' => 'Normal',
                                        'suspendido' => 'Suspendido',
                                        'retirado' => 'Retirado',
                                    ])
                                    ->default('nuevo')
                                    ->required()
                                    ->disabled() ,
                                TextInput::make('first_last_name')
                                    ->label('Primer Apellido')
                                    ->debounce(1500)
                                    ->afterStateUpdated(function ($set, $state, $get) {
                                        $set('full_last_name', trim(($get('first_last_name') ?? '') . ' ' . ($get('second_last_name') ?? '')));
                                    })
                                    ->required(),
                                TextInput::make('second_last_name')
                                    ->label('Segundo Apellido')
                                    ->debounce(1500)
                                    ->afterStateUpdated(function ($set, $state, $get) {
                                        $set('full_last_name', trim(($get('first_last_name') ?? '') . ' ' . ($get('second_last_name') ?? '')));
                                    }),
                                TextInput::make('full_last_name')
                                    ->label('Nombre Completo')
                                    ->afterStateHydrated(function (callable $set, $state, $get) {
                                        // Configura el valor del campo basado en otros campos
                                        $set('full_last_name', trim(($get('first_last_name') ?? '') . ' ' . ($get('second_last_name') ?? '')));
                                    })
                                    ->disabled(),
                                TextInput::make('first_name')
                                    ->label('Nombres')
                                    ->required(),
                                TextInput::make('full_name')
                                    ->label('Nombre Completo')
                                    ->disabled()
                                    ->hidden()
                                    ->required(),
                                DatePicker::make('dob')
                                    ->label('Fecha de Nacimiento')
                                    ->required(),
                                Select::make('gender')
                                    ->label('Genero')
                                    ->options([
                                        'Male' => 'Masculino',
                                        'Female' => 'Femenino',
                                    ])
                                    ->required(),
                                TextInput::make('nationality')
                                    ->label('Nacionalidad')
                                    ->required(),
                                TextInput::make('place_of_birth')
                                    ->label('Lugar de Nacimiento')
                                    ->required(),
                                TextInput::make('phone')
                                    ->label('Teléfono'),
                                TextInput::make('previous_school')
                                    ->label('Centro de Procedencia'),

                            ]),
                        ])
                        ->description('Información Básica del Estudiante.'),
                    Forms\Components\Wizard\Step::make('Documentos y Datos Fiscales')
                        ->schema([

                            Forms\Components\Section::make()->columns(2)
                                ->schema([
                                    FileUpload::make('picture_path')
                                        ->label('Foto')
                                        ->image()
                                        ->avatar()
                                        ->directory('students/pictures'),
                                    FileUpload::make('document')
                                        ->label('Documentos')
                                        ->directory('students/documents'), // Directory where the file will be stored

                                    Textarea::make('comments')
                                        ->label('Comentarios')
                                        ->placeholder('Entrar los comentarios aquí...')
                                        ->columnSpan(2)
                                        ->rows(4)
                                        ->maxLength(500),
                                ])
                                ->columnSpan(2)
                                ->heading('Foto , Documentos y Comentarios'),
                            Forms\Components\Section::make()->columns(2)
                                ->schema([
                                    Select::make('ncf_type')
                                        ->label('tipo NCF')
                                        ->options([
                                            'consumidor final' => 'Consumidor Final',
                                            'credito fiscal' => 'Crédito Fiscal',
                                            'regimen especial' => 'Regimen Especial',
                                            'gubernamental'    => 'Gubernamental',
                                        ])
                                        ->reactive()
                                        ->afterStateUpdated(function ($state, callable $set) {
                                            if ($state === 'consumidor final') {
                                                $set('rnc', null); // Limpiar campo RNC
                                                $set('company', null); // Limpiar campo Razón Social
                                            }
                                        })
                                        ->default('consumidor final'),
                                    TextInput::make('rnc')
                                        ->disabled(fn (callable $get) => $get('ncf_type') === 'consumidor final')
                                        ->label('RNC o Cédula'),
                                    TextInput::make('company')
                                        ->disabled(fn (callable $get) => $get('ncf_type') === 'consumidor final')
                                        ->label('Razón Social')
                                        ->columnSpan('full'),
                                ])
                                ->columnSpan(2)
                                ->heading('Datos Fiscales'), // Título visible de la sección
                        ])

                        ->description('Proporcionar datos fiscales del estudiante.'),

                    Forms\Components\Wizard\Step::make('Salud del Estudiante')
                        ->schema([
                            Grid::make()->columns(2)->schema([
                            Forms\Components\TextInput::make('activity')
                                ->label('Student Activities'),
                            Forms\Components\TextInput::make('skill')
                                ->label('Student Skills'),
                            Forms\Components\TextInput::make('difficulty')
                                ->label('Student Difficulties'),
                            Forms\Components\TextInput::make('health_status')
                                ->label('Health Status'),
                            Forms\Components\TextInput::make('illness')
                                ->label('Illness'),
                            Forms\Components\TextInput::make('allergies')
                                ->label('Allergies'),
                            Forms\Components\TextInput::make('accidents')
                                ->label('Accidents'),
                            Forms\Components\TextInput::make('doctor')
                                ->label('Medico del estudiante'),
                            Forms\Components\TextInput::make('clinic')
                                ->label('Centro de salud'),
                            Forms\Components\TextInput::make('phone_no')
                                ->label('Telefono del Doctor'),
                            Forms\Components\TextInput::make('vaccinations')
                                ->label('Vacunaciones'),
                            Forms\Components\Select::make('blood_type')
                                ->label('Tipo de Sangre')
                                ->options([
                                    'A+' => 'A+',
                                    'A-' => 'A-',
                                    'B+' => 'B+',
                                    'B-' => 'B-',
                                    'AB+' => 'AB+',
                                    'AB-' => 'AB-',
                                    'O+' => 'O+',
                                    'O-' => 'O-',
                                ])

                        ])
                               ])
                                ->description('Proporcionar los detalles de salud del estudiante.'),


                    Forms\Components\Wizard\Step::make('Información Académica')
                        ->schema([
                            Grid::make()->columns(2)->schema([
                                Select::make('student_year.academic_year_id')
                                    ->label('Año Académico')
                                    ->options(function () {
                                        return AcademicYear::pluck('name', 'id')->toArray();
                                    })
                                    ->reactive()
                                    ->required()
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                Select::make('student_year.level_id')
                                    ->label('Nivel')
                                    ->options(function (callable $get) {
                                        $academicYearId = $get('student_year.academic_year_id');
                                        if (!$academicYearId) return [];

                                        return \App\Models\AcademicLevel::where('academic_year_id', $academicYearId)
                                            ->join('levels', 'academic_levels.level_id', '=', 'levels.id')
                                            ->pluck('levels.name', 'levels.id')
                                            ->toArray();
                                    })
                                    ->reactive()
                                    ->required()
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                Select::make('student_year.grade_id')
                                    ->label('Grado')
                                    ->options(function (callable $get) {
                                        $levelId = $get('student_year.level_id');
                                        $academicYearId = $get('student_year.academic_year_id');
                                        if (!$levelId || !$academicYearId) return [];

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
                                    ->required()
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                Select::make('student_year.grade_class_section_id')
                                    ->label('Sección')
                                    ->options(function (callable $get) {
                                        $gradeId = $get('student_year.grade_id');
                                        $academicYearId = $get('student_year.academic_year_id');
                                        if (!$gradeId || !$academicYearId) return [];

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
                                    ->required()
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                TextInput::make('student_year.classroom')
                                    ->label('Aula')
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                TextInput::make('minerd_id')
                                    ->label('Código Minerd')
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                TextInput::make('student_year.order_no')
                                    ->label('Número de orden')
                                    ->numeric()
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                TextInput::make('student_year.registration_discount')
                                    ->label('Descuento de Inscripción')
                                    ->numeric()
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                Radio::make('student_year.registration_discount_type')
                                    ->label('Tipo De Descuento')
                                    ->options([
                                        'percentage' => 'Porciento',
                                        'fixed' => 'Fijo',
                                    ])
                                    ->default('percentage')
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                TextInput::make('student_year.monthly_discount')
                                    ->label('Descuento en Cuotas')
                                    ->numeric()
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                Radio::make('student_year.monthly_discount_type')
                                    ->label('Tipo de Descuento')
                                    ->options([
                                        'percentage' => 'Porciento',
                                        'fixed' => 'Fijo',
                                    ])
                                    ->default('percentage')
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                Textarea::make('student_year.notes')
                                    ->label('Notas')
                                    ->columnSpan(2)
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),
                            ]),
                        ])

                        ->description('Proporcionar los detalles Academicos.')
                        ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                        ])
                    ->columnSpan(2) // Ensure the wizard uses full width
                    ->extraAttributes(['style' => 'max-width: 100%;']), // Allow full width

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('family.id')
                    ->label('ID Familia')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('enrollment_no')
                    ->label('ID Estudiante')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('first_name')
                    ->label('Nombres')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('family.last_name')
                    ->label('Apellidos')
                    ->sortable()
                    ->formatStateUsing(fn ($record) => "{$record->first_last_name} {$record->second_last_name}")
                    ->searchable(),
                // Mostrar el grado del estudiante a través de la relación correcta
                TextColumn::make('studentYears.gradeClassSection.academicGrade.grade.name')
                    ->label('Grado')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function($record) {
                        $latestStudentYear = $record->studentYears()->latest()->first();
                        if (!$latestStudentYear) return 'N/A';
                        return $latestStudentYear->gradeClassSection?->academicGrade?->grade?->name ?? 'N/A';
                    }),

                // Mostrar la sección del estudiante a través de la relación correcta
                TextColumn::make('studentYears.gradeClassSection.classSection.name')
                    ->label('Sección')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(function($record) {
                        $latestStudentYear = $record->studentYears()->latest()->first();
                        if (!$latestStudentYear) return 'N/A';
                        return $latestStudentYear->gradeClassSection?->classSection?->name ?? 'N/A';
                    }),


            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\StudentYearsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
