<?php

namespace App\Filament\Resources\FamilyResource\RelationManagers;

use App\Models\Family;
use App\Models\Progenitor;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentsRelationManager extends RelationManager
{
    protected static string $relationship = 'students';

    public function form(Form $form): Form
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
                                    ->label('Familia')
                                    ->relationship('family', 'last_name')
                                    ->default(fn ($livewire) => $livewire->ownerRecord->id)
                                    ->disabled()
                                    ->required(),
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
                                    ->reactive()
                                    ->debounce(1500)
                                    ->afterStateHydrated(function (callable $set) {
                                        $family = $this->getOwnerRecord();

                                        if ($family && $family->father) {
                                            $set('first_last_name', $family->father->first_last_name);
                                        } elseif ($family && $family->mother) {
                                            $set('first_last_name', $family->mother->first_last_name);
                                        } else {
                                            $set('first_last_name', '');
                                        }
                                    })
                                    ->afterStateUpdated(function ($set, $state, $get) {
                                        $set('full_last_name', trim(($get('first_last_name') ?? '') . ' ' . ($get('second_last_name') ?? '')));
                                    })
                                    ->required(),
                                TextInput::make('second_last_name')
                                    ->reactive()
                                    ->debounce(1500)
                                    ->afterStateHydrated(function (callable $set) {
                                        $family = $this->getOwnerRecord();

                                        if ($family && $family->mother) {
                                            $set('second_last_name', $family->mother->first_last_name);
                                        } else {
                                            $set('second_last_name', '');
                                        }
                                    })
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
                        ])

                ])
                    ->columnSpan(2) // Ensure the wizard uses full width
                    ->extraAttributes(['style' => 'max-width: 100%;']), // Allow full width
            ]);

    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('first_name')
            ->columns([
                TextColumn::make('enrollment_no')
                    ->label('Student ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('first_name')
                    ->label('Fist Name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('studentYears.grade.name')
                    ->label('Grade')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($record) => $record->studentYears()->latest()->first()?->grade->name ?? 'N/A'),

                // Mostrar la sección del último registro en StudentYear
                TextColumn::make('studentYears.section.name')
                    ->label('ClassSection')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($record) => $record->studentYears()->latest()->first()?->section->name ?? 'N/A'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data): array {
                        // Generar 'enrollment_no' y 'email' antes de crear el registro
                        $data['enrollment_no'] = Student::generateEnrollmentNumber();
                        $data['email'] = "{$data['enrollment_no']}@cefodipf.edu.do";
                        return $data;
                    }),
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
//                Tables\Actions\BulkActionGroup::make([
//                    Tables\Actions\DeleteBulkAction::make(),
//                ]),
            ]);
    }
}
