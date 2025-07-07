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

        <form>
            <input type="text" name="tahun" id="tahun">
            <button name="myButton" id="myButton"">Submit</button>
        </form>

        <div class="card-body">

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
        </div>
    </div>
@endsection


@section('script')
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // map('sumbagut')

            let url = '/api/pssarpen'
            getData(url)
        })

        $('#myButton').click(function(event) {
            event.preventDefault(); // Prevents the default form submission
            var tahun = $('#tahun').val();
            url = '/api/pssarpen?tahun=' + tahun
            getData(url)
        });

        function getData(url) {
            new DataTable('#example', {
                ajax: url,
                success: function(data) {
                    console.log(data);
                },
                columns: [{
                        data: 'pop.sbu_id'
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
                destroy: true,
            });
        }

        function map(sbu) {
            map = L.map('map', {
                center: [-5.3777885489077875, 117.28861305443667],
                zoom: 5
            });

            var LeafIcon = L.Icon.extend({
                options: {
                    iconSize: [20, 20],
                }
            });

            var greenIcon = new LeafIcon({
                iconUrl: '/assets/images/red.png',
            })

            osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map)

            // create a red polyline from an array of LatLng points
            // create a red polyline from an array of arrays of LatLng points
            var latlngs = null;
            var polyLineGroup = L.layerGroup().addTo(map);
            $.ajax({
                type: 'GET',
                url: '/api/sbupolygon/' + sbu,
                success: function(data) {

                    latlngs = data
                    var polyline = L.polyline(latlngs, {
                        color: 'red'
                    });
                    polyLineGroup.addLayer(polyline)
                    // zoom the map to the polyline
                    map.flyToBounds(polyline.getBounds());
                }
            })

            var locations = []
            var markerGroup = L.layerGroup().addTo(map);
            $.ajax({
                type: 'GET',
                url: '/api/sbumarker/' + sbu,
                success: function(data) {

                    data.forEach(element => {
                        marker = new L.marker([element['lng'], element['lat']], {
                                icon: greenIcon
                            })
                            .bindPopup("<b>" + element['marker_name'] + "</b><br>" + element['info']);
                        markerGroup.addLayer(marker)
                    });
                }
            })


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
