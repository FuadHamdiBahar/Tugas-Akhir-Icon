<?php

namespace App\Http\Controllers;

use App\Models\ApiModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiController extends Controller
{

    public function listOfMaxTrafficEachSourceToDestination()
    {
        $start = '2024-05-01 00:00:00.000 +0700';
        $end = '2024-05-31 23:59:59.000 +0700';

        $rings = array(
            array('SBU-GI.ACEH-NE8000.M14-NPE-02', 'SBU-SIGLI-NE8000.M14-UPE-04', '1'),
            array('SBU-SIGLI-NE8000.M14-UPE-04', 'SBU-BIREUN-NE8000.M14-UPE-03', '1'),
            array('SBU-BIREUN-NE8000.M14-UPE-03', 'SBU-LHOKSEUMAWE-NE8000.M14-UPE-04', '1'),
            array('SBU-LHOKSEUMAWE-NE8000.M14-UPE-04', 'SBU-IDIE-NE8000.M14-UPE-02', '1'),
            array('SBU-IDIE-NE8000.M14-UPE-02', 'SBU-LANGSA-NE8000.M14-UPE-02', '1'),
            array('SBU-LANGSA-NE8000.M14-UPE-02', 'SBU-P.BRANDAN-NE8000.M14-UPE-02', '1'),
            array('SBU-P.BRANDAN-NE8000.M14-UPE-02', 'SBU-BINJAI-NE8000.M14-UPE-02', '1'),
            array('SBU-BINJAI-NE8000.M14-UPE-02', 'SBU-PAYAGELI-NE8000.M14-UPE-01', '1'),
            array('SBU-PAYAGELI-NE8000.M14-UPE-01', 'SBU-TITIKUNING-NE8000.M14-NPE-01', '1'),
            array('SBU-BINJAI-NE8000.M14-UPE-02', 'SBU-GLUGUR-NE8000.M14-NPE-03', '1'),
            array('SBU-GLUGUR-NE8000.M14-NPE-03', 'SBU-TITIKUNING-NE8000.M14-NPE-01', '1'),
            array('SBU-GLUGUR-NE8000.M14-NPE-03', 'SBU-PAYAGELI-NE8000.M14-UPE-01', '1'),
            array('SBU-P.BRANDAN-NE8000.M14-UPE-02', 'SBU-RANTING.STABAT-NE8000.M14-UPE-02', '1'),
            array('SBU-RANTING.STABAT-NE8000.M14-UPE-02', 'SBU-BINJAI-NE8000.M14-UPE-02', '1'),
            array('SBU-TITIKUNING-NE8000.M14-NPE-01', 'SBU-BRASTAGI-NE8000.M14-UPE-02', '2'),
            array('SBU-BRASTAGI-NE8000.M14-UPE-02', 'SBU-SIDIKALANG-NE8000.M14-UPE-03', '2'),
            array('SBU-SIDIKALANG-NE8000.M14-UPE-03', 'SBU-GI.TELE-NE8000.M14-UPE-03', '2'),
            array('SBU-GI.TELE-NE8000.M14-UPE-03', 'SBU-TARUTUNG-NE8000.M14-NPE-02', '2'),
            array('SBU-TARUTUNG-NE8000.M14-NPE-02', 'SBU-SIBOLGA-NE8000.M14-NPE-01', '2'),
            array('SBU-SIBOLGA-NE8000.M14-NPE-01', 'SBU-P.SIDEMPUAN-NE8000.M14-NPE-02', '2'),
            array('SBU-TARUTUNG-NE8000.M14-NPE-02', 'SBU-PORSEA-NE8000.M14-NPE-01', '2'),
            array('SBU-PORSEA-NE8000.M14-NPE-01', 'SBU-SIANTAR-NE8000.M14-NPE-01', '2'),
            array('SBU-SIANTAR-NE8000.M14-NPE-01', 'SBU-TEBINGTINGGI-NE8000.M14-NPE-03', '2'),
        );


        $merge = array();

        foreach ($rings as $ring) {
            $data = ApiModel::queryMaxTrafficEachSourceToDestination($start, $end, $ring[0], $ring[1], $ring[2], 'Bits sent');
            array_push($merge, $data);
        }

        $result = array(
            'date_range' => $start . ' to ' . $end,
            'message' => 'success',
            'status' => Response::HTTP_OK,
            'data' => $merge
        );
        return $result;
    }
    public function listTraffic()
    {
        $start = '2024-06-03 00:00:00.000 +0700';
        $end = '2024-06-03 23:59:59.000 +0700';
        $source = '192.168.190.64';
        $destination = 'ULP.CALANG';

        $in = ApiModel::queryTraffic($start, $end, $source, $destination, 'Bits received');
        $out = ApiModel::queryTraffic($start, $end, $source, $destination, 'Bits sent');

        $result = array(
            'in' => $in,
            'out' => $out,
            'message' => 'success',
            'status' => Response::HTTP_OK,
        );
        return $result;
    }
}
