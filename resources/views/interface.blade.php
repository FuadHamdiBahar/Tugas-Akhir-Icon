@extends('layouts.main')

@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        {{-- <h4 class="card-title">{{ ucfirst($sbu) }} Utilisation Summary</h4> --}}
                    </div>
                    <div class="card-header-toolbar d-flex align-items-center">
                        <button class="btn btn-success" type="button" onclick="add()">+Add</button>
                    </div>
                </div>
                <div class="card-body">
                    {{-- <p>Images in Bootstrap are made responsive with <code>.img-fluid</code>.
                <code>max-width: 100%;</code> and <code>height: auto;</code> are applied to the
                image so that it scales with the parent element.
            </p> --}}

                    <div class="table-responsive">
                        <table id="datatable" class="table data-tables table-striped">
                            <thead>
                                <tr class="ligth">
                                    <th>Interface Name</th>
                                    <th>Description</th>
                                    <th>Capacity</th>
                                    <th>Status</th>
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
                        <h4 class="mb-3">Add Interface</h4>
                        <div class="content create-workform bg-body">
                            <form id="addForm" name="addForm">
                                @csrf
                                <input type="text" name="hostid" type="hostid" hidden value="{{ $hostid }}">
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
        $(document).ready(function() {
            var hostid = '{{ $hostid }}'
            loadTable(hostid)

            let table = '';
        });

        function loadTable(hostid) {
            table = new DataTable('#datatable', {
                ajax: '/api/interface/' + hostid,
                bDestroy: true,
                columns: [{
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
                        render: function(data) {
                            return `<button class='btn btn-small btn-warning' type='button' onclick='edit(` +
                                data + `)'>Edit</button> 
                            <button class='btn btn-small btn-danger' type='button' onclick="hapus(` + data +
                                `)">Delete</button>`
                        }
                    }
                ]
            })
        }

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
                    $('#interface_name').val('')
                    $('#description').val('')
                    $('#capacity').val('')
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
                    console.log(data);
                    $('#edit #interfaceid').val(iid)
                    $('#edit #interface_name').val(data['interface_name'])
                    $('#edit #description').val(data['description'])
                    $('#edit #capacity').val(data['capacity'])
                }
            })
        }

        function closeModal() {
            $('#edit').modal('hide')
            $('#interfaceid').val('')
            $('#edit #interface_name').val('')
            $('#edit #description').val('')
            $('#edit #capacity').val('')
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
