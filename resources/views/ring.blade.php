@extends('layouts.table')

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="card car-transparent">
                <div class="card-body p-0">
                    <div class="profile-image position-relative">
                        <img src="../assets/images/page-img/indonesia.png" class="img-fluid rounded w-100" alt="profile-image">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-block card-stretch card-height">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Utilisation Summary</h4>
                    </div>
                    <div class="card-header-toolbar d-flex align-items-center">
                        {{-- <p>Date range : {{ $date_range }}</p> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive rounded mb-3">
                        <table class="data-table table mb-0 tbl-server-info">
                            <thead class="bg-white text-uppercase">
                                <tr class="ligth ligth-data">
                                    <th>Ring</th>
                                    <th>Utilisasi (Gbps)</th>
                                </tr>
                            </thead>
                            <tbody class="ligth-body">
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $d['ring'] }}</td>
                                        <td>{{ number_format($d['val'] / 1000000000, 1) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-block card-stretch card-height">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Ring Details</h4>
                    </div>
                    <div class="card-header-toolbar d-flex align-items-center">
                        {{-- <p>Date range : {{ $date_range }}</p> --}}
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive rounded mb-3">
                        <table class="data-table table mb-0 tbl-server-info">
                            <thead class="bg-white text-uppercase">
                                <tr class="ligth ligth-data">
                                    <th>Ring</th>
                                    <th>Kapasitas</th>
                                    <th>Utilisasi (Gbps)</th>
                                </tr>
                            </thead>
                            <tbody class="ligth-body">
                                @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $d['ring'] }}</td>
                                        {{-- <td>{{ $d['kapasitas'] }}</td> --}}
                                        <td>{{ number_format($d['val'] / 1000000000, 1) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
