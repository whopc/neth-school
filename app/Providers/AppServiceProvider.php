<?php

namespace App\Providers;

use App\Models\AcademicGrade;
use App\Models\AcademicYear;
use App\Models\GradeClassSection;
use App\Models\ClassSection;
use Filament\Forms\Components\TextInput;
use Filament\Support\View\Components\Modal;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //let the magic
        Modal::closedByClickingAway(false);

        TextInput::configureUsing(function (TextInput $textInput) {
            $textInput->afterStateUpdated(function (&$state) {
                \Log::info('Se ejecutó afterStateUpdated con el estado: '.$state);
                $state = strtoupper($state);
            });
        });
        Validator::replacer('unique', function ($message, $attribute, $rule, $parameters) {
            if ($attribute === 'id_number' && $rule === 'unique') {
                return 'Esta cédula pertenece a otra docente ya registrado.';
            }
            return $message;
        });



    }
}
