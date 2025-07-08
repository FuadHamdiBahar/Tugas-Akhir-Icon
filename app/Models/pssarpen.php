<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class pssarpen extends Model
{
    use HasUuids;

    public static function getPsSarpen($request)
    {
        $q = pssarpen::with('pop');
        if (count($request->all()) > 0) {
            if ($request->sbu) {
                $sbu = $request->sbu;
                $q->whereHas('pop', function (Builder $query) use ($sbu) {
                    $query->where('sbu_id', '=', "{$sbu}");
                });
            }

            if ($request->pop_name) {
                $pop_name = strtoupper($request->pop_name);
                $q->whereHas('pop', function (Builder $query) use ($pop_name) {
                    $query->where('pop_name', 'like', "%{$pop_name}%");
                });
            }

            if ($request->perangkat) {
                $q->where('perangkat', 'like', "%{$request->perangkat}%");
            }

            if ($request->tahun) {
                $q->where('tahun', '=', $request->tahun);
            }
        } else {
            return pssarpen::with('pop')->get();
        }

        return $q->get();
    }

    public function pop(): BelongsTo
    {
        return $this->belongsTo(Pop::class, 'pop_id', 'pop_id');
    }

    public function sbuPsSarpen(): HasOneThrough
    {
        return $this->hasOneThrough(Sbu::class, Pop::class, 'pop_id', 'sbu_id', 'psid', 'pop_id');
    }
}
