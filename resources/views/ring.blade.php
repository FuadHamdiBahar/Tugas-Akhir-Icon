@extends('layouts.main')

@section('header')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        #map {
            height: 600px;
        }
    </style>
@endsection

@section('body')
    <div class="row">

        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Summary Distribution Ring {{ $sbu_name }}</h4>
                </div>
                <div>
                    {{-- <h4></h4> --}}
                    <h4><span class="badge badge-primary">{{ $date }}</span> </h4>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-6">
            <div class="card car-transparent">
                <div class="card-body p-0">
                    <div class="profile-image position-relative">
                        <img src="../assets/images/sbu/{{ $image }}" class="img-fluid rounded w-100"
                            alt="profile-image">
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-lg-12 mb-4">
            <div id="map"></div>
        </div>

        <div class="col-lg-4">
            <div class="card car-transparent">
                <div class="card-body p-0">
                    <div class="profile-image position-relative p-1 m-1" id="chart">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card car-transparent">
                <div class="card-body p-0">
                    <div class="profile-image position-relative p-1 m-1" id="weeklyTrend">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card car-transparent">
                <div class="card-body p-0">
                    <div class="profile-image position-relative p-1 m-1" id="barChart">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card car-transparent">
                <div class="card-body p-0">
                    <div class="profile-image position-relative p-1 m-1" id="localUtilization">
                    </div>
                </div>
            </div>
        </div>



        {{-- <div class="col-lg-6">
            <div class="card card-block card-stretch card-height">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="header-title">
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart" id="chart"></div>
                </div>
            </div>
        </div> --}}

        <div class="col-lg-8">
            <table class="data-table table mb-0 tbl-server-info" id="table">
                <thead class="bg-white text-uppercase">
                    <tr class="ligth ligth-data">
                        <th>Ring</th>
                        <th>Hostname</th>
                        <th>Interface</th>
                        <th>Utilisation (Gbps)</th>
                        <th>Capacity (Gbps)</th>
                    </tr>
                </thead>
                <tbody class="ligth-body">

                </tbody>
            </table>
        </div>

        <div class="col-lg-12">
            <table class="table" id="tableLink">
                <thead>
                    <tr class="ligth">
                        <th scope="col">Ring</th>
                        <th scope="col">Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-12">
        <small>*Click this link to update data <a href="/updateweeklytrend/{{ $sbu }}">Update.</a></small>
    </div>
@endsection


