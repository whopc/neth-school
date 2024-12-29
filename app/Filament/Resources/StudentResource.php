<?php

namespace App\Filament\Resources;

use App\Models\AcademicYear;
use App\Models\Family;
use App\Models\Progenitor;
use App\Models\Section;
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
use App\Models\GradeSection;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'fas-user-graduate';

    protected static ?string $navigationGroup = 'Academic Community';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Forms\Components\Wizard\Step::make('Student Information')
                        ->schema([
                            Grid::make()->columns(2)->schema([

                                Hidden::make('enrollment_no'),
                                Hidden::make('email'),
                                Select::make('family_id')
                                    ->label('Family')
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
                                    ->label('Status')
                                    ->options([
                                        'nuevo' => 'Nuevo',
                                        'normal' => 'Normal',
                                        'suspendido' => 'Suspendido',
                                        'retirado' => 'Retirado',
                                    ])
                                    ->default('nuevo')
                                    ->required(),
                                TextInput::make('first_last_name')
                                    ->debounce(1500)
                                    ->afterStateUpdated(function ($set, $state, $get) {
                                        $set('full_last_name', trim(($get('first_last_name') ?? '') . ' ' . ($get('second_last_name') ?? '')));
                                    })
                                    ->required(),
                                TextInput::make('second_last_name')
                                    ->debounce(1500)
                                    ->afterStateUpdated(function ($set, $state, $get) {
                                        $set('full_last_name', trim(($get('first_last_name') ?? '') . ' ' . ($get('second_last_name') ?? '')));
                                    }),
                                TextInput::make('full_last_name')
                                    ->afterStateHydrated(function (callable $set, $state, $get) {
                                        // Configura el valor del campo basado en otros campos
                                        $set('full_last_name', trim(($get('first_last_name') ?? '') . ' ' . ($get('second_last_name') ?? '')));
                                    })
                                    ->disabled(),
                                TextInput::make('first_name')
//                                    ->afterStateUpdated(function ($set, $state, $get) {
//                                        $set('full_name', trim(($get('first_name') ?? '') . ' ' . ($get('full_last_name') ?? '')));
//                                    })
//                                    ->live()
                                    ->required(),
                                TextInput::make('full_name')
                                    ->disabled()
                                    ->hidden()
                                    ->required(),
                                DatePicker::make('dob')
                                    ->label('Date of Birth')
                                    ->required(),
                                Select::make('gender')
                                    ->options([
                                        'Male' => 'Male',
                                        'Female' => 'Female',
                                    ])
                                    ->required(),
                                TextInput::make('nationality')
                                    ->required(),
                                TextInput::make('place_of_birth')
                                    ->required(),
                                TextInput::make('phone')
                                    ->required(),
                                TextInput::make('previous_school')
                                    ->required(),

                            ]),
                        ])
                        ->description('Enter the basic information and fiscal data about the student.'),
                    Forms\Components\Wizard\Step::make('Documement and Data Fiscal')
                        ->schema([
                            Forms\Components\Section::make()->columns(2)
                                ->schema([
                                    Select::make('ncf_type')
                                        ->label('NCF Type')
                                        ->options([
                                            'consumidor final' => 'Consumidor Final',
                                            'credito fiscal' => 'Credito Fiscal',
                                            'regimen especial' => 'Regimen Especial',
                                            'gubernamental'    => 'Gubernamental',
                                        ])
                                        ->default('consumidor final'),
                                    TextInput::make('rnc')
                                        ->label('RNC o Cédula'),
                                    TextInput::make('company')
                                        ->label('Company')
                                        ->columnSpan('full'),
                                ])
                                ->columnSpan(2)
                                ->heading('Datos Fiscales'), // Título visible de la sección
                            Forms\Components\Section::make()->columns(2)
                                ->schema([
                                    FileUpload::make('picture_path')
                                        ->label('Upload Picture')
                                        ->image()
                                        ->avatar()
                                        ->directory('students/pictures'),
                                    FileUpload::make('document')
                                        ->label('Document')
                                        ->directory('students/documents'), // Directory where the file will be stored
                                    Checkbox::make('is_returning')
                                        ->label('Returning Student')
                                        ->default(false),
                                    Textarea::make('comments')
                                        ->label('Comments')
                                        ->placeholder('Enter your comments here...')
                                        ->columnSpan(2)
                                        ->rows(4)
                                        ->maxLength(500),
                                ])
                                ->columnSpan(2)
                                ->heading('Foto , Documento y Comentario'),
                        ])

                        ->description('Provide the document and data fiscal for the student.'),

                    Forms\Components\Wizard\Step::make('Student Health')
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
                                ->label('Student Doctor'),
                            Forms\Components\TextInput::make('clinic')
                                ->label('Doctor Clinic'),
                            Forms\Components\TextInput::make('phone_no')
                                ->label('Doctor Phone Number'),
                            Forms\Components\TextInput::make('vaccinations')
                                ->label('Vaccinations'),
                            Forms\Components\Select::make('blood_type')
                                ->label('Blood Type')
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
                        //->description('Provide the health details for the student.'),
                ]),
                    Forms\Components\Wizard\Step::make('Academic Information')
                        ->schema([
                            Grid::make()->columns(2)->schema([
                                Select::make('student_year.academic_year_id')
                                    ->label('Academic Year')
                                    ->options(function () {
                                        return AcademicYear::pluck('name', 'id')->toArray();
                                    })
                                    ->reactive()
                                    ->required()
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                Select::make('student_year.level_id')
                                    ->label('Level')
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
                                    ->label('Grade')
                                    ->options(function (callable $get) {
                                        $levelId = $get('student_year.level_id');
                                        if (!$levelId) return [];

                                        return \App\Models\AcademicGrade::whereHas('academicLevel', function ($query) use ($levelId) {
                                            $query->where('level_id', $levelId);
                                        })
                                            ->join('grades', 'academic_grades.grade_id', '=', 'grades.id')
                                            ->pluck('grades.name', 'grades.id')
                                            ->toArray();
                                    })
                                    ->reactive()
                                    ->required()
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                Select::make('student_year.section_id')
                                    ->label('Section')
                                    ->options(function (callable $get) {
                                        $gradeId = $get('student_year.grade_id');
                                        if (!$gradeId) return [];

                                        return Section::where('grade_id', $gradeId)
                                            ->pluck('name', 'id')
                                            ->toArray();
                                    })
                                    ->required()
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                TextInput::make('student_year.classroom')
                                    ->label('Classroom')
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                TextInput::make('student_year.order_no')
                                    ->label('Order No')
                                    ->numeric()
                                    ->required()
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                TextInput::make('student_year.registration_discount')
                                    ->label('Registration Discount')
                                    ->numeric()
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                Radio::make('student_year.registration_discount_type')
                                    ->label('Registration Discount Type')
                                    ->options([
                                        'percentage' => 'Percentage',
                                        'fixed' => 'Fixed',
                                    ])
                                    ->default('percentage')
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                TextInput::make('student_year.monthly_discount')
                                    ->label('Monthly Discount')
                                    ->numeric()
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                Radio::make('student_year.monthly_discount_type')
                                    ->label('Monthly Discount Type')
                                    ->options([
                                        'percentage' => 'Percentage',
                                        'fixed' => 'Fixed',
                                    ])
                                    ->default('percentage')
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),

                                Textarea::make('student_year.notes')
                                    ->label('Notes')
                                    ->columnSpan(2)
                                    ->visible(fn ($livewire) => $livewire instanceof Pages\CreateStudent),
                            ]),
                        ])
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
                    ->label('Family ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('enrollment_no')
                    ->label('Student ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('first_name')
                    ->label('Fist Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('family.last_name')
                    ->label('Last Name')
                    ->sortable()
                    ->formatStateUsing(fn ($record) => "{$record->first_last_name} {$record->second_last_name}")
                    ->searchable(),
                TextColumn::make('studentYears.grade.name')
                    ->label('Grade')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($record) => $record->studentYears()->latest()->first()?->grade->name ?? 'N/A'),

                // Mostrar la sección del último registro en StudentYear
                TextColumn::make('studentYears.section.name')
                    ->label('Section')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($record) => $record->studentYears()->latest()->first()?->section->name ?? 'N/A'),

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
