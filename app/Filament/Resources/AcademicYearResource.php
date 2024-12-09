<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AcademicYear;
use App\Models\AcademicLevel;
use App\Models\AcademicGrade;
use App\Models\Section;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AcademicYearResource\Pages;
use App\Filament\Resources\AcademicYearResource\RelationManagers;

class AcademicYearResource extends Resource
{
    protected static ?string $model = AcademicYear::class;

    protected static ?string $navigationIcon = 'fas-school';

    protected static ?string $navigationGroup = 'Academic Structure';

    // Override the label for the resource
    public static function getModelLabel(): string
    {
        return 'Academic Year';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('tabs')
                    ->tabs([
                        Tab::make('Academic Year')
                            ->schema([
                                TextInput::make('name')->required(),
                                TextInput::make('short_name')->required(),
                                DatePicker::make('start_date')->required(),
                                DatePicker::make('end_date')->required(),
                            ]),

                        Tab::make('Academic Levels')
                            ->schema([
                                Forms\Components\Repeater::make('academicLevels')
                                    ->relationship('academicLevels')
                                    ->schema([
                                        Forms\Components\Select::make('level_id')
                                            ->label('Level')
                                            ->relationship('level', 'name') // Adjust according to your Level model
                                            ->required(),
                                        Forms\Components\TextInput::make('admission_fees')
                                            ->label('Admission Fees')
                                            ->required()
                                            ->numeric(),
                                        Forms\Components\TextInput::make('materials_fees')
                                            ->label('Material Fees')
                                            ->numeric(),

                                        Forms\Components\Repeater::make('academicGrades')
                                            ->relationship('academicGrades')
                                            ->schema([
                                                Forms\Components\Select::make('grade_id')
                                                    ->label('Grade')
                                                    ->relationship('grade', 'name') // Adjust according to your Grade model
                                                    ->required()
                                                    ->reactive()
                                                    ->afterStateUpdated(function (callable $set, $state, $get) {
                                                        $set('grade_id', $state);
                                                    }),

                                                Forms\Components\TextInput::make('fee_cuota')
                                                    ->label('Fee Cuota')
                                                    ->required()
                                                    ->numeric(),

                                                Forms\Components\Checkbox::make('platform')
                                                    ->label('Platform'),

                                                Forms\Components\Repeater::make('gradeSections')
                                                    ->relationship('gradeSections')
                                                    ->schema([
                                                        Select::make('section_id')
                                                            ->label('Section')
                                                            ->relationship('section', 'name') // Adjust according to your Section model
                                                            ->options(function (callable $get) {
                                                                // Obtén el grade_id seleccionado
                                                                $gradeId = $get('../../grade_id');

                                                                // Busca las secciones asociadas con el grade_id
                                                                return Section::where('grade_id', $gradeId)
                                                                    ->pluck('name', 'id') // Devuelve las opciones de las secciones
                                                                    ->toArray(); // Convierte a un array para que Filament lo pueda utilizar
                                                            })
                                                            ->required(),
                                                        Select::make('main_teacher_id')
                                                            ->relationship('Teacher' , 'first_name')
                                                            ->label('Main Teacher'),
                                                    ])

                                            ])

                                    ])

                            ]),
                    ])
                    ->columnSpan(2), // Adjust based on your layout
            ]);
    }



    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('short_name'),
                TextColumn::make('start_date'),
                TextColumn::make('end_date'),
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
