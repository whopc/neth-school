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

class FamilyResource extends Resource
{
    protected static ?string $model = Family::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Familias';
    protected static ?string $navigationGroup = 'Academic Community';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                // Columna 1: Campos del father
                                Select::make('father_id')
                                    ->label('Father')
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
                                                        'national_id' => 'National id',
                                                        'passport' => 'Passaport',
                                                    ])
                                                    ->default('national_id')
                                                    ->required()
                                                    ->reactive(),
                                                TextInput::make('id_number')
                                                    ->label('Número de Identificación')
                                                    ->required()
                                                    ->rules(['unique:progenitors,id_number'])
                                                    ->placeholder('Please enter your identification number')
                                                    ->mask(fn (callable $get) => $get('id_type') === 'national_id' ? '999-9999999-9' : null)
                                                    ->maxLength(fn (callable $get) => $get('id_type') === 'national_id' ? 13 : null)
                                                    ->minLength(fn (callable $get) => $get('id_type') === 'national_id' ? 13 : null)
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
                                                    ->options(['father' => 'Father'])
                                                    ->default('father')
                                                    ->hidden(fn () => true)
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
                                                    ->label('Tipo de Documento')
                                                    ->options([
                                                        'national_id' => 'National Id',
                                                        'passport' => 'passport',
                                                    ])
                                                    ->required()
                                                    ->reactive(),
                                                TextInput::make('id_number')
                                                    ->label('Id Number')
                                                    ->required()
                                                    ->rules([
                                                        fn($component) => Rule::unique('progenitors', 'id_number')->ignore($component->getRecord()?->id)
                                                    ])
                                                    ->placeholder('Please enter your identification number')
                                                    ->mask(fn (callable $get) => $get('id_type') === 'national_id' ? '999-9999999-9' : null)
                                                    ->maxLength(fn (callable $get) => $get('id_type') === 'national_id' ? 13 : null)
                                                    ->minLength(fn (callable $get) => $get('id_type') === 'national_id' ? 13 : null)
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
                                                    ->options(['father' => 'Father'])
                                                    ->default('father')
                                                    ->hidden(fn () => true)
                                                    ->columnSpan(2),
                                            ]),
                                    ])
                                    ->reactive()
                                    ->afterStateUpdated(fn(callable $set, $state, $get) => $set('last_name', trim((Progenitor::find($get('father_id'))?->first_last_name ?? '') . ' ' . (Progenitor::find($get('mother_id'))?->first_last_name ?? '')))),

                                // Columna 2: Campos de la mother
                                Select::make('mother_id')
                                    ->label('Mother')
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
                                                    ->default('national_id')
                                                    ->required()
                                                    ->reactive()
                                                    ->afterStateUpdated(fn($state, callable $set) => $set('id_number', '')),
                                                TextInput::make('id_number')
                                                    ->label('Identification Number')
                                                    ->required()
                                                    ->rules(['unique:progenitors,id_number'])
                                                    ->placeholder('Please enter your identification number')
                                                    ->mask(fn (callable $get) => $get('id_type') === 'national_id' ? '999-9999999-9' : null)
                                                    ->maxLength(fn (callable $get) => $get('id_type') === 'national_id' ? 13 : null)
                                                    ->minLength(fn (callable $get) => $get('id_type') === 'national_id' ? 13 : null)
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
                                                    ->options(['father' => 'Father','mother' => 'Mother'])
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
                                                    //->value(fn ($record) => $record->id_type) // Cargar el valor actual al editar
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
                                                    ->mask(fn (callable $get) => $get('id_type') === 'national_id' ? '999-9999999-9' : null)
                                                    ->maxLength(fn (callable $get) => $get('id_type') === 'national_id' ? 13 : null)
                                                    ->minLength(fn (callable $get) => $get('id_type') === 'national_id' ? 13 : null)
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
                                                    ->options(['father' => 'Father','mother' => 'Mother'])
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
                                    ->afterStateUpdated(fn(callable $set, $state, $get) => $set('last_name', trim((Progenitor::find($get('father_id'))?->first_last_name ?? '') . ' ' . (Progenitor::find($get('mother_id'))?->first_last_name ?? '')))),
                            ]),

                        TextInput::make('last_name')
                            ->label('Family')
                            ->required()
                            ->afterStateUpdated(fn($state, callable $set) => $set('last_name', strtoupper($state)))
                            ->reactive(),

                        Section::make('Tutor')
                            ->schema([
                                Toggle::make('tutor_enabled')
                                    ->label('Habilitar Tutor')
                                    ->reactive()
                                    ->default(false),

                                TextInput::make('t_name')
                                    ->label('name del Tutor')
                                    ->visible(fn ($get) => $get('tutor_enabled'))
                                    ->nullable()
                                    ->afterStateUpdated(fn($state, callable $set) => $set('t_name', strtoupper($state))),

                                TextInput::make('t_last_name')
                                    ->label('last_name del Tutor')
                                    ->visible(fn ($get) => $get('tutor_enabled'))
                                    ->nullable()
                                    ->afterStateUpdated(fn($state, callable $set) => $set('t_last_name', strtoupper($state))),

                                TextInput::make('t_address')
                                    ->label('Dirección del Tutor')
                                    ->visible(fn ($get) => $get('tutor_enabled'))
                                    ->nullable()
                                    ->afterStateUpdated(fn($state, callable $set) => $set('t_address', strtoupper($state))),

                                TextInput::make('t_telephone')
                                    ->label('Teléfono del Tutor')
                                    ->visible(fn ($get) => $get('tutor_enabled'))
                                    ->nullable()
                                    ->afterStateUpdated(fn($state, callable $set) => $set('t_telephone', strtoupper($state))),

                                TextInput::make('kinship')
                                    ->label('Parentezco del Tutor')
                                    ->visible(fn ($get) => $get('kinship'))
                                    ->nullable()
                                    ->afterStateUpdated(fn($state, callable $set) => $set('parentezco', strtoupper($state))),
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
                    ->label('last_name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('father.name')
                    ->label('Father')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('mother.name')
                    ->label('Mother')
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
            // Aquí podrías agregar relaciones adicionales si las tienes
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
