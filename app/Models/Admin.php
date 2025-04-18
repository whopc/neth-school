<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Admin extends User
{
  public function newQuery($excludeDeleted = true): Builder
  {
      return parent::newQuery($excludeDeleted)
          ->where('role_id', Role::ADMIN);
  }
}
