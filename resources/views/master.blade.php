@extends('layouts.table')

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Hostname List</h4>
                </div>
                <button class="btn btn-primary" onclick="add()"><i class="las la-plus mr-3"></i>Add
                    Hostname</button>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="table-responsive rounded mb-3">
                <table class=" table mb-0 tbl-server-info" id="myTable">
                    <thead class="bg-white text-uppercase">
                        <tr class="ligth ligth-data">
                            <th>SBU Name</th>
                            <th>Hostname</th>
                            <th>Number of Interfaces</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">

                    </tbody>
                </table>
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
        let table;
        $(document).ready(function() {
            table = $('#myTable').DataTable({
                ajax: '/api/host',
                columns: [{
                        data: 'sbu_name'
                    },
                    {
                        data: 'host_name'
                    },
                    {
                        data: 'jumlah'
                    },
                    {
                        data: 'hostid',
                        render: function(data, type, row) {
                            return `<a class="badge badge-info mr-2" href="/interface/${data}"><i class="ri-eye-line mr-0"></i></a>
                        <a class="badge bg-success mr-2" onclick="edit(${data})"><i class="ri-pencil-line mr-0"></i></a>
                        <a class="badge bg-warning mr-2" onclick="hapus(${data})"><i class="ri-delete-bin-line mr-0"></i></a>`;
                        }
                    }
                ]
            });
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
                    table.ajax.reload();

                    $('#add').modal('hide')
                    $('#addForm').trigger('reset');
                    Swal.fire({
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        });

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
                    $('#hid').val(hid)
                    $('#edit #sbuname').val(data['sbu_name'])
                    $('#edit #hostname').val(data['host_name'])
                }
            })
        }

        function closeModal() {
            $('#edit').modal('hide')
            $('#myForm').trigger('reset');
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
                    table.ajax.reload();
                    Swal.fire({
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            })
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
