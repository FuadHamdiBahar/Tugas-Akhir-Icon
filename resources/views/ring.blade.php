@extends('layouts.main')

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">{{ $sbu_name }} Ring Summary</h4>
                </div>
                <div>
                    <h4>{!! htmlspecialchars_decode(date('F', strtotime($date))) !!}</h4>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card car-transparent">
                <div class="card-body p-0">
                    <div class="profile-image position-relative">
                        <img src="../assets/images/sbu/{{ $image }}" class="img-fluid rounded w-100"
                            alt="profile-image">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card car-transparent">
                <div class="card-body p-0">
                    <div class="profile-image position-relative p-1 m-1" id="chart">
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="col-lg-6">
            <div class="card card-block card-stretch card-height">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="header-title">
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart" id="chart"></div>
                </div>
            </div>
        </div> --}}

        <div class="col-lg-6">
            <table class="data-table table mb-0 tbl-server-info">
                <thead class="bg-white text-uppercase">
                    <tr class="ligth ligth-data">
                        <th>Ring</th>
                        <th>Utilisasi (Gbps)</th>
                        <th>Utilisasi (%)</th>
                    </tr>
                </thead>
                <tbody class="ligth-body">
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $d['ring'] }}</td>
                            <td>{{ $d['val'] }}</td>
                            <td>{{ $d['utility'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="col-lg-6">
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
@endsection


@section('script')
    <script type="text/javascript">
        // Get the current path
        var pathname = window.location.pathname;

        // Split the path by '/' and get the last element
        var parts = pathname.split('/');
        var sbu = parts.pop() || parts.pop(); // Handle potential trailing slash

        $.ajax({
            type: 'GET',
            url: '/api/trend/' + sbu,
            success: function(data) {
                var options = {
                    chart: {
                        // height: 328,
                        type: 'line',
                        zoom: {
                            enabled: false
                        },

                    },
                    stroke: {
                        curve: 'smooth',
                        width: 5
                    },
                    //colors: ["#3F51B5", '#2196F3'],
                    series: data,
                    title: {
                        text: 'Media',
                        align: 'left',
                        offsetY: 25,
                        offsetX: 20
                    },
                    subtitle: {
                        text: 'Statistics',
                        offsetY: 55,
                        offsetX: 20
                    },
                    markers: {
                        size: 6,
                        strokeWidth: 0,
                        hover: {
                            size: 9
                        }
                    },
                    grid: {
                        show: true,
                        padding: {
                            bottom: 0
                        }
                    },
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ],
                    xaxis: {
                        tooltip: {
                            enabled: false
                        }
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        offsetY: -20
                    }
                }

                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            }
        })
    </script>
@endsection
