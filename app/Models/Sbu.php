<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sbu extends Model
{
    public function pop(): HasMany
    {
        return $this->hasMany(Pop::class, 'sbu_id', 'sbu_id');
    }
}
