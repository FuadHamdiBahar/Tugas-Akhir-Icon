@extends('layouts.main')

@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Daftar Polygon</h4>
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
                                    <th>SBU</th>
                                    <th>Polygon Name</th>
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
                        <h4 class="mb-3">Add Polygon</h4>
                        <div class="content create-workform bg-body">
                            <form id="addForm" name="addForm">
                                @csrf
                                <div class="pb-3">
                                    <label class="mb-2">SBU Name</label>
                                    <select name="sbuname" id="sbuname" class="selectpicker form-control"
                                        data-style="py-0">
                                        <option value="" selected>-PILIH SBU-</option>
                                        <option value="sumbagut">Sumbagut</option>
                                        <option value="sumbagteng">Sumbagteng</option>
                                        <option value="sumbagsel">Sumbagsel</option>
                                        <option value="jakarta">Jakarta</option>
                                        <option value="jabar">Jabar</option>
                                        <option value="jateng">Jateng</option>
                                        <option value="jatim">Jatim</option>
                                        <option value="kalimantan">Kalimantan</option>
                                        <option value="sulawesi">Sulawesi</option>
                                    </select>
                                </div>
                                <div class="pb-3">
                                    <label class="mb-2">Polygon Name</label>
                                    <input name="polygonname" id="polygonname"type="text" class="form-control">
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
                        <h4 class="mb-3">Edit Polygon</h4>
                        <div class="content create-workform bg-body">
                            <form id="editForm" name="editForm">
                                @csrf
                                <input type="text" name="polygonid" id="polygonid" hidden>
                                <div class="pb-3">
                                    <label class="mb-2">SBU Name</label>
                                    <select name="sbuname" id="sbuname" class="selectpicker form-control"
                                        data-style="py-0">
                                        <option value="" selected>-PILIH SBU-</option>
                                        <option value="sumbagut">Sumbagut</option>
                                        <option value="sumbagteng">Sumbagteng</option>
                                        <option value="sumbagsel">Sumbagsel</option>
                                        <option value="jakarta">Jakarta</option>
                                        <option value="jabar">Jabar</option>
                                        <option value="jateng">Jateng</option>
                                        <option value="jatim">Jatim</option>
                                        <option value="kalimantan">Kalimantan</option>
                                        <option value="sulawesi">Sulawesi</option>
                                    </select>
                                </div>
                                <div class="pb-3">
                                    <label class="mb-2">Polygon Name</label>
                                    <input name="polygonname" id="polygonname"type="text" class="form-control">
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
    @include('partials.modal')
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let table = '';
            loadTable()
        });

        function add() {
            $('#add').modal('show')
        }

        $('#addForm').submit(function(e) {
            e.preventDefault()
            var form = $(this).serialize()

            $.ajax({
                url: '/api/polygon',
                type: 'POST',
                dataType: 'json',
                data: form,
                success: function(data) {
                    $('#add').modal('hide')
                    $('#add #sbuname').val('')
                    $('#add #polygonname').val('')
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

        function loadTable() {
            table = new DataTable('#datatable', {
                ajax: '/api/polygon',
                bDestroy: true,
                columns: [{
                        data: 'sbu_name'
                    },
                    {
                        data: 'polygon_name'
                    },
                    {
                        data: 'created_by'
                    },
                    {
                        data: 'updated_by'
                    },
                    {
                        data: 'polygonid',
                        width: '15%',
                        render: function(data) {
                            return `<a class='btn btn-small btn-primary' href='/master/polygons/` + data + `'><i class="ri-eye-line"></i></a> 
                            <button class='btn btn-small btn-warning' type='button' onclick="edit('` + data + `')"><i class="ri-pencil-line"></i></button> 
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

        function hapus(polygonid) {
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
                        url: '/api/polygon/' + polygonid,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
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

        function edit(polygonid) {

            $('#edit').modal('show')
            $.ajax({
                url: '/api/polygon/' + polygonid,
                type: 'GET',
                success: function(data) {
                    $('#polygonid').val(polygonid)
                    $("#editForm #sbuname").val(data['sbu_name']).change();
                    $('#edit #polygonname').val(data['polygon_name'])
                }
            })
        }

        function closeModal() {
            $('#edit').modal('hide')
            $('#edit #polygonid').val('')
            $('#edit #sbuname').val('')
            $('#edit #polygonname').val('')
            $('#edit #lat').val('')
            $('#edit #lng').val('')
        }

        $("#editForm").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this).serialize();

            $.ajax({
                url: '/api/polygon',
                type: 'PUT',
                dataType: 'json',
                data: form,
                success: function(data) {
                    closeModal()
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
