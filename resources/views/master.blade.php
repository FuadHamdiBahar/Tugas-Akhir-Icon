@extends('layouts.main')

@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Daftar Hostname</h4>
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
                                    <th>Ring</th>
                                    <th>Hostname</th>
                                    <th>Number of Interfaces</th>
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
                        <h4 class="mb-3">Add Host</h4>
                        <div class="content create-workform bg-body">
                            <form id="addForm" name="addForm">
                                @csrf
                                <div class="pb-3">
                                    <label class="mb-2">SBU Name</label>
                                    <input name="sbuname" id="sbuname"type="text" class="form-control">
                                </div>
                                <div class="pb-3">
                                    <label class="mb-2">Ring</label>
                                    <input name="idring" id="idring"type="number" class="form-control">
                                </div>
                                <div class="pb-3">
                                    <label class="mb-2">Hostname</label>
                                    <input name="hostname" id="hostname"type="text" class="form-control">
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
                        <h4 class="mb-3">Edit Host</h4>
                        <div class="content create-workform bg-body">
                            <form id="myForm" name="myForm">
                                @csrf
                                <input type="text" name="hid" id="hid" hidden>
                                <div class="pb-3">
                                    <label class="mb-2">SBU Name</label>
                                    <input name="sbuname" id="sbuname"type="text" class="form-control">
                                </div>
                                <div class="pb-3">
                                    <label class="mb-2">Ring</label>
                                    <input name="idring" id="idring"type="text" class="form-control">
                                </div>
                                <div class="pb-3">
                                    <label class="mb-2">Hostname</label>
                                    <input name="hostname" id="hostname"type="text" class="form-control">
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
                url: '/api/host',
                type: 'POST',
                dataType: 'json',
                data: form,
                success: function(data) {
                    $('#add').modal('hide')
                    $('#sbuname').val('')
                    $('#idring').val('')
                    $('#hostname').val('')
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
                ajax: '/api/host',
                bDestroy: true,
                columns: [{
                        data: 'sbu_name'
                    },
                    {
                        data: 'ring'
                    },
                    {
                        data: 'host_name'
                    },
                    {
                        data: 'jumlah'
                    },
                    {
                        data: 'created_by'
                    },
                    {
                        data: 'updated_by'
                    },
                    {
                        data: 'hostid',
                        render: function(data) {
                            return `<a class='btn btn-small btn-primary' href='/interface/` + data + `'><i class="ri-eye-line"></i></a> 
                            <button class='btn btn-small btn-warning' type='button' onclick='edit(` + data + `)'><i class="ri-pencil-line"></i></button> 
                            <button class='btn btn-small btn-danger' type='button' onclick="hapus(` + data +
                                `)"><i class="ri-delete-bin-7-line"></i></button>`
                        }
                    }
                ],
                order: [
                    ['updated_at', 'desc']
                ]
            })
        }

        function hapus(hid) {
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
                        url: '/api/host/' + hid,
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

        function edit(hid) {

            $('#edit').modal('show')
            $.ajax({
                url: '/api/host/' + hid,
                type: 'GET',
                success: function(data) {
                    console.log(hid);
                    $('#hid').val(hid)
                    $('#edit #sbuname').val(data['sbu_name'])
                    $('#edit #idring').val(data['ring'])
                    $('#edit #hostname').val(data['host_name'])
                }
            })
        }

        function closeModal() {
            $('#edit').modal('hide')
            $('#hid').val('')
            $('#sbuname').val('')
            $('#idring').val('')
            $('#hostname').val('')
        }

        $("#myForm").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this).serialize();

            $.ajax({
                url: '/api/host',
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
