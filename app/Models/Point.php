<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\DB;

class Point extends Model
{
    use HasUuids;

    protected $primaryKey = "pointid";

    protected $fillable = ['pointid', 'refid', 'lat', 'lng', 'created_by'];

    public static function createPoint($data)
    {
        return Point::create($data);
    }

    public static function updatePoint($markerid, $data)
    {
        return Point::where('refid', $markerid)->update($data);
    }
}
