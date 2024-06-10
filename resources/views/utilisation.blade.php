@extends('layouts.main')

@section('body')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Utilisation Summary</h4>
                    </div>
                    <div class="card-header-toolbar d-flex align-items-center">
                        {{-- <p>Date range : {{ $date_range }}</p> --}}
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
                                    <th>Max Bandwith (Gbps)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $d->ring }}</td>
                                        <td>{{ $d->origin }}</td>
                                        <td>{{ $d->interface }}</td>

                                        <td>{{ $d->terminating }}</td>
                                        <td class="text-end">{{ number_format($d->max / 1000000000, 1) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Ring</th>
                                    <th>Origin</th>
                                    <th>to</th>
                                    <th>Terminating</th>
                                    <th>Max Bandwith (bps)</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
