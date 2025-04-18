<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use App\Filament\Resources\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'fas-chalkboard-teacher';

    protected static ?string $navigationLabel = 'Docentes';
    protected static ?string $navigationGroup = 'Comunidad Académica';

    protected static ?string $pluralModelLabel = 'Docentes';
    protected static ?string $modelLabel = 'Docente';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                    ->label('Nombres')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->label('Apellidos')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('id_number')
                    ->label('Cédula')
                    ->placeholder('Please enter your identification number')
                    ->mask('999-9999999-9')
                    //->unique()
//                    ->rules([
//                        'unique:teachers,id_number' => __('Esta cédula pertenece a otra docente ya registrado.'),
//                    ])
                    ->rules(function (callable $get) {
                        return function ($attribute, $value, $fail) use ($get) {
                            $recordId = $get('id'); // Opcional: ID del registro actual si estás editando un registro existente

                            $exists = Teacher::where('id_number', $value)
                                ->when($recordId, function ($query) use ($recordId) {
                                    $query->where('id', '!=', $recordId); // Ignorar el registro actual si aplica
                                })
                                ->exists();

                            if ($exists) {
                                $fail('Este número de identificación ya está asignado a otra persona.');
                            }
                        };
                    })

                    ->maxLength(13)
                    ->minLength(13)
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('dob')
                    ->label('Fecha de Nacimiento')
                    ->required(),
                Forms\Components\Select::make('gender')
                    ->label('Genero')
            ->options([ 'masculino' => 'Masculino', 'femenino' => 'Femenino' ,
               ]),
                Forms\Components\TextInput::make('address')
                    ->label('Dirección')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                ->label('Teléfono')
                    ->tel()
                    ->mask('(999) 999-9999') // Aplicar la máscara fija para formato de teléfono
                    ->maxLength(14) // Longitud máxima incluyendo paréntesis, espacio y guión
                    ->minLength(14) // Longitud mínima requerida
                    ->afterStateUpdated(fn($state, callable $set) => $set('phone', $state))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Correo Personal')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('user_email')
                    ->label('Correo Institucional')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('specialization')
                    ->label('Especialidad')
                    ->maxLength(255),
                Forms\Components\TextInput::make('academic_degree')
                    ->label('Grado Académico')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('hire_date')
                    ->label('Fecha de Ingreso')
                    ->required(),
                Forms\Components\Toggle::make('status')
                    ->label('Estado')
                    ->required(),
                Forms\Components\Select::make('contract_type')
                    ->label('Genero')
                    ->options([ 'minerd' => 'MINERD', 'privado' => 'Privado' ,
                    ]),
                Forms\Components\TextInput::make('salary')
                    ->label('Salario')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->label('Nombres')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Apellidos')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dob')
                    ->label('Fecha de Nacimiento')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Genero')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Teléfono')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('contract_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('salary')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
