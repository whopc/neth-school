<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FamilyResource\Pages;
use App\Models\Family;
use App\Models\Progenitor;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Validation\Rule;
use App\Filament\Resources\FamilyResource\RelationManagers;

class FamilyResource extends Resource
{
    protected static ?string $model = Family::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Familias';
    protected static ?string $navigationGroup = 'Comunidad Académica';

    protected static ?string $pluralModelLabel = 'Familias';
    protected static ?string $modelLabel = 'Familia';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('id')
                            ->label('ID')
                            ->disabled() // Deshabilitado para solo lectura
                            ->hidden(fn($record) => is_null($record)) // Ocultar en la creación de registros nuevos
                            ->afterStateHydrated(fn($component, $state) => $state = $component->getRecord()?->id),
                        Grid::make(2)
                            ->schema([
                                // Columna 1: Campos del father
                                Select::make('father_id')
                                    ->label('Padre')
                                    ->relationship('father', 'name')
                                    ->searchable()
                                    ->getSearchResultsUsing(function (string $searchQuery) {
                                        return Progenitor::where('role', 'father')
                                            ->where(function ($query) use ($searchQuery) {
                                                $query->where('name', 'like', "%$searchQuery%")
                                                    ->orWhere('first_last_name', 'like', "%$searchQuery%")
                                                    ->orWhere('id_number', 'like', "%{$searchQuery}%");
                                            })
                                            ->get()
                                            ->mapWithKeys(fn($father) => [
                                                $father->id => "{$father->name} {$father->first_last_name} ({$father->id_number})"
                                            ]);
                                    })
                                    ->getOptionLabelUsing(fn($value) => Progenitor::find($value)?->name . ' ' . Progenitor::find($value)?->first_last_name . ' (' . Progenitor::find($value)?->id_number . ')')
                                    ->createOptionForm([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label('Nombre')
                                                    ->required()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('name', strtoupper($state))),
                                                TextInput::make('first_last_name')
                                                    ->label('Primer Apellido')
                                                    ->required()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('first_last_name', strtoupper($state))),
                                                TextInput::make('second_last_name')
                                                    ->label('Segundo Apellido')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('second_last_name', strtoupper($state))),
                                                Select::make('id_type')
                                                    ->label('Tipo de Identificación')
                                                    ->options([
                                                        'national_id' => 'Cédula',
                                                        'passport' => 'Pasaporte',
                                                    ])
                                                    ->default('national_id')
                                                    ->required()
                                                    ->reactive(),
                                                TextInput::make('id_number')
                                                    ->label('Número de Identificación')
                                                    ->required()
                                                    ->rules(['unique:progenitors,id_number'])
                                                    ->placeholder('Please enter your identification number')
                                                    ->mask(fn(callable $get) => $get('id_type') === 'national_id' ? '999-9999999-9' : null)
                                                    ->maxLength(fn(callable $get) => $get('id_type') === 'national_id' ? 13 : null)
                                                    ->minLength(fn(callable $get) => $get('id_type') === 'national_id' ? 13 : null)
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('id_number', strtoupper($state))),
                                                TextInput::make('home_phone')
                                                    ->label('Numero local')
                                                    ->tel()
                                                    ->mask('(999) 999-9999') // Aplicar la máscara fija para formato de teléfono
                                                    ->maxLength(14) // Longitud máxima incluyendo paréntesis, espacio y guión
                                                    ->minLength(14) // Longitud mínima requerida
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('home_phone', $state)),
                                                TextInput::make('mobile_phone')
                                                    ->label('Numero Mobil')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('mobile_phone', strtoupper($state))),
                                                TextInput::make('place_of_work')
                                                    ->label('Lugar de Trabajo')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('place_of_work', strtoupper($state))),
                                                TextInput::make('work_phone')
                                                    ->label('Numero de Trabajo')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('work_phone', strtoupper($state))),
                                                TextInput::make('email')
                                                    ->label('Correo')
                                                    ->email()
                                                    ->nullable()
                                                    ->rules(['email'])
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('email', strtoupper($state))),
                                                TextInput::make('address')
                                                    ->label('Dirección')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('address', strtoupper($state))),
                                                Select::make('role')
                                                    ->label('Rol')
                                                    ->options(['father' => 'Padre'])
                                                    ->default('father')
                                                    ->hidden(fn() => true)
                                                    ->columnSpan(2),
                                            ]),
                                    ])
                                    ->editOptionForm([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label('Nombre')
                                                    ->required()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('name', strtoupper($state))),
                                                TextInput::make('first_last_name')
                                                    ->label('Primer Apellido')
                                                    ->required()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('first_last_name', strtoupper($state))),
                                                TextInput::make('second_last_name')
                                                    ->label('Segundo Apellido')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('second_last_name', strtoupper($state))),
                                                Select::make('id_type')
                                                    ->label('Tipo de Identificación')
                                                    ->label('Tipo de Documento')
                                                    ->options([
                                                        'national_id' => 'Cédula',
                                                        'passport' => 'Pasaporte',
                                                    ])
                                                    ->required()
                                                    ->reactive(),
                                                TextInput::make('id_number')
                                                    ->label('Numero de Identificación')
                                                    ->required()
                                                    ->rules([
                                                        fn($component) => Rule::unique('progenitors', 'id_number')->ignore($component->getRecord()?->id)
                                                    ])
                                                    ->placeholder('Por Favor Digite el Numero de Identificación')
                                                    ->mask(fn(callable $get) => $get('id_type') === 'national_id' ? '999-9999999-9' : null)
                                                    ->maxLength(fn(callable $get) => $get('id_type') === 'national_id' ? 13 : null)
                                                    ->minLength(fn(callable $get) => $get('id_type') === 'national_id' ? 13 : null)
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('id_number', strtoupper($state))),
                                                TextInput::make('home_phone')
                                                    ->label('Numero local')
                                                    ->tel()
                                                    ->mask('(999) 999-9999') // Aplicar la máscara fija para formato de teléfono
                                                    ->maxLength(14) // Longitud máxima incluyendo paréntesis, espacio y guión
                                                    ->minLength(14) // Longitud mínima requerida
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('home_phone', $state)),
                                                TextInput::make('mobile_phone')
                                                    ->label('Numero Mobil')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('mobile_phone', strtoupper($state))),
                                                TextInput::make('place_of_work')
                                                    ->label('Lugar de Trabajo')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('place_of_work', strtoupper($state))),
                                                TextInput::make('work_phone')
                                                    ->label('Numero de Trabajo')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('work_phone', strtoupper($state))),
                                                TextInput::make('email')
                                                    ->label('Correo')
                                                    ->email()
                                                    ->nullable()
                                                    ->rules(['email'])
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('email', strtoupper($state))),
                                                TextInput::make('address')
                                                    ->label('Dirección')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('address', strtoupper($state))),
                                                Select::make('role')
                                                    ->label('Rol')
                                                    ->options(['father' => 'Father'])
                                                    ->default('father')
                                                    ->hidden(fn() => true)
                                                    ->columnSpan(2),
                                            ]),
                                    ])
                                    ->reactive()
                                    ->afterStateUpdated(fn($set, $state, $get) => $set('apellido_madre', Progenitor::find($get('mother_id'))?->first_last_name ?? ''))
                                    ->afterStateUpdated(fn($set, $state, $get) => $set('nombre_madre', Progenitor::find($get('mother_id'))?->name ?? ''))
                                    ->afterStateUpdated(fn($set, $state, $get) => $set('apellido_padre', Progenitor::find($get('father_id'))?->first_last_name ?? ''))
                                    ->afterStateUpdated(fn($set, $state, $get) => $set('nombre_padre', Progenitor::find($get('father_id'))?->name ?? ''))
                                    ->afterStateUpdated(fn(callable $set, $state, $get) => $set('last_name', trim((Progenitor::find($get('father_id'))?->first_last_name ?? '') . ' ' . (Progenitor::find($get('mother_id'))?->first_last_name ?? '')))),

                                // Columna 2: Campos de la mother
                                Select::make('mother_id')
                                    ->label('Madre')
                                    ->relationship('mother', 'name')
                                    ->searchable()
                                    ->required()
                                    ->getSearchResultsUsing(function (string $searchQuery) {
                                        return Progenitor::where('role', 'mother')
                                            ->where(function ($query) use ($searchQuery) {
                                                $query->where('name', 'like', "%{$searchQuery}%")
                                                    ->orWhere('first_last_name', 'like', "%{$searchQuery}%")
                                                    ->orWhere('id_number', 'like', "%{$searchQuery}%");
                                            })
                                            ->get()
                                            ->mapWithKeys(fn($mother) => [
                                                $mother->id => "{$mother->name} {$mother->first_last_name} ({$mother->id_number})"
                                            ]);
                                    })
                                    ->getOptionLabelUsing(fn($value) => Progenitor::find($value)?->name . ' ' . Progenitor::find($value)?->first_last_name . ' (' . Progenitor::find($value)?->id_number . ')')
                                    ->createOptionForm([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label('Nombre')
                                                    ->required()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('name', strtoupper($state))),
                                                TextInput::make('first_last_name')
                                                    ->label('Primer Apellido')
                                                    ->required()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('first_last_name', strtoupper($state))),
                                                TextInput::make('second_last_name')
                                                    ->label('Segundo Apellido')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('second_last_name', strtoupper($state))),
                                                Select::make('id_type')
                                                    ->label('Tipo de Identificacíón')
                                                    ->options([
                                                        'national_id' => 'Cédula',
                                                        'passport' => 'Pasaporte',
                                                    ])
                                                    ->default('national_id')
                                                    ->required()
                                                    ->reactive()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('id_number', '')),
                                                TextInput::make('id_number')
                                                    ->label('Numero de Identificación')
                                                    ->required()
                                                    ->rules(['unique:progenitors,id_number'])
                                                    ->placeholder('Please enter your identification number')
                                                    ->mask(fn(callable $get) => $get('id_type') === 'national_id' ? '999-9999999-9' : null)
                                                    ->maxLength(fn(callable $get) => $get('id_type') === 'national_id' ? 13 : null)
                                                    ->minLength(fn(callable $get) => $get('id_type') === 'national_id' ? 13 : null)
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('id_number', strtoupper($state))),
                                                TextInput::make('home_phone')
                                                    ->label('Teléfono Local')
                                                    ->tel()
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('home_phone', strtoupper($state))),
                                                TextInput::make('mobile_phone')
                                                    ->label('Celular')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('mobile_phone', strtoupper($state))),
                                                TextInput::make('place_of_work')
                                                    ->label('Lugar de Trabajo')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('place_of_work', strtoupper($state))),
                                                TextInput::make('work_phone')
                                                    ->label('Teléfono de Trabajo')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('work_phone', strtoupper($state))),
                                                TextInput::make('email')
                                                    ->label('Correo')
                                                    ->email()
                                                    ->nullable()
                                                    ->rules(['email'])
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('email', strtoupper($state))),
                                                TextInput::make('address')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('address', strtoupper($state))),
                                                Select::make('role')
                                                    ->options(['father' => 'Father', 'mother' => 'Mother'])
                                                    ->default('mother')
                                                    ->columnSpan(2),
                                            ]),
                                    ])
                                    ->editOptionForm([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('name')
                                                    ->required()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('name', strtoupper($state))),
                                                TextInput::make('first_last_name')
                                                    ->required()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('first_last_name', strtoupper($state))),
                                                TextInput::make('second_last_name')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('second_last_name', strtoupper($state))),
                                                Select::make('id_type')
                                                    ->label('Id Type')
                                                    ->options([
                                                        'national_id' => 'National Id',
                                                        'passport' => 'passport',
                                                    ])
                                                    ->required()
                                                    ->reactive()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('id_type', $state->record->id_type ?? 'national_id')),
                                                TextInput::make('id_number')
                                                    ->label('Identification Number')
                                                    ->required()
                                                    ->rules([
                                                        fn($component) => Rule::unique('progenitors', 'id_number')->ignore($component->getRecord()?->id)
                                                    ])
                                                    ->placeholder('Please enter your identification number')
                                                    ->mask(fn(callable $get) => $get('id_type') === 'national_id' ? '999-9999999-9' : null)
                                                    ->maxLength(fn(callable $get) => $get('id_type') === 'national_id' ? 13 : null)
                                                    ->minLength(fn(callable $get) => $get('id_type') === 'national_id' ? 13 : null)
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('id_number', strtoupper($state))),
                                                TextInput::make('home_phone')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('home_phone', strtoupper($state))),
                                                TextInput::make('mobile_phone')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('mobile_phone', strtoupper($state))),
                                                TextInput::make('place_of_work')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('place_of_work', strtoupper($state))),
                                                TextInput::make('work_phone')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('work_phone', strtoupper($state))),
                                                TextInput::make('email')
                                                    ->email()
                                                    ->nullable()
                                                    ->rules(['email'])
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('email', strtoupper($state))),
                                                TextInput::make('address')
                                                    ->nullable()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('address', strtoupper($state))),
                                                Select::make('role')
                                                    ->options(['father' => 'Father', 'mother' => 'Mother'])
                                                    ->default('mother')
                                                    ->columnSpan(2),
                                            ]),
                                    ])
                                    ->rules(function (callable $get) {
                                        return function ($attribute, $value, $fail) use ($get) {
                                            $fatherId = $get('father_id');
                                            $motherId = $value;
                                            $familiaId = $get('id'); // Obtener el ID del registro actual

                                            $exists = Family::where('father_id', $fatherId)
                                                ->where('mother_id', $motherId)
                                                ->where('id', '!=', $familiaId) // Ignorar el registro actual
                                                ->whereNull('deleted_at') // Asegúrate de manejar registros soft-deleted
                                                ->exists();

                                            if ($exists) {
                                                $fail('La combinación de father y mother ya existe en otra familia.');
                                            }
                                        };
                                    })
                                    ->reactive()
                                    ->afterStateUpdated(fn($set, $state, $get) => $set('apellido_madre', Progenitor::find($get('mother_id'))?->first_last_name ?? ''))
                                    ->afterStateUpdated(fn($set, $state, $get) => $set('nombre_madre', Progenitor::find($get('mother_id'))?->name ?? ''))
                                    ->afterStateUpdated(fn($set, $state, $get) => $set('apellido_padre', Progenitor::find($get('father_id'))?->first_last_name ?? ''))
                                    ->afterStateUpdated(fn($set, $state, $get) => $set('nombre_padre', Progenitor::find($get('father_id'))?->name ?? ''))
                                    ->afterStateUpdated(fn(callable $set, $state, $get) => $set('last_name', trim((Progenitor::find($get('father_id'))?->first_last_name ?? '') . ' ' . (Progenitor::find($get('mother_id'))?->first_last_name ?? '')))),
                            ]),

                        TextInput::make('last_name')
                            ->label('Apellidos Familia')
                            ->required()
                            ->afterStateUpdated(fn($state, callable $set) => $set('last_name', strtoupper($state)))
                            ->reactive(),
                        Section::make('Detalles de los Padres')
                            ->schema([
                                TextInput::make('nombre_padre')
                                    ->label('Nombre del Padre')
                                    ->disabled()
                                    ->reactive()
                                    ->afterStateHydrated(fn($set, $get) => $set('nombre_padre', Progenitor::find($get('father_id'))?->name ?? '')),
                                TextInput::make('apellido_padre')
                                    ->label('Apellido del Padre')
                                    ->disabled()
                                    ->reactive()
                                    ->afterStateHydrated(fn($set, $get) => $set('apellido_padre', Progenitor::find($get('father_id'))?->first_last_name ?? '')),
                                TextInput::make('nombre_madre')
                                    ->label('Nombre de la Madre')
                                    ->disabled()
                                    ->reactive()
                                    ->afterStateHydrated(fn($set, $get) => $set('nombre_madre', Progenitor::find($get('mother_id'))?->name ?? '')),
                                TextInput::make('apellido_madre')
                                    ->label('Apellido de la Madre')
                                    ->disabled()
                                    ->reactive()
                                    ->afterStateHydrated(fn($set, $get) => $set('apellido_madre', Progenitor::find($get('mother_id'))?->first_last_name ?? '')),
                            ])
                            ->columns(2),
                        Section::make('Tutor')
                            ->schema([
                                Toggle::make('tutor_enabled')
                                    ->label('Habilitar Tutor')
                                    ->reactive()
                                    ->default(false),

                                TextInput::make('t_name')
                                    ->label('name del Tutor')
                                    ->visible(fn($get) => $get('tutor_enabled'))
                                    ->nullable()
                                    ->afterStateUpdated(fn($state, callable $set) => $set('t_name', strtoupper($state))),

                                TextInput::make('t_last_name')
                                    ->label('last_name del Tutor')
                                    ->visible(fn($get) => $get('tutor_enabled'))
                                    ->nullable()
                                    ->afterStateUpdated(fn($state, callable $set) => $set('t_last_name', strtoupper($state))),

                                TextInput::make('t_address')
                                    ->label('Dirección del Tutor')
                                    ->visible(fn($get) => $get('tutor_enabled'))
                                    ->nullable()
                                    ->afterStateUpdated(fn($state, callable $set) => $set('t_address', strtoupper($state))),

                                TextInput::make('t_telephone')
                                    ->label('Teléfono del Tutor')
                                    ->visible(fn($get) => $get('tutor_enabled'))
                                    ->nullable()
                                    ->afterStateUpdated(fn($state, callable $set) => $set('t_telephone', strtoupper($state))),

                                TextInput::make('kinship')
                                    ->label('Parentesco del Tutor')
                                    ->visible(fn($get) => $get('kinship'))
                                    ->nullable()
                                    ->afterStateUpdated(fn($state, callable $set) => $set('kinship', strtoupper($state))),
                            ])
                            ->columns(2),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('last_name')
                    ->label('Apellidos')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('father.name')
                    ->label('Padre')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('mother.name')
                    ->label('Madre')
                    ->sortable()
                    ->searchable(),
            ])
            ->actions([
                ActionGroup::make([
                    Actions\EditAction::make(),
                    Actions\ViewAction::make(),
                    Actions\DeleteAction::make(),
                ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\StudentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFamilies::route('/'),
            'create' => Pages\CreateFamily::route('/create'),
            'edit' => Pages\EditFamily::route('/{record}/edit'),
        ];
    }
}
