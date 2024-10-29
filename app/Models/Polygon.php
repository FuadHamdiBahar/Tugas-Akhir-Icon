<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Polygon extends Model
{
    use HasUuids;

    protected $fillable = ['sbu_name'];

    protected $primaryKey = "polygonid";

    public static function getPolygon($polygonid)
    {
        $polygon = Polygon::where('polygonid', $polygonid)->first();
        $points = Point::where('refid', $polygonid)->get(['lat', 'lng']);

        $result = [];
        foreach ($points as $p) {
            array_push($result, [$p->lng, $p->lat]);
        }

        return [
            'info' => $polygon->polygon_name,
            'points' => $result
        ];
    }
}
