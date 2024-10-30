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
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Daftar Point</h4>
                    </div>
                    <div class="card-header-toolbar d-flex align-items-center">
                        <button class="btn btn-success" type="button" onclick="add()">+Add</button>
                        {{-- <h4><span class="badge badge-primary">{{ $month }}</span> </h4> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table data-tables table-striped">
                            <thead>
                                <tr class="ligth">
                                    <th>Point ID</th>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Created by</th>
                                    <th>Updated by</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup text-left">
                        <h4 class="mb-3">Add Point</h4>
                        <div class="content create-workform bg-body">
                            <form id="addForm" name="addForm">
                                @csrf
                                <input type="text" id="refid" name="refid" hidden>
                                <div class="pb-3">
                                    <label class="mb-2">Latitude</label>
                                    <input name="lat" id="lat" type="text" class="form-control">
                                </div>
                                <div class="pb-3">
                                    <label class="mb-2">Longitude</label>
                                    <input name="lng" id="lng" type="text" class="form-control">
                                </div>

                                <div class="col-lg-12 mt-4">
                                    <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                                        <button class="btn btn-primary mr-4" data-dismiss="modal" type="button"
                                            onclick="closeModal()">Cancel</button>
                                        <button class="btn btn-outline-primary" type="submit">Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup text-left">
                        <h4 class="mb-3">Edit Point</h4>
                        <div class="content create-workform bg-body">
                            <form id="editForm" name="editForm">
                                @csrf
                                <input type="text" name="pointid" id="pointid" hidden>
                                <div class="pb-3">
                                    <label class="mb-2">Latitude</label>
                                    <input name="lat" id="lat" type="text" class="form-control">
                                </div>
                                <div class="pb-3">
                                    <label class="mb-2">Longitude</label>
                                    <input name="lng" id="lng" type="text" class="form-control">
                                </div>

                                <div class="col-lg-12 mt-4">
                                    <div class="d-flex flex-wrap align-items-ceter justify-content-center">
                                        <button class="btn btn-primary mr-4" data-dismiss="modal" type="button"
                                            onclick="closeModal()">Cancel</button>
                                        <button class="btn btn-outline-primary" type="submit">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        $(document).ready(function() {
            let polygonid = '{{ $polygonid }}'.toLowerCase()
            map(polygonid)

            let table = '';
            loadTable(polygonid)

            document.getElementById("refid").value = polygonid;
        })

        function add() {
            $('#add').modal('show')
        }

        $('#addForm').submit(function(e) {
            e.preventDefault()
            var form = $(this).serialize()

            $.ajax({
                url: '/api/point',
                type: 'POST',
                dataType: 'json',
                data: form,
                success: function(data) {
                    console.log(data);

                    $('#add').modal('hide')
                    $('#add #lat').val('')
                    $('#add #lng').val('')

                    table.ajax.reload()
                    Swal.fire({
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });

        function map(polygonid) {
            map = L.map('map', {
                center: [-5.3777885489077875, 117.28861305443667],
                zoom: 5
            });

            var LeafIcon = L.Icon.extend({
                options: {
                    iconSize: [20, 20],
                }
            });

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
                url: '/api/polygon/' + polygonid,
                success: function(data) {
                    var polygon = L.polygon(data['points'], {
                        color: 'red'
                    }).addTo(map).bindPopup('<b>' + data['polygon_name'] + '</b>');
                    map.flyToBounds(polygon.getBounds());

                }
            })
        }

        function loadTable(polygonid) {
            table = new DataTable('#datatable', {
                ajax: '/api/polygon/' + polygonid,
                bDestroy: true,
                columns: [{
                        data: 'pointid'
                    },
                    {
                        data: 'lat'
                    },
                    {
                        data: 'lng'
                    },
                    {
                        data: 'created_by'
                    },
                    {
                        data: 'updated_by'
                    },
                    {
                        data: 'pointid',
                        width: '15%',
                        render: function(data) {
                            return `<button class='btn btn-small btn-warning' type='button' onclick="edit('` +
                                data + `')"><i class="ri-pencil-line"></i></button> 
                            <button class='btn btn-small btn-danger' type='button' onclick="hapus('` + data +
                                `')"><i class="ri-delete-bin-7-line"></i></button>`
                        }
                    }
                ],
                order: [
                    ['updated_at', 'desc']
                ]
            })
        }

        function hapus(pointid) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '/api/point/' + pointid,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            console.log(data);
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            });
                            table.ajax.reload()
                        }
                    })
                }
            });
        }

        function edit(pointid) {

            $('#edit').modal('show')
            document.getElementById("pointid").value = pointid;
            $.ajax({
                url: '/api/point/' + pointid,
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    $('#pointid').val(pointid)
                    $('#edit #lat').val(data['lat'])
                    $('#edit #lng').val(data['lng'])
                }
            })
        }

        function closeModal() {
            $('#edit').modal('hide')
            $('#edit #lat').val('')
            $('#edit #lng').val('')
        }

        $("#editForm").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this).serialize();

            $.ajax({
                url: '/api/point',
                type: 'PUT',
                dataType: 'json',
                data: form,
                success: function(data) {
                    closeModal()
                    console.log(data);
                    table.ajax.reload()
                    Swal.fire({
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });
    </script>
@endsection
