<?php

namespace App\Filament\Resources;


use App\Models\Grade;
use App\Models\Level;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AcademicYear;
//use App\Models\AcademicLevel;
//use App\Models\AcademicGrade;
use App\Models\Section;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
//use Illuminate\Database\Eloquent\Builder;
//use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AcademicYearResource\Pages;
//use App\Filament\Resources\AcademicYearResource\RelationManagers;

class AcademicYearResource extends Resource
{
    protected static ?string $model = AcademicYear::class;

    protected static ?string $navigationIcon = 'fas-school';

    protected static ?string $navigationGroup = 'Estructura Académica';

    protected static ?string $navigationLabel = 'Años Académicos';

    protected static ?string $pluralModelLabel = 'Años Académicos';
    protected static ?string $modelLabel = 'Año Académico';




    // Override the label for the resource
//    public static function getModelLabel(): string
//    {
//        return 'Academic Year';
//    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('tabs')
                    ->tabs([
                        Tab::make('Año Académico')->label('Año Académico')
                            ->schema([
                                Grid::make()->columns(2)->schema([
                                TextInput::make('name')->required()->label('Nombre'),
                                    TextInput::make('short_name')->required()->label('Nombre Corto'),
                                    DatePicker::make('start_date')->required()->label('Fecha Inicio'),
                                    DatePicker::make('end_date')->required()->label('Fecha Fin'),]),
                                Forms\Components\Toggle::make('status')
                                    ->label('Estado')
                                    ->default(0)
                                    ->required(),

                            ]),

                        Tab::make('Academic Levels')->label("Niveles")
                            ->schema([
                                Forms\Components\Repeater::make('academicLevels')->label('Niveles')
                                    ->relationship('academicLevels')
                                    ->schema([
                                        Forms\Components\Select::make('level_id')
                                            ->label('Nivel')
                                            ->live(onBlur: true)
                                            ->relationship('level', 'name') // Adjust according to your Level model
                                            ->required()
                                            ->reactive(),



                                        Forms\Components\TextInput::make('admission_fees')
                                            ->label('Cuota de Inscripción')
                                            ->numeric()
                                            ->reactive()
                                            ->disabled(fn (callable $get) => !$get('cuota')) // Deshabilita cuando 'cuota' es false (0)
                                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                                if (!$get('cuota')) {
                                                    $set('admission_fees', null);
                                                }
                                            }),

                                        Forms\Components\TextInput::make('materials_fees')
                                            ->label('Cuota de Materiales')
                                            ->numeric()
                                            ->reactive()
                                            ->disabled(fn (callable $get) => !$get('cuota')) // Deshabilita cuando 'cuota' es false (0)
                                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                                if (!$get('cuota')) {
                                                    $set('materials_fees', null);
                                                }
                                            }),
                                        Forms\Components\Toggle::make('cuota')
                                            ->label('Cuota')
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                                if (!$state) {
                                                    // Limpiar los valores dentro de este Repeater
                                                    $set('admission_fees', null);
                                                    $set('materials_fees', null);

                                                    // Obtener los valores actuales del Repeater 'academicGrades'
                                                    $grades = $get('academicGrades') ?? [];

                                                    // Limpiar 'fee_cuota' en cada grado dentro del repeater
                                                    foreach ($grades as $index => $grade) {
                                                        $grades[$index]['fee_cuota'] = null;
                                                    }

                                                    // Guardar los valores actualizados en 'academicGrades'
                                                    $set('academicGrades', $grades);
                                                }
                                            })
                                            ->default(true)
                                            ->required(),

                                        Forms\Components\Repeater::make('academicGrades')->label('Grados')
                                            ->relationship('academicGrades')
                                            ->schema([
                                                Forms\Components\Select::make('grade_id')
                                                    ->label('Grado')
                                                    ->relationship('grade', 'name', function ($query) {
                                                        $query->orderBy('order'); // Ordena por el campo 'order' en el modelo Grade
                                                    })
                                            ->afterStateUpdated(function ($state, callable $set) {
                                                // Cuando cambia el grado, limpiar la sección seleccionada
                                                $set('gradeSections', []);
                                            }),


                                                Forms\Components\TextInput::make('fee_cuota')
                                                    ->label('Cuota Mensual')
                                                    ->required()
                                                    ->reactive()
                                                    ->disabled(fn (callable $get) => !$get('../../cuota')) // Busca el `cuota` del Repeater superior
                                                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                                        if (!$get('../../cuota')) { // Busca `cuota` correctamente en el repeater superior
                                                            $set('fee_cuota', null);
                                                        }
                                                    })
                                                    ->numeric(),

                                                Forms\Components\Checkbox::make('platform')
                                                    ->label('Progrentis'),

                                                Forms\Components\Repeater::make('gradeSections')->label('Secciones')
                                                    ->columns(2)
                                                    ->relationship('gradeSections')
                                                    ->schema([
                                                        Select::make('section_id')
                                                            ->label('Sección')
                                                            ->relationship('section', 'name') // Adjust according to your Section model
                                                            ->options(function (callable $get) {
                                                                // Obtén el grade_id seleccionado
                                                                $gradeId = $get('../../grade_id');

                                                                // Busca las secciones asociadas con el grade_id
                                                                return Section::where('grade_id', $gradeId)
                                                                    ->pluck('name', 'id') // Devuelve las opciones de las secciones
                                                                    ->toArray(); // Convierte a un array para que Filament lo pueda utilizar
                                                            })
                                                            ->fixIndistinctState()
                                                            ->reactive()
                                                            ->required(),
                                                        Select::make('main_teacher_id')
                                                            ->relationship('Teacher' , 'first_name')
                                                            ->fixIndistinctState()
                                                            ->label('Profesor Tutor'),

                                                    ])
                                                    ->grid(2)
                                                    ->itemLabel(function (array $state): ?string {
                                                        // Obtiene el nombre de la sección basado en section_id
                                                        $section = Section::find($state['section_id'] ?? null);
                                                        return $section ? "Sección: {$section->name}" : 'Nueva Sección';
                                                    }),
                                            ])
                                            ->columnSpan(3)
                                            ->itemLabel(function (array $state): ?string {
                                                // Obtiene el nombre de la sección basado en section_id
                                                $grade = Grade::find($state['grade_id'] ?? null);
                                                return $grade ? "Grado: {$grade->name}" : 'Nuevo Grado';
                                            }),
                                    ])
                                    ->columnSpan(2)
                                    ->itemLabel(function (array $state): ?string {
                                        // Obtiene el nombre de la sección basado en section_id
                                        $level = Level::find($state['level_id'] ?? null);
                                        return $level ? "Nivel: {$level->name}" : 'Nuevo Nivel';
                                    }),
                            ]),

                    ])
                    ->columnSpan(2), // Adjust based on your layout
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Año Académico'),
                //TextColumn::make('short_name'),
                TextColumn::make('start_date')->label('Fecha Inicio'),
                TextColumn::make('end_date')->label('Fecha Fin'),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAcademicYears::route('/'),
            'create' => Pages\CreateAcademicYear::route('/create'),
            'edit' => Pages\EditAcademicYear::route('/{record}/edit'),
        ];
    }
}
