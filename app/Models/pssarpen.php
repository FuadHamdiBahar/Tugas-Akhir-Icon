<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class pssarpen extends Model
{
    use HasUuids;

    public static function getPsSarpen($request)
    {
        $q = pssarpen::with('pop');
        if (count($request->all()) > 0) {
            if ($request->tahun) {
                $q->where('tahun', '=', $request->tahun);
            }

            if ($request->perangkat) {
                $q->where('perangkat', 'like', "%{$request->perangkat}%");
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
}