@section('script')
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            let sbu = '{{ $sbu }}'.toLowerCase()
            let month = '{{ $month }}'
            let date = '{{ $date }}'

            map()
            showTrend(sbu, month)
            showWeeklyTrend(sbu)
            showBar(sbu, month, date)
            localUtilizatoin(sbu)
            showTable(sbu, month, date)
            showLocation(sbu)
        })

        function getMonthName(monthNumber) {
            // Array of month names
            const monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            // Adjust monthNumber to be zero-based
            const index = monthNumber - 1;

            // Check if monthNumber is valid
            if (index >= 0 && index < 12) {
                return monthNames[index];
            } else {
                return "Invalid month number";
            }
        }

        function showWeeklyTrend(sbu) {
            $.ajax({
                type: 'GET',
                url: '/api/weekly/' + sbu,
                success: function(data) {
                    // console.log(data);
                    var options = {
                        series: data['data'],
                        chart: {
                            height: 350,
                            type: 'line',
                            zoom: {
                                enabled: false
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            width: 3,
                            curve: 'smooth',
                        },
                        title: {
                            text: 'Page Statistics',
                            align: 'left'
                        },
                        legend: {
                            tooltipHoverFormatter: function(val, opts) {
                                return val + ' - <strong>' + opts.w.globals.series[opts.seriesIndex][
                                    opts.dataPointIndex
                                ] + '</strong>'
                            }
                        },
                        colors: ['#FF5733', '#33FF57', '#3357FF', '#F1C40F', '#8E44AD', '#2980B9',
                            '#2ECC71', '#E74C3C', '#000347', '#34495E'
                        ],
                        markers: {
                            size: 0,
                            hover: {
                                sizeOffset: 6
                            }
                        },
                        xaxis: {
                            categories: data['categories'],
                        },
                        yaxis: {
                            title: {
                                text: 'Giga bits per second'
                            }
                        },
                        title: {
                            text: 'Max Traffic In Last 4 Weeks',
                            align: 'left'
                        },
                        tooltip: {
                            y: [{
                                title: {
                                    formatter: function(val) {
                                        return val;
                                    }
                                }
                            }]
                        },
                        grid: {
                            borderColor: '#f1f1f1',
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#weeklyTrend"), options);
                    chart.render();
                }
            })
        }

        function showBar(sbu, month, date) {
            $.ajax({
                url: '/api/summary/' + sbu,
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    const dataList = data.map(ring => ring.data);
                    const nameList = data.map(ring => ring.name);

                    var options = {
                        series: [{
                            name: 'Bar',
                            data: dataList
                        }],
                        chart: {
                            height: 350,
                            type: 'bar',
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 10,
                                dataLabels: {
                                    position: 'top', // top, center, bottom
                                },
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: function(val) {
                                return val + "%";
                            },
                            offsetY: -20,
                            style: {
                                fontSize: '12px',
                                colors: ["#304758"]
                            }
                        },

                        xaxis: {
                            categories: nameList,
                            position: 'below',
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            crosshairs: {
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        colorFrom: '#D8E3F0',
                                        colorTo: '#BED1E6',
                                        stops: [0, 100],
                                        opacityFrom: 0.4,
                                        opacityTo: 0.5,
                                    }
                                }
                            },
                            tooltip: {
                                enabled: true,
                            }
                        },
                        yaxis: {
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false,
                            },
                            labels: {
                                show: false,
                                formatter: function(val) {
                                    return val + "%";
                                }
                            },
                            title: {
                                text: 'Percentage',
                            },

                        },
                        title: {
                            text: 'Utilization Percentage Each Ring in ' + date
                        },
                    };

                    var chart = new ApexCharts(document.querySelector("#barChart"), options);
                    chart.render();
                }
            })

        }

        function showTable(sbu, month, date) {
            $.ajax({
                type: 'GET',
                url: '/api/list/' + sbu,
                success: function(data) {
                    var resulttag = "";

                    data.forEach(element => {
                        resulttag += "<tr>"
                        resulttag += "<td>" + element.ring + "</td>"
                        resulttag += "<td>" + element.host_name + "</td>"
                        resulttag += "<td>" + element.interface_name + "</td>"
                        resulttag += "<td>" + element.traffic + "</td>"
                        resulttag += "<td>" + element.capacity + "</td>"
                        resulttag += "</tr>"
                    });

                    $("#table tbody").append(resulttag);
                }
            })
        }

        function showTrend(sbu, month) {
            $.ajax({
                type: 'GET',
                url: '/api/trend/' + sbu,
                success: function(data) {
                    var options = {
                        series: data,
                        chart: {
                            height: 350,
                            type: 'line',
                            zoom: {
                                enabled: false
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            width: 3,
                            curve: 'smooth',
                        },
                        title: {
                            text: 'Max Traffic Each Ring in ' + month,
                            align: 'left'
                        },
                        colors: ['#FF5733', '#33FF57', '#3357FF', '#F1C40F', '#8E44AD', '#2980B9',
                            '#2ECC71', '#E74C3C', '#000347', '#34495E'
                        ],
                        legend: {
                            tooltipHoverFormatter: function(val, opts) {
                                return val + ' - <strong>' + opts.w.globals.series[opts.seriesIndex][
                                    opts.dataPointIndex
                                ] + '</strong>'
                            }
                        },
                        markers: {
                            size: 0,
                            hover: {
                                sizeOffset: 6
                            }
                        },
                        xaxis: {
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep',
                                'Okt', 'Nov', 'Dec'
                            ],
                        },
                        yaxis: {
                            title: {
                                text: 'Giga bits per second'
                            }
                        },
                        tooltip: {
                            y: [{
                                title: {
                                    formatter: function(val) {
                                        return val;
                                    }
                                }
                            }]
                        },
                        grid: {
                            borderColor: '#f1f1f1',
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();

                }
            })
        }

        function showLocation(sbu) {
            $.ajax({
                type: 'GET',
                url: '/api/link/' + sbu,
                success: function(data) {
                    var resulttag = "";

                    data.forEach(element => {
                        resulttag += "<tr>"
                        resulttag += "<td>" + element.ring + "</td>"
                        resulttag += "<td>" + element.location + "</td>"
                        resulttag +=
                            `<td>
                                <a class="badge badge-info mr-2" data-toggle="tooltip" 
                                data-placement="top" title data-original-title="View" 
                                href="/` + sbu + `/ring/` + element.ring + `"><i class="ri-eye-line mr-0"></i></a>
                            </td>`
                        resulttag += "</tr>"
                    });

                    // then finally
                    $("#tableLink tbody").append(resulttag);
                    // console.log(resulttag);
                }
            })
        }

        function localUtilizatoin(sbu, month, year) {
            $.ajax({
                url: '/api/localUtilization/' + sbu,
                type: 'GET',
                success: function(result) {
                    console.log(result);
                    var options = {
                        series: result['data'],
                        chart: {
                            width: '100%',
                            type: 'donut',
                        },
                        plotOptions: {
                            pie: {
                                startAngle: 0,
                                endAngle: 360
                            }
                        },
                        dataLabels: {
                            enabled: true,
                        },
                        // fill: {
                        //     type: 'gradient',
                        // },
                        legend: {
                            formatter: function(val, opts) {
                                return val + " - " + opts.w.globals.series[opts.seriesIndex] + ' Gbps'
                            },
                            position: 'bottom',
                        },
                        title: {
                            text: 'Local Utilization',
                            align: 'center',
                        },
                        labels: ['Utilized', 'Idle'],
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val + " Gbps"
                                }
                            }
                        },
                        responsive: [{
                            breakpoint: 400,
                            options: {
                                chart: {
                                    width: 200
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }]
                    };

                    var natChart = new ApexCharts(document.querySelector("#localUtilization"), options);
                    natChart.render();
                }
            })
        }

        function map() {
            var map = L.map('map', {
                center: [3.8436159904648886, 97.56073738176667],
                zoom: 7
            });

            osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map)

            var locations = [
                ['POP_1BNA003 BANDA ACEH GI SHELTER PLN', 95.343305, 5.513006],
                ['POP_1MDN001 GLUGUR MEDAN GI SHELTER PLN', 98.668327, 3.616638],
                ['POP_1MDN003 TITI KUNING GI SHELTER PLN', 98.689419, 3.540087],
                ['POP_1KBJ001 BERASTAGI GI SHELTER PLN', 98.504198, 3.157928],
                ['POP_1SDK001 SIDIKALANG GI SHELTER PLN', 98.339278, 2.734974],
                ['POP_1PRR001 TELE GI SHELTER PLN', 98.629083, 2.532683],
                ['POP_1TRT001 TARUTUNG GIS SHELTER PLN', 98.991038, 2.016564],
                ['POP_1SBG001 SIBOLGA GI SHELTER PLN', 98.834962, 1.691171],
                ['POP_1PSP001 PADANG SIDEMPUAN SHELTER PLN', 99.300395, 1.339638],
                ['POP_1LBP001 SEI ROTAN GI SHELTER PLN', 98.787769, 3.600104],
                ['POP_1SRH001 TEBING TINGGI GI SHELTER PLN', 99.165483, 3.38245],
                ['POP_1KIS001 KISARAN GI SHELTER PLN', 99.653777, 2.961529],
                ['POP_1RAP002 RANTAU PRAPAT SHELTER PLN', 99.808374, 2.112545],
                ['POP_1STB001 PANGKALAN BRANDAN GI SHELTER PLN', 98.272396, 3.992511],
                ['POP_1STB002 RANTING STABAT MINI SHELTER PLN', 98.443403, 3.742352],
                ['POP_1LMP001 KUALA TANJUNG GI SHELTER PLN', 99.458157, 3.343542],
                ['POP_1LBP002 PAYAGELI GI SHELTER PLN', 98.593363, 3.59025],
                ['POP_1BNJ001 BINJAI GI SHELTER PLN', 98.507101, 3.644916],
                ['POP_1MDN002 BELAWAN SHELTER PLN', 98.670838, 3.769432],
                ['POP_1MDN005 WILSU ODC PLN', 98.672969, 3.615412],
                ['POP_1MDN008 MEDAN TIMUR ODC PLN', 98.701579, 3.609552],
                ['POP_1MDN018 CABANG MEDAN MINI SHELTER PLN', 98.676071, 3.586288],
                ['POP_1MDN011 KITSBU GI ODC PLN', 98.686088, 3.539111],
                ['POP_1BLG001 PORSEA SHELTER PLN', 99.186921, 2.464089],
                ['POP_1PMS001 PEMATANG SIANTAR GI SHELTER PLN', 99.105462, 2.964307],
                ['POP_1AKK001 AEK KANOPAN GI MINI SHELTER PLN', 99.637299, 2.568917],
                ['POP_1SGI001 SIGLI GI SHELTER PLN', 95.963254, 5.351915],
                ['POP_1BIR001 BIREUEN GI SHELTER PLN', 96.725209, 5.131541],
                ['POP_1LSM001 LHOKSEUMAWE GI SHELTER PLN', 97.182212, 5.114952],
                ['POP_1LGS001 IDIE GI SHELTER PLN', 97.839053, 4.878885],
                ['POP_1LGS002 LANGSA GI SHELTER PLN', 97.94289, 4.511266],
                ['POP_1KRB001 KUALA SIMPANG MINI POP PLN', 98.050281, 4.289456],
                ['POP_1PYB001 KOTA NOPAN GI SHELTER PLN', 99.723887, 0.654887],
                ['POP_1SUS001 SUBULUSSALAM AREA MINI ODC PLN', 98.031197, 2.632353],
                ['POP_1TKN10001_TAKENGON ULP ODC PLN', 96.842638, 4.632571],
                ['POP_1TTN001_BAKONGAN GH MINI POP PLN', 97.482191, 2.924778],
            ];

            var markerGroup = L.layerGroup().addTo(map);
            for (var i = 0; i < locations.length; i++) {
                marker = new L.marker([locations[i][2], locations[i][1]])
                    .bindPopup(locations[i][0]);
                markerGroup.addLayer(marker)
            }


            // create a red polyline from an array of LatLng points
            // create a red polyline from an array of arrays of LatLng points
            var latlngs = [
                [
                    [5.503858615871162, 95.33098938249675],
                    [5.349212970889313, 95.95664027473715]
                ],
                [
                    [5.351837594390447, 95.95919011164517],
                    [5.12759988734557, 96.72683009003512]
                ],
                [
                    [5.128038414816811, 96.72739669425819],
                    [5.105718964163737, 97.17556189230321]
                ],
                [
                    [5.110985463935104, 97.17668599934373],
                    [4.875133305160696, 97.83550738639978]
                ],
                [
                    [4.87445446461986, 97.8353468835933],
                    [4.507010667991968, 97.94138836208775]
                ],
                [
                    [4.509884368621943, 97.94240926479692],
                    [4.289220199636777, 98.04721997023694]
                ],
                [
                    [4.286533090818184, 98.0498207989812],
                    [3.99149213494131, 98.26982100125475]
                ],
                [

                    [4.508667399233547, 97.94210562996396],
                    [4.052082312760819, 98.29409391272094],
                    [3.991268390274952, 98.2715933377717]

                ],
                [
                    [5.130111198041344, 96.72239677590352],
                    [4.627998596107981, 96.83664486055225]
                ],
                [
                    [3.99245950102579, 98.27090020077011],
                    [3.740405163208619, 98.44385065470851]
                ],
                [
                    [3.741401792923956, 98.44326812214696],
                    [3.643865113199742, 98.50642773761113]
                ],
                [
                    [3.989327253071655, 98.27115561964776],
                    [3.64315633965166, 98.43848072811656],
                    [3.644580356222597, 98.50532665241096]
                ],
                [
                    [3.645006002188297, 98.50746332175002],
                    [3.590464281923145, 98.59326139649303]
                ],
                [
                    [3.644468349463443, 98.5069476288179],
                    [3.616180289273345, 98.6681745976435]
                ],
                [
                    [3.616442571554626, 98.66763366059146],
                    [3.590199339331108, 98.59326489468357]
                ],
                [
                    [3.54009670386327, 98.68928747999342],
                    [3.616636033815762, 98.66833766958273]
                ],
                [
                    [3.54026080159204, 98.68942835766934],
                    [3.539165092311384, 98.68605100912828]
                ],
                [
                    [3.540266881127853, 98.68938609591764],
                    [3.590559856364478, 98.59331697563843]
                ],
                [
                    [3.540583963130861, 98.68928377496209],
                    [3.600649030450765, 98.78766434840674]
                ],
                [
                    [3.602566651201813, 98.78622455521075],
                    [3.384861716044707, 99.16582819926266]
                ],
                [
                    [3.385284223260775, 99.1644364619617],
                    [2.964530951452584, 99.65293853991763]
                ],
                [
                    [3.386398001528215, 99.16611406591377],
                    [3.347216815276794, 99.45794947433923]
                ],
                [
                    [3.345122762828677, 99.45802689243021],
                    [2.964530951452584, 99.65293853991763]
                ],
                [
                    [2.971761876709489, 99.64980142248568],
                    [2.12126723699728, 99.80701133500355]
                ],
                [
                    [2.966012807512191, 99.65283890918928],
                    [2.576353214177348, 99.63555985193898]
                ],
                [
                    [2.573241174191911, 99.63320553698706],
                    [2.119569654640938, 99.80635379894012]
                ],
                [
                    [3.390538736481114, 99.16250953424519],
                    [2.977098070985595, 99.10528657510783]
                ],
                [
                    [2.97266796708091, 99.10156640018226],
                    [2.471470794604008, 99.18835883086942]
                ],
                [
                    [2.475791215744705, 99.18623945210949],
                    [2.023548424899376, 98.98611723324635]
                ],
                [
                    [3.540777884949272, 98.68929761695917],
                    [3.165866116340127, 98.50360915750858]
                ],
                [
                    [3.161499675358048, 98.50399763419716],
                    [2.737629574483439, 98.33864146258779]
                ],
                [
                    [2.740216617026134, 98.33792760388401],
                    [2.536844344009798, 98.62929460979457]
                ],
                [
                    [2.535340328381861, 98.62825584011287],
                    [2.020148789561595, 98.98798082642077]
                ],
                [
                    [2.021998565176167, 98.98874722343929],
                    [1.700522684097745, 98.83463601011857]
                ],
                [
                    [1.696041195895421, 98.83191380218646],
                    [1.346050578915736, 99.30129254039545]
                ],
                [
                    [2.738036267195033, 98.33901132394398],
                    [2.635544292147849, 98.02839859033897]
                ],
                [
                    [2.928259811673737, 97.4832498351402],
                    [2.636443449566292, 98.02832813646947]
                ],
                [
                    [3.644734142198498, 98.50649379270257],
                    [3.769559441844008, 98.67099094280346]
                ],
                [
                    [3.769405241253596, 98.67060878351344],
                    [3.600174174911785, 98.78804102964618]
                ],
                [
                    [3.6167545175431, 98.6682704192894],
                    [3.615489241165947, 98.67290410978961]
                ],
                [
                    [3.615474427923201, 98.6728345916184],
                    [3.609728164555243, 98.70159306971995]
                ],
                [
                    [3.609619167169478, 98.70160488830618],
                    [3.586367341620756, 98.67603265664859]
                ],
                [
                    [1.334121673510129, 99.29991638774834],
                    [0.6545350375443992, 99.72043932075526]
                ],
            ];

            var polyLineGroup = L.layerGroup().addTo(map);
            var polyline = L.polyline(latlngs, {
                color: 'red'
            });
            polyLineGroup.addLayer(polyline)

            // zoom the map to the polyline
            map.fitBounds(polyline.getBounds());


            var baseLayers = {
                "OpenStreetMap": osm,
                "GoogleStreet": googleStreets,
            };

            var overlays = {
                "Marker": markerGroup,
                "Polyline": polyLineGroup
            };

            L.control.layers(baseLayers, overlays).addTo(map);
            L.Control.geocoder().addTo(map);
        }
    </script>
@endsection
