<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\DB;
use PDO;

class Point extends Model
{
    use HasUuids;

    protected $primaryKey = "pointid";

    protected $fillable = ['pointid', 'refid', 'lat', 'lng', 'created_by', 'updated_by'];

    public static function updatePoint($pointid, $data)
    {
        return Point::where('pointid', $pointid)->update($data);
    }

    public static function deletePoint($pointid)
    {
        return Point::where('pointid', $pointid)->delete();
    }

    public static function getPoint($pointid)
    {
        return Point::where('pointid', $pointid)->first();
    }

    public static function deletePointByRefId($refid)
    {
        return Point::where('refid', $refid)->delete();
    }

    public static function createPoint($data)
    {
        return Point::create($data);
    }

    public static function updatePointByRefId($refid, $data)
    {
        return Point::where('refid', $refid)->update($data);
    }
}
