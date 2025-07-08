<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pop extends Model
{
    public static function getPopSarpen($request)
    {
        $q = Pop::with('pssarpen')->has('pssarpen');
        if (count($request->all()) > 0) {
            if ($request->sbu) {
                $q->where('sbu_id', '=', "{$request->sbu}");
            }

            if ($request->pop_name) {
                $q->where('pop_name', 'like', "%{$request->pop_name}%");
            }

            if ($request->perangkat) {
                $perangkat = $request->perangkat;
                $q->whereHas('pssarpen', function (Builder $query) use ($perangkat) {
                    $query->where('perangkat', 'like', "%{$perangkat}%");
                });
            }

            if ($request->tahun) {
                $tahun = $request->tahun;
                $q->whereHas('pssarpen', function (Builder $query) use ($tahun) {
                    $query->where('tahun', '=', $tahun);
                });
            }
        } else {
            return Pop::with('pssarpen')->has('pssarpen')->get();
        }
        return $q->get();
    }

    public function sbu(): BelongsTo
    {
        return $this->belongsTo(Sbu::class, 'sbu_id', 'sbu_id');
    }

    public function pssarpen(): HasMany
    {
        return $this->hasMany(pssarpen::class, 'pop_id', 'pop_id');
    }
}
