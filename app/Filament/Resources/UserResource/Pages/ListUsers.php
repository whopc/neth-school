<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
//use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(),
            'ADMIN' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereHas('role', function ($q) {
                        $q->where('name', 'ADMIN');
                    });

                })
                ->badge(function () {
                    return \App\Models\User::whereHas('role', function ($q) {
                        $q->where('name', 'ADMIN');
                    })->count();
                })
                ->badgeColor('danger'),



            'TEACHER' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereHas('role', function ($q) {
                        $q->where('name', 'TEACHER');
                    });
                })
                ->badge(function () {
                    return \App\Models\User::whereHas('role', function ($q) {
                        $q->where('name', 'TEACHER');
                    })->count();
                })
                ->badgeColor('info'),
            'STUDENT' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereHas('role', function ($q) {
                        $q->where('name', 'STUDENT');
                    });
                })
                ->badge(function () {
                    return \App\Models\User::whereHas('role', function ($q) {
                        $q->where('name', 'STUDENT');
                    })->count();
                })
                ->badgeColor('success'),
            'FAMILY' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) {
                    $query->whereHas('role', function ($q) {
                        $q->where('name', 'FAMILY');
                    });
                })
                ->badge(function () {
                    return \App\Models\User::whereHas('role', function ($q) {
                        $q->where('name', 'FAMILY');
                    })->count();
                })
                ->badgeColor('warning'),

        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
