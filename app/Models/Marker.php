<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Facades\DB;

class Marker extends Model
{
    use HasUuids;

    protected $primaryKey = "markerid";

    protected $fillable = ['markerid', 'sbu_name', 'marker_name', 'created_by'];

    public static function createMarker($data)
    {
        return Marker::create($data);
    }

    public static function deleteMarker($markerid)
    {
        return Marker::destroy($markerid);
    }

    public static function updateMarker($markerid, $data)
    {
        return Marker::where('markerid', $markerid)->update($data);
    }
}
