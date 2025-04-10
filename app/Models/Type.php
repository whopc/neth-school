<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Type extends Model
{
    const ADMIN= 1;

    const TEACHER= 2;
    const STUDENT= 3;
    const FAMILY= 4;

    protected $table = 'types';
    protected $fillable = [
        'name',
        ];
    public $timestamps = false;

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }


}


