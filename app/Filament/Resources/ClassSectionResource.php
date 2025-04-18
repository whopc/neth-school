<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Tables;
use App\Models\ClassSection;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SectionResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SectionResource\RelationManagers;
use Filament\Forms\Components\Select;


use function Laravel\Prompts\select;

class ClassSectionResource extends Resource
{
    protected static ?string $model = ClassSection::class;

    protected static ?string $navigationIcon = 'fas-puzzle-piece';
    protected static ?string $navigationGroup = 'Estructura Académica';

    protected static ?string $navigationLabel = 'Secciones';

    protected static ?string $pluralModelLabel = 'Secciones';

    protected static ?string $modelLabel = 'Sección';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->columns(2)->schema([

                    TextInput::make('name')->required()
                        ->columnSpan('full')
                        ->label('Nombre'),
                    Select::make('grade_id')
                        ->label('Grado')
                        ->relationship('grade', 'name') // Relación con el modelo Grade
                        ->options(function () {
                            return \App\Models\Grade::all()->pluck('order', 'id')
                                ->mapWithKeys(function ($item, $key) {
                                    $grade = \App\Models\Grade::find($key);
                                    return [$key => $grade->order . ' - ' . $grade->name]; // Concatenar 'order' y 'name'
                                });
                        })
                        ->searchable()
                        ->placeholder('Seleccionar un grado')
                        ->required(),

                    TextInput::make('short_name')->required()
                        ->label('Sigla del sección'),
                ])


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('grade.order')
                    ->label('Orden') // Etiqueta para la columna
                    ->sortable() // Agrega la opción de ordenar por este campo
                    ->searchable(),
                TextColumn::make('grade.name')
                    ->label('Grado') // Etiqueta para la columna
                    ->sortable() // Agrega la opción de ordenar por este campo

                    ->searchable(), // Permite buscar por orden// Permite buscar por orden
                TextColumn::make('name')
                ->label('Nombre'),
                TextColumn::make('short_name')
                ->label('Sigla del sección'),

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
            'index' => Pages\ListClassSections::route('/'),
            'create' => Pages\CreateClassSection::route('/create'),
            'edit' => Pages\EditClassSection::route('/{record}/edit'),
        ];
    }
}
