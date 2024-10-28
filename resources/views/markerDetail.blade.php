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
        <div class="col-lg-12 mb-4">
            <div id="map"></div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        $(document).ready(function() {
            let markerid = '{{ $markerid }}'.toLowerCase()
            console.log(markerid);

            map(markerid)
        })

        function map(markerid) {
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
                iconUrl: '/storage/red.png',
                // shadowUrl: 'http://leafletjs.com/examples/custom-icons/leaf-shadow.png'
            })

            osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map)

            $.ajax({
                type: 'GET',
                url: '/api/marker/' + markerid,
                success: function(data) {
                    var marker = L.marker([data['lng'], data['lat']], {
                        icon: greenIcon
                    }).addTo(map).bindPopup('<b>' + data['marker_name'] + '</b><br>Latitude: ' + data[
                        'lat'] + ' Longitude: ' + data['lng']);
                    console.log(data);
                    map.flyTo(marker.getLatLng(), 10)
                }
            })
        }
    </script>
@endsection
