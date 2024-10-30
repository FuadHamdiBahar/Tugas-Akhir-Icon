<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Polygon extends Model
{
    use HasUuids;

    protected $fillable = ['sbu_name', 'polygon_name', 'created_by', 'updated_by'];

    protected $primaryKey = "polygonid";

    public static function createPolygon($data)
    {
        return Polygon::create($data);
    }

    public static function updatePolygon($polygonid, $data)
    {
        Polygon::where('polygonid', $polygonid)->update($data);
    }

    public static function deletePolygon($polygonid)
    {
        return Polygon::where('polygonid', $polygonid)->delete();
    }

    public static function getPolygon($polygonid)
    {
        $polygon = Polygon::where('polygonid', $polygonid)->first();
        $points = Point::where('refid', $polygonid)->get();

        $result = [];
        foreach ($points as $p) {
            array_push($result, [$p->lng, $p->lat]);
        }

        return [
            'sbu_name' => $polygon->sbu_name,
            'polygon_name' => $polygon->polygon_name,
            'points' => $result,
            'data' => $points
        ];
    }
}
