<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pop extends Model
{
    public function sbu(): BelongsTo
    {
        return $this->belongsTo(Sbu::class, 'sbu_id', 'sbu_id');
    }

    public function pssarpen(): HasMany
    {
        return $this->hasMany(pssarpen::class, 'pop_id', 'pop_id');
    }
}
