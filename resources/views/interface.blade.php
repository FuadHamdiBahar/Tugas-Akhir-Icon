@extends('layouts.table')

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Interface List</h4>
                    {{-- <p class="mb-0">The product list effectively dictates product presentation and
                        provides space<br> to list your products and offering in the most appealing way.</p> --}}
                </div>
                <button class="btn btn-primary" onclick="add()"><i class="las la-plus mr-3"></i>Add
                    Interface</button>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="table-responsive rounded mb-3">
                <table class="table mb-0 tbl-server-info" id="myTable">
                    <thead class="bg-white text-uppercase">
                        <tr class="ligth ligth-data">

                            <th>Ring</th>
                            <th>Interface</th>
                            <th>Description</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="ligth-body">


                    </tbody>
                </table>
            </div>
        </div>
    </div>

    </div>
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="popup text-left">
                        <h4 class="mb-3">Add Interface</h4>
                        <div class="content create-workform bg-body">
                            <form id="addForm" name="addForm">
                                @csrf
                                <input type="text" name="hostid" type="hostid" hidden value="{{ $hostid }}">
                                <div class="pb-3">
                                    <label class="mb-2">Ring</label>
                                    <input name="ring" id="ring"type="text" class="form-control">
                                </div>
                                <div class="pb-3">
                                    <label class="mb-2">Interface Name</label>
                                    <input name="interface_name" id="interface_name"type="text" class="form-control">
                                </div>
                                <div class="pb-3">
                                    <label class="mb-2">Description</label>
                                    <input name="description" id="description"type="text" class="form-control">
                                </div>
                                <div class="pb-3">
                                    <label class="mb-2">Capacity</label>
                                    <input name="capacity" id="capacity"type="number" class="form-control">
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
                        <h4 class="mb-3">Edit Interface</h4>
                        <div class="content create-workform bg-body">
                            <form id="myForm" name="myForm">
                                @csrf
                                <input type="text" name="interfaceid" id="interfaceid" hidden>
                                <div class="pb-3">
                                    <label class="mb-2">Ring</label>
                                    <input name="ring" id="ring"type="text" class="form-control">
                                </div>
                                <div class="pb-3">
                                    <label class="mb-2">Interface Name</label>
                                    <input name="interface_name" id="interface_name"type="text" class="form-control">
                                </div>
                                <div class="pb-3">
                                    <label class="mb-2">Description</label>
                                    <input name="description" id="description"type="text" class="form-control">
                                </div>
                                <div class="pb-3">
                                    <label class="mb-2">Capacity</label>
                                    <input name="capacity" id="capacity"type="text" class="form-control">
                                </div>
                                <div class="pb-3">
                                    <label class="mb-2">Status</label>
                                    <input name="status" id="status" type="text" class="form-control">
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
    <script>
        let table;
        $(document).ready(function() {
            var hostid = '{{ $hostid }}'
            table = $('#myTable').DataTable({
                ajax: '/api/interface/' + hostid,
                columns: [{
                        data: 'ring'
                    },
                    {
                        data: 'interface_name'
                    },
                    {
                        data: 'description'
                    },
                    {
                        data: 'capacity'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'interfaceid',
                        render: function(data, type, row) {
                            return `<a class="badge bg-success mr-2" onclick="edit(${data})"><i class="ri-pencil-line mr-0"></i></a>
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
                url: '/api/interface',
                type: 'POST',
                dataType: 'json',
                data: form,
                success: function(data) {
                    console.log(data);

                    $('#add').modal('hide')
                    $('#addForm').trigger("reset")
                    table.ajax.reload()
                    Swal.fire({
                        icon: "success",
                        title: "Your work has been saved",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);

                }
            })
        });

        function hapus(iid) {
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
                        url: '/api/interface/' + iid,
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

        function edit(iid) {
            $('#edit').modal('show')
            $.ajax({
                url: '/api/interface/detail/' + iid,
                type: 'GET',
                success: function(data) {
                    $('#edit #interfaceid').val(iid)
                    $('#edit #ring').val(data['ring'])
                    $('#edit #interface_name').val(data['interface_name'])
                    $('#edit #description').val(data['description'])
                    $('#edit #capacity').val(data['capacity'])
                    $('#edit #status').val(data['status'])
                }
            })
        }

        function closeModal() {
            $('#edit').modal('hide')
            $('#myForm').trigger("reset")
        }

        $("#myForm").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this).serialize();

            $.ajax({
                url: '/api/interface',
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
@endsection
