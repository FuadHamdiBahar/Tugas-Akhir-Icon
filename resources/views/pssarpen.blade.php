@extends('layouts.table')

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
            z-index: 1;
        }

        .red-circle {
            background-color: #e72b2b;
            border: 1px solid rgb(77, 67, 67);
            height: 100px;
            border-radius: 50%;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            width: 100px;
        }

        .blue-circle {
            background-color: #2b38e7;
            border: 1px solid rgb(77, 67, 67);
            height: 100px;
            border-radius: 50%;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            width: 100px;
        }

        .green-circle {
            background-color: #2b38e7;
            border: 1px solid rgb(77, 67, 67);
            height: 100px;
            border-radius: 50%;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            width: 100px;
        }
    </style>
@endsection

@section('body')
    <div class="row">

        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">PS Sarpen</h4>
                </div>
                <div>
                    {{-- <h4></h4> --}}
                    <h4><span class="badge badge-primary">{{ $date }}</span> </h4>
                </div>
            </div>
        </div>

        <div class="col-lg-12 mb-4">
            <div id="map"></div>
        </div>

        <div class="col-lg-12 mb-4">
            <form id="myForm">
                <div class="row">
                    <div class="col-md-4">
                        <label for="sbu">SBU</label>
                        <input type="text" name="sbu" id="sbu" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="pop_name">POP Name</label>
                        <input type="text" name="pop_name" id="pop_name" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="perangkat">Device Name</label>
                        <input type="text" name="perangkat" id="perangkat" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="tahun">Year</label>
                        <input type="text" name="tahun" id="tahun" class="form-control">
                    </div>
                </div>
                <button name="myButton" id="myButton" class="btn btn-primary mt-2">Submit</button>
                <button name="resetButton" id="resetButton" class="btn btn-primary mt-2" onclick="reset()">Reset</button>
            </form>
        </div>

        <div class="col-lg-12">
            <div class="table-responsive rounded mb-3">
                <table class=" table mb-0 tbl-server-info" id="myTable">
                    <thead class="bg-white text-uppercase">
                        <tr class="ligth ligth-data">
                            <th>SBU Name</th>
                            <th>POP Name</th>
                            <th>Device</th>
                            <th>Year</th>
                            <th>Amount</th>
                            <th>Partner</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">

                    </tbody>
                </table>
            </div>
        </div>

        {{-- <div class="card-body">

            <div class="table-responsive">
                <table id="example" class="table table-striped">
                    <thead>
                        <tr>
                            <th>SBU</th>
                            <th>POP Name</th>
                            <th>Perangkat</th>
                            <th>Tahun</th>
                            <th>Jumlah</th>
                            <th>Mitra Pelaksana</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>SBU</th>
                            <th>POP Name</th>
                            <th>Perangkat</th>
                            <th>Tahun</th>
                            <th>Jumlah</th>
                            <th>Mitra Pelaksana</th>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div> --}}
    </div>
@endsection


@section('script')
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script type="text/javascript">
        var map = new L.Map('map');
        map.setView(new L.LatLng(-4.668052508873149, 117.75463251366503), 5);

        let table;
        $(document).ready(function() {
            table = $('#myTable').DataTable({
                ajax: '/api/pssarpen',
                columns: [{
                        data: 'pop.sbu_name'
                    },
                    {
                        data: 'pop.pop_name'
                    },
                    {
                        data: 'perangkat'
                    },
                    {
                        data: 'tahun'
                    },
                    {
                        data: 'jumlah'
                    },
                    {
                        data: 'mitra_pelaksana'
                    },
                ],
                dom: '<"d-flex justify-content-between align-items-center"lfB>rtip',
                buttons: [{
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        className: 'btn btn-primary btn-sm'
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'Export to PDF',
                        className: 'btn btn-primary btn-sm',
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        className: 'btn btn-primary btn-sm',
                    }
                ],
            });
            createMap('/api/pssarpen/marker')
        })

        $('#myButton').click(function(event) {
            event.preventDefault(); // Prevents the default form submission
            var str = $("form").serialize();

            tableUrl = '/api/pssarpen?' + str
            markerUrl = '/api/pssarpen/marker?' + str

            // reset layer 
            map.eachLayer((layer) => {
                layer.remove();
            });

            table.ajax.url(tableUrl).load();
            createMap(markerUrl)
        });

        function createMap(markerUrl) {
            osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            })

            map.addLayer(osm)

            googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            })

            map.addLayer(googleStreets)


            var baseLayers = {
                "OpenStreetMap": osm,
                "GoogleStreet": googleStreets,
            };

            var LeafIcon = L.Icon.extend({
                options: {
                    iconSize: [10, 10],
                }
            });

            var greenIcon = new LeafIcon({
                iconUrl: '/assets/images/red.png',
            })


            var myIcon = L.divIcon({
                className: 'circle'
            });


            $.ajax({
                url: markerUrl,
                success: function(data) {
                    data.forEach(pop => {
                        var year = 0
                        var teks = "<b>" + pop.pop_name + "</b>"

                        pop.pssarpen.forEach(sarpen => {
                            teks += "<br>" + sarpen.perangkat + " - " + sarpen.tahun
                            if (sarpen.tahun > year) {
                                year = sarpen.tahun
                            }
                        })

                        var className = ''

                        const currentYear = new Date().getFullYear();

                        if (year == currentYear) {
                            className = 'green-circle'
                        } else if (year == currentYear - 1) {
                            className = 'blue-circle'
                        } else if (year <= currentYear - 2) {
                            className = 'red-circle'
                        }


                        marker = new L.marker([pop.lat, pop.lng], {
                            icon: L.divIcon({
                                className: className
                            })
                        }).addTo(map)

                        marker.bindPopup(teks)
                    });

                }
            })


        }

        $('#resetButton').click(function(event) {
            event.preventDefault(); // Prevents the default form submission
            table.ajax.url('/api/pssarpen').load();
            createMap('/api/pssarpen/marker')
        });
    </script>
@endsection
