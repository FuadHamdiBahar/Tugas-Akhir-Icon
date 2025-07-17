@extends('layouts.main')

@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">{{ ucfirst($sbu) }} Utilisation Summary</h4>
                    </div>
                    <div class="card-header-toolbar d-flex align-items-center">
                        <h4><span class="badge badge-primary">{{ $month }}</span> </h4>
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
                                    <th>Ring</th>
                                    <th>Origin</th>
                                    <th>Interface</th>
                                    <th>Terminating</th>
                                    <th>Capacity</th>
                                    <th>Max Traffic (Gbps)</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $d->ring }}</td>
                                        <td>{{ $d->origin }}</td>
                                        <td>{{ $d->interface }}</td>
                                        <td>{{ $d->terminating }}</td>
                                        <td>{{ number_format($d->capacity, 0) }}</td>
                                        <td class="text-end">{{ number_format($d->traffic, 1) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center list-action">
                                                <a class="badge badge-info mr-2" data-toggle="tooltip" data-placement="top"
                                                    title="" data-original-title="View"
                                                    href="/device/{{ $d->origin }}/{{ $d->terminating }}"><i
                                                        class="ri-eye-line mr-0"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Ring</th>
                                    <th>Origin</th>
                                    <th>Interface</th>
                                    <th>Terminating</th>
                                    <th>Capacity</th>
                                    <th>Max Traffic (Gbps)</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let table = $(document).ready(function() {
            $('#datatable').DataTable({
                bDestroy: true,
                order: [
                    [5, 'desc']
                ]
            });
        });
    </script>
@endsection
