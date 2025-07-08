<?php

namespace App\Http\Controllers;

use App\Models\ApiModel;
use App\Models\Marker;
use App\Models\Point;
use App\Models\Polygon;
use App\Models\Pop;
use App\Models\pssarpen;
use App\Models\Sbu;
use App\Models\TrendModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function pssarpenMarker(Request $request)
    {
        return Pop::getPopSarpen($request);
    }

    public function pssarpen(Request $request)
    {
        // return pssarpen::with('pop')->with('sbu')->get();
        $data['data'] = pssarpen::getPsSarpen($request);
        return $data;
    }

    public function deletePoint($pointid)
    {
        return Point::deletePoint($pointid);
    }

    public function updatePoint(Request $request)
    {
        $pointid = $request->input('pointid');
        $email = session('email');
        $data = [
            'lat' => $request->input('lat'),
            'lng' => $request->input('lng'),
            'updated_by' => $email,
        ];

        return Point::updatePoint($pointid, $data);
    }

    public function createPoint(Request $request)
    {
        $email = session('email');
        $data = [
            'refid' => $request->post('refid'),
            'lat' => $request->post('lat'),
            'lng' => $request->post('lng'),
            'created_by' => $email,
            'updated_by' => $email
        ];

        return Point::createPoint($data);
    }

    public function retrieveSinglePoint($pointid)
    {
        return Point::getPoint($pointid);
    }

    public function createPolygon(Request $request)
    {
        $email = session('email');
        $data = [
            'sbu_name' => $request->post('sbuname'),
            'polygon_name' => $request->post('polygonname'),
            'created_by' => $email,
            'updated_by' => $email,
        ];

        return Polygon::createPolygon($data);
    }

    public function updatePolygon(Request $request)
    {
        $polygonid = $request->input('polygonid');
        $data = [
            'sbu_name' => $request->input('sbuname'),
            'polygon_name' => $request->input('polygonname'),
        ];
        Polygon::updatePolygon($polygonid, $data);
        return $request;
    }
    public function deletePolygon($polygonid)
    {
        // hapus point
        Point::deletePoint($polygonid);
        // hapus polygon
        return Polygon::deletePolygon($polygonid);
    }

    public function retrieveSinglePolygon($polygonid)
    {
        return Polygon::getPolygon($polygonid);
    }

    public function retrievePolygon()
    {
        return ['data' => Polygon::all()];
    }

    public function deleteMarker($markerid)
    {
        // hapus point
        Point::deletePointByRefId($markerid);
        // hapus marker
        return Marker::deleteMarker($markerid);
    }

    public function updateMarker(Request $request)
    {
        // get user email
        $email = session('email');
        $markerid = $request->input('markerid');

        // input marker
        $data = [
            'sbu_name' => $request->input('sbuname'),
            'marker_name' => $request->input('markername'),
            'updated_by' => $email
        ];
        Marker::updateMarker($markerid, $data);

        // input point
        $data = [
            'lat' => $request->post('lat'),
            'lng' => $request->post('lng'),
            'updated_by' => $email
        ];
        Point::updatePointByRefId($markerid, $data);
        return $request;
    }

    public function createMarker(Request $request)
    {
        // email
        $email = session('email');

        // create marker array data
        $data = [
            'sbu_name' => $request->post('sbuname'),
            'marker_name' => $request->post('markername'),
            'created_by' => $email,
            'updated_by' => $email,
        ];

        $newMarker = Marker::createMarker($data);

        // create point array data
        $data = [
            'refid' => $newMarker->markerid,
            'lat' => $request->post('lat'),
            'lng' => $request->post('lng'),
            'created_by' => $email
        ];

        // insert point
        Point::createPoint($data);
        return $request;
    }

    public function retrieveSingleMarker($markerid)
    {
        $data = DB::select("SELECT * FROM markers m JOIN points p on m.markerid = p.refid WHERE m.markerid = '$markerid'");
        if (count($data) > 0) {
            return $data[0];
        }
        return null;
    }

    public function retrieveMarker()
    {
        return ['data' => Marker::all()];
    }

    public function sbuPolygon($sbu)
    {
        $polyid = DB::select("SELECT p.polygonid FROM polygons p WHERE p.sbu_name = '$sbu'");

        $result = [];
        foreach ($polyid as $item) {
            $polyPoint = [];
            $points = DB::select("SELECT * FROM points p WHERE p.refid = '$item->polygonid'");
            foreach ($points as $po) {
                array_push($polyPoint, [$po->lng, $po->lat]);
            }
            array_push($result, $polyPoint);
        }
        return $result;
    }

    public function sbuMarker($sbu)
    {
        // $sql = "select 
        //             temp.*, concat(traffic.host_name, ' -> ', traffic.description, ' : ', traffic.traffic, ' Gbps') as info 
        //         from (
        //             select 
        //                 m.sbu_name, m.markerid, m.marker_name, p.lat, p.lng, mh.hostid 
        //             from myapp.markers m 
        //             join myapp.points p on m.markerid = p.refid
        //             left join myapp.marker_hosts mh on mh.markerid = m.markerid
        //             where m.sbu_name = '$sbu'
        //         ) temp 
        //         left join (
        //             select 
        //                 h.hostid, h.ring, h.host_name, it.interface_name, it.description,
        //                 round(it.capacity / 1000000000, 1) as capacity, 
        //                 round(max(wt.traffic) / 1000000000, 1) as traffic
        //             from myapp.hosts h
        //             join myapp.interfaces it on it.hostid = h.hostid 
        //             join myapp.weekly_trends wt on it.interfaceid = wt.interfaceid 
        //             where h.sbu_name = '$sbu'
        //             and wt.`month` = MONTH(CURRENT_DATE()) 
        //             group by h.host_name, it.interface_name, h.ring, it.capacity, h.hostid, it.description
        //             order by ring
        //         ) traffic on temp.hostid = traffic.hostid";
        // return DB::select($sql);

        $sql = "SELECT * FROM markers m JOIN points p ON m.markerid = p.refid WHERE m.sbu_name = '$sbu'";
        $marker = DB::select($sql);

        foreach ($marker as $m) {
            $sql = "
            select 
                concat(traffic.host_name, ' -> ', traffic.description, ' : ', traffic.traffic, ' Gbps') as info 
            from (
                select 
                    m.sbu_name, m.markerid, m.marker_name, p.lat, p.lng, mh.hostid 
                from myapp.markers m 
                join myapp.points p on m.markerid = p.refid
                left join myapp.marker_hosts mh on mh.markerid = m.markerid
            ) temp 
            join (
                select 
                    h.hostid, h.ring, h.host_name, it.interface_name, it.description,
                    round(it.capacity / 1000000000, 1) as capacity, 
                    round(max(wt.traffic) / 1000000000, 1) as traffic
                from myapp.hosts h
                join myapp.interfaces it on it.hostid = h.hostid 
                join myapp.weekly_trends wt on it.interfaceid = wt.interfaceid 	
                where wt.`month` = MONTH(CURRENT_DATE()) 
                group by h.host_name, it.interface_name, h.ring, it.capacity, h.hostid, it.description
                order by ring
            ) traffic on temp.hostid = traffic.hostid
            where temp.markerid = '$m->markerid'";

            $hosts = DB::select($sql);
            $temp = '';
            foreach ($hosts as $i => $h) {
                $idx = $i + 1;
                $temp .= "<br>$idx." . $h->info;
            }

            // if (count($hosts) > 1) {
            $m->info = $temp;
            // } else {
            // $m->info = '';
            // }
            # code...
        }
        return $marker;
    }

    public function deleteInterface($interfaceid)
    {
        return TrendModel::deleteInterface($interfaceid);
    }

    public function updateInterface(Request $request)
    {
        return TrendModel::updateInterface($request);
    }

    public function createInterface(Request $request)
    {
        return TrendModel::createInterface($request);
    }

    public function retrieveSingleInterface($interfaceid)
    {
        return TrendModel::retrieveSingleInterface($interfaceid);
    }

    public function retrieveInterface($hostid)
    {
        $data = array(
            'data' => TrendModel::retrieveInterface($hostid)
        );
        return $data;
    }

    public function deleteHost($hostid)
    {
        return TrendModel::deleteHost($hostid);
    }

    public function createHost(Request $request)
    {
        return TrendModel::createHost($request);
    }

    public function updateHost(Request $request)
    {
        return TrendModel::updateHost($request);
    }

    public function retrieveSingleHost($hostid)
    {
        return TrendModel::retrieveSingleHost($hostid);
    }

    public function retrieveHost()
    {
        $data = array(
            'data' => TrendModel::retrieveHost()
        );
        return $data;
    }

    public function getSingleMaster($hid, $iid)
    {
        return TrendModel::getSingleMaster($hid, $iid);
    }

    public function updateMaster(Request $request)
    {
        return TrendModel::updateMaster($request);
    }

    public function localUtilization($sbu_name)
    {
        $month = (int)date('m');
        $year = date('Y');
        $query = TrendModel::getLocalUtilization($sbu_name, $year, $month);

        $data = [];
        foreach ($query as $q) {
            array_push($data, (float) $q->utilized);
            array_push($data, (float) $q->idle);
        }

        $result['data'] = $data;
        return $result;
    }

    public function totalUtilizationEachMonth($year)
    {
        $months = TrendModel::getTotalUtilizationEachMonth($year);

        $idle = [];
        $utilized = [];
        $categories = [];
        $data = array();
        foreach ($months as $month) {
            array_push($idle, (float) $month->idle);
            array_push($utilized, (float) $month->utilized);
            array_push($categories, RingController::convertNumToTextMonth($month->month));
        }

        array_push($data, ['name' => 'utilized', 'data' => $utilized]);
        array_push($data, ['name' => 'idle', 'data' => $idle]);

        $res['data'] = $data;
        $res['categories'] = $categories;
        return $res;
    }

    public function totalUtilization($year, $month)
    {
        $query = TrendModel::getTotalUtilization($year, $month);
        // return $query;

        $data = [];
        foreach ($query as $q) {
            array_push($data, (float) $q->utilized);
            array_push($data, (float) $q->idle);
        }

        $res['data'] = $data;
        $res['capacity'] = (float) $q->capacity;

        return $res;
    }

    function getMonthIndex($month)
    {
        $months = ["jan" => 1, "feb" => 2, "mar" => 3, "apr" => 4, "may" => 5, "jun" => 6, "jul" => 7, "aug" => 8, "sep" => 9, "oct" => 10, "nov" => 11, "dec" => 12];
        return $months[$month];
    }

    public function monthDifference()
    {
        $curm = (int) date('m');
        $befm = $curm - 1;

        $rings = TrendModel::topEachSBU($curm);
        // return $rings;

        $t1 = [];
        $t2 = [];
        $name = [];
        foreach ($rings as $r) {
            $parts = explode(" ", $r->name, 2);
            $prev = TrendModel::getPrevious($befm, $parts[0], $parts[1])[0];
            // return $prev;
            array_push($t1, $r->traffic);
            array_push($t2, $prev->traffic);
            array_push($name, $r->name);
            // return $prev;
        }


        $cur['name'] = RingController::convertNumToTextMonth($curm);
        $bef['name'] = RingController::convertNumToTextMonth($befm);

        $cur['data'] = $t1;
        $bef['data'] = $t2;

        $res['data'] = [$cur, $bef];
        $res['name'] = $name;
        return $res;
    }

    public function topEachMonth()
    {
        $query = TrendModel::topEachMonth();

        $month = [];
        $traffic = [];
        $points = [];
        foreach ($query as $q) {
            array_push($month, RingController::convertNumToTextMonth($q->month));
            array_push($traffic, $q->traffic);

            // sulap hahah
            $temp['x'] = RingController::convertNumToTextMonth($q->month);
            $t['text'] = $q->name;
            $t['offsetY'] = 0;
            $temp['label'] = $t;
            array_push($points, $temp);
            // sampai sini sulapnya
        }



        $data['month'] = $month;
        $data['traffic'] = $traffic;
        $data['points'] = $points;

        return $data;
    }

    public function topEachSBU()
    {
        $month = date('m');
        $query = TrendModel::topEachSBU($month);

        $result = [];

        // spyder style
        $temp['name'] = 'Actual';
        $temp['data'] = [];

        $categories = [];
        foreach ($query as $item) {
            array_push($temp['data'], (int) $item->traffic);
            array_push($categories, $item->name);
        }

        $traffic = [];
        array_push($traffic, $temp);

        $temp['name'] = 'Expected';
        $temp['data'] = [100, 100, 100, 100, 100, 100, 100, 100, 100, 100];

        array_push($traffic, $temp);

        $result['data'] = $traffic;
        $result['categories'] = $categories;

        // bar chart style
        // foreach ($query as $q) {
        //     $temp['x'] = $q->name;
        //     $temp['y'] = $q->traffic;
        //     $goals['name'] = 'Expected';
        //     $goals['value'] = 100;
        //     $goals['strokeColor'] = '#FF0000';
        //     $goals['strokeHeight'] = 2;
        //     $goals['strokeDashArray'] = 2;

        //     $temp['goals'] = [$goals];

        //     array_push($result, $temp);
        // }

        return $result;
    }

    public function top()
    {
        $month = date('m');
        $query = TrendModel::getTopFive($month);

        $result = [];
        foreach ($query as $q) {
            $temp['x'] = $q->name;
            $temp['y'] = (float) $q->traffic;

            $goals['name'] = 'Expected';
            $goals['value'] = 100;
            $goals['strokeColor'] = '#FF0000';
            $goals['strokeWidth'] = 2;
            $goals['strokeDashArray'] = 2;

            $temp['goals'] = [$goals];

            array_push($result, $temp);
        }

        return $result;
    }

    // ring link details
    public static function ringLink($sbu)
    {
        // read file
        $path = public_path('location utilisasi.xlsx');
        $reader = new Xlsx();
        $spreadsheet = $reader->load($path);
        $sheet = $spreadsheet->getSheetByName($sbu);
        $totalRows = $sheet->getHighestRow();

        // $merge = array();
        // $temp = [];
        // for ($row = 3; $row <= $totalRows; $row++) {
        //     $current_ring = $sheet->getCell("B{$row}")->getValue();
        //     $next_row = $row + 1;
        //     $next_ring = $sheet->getCell("B{$next_row}")->getValue();
        //     if (!empty($sheet->getCell("E{$row}")->getValue())) {
        //         $origin = $sheet->getCell("E{$row}")->getValue();
        //         array_push($temp, $origin);
        //     }
        //     if ($current_ring != $next_ring) {
        //         array_push($merge, [
        //             'ring' => $current_ring,
        //             'link' => $temp
        //         ]);
        //         $temp = [];
        //     }
        // }

        $temp = array();
        for ($row = 3; $row <= $totalRows; $row++) {
            $ring = $sheet->getCell("B{$row}")->getValue();
            $location = $sheet->getCell("C{$row}")->getValue();
            array_push($temp, [
                'ring' => $ring,
                'location' => $location
            ]);
        }


        return $temp;
    }

    // ring trends
    public static function ringTrend($sbu)
    {
        $rings = TrendModel::getRingTrend($sbu);
        foreach ($rings as $ring) {
            $ring->data = explode(',', $ring->data);
        }

        return $rings;
    }
    // public static function ringTrend($sbu)
    // {
    //     $rings = TrendModel::getNumberOfRing($sbu, '2024');

    //     // Iterate over the array and extract the 'ring' values
    //     $flat = [];
    //     foreach ($rings as $r) {
    //         $flat[] = $r->ring;
    //     }

    //     // return $flat;

    //     // merge
    //     $merge = array();
    //     foreach ($flat as $f) {
    //         $result = TrendModel::getTrendsEachSbu($sbu, '2024', $f);
    //         array_push($merge, $result);
    //     }

    //     // return $merge;

    //     // transform
    //     $transform = array();
    //     $month = array();
    //     foreach ($merge as $m) {
    //         $temp = array();
    //         $ring = '';
    //         foreach ($m as $b) {
    //             $ring = $b->ring;
    //             array_push($temp, number_format($b->traffic / 1000000000, 1));
    //         }
    //         array_push($transform, [
    //             'name' => $ring,
    //             'data' => $temp
    //         ]);

    //         // array_push($month, $m->month);
    //     }

    //     // $res['data'] = $transform;
    //     // $res['month'] = $month;

    //     return $transform;
    // }

    public static function getLastDateOfWeek($week)
    {
        // Create a DateTime object for the first day of the given week and year
        $date = new DateTime();
        $date->setISODate(date("Y"), $week);

        // Modify the date to get the last day of the week (Sunday)
        $date->modify('+6 days');

        // Return the formatted date
        return $date->format('d-m');
    }

    // weekly trends
    public static function weeklyTrend($sbu)
    {
        $cw = (int) date('W');
        $fw = $cw - 3;
        $rings = TrendModel::getWeeklyTrend($sbu, $fw, $cw);
        foreach ($rings as $ring) {
            $ring->data = explode(',', $ring->data);
        }
        $res['data'] = $rings;

        $categories = [];
        for ($i = $fw; $i <= $cw; $i++) {
            array_push($categories, self::getLastDateOfWeek($i));
        }
        $res['categories'] = $categories;

        return $res;
    }
    // public static function weeklyTrend($sbu)
    // {
    //     $cw = (int) date('W');
    //     $fw = $cw - 3;

    //     $ringList = TrendModel::getWeeklyNumberOfRing($sbu);

    //     $merge = [];
    //     foreach ($ringList as $rl) {
    //         $query = TrendModel::getWeeklyTrend($sbu, $rl->ring, $fw, $cw);
    //         array_push($merge, $query);
    //     }

    //     // return $merge;

    //     $data = [];
    //     foreach ($merge as $items) {
    //         $traffic = [];
    //         $name = '';
    //         foreach ($items as $i) {
    //             array_push($traffic, number_format($i->traffic / 1000000000, 1));
    //             $name = $i->ring;
    //         }
    //         $temp['name'] = $name;
    //         $temp['data'] = $traffic;

    //         array_push($data, $temp);
    //     }

    //     $categories = [];
    //     for ($i = $fw; $i <= $cw; $i++) {
    //         array_push($categories, self::getLastDateOfWeek($i));
    //     }
    //     $res['data'] = $data;
    //     $res['categories'] = $categories;
    //     return $res;
    // }

    // ring baru
    public static function listOfMaxTrafficEachRing($sbu)
    {
        $month = date('m');
        $query = TrendModel::getUtilizationList($sbu, $month);

        return $query;
    }

    public static function sumOfMaxTrafficEachRing($sbu)
    {
        $month = date('m');
        $query = TrendModel::getRingTrendMonth($sbu, $month);
        return $query;
    }
    // ring lama
    // public static function listOfMaxTrafficEachRing($sbu, $month)
    // {
    //     ini_set('max_execution_time', 60);

    //     // read file
    //     $path = public_path('ring utilisasi.xlsx');
    //     $reader = new Xlsx();
    //     $spreadsheet = $reader->load($path);
    //     $sheet = $spreadsheet->getSheetByName($sbu);
    //     $totalRows = $sheet->getHighestRow();

    //     // new array to merge
    //     $merge = array();

    //     for ($row = 3; $row <= $totalRows; $row++) {
    //         if (!empty($sheet->getCell("C{$row}")->getValue())) {
    //             $data = ApiModel::queryMaxTrafficEachSourceToDestination(
    //                 $sheet->getCell("C{$row}")->getValue(),
    //                 $sheet->getCell("D{$row}")->getValue(),
    //                 $sheet->getCell("B{$row}")->getValue(),
    //                 $month,

    //             );
    //             // var_dump($sheet->getCell("C{$row}")->getValue());
    //             array_push($merge, $data);
    //         }
    //     }

    //     $flat = array();
    //     foreach ($merge as $hosts) {
    //         foreach ($hosts as $h) {
    //             $flat[] = $h;
    //         }
    //     }

    //     // check missing sbu ring max
    //     return $flat;
    // }

    // public static function sumOfMaxTrafficEachRing($sbu, $month)
    // {
    //     $flat = self::listOfMaxTrafficEachRing($sbu, $month);
    // $resume = array();
    // $val = 0;
    // for ($r = 0; $r < count($flat); $r++) {
    //     // n - 1
    //     if ($r < count($flat) - 1) {
    //         $current_ring = $flat[$r]->ring;
    //         $next_ring = $flat[$r + 1]->ring;
    //         // kalau ring n == n+1 jumlahkan
    //         // kalau tidak catet terus reset valnya
    //         if ($current_ring == $next_ring) {
    //             $val += (int)$flat[$r]->traffic;
    //         } else {
    //             $val += (int)$flat[$r]->traffic;
    //             $resume[] = array(
    //                 'name' => $current_ring,
    //                 'data' => $val,
    //                 // 'utility' => $val
    //             );
    //             $val = 0;
    //         }
    //     } else {
    //         $current_ring = $flat[$r]->ring;
    //         $prev_ring = $flat[$r - 1]->ring;
    //         if ($current_ring == $prev_ring) {
    //             $val += (int)$flat[$r]->traffic;
    //             $resume[] = array(
    //                 'name' => $current_ring,
    //                 'data' => $val,
    //                 // 'utility' => $val
    //             );
    //         } else {
    //             $val = (int)$flat[$r]->traffic;
    //             $resume[] = array(
    //                 'name' => $current_ring,
    //                 'data' => $val,
    //                 // 'utility' => $val
    //             );
    //         }
    //     }
    // }

    // return $resume;
    // }

    // sbu
    public static function listOfMaxTrafficEachSourceToDestination($sbu, $month)
    {
        $sql = "select 
                h.ring, h.host_name as origin, it.interface_name as interface, it.description as terminating,
                round(it.capacity / 1000000000, 1) as capacity, 
                round(max(wt.traffic) / 1000000000, 1) as traffic
            from myapp.hosts h 
            join myapp.interfaces it on it.hostid = h.hostid 
            join myapp.weekly_trends wt on it.interfaceid = wt.interfaceid 
            where h.sbu_name = '$sbu'
            and wt.`month` = MONTH(CURRENT_DATE())
            group by h.host_name, it.interface_name, h.ring, it.capacity, it.description
            order by ring";

        return DB::select($sql);

        // ini_set('max_execution_time', 60);

        // // new array to merge
        // $merge = array();

        // $sql = "select 
        //     h.sbu_name, h.ring, h.host_name, i.interface_name, i.description 
        // from myapp.hosts h 
        // join myapp.interfaces i on h.hostid = i.hostid 
        // where h.sbu_name = '$sbu'";
        // $data = DB::select($sql);

        // foreach ($data as $d) {
        //     $data = ApiModel::queryMaxTrafficEachSourceToDestination(
        //         $d->host_name,
        //         $d->description,
        //         $d->ring,
        //         $month,
        //     );
        //     array_push($merge, $data);
        // }

        // $flat = array();
        // foreach ($merge as $hosts) {
        //     foreach ($hosts as $h) {
        //         $flat[] = $h;
        //     }
        // }

        // $result = array(
        //     'sbu' => $sbu,
        //     'data' => $flat,
        //     'month' => date('F', strtotime(date('d-m-Y')))
        // );
        // return $result;
    }

    public function listTrafficMonth($origin, $terminating)
    {
        $m = (int) date('m');
        $month = RingController::convertNumToTextMonth($m);
        $in = ApiModel::queryTrafficMonth($origin, $terminating, 'Bits received', $month);
        $out = ApiModel::queryTrafficMonth($origin, $terminating, 'Bits sent', $month);

        $merge = array();
        $temp = array();
        $max = 0;
        foreach ($in as $data) {
            if ($max < $data->traffic) {
                $max = $data->traffic;
            }
            array_push($temp, $data->traffic);
        }

        array_push($merge, [
            'name' => 'Bits received',
            'data' => $temp
        ]);

        $temp = array();
        foreach ($out as $data) {
            if ($max < $data->traffic) {
                $max = $data->traffic;
            }
            array_push($temp, $data->traffic);
        }

        array_push($merge, [
            'name' => 'Bits sent',
            'data' => $temp,
        ]);

        $res['data'] = $merge;
        $res['traffic'] = $max;
        $res['month'] = $month;

        return $res;
    }

    public function listTrafficWeek($origin, $terminating)
    {
        $m = (int) date('m');
        $month = RingController::convertNumToTextMonth($m);
        $in = ApiModel::queryTrafficWeek($origin, $terminating, 'Bits received', $month);
        $out = ApiModel::queryTrafficWeek($origin, $terminating, 'Bits sent', $month);
        // return $out;

        $merge = array();
        $temp = array();
        $time = array();
        $max = 0;
        foreach ($in as $data) {
            if ($max < $data->traffic) {
                $max = $data->traffic;
            }
            array_push($time, $data->time);
            array_push($temp, $data->traffic);
        }

        array_push($merge, [
            'name' => 'Bits received',
            'data' => $temp
        ]);

        $temp = array();
        foreach ($out as $data) {
            if ($max < $data->traffic) {
                $max = $data->traffic;
            }
            array_push($temp, $data->traffic);
        }

        array_push($merge, [
            'name' => 'Bits sent',
            'data' => $temp
        ]);

        $res['data'] = $merge;
        $res['traffic'] = $max;
        $res['time'] = $time;

        return $res;
    }
}
