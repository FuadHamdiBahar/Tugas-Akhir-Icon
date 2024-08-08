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
                        {{-- <h4><span class="badge badge-primary">{{ $month }}</span> </h4> --}}
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
    @include('partials.modal')
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var hostid = '{{ $hostid }}'
            loadTable(hostid)
        });

        function loadTable(hostid) {
            new DataTable('#datatable', {
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
                            return "<a href='/interface/" + data + "'>View</a>"
                        }
                    }
                ]
            })
        }
    </script>
@endsection
