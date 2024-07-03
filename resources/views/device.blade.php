@extends('layouts.main')

@section('body')
    <div class="row">
        <div class="col-lg-4">
            <div class="card card-transparent card-block card-stretch card-height border-none">
                <div class="card-body p-0 mt-lg-2 mt-0">
                    <h4 class="mb-3">{{ $origin }} link to {{ $terminating }}</h4>
                    {{-- <p class="mb-0 mr-4">Your dashboard gives you views of key performance or business
                        process.</p> --}}
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 card-total-sale">
                                <div class="icon iq-icon-box-2 bg-info-light">
                                    {{-- <img src="{{ asset('assets/images/product/1.png') }}" class="img-fluid" alt="image"> --}}
                                </div>
                                <div>
                                    <p class="mb-2">Month</p>
                                    <h4>{{ $month }}</h4>
                                </div>
                            </div>
                            {{-- <div class="iq-progress-bar mt-2">
                                <span class="bg-info iq-progress progress-1" data-percent="85"
                                    style="transition: width 2s ease 0s; width: 85%;">
                                </span>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 card-total-sale">
                                <div class="icon iq-icon-box-2 bg-info-light">
                                    {{-- <img src="{{ asset('assets/images/product/2.png') }}" class="img-fluid" alt="image"> --}}
                                </div>
                                <div>
                                    <p class="mb-2">Max Traffic (month)</p>
                                    <h4 id="traffic_month"></h4>
                                </div>
                            </div>
                            {{-- <div class="iq-progress-bar mt-2">
                                <span class="bg-danger iq-progress progress-1" data-percent="70"
                                    style="transition: width 2s ease 0s; width: 70%;">
                                </span>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 card-total-sale">
                                <div class="icon iq-icon-box-2 bg-info-light">
                                    {{-- <img src="{{ asset('assets/images/product/3.png') }}" class="img-fluid" alt="image"> --}}
                                </div>
                                <div>
                                    <p class="mb-2">Max Traffic (week)</p>
                                    <h4 id="traffic_week"></h4>
                                </div>
                            </div>
                            {{-- <div class="iq-progress-bar mt-2">
                                <span class="bg-success iq-progress progress-1" data-percent="75"
                                    style="transition: width 2s ease 0s; width: 75%;">
                                </span>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="chart" id="week"></div>
        </div>
        <div class="col-lg-12">

            <div class="chart" id="month"></div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            let origin = '{{ $origin }}'
            let terminating = '{{ $terminating }}'
            weekTrend(origin, terminating)
            monthTrend(origin, terminating)
        })

        function monthTrend(origin, terminating) {

            $.ajax({
                url: '/api/trendmonth/' + origin + '/' + terminating,
                type: 'GET',
                success: function(data) {
                    var options = {
                        series: data['data'],
                        chart: {
                            height: 300,
                            type: 'line',
                            zoom: {
                                enabled: false
                            },
                            toolbar: {
                                show: false
                            }
                        },
                        colors: ['#219ebc', '#ffb703'],
                        stroke: {
                            curve: 'smooth',
                            width: 2,
                        },
                        title: {
                            text: 'Monthly',
                            align: 'left'
                        },
                        grid: {
                            show: true,
                            padding: {
                                bottom: 0
                            }
                        },

                        xaxis: {
                            // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                            title: {
                                text: 'Hour'
                            },
                            labels: {
                                rotate: -90,
                                show: false,
                            },
                        },
                        yaxis: {
                            title: {
                                text: 'Giga bit per second'
                            },
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'right',
                            floating: true,
                            offsetY: -25,
                            offsetX: -5
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#month"), options);
                    chart.render();

                    $('#traffic_month').text(data['traffic'] + ' Gbps')
                }
            })
        }

        function weekTrend(origin, terminating) {
            $.ajax({
                url: '/api/trendweek/' + origin + '/' + terminating,
                type: 'GET',
                success: function(data) {

                    var options = {
                        series: data['data'],
                        chart: {
                            type: 'line',
                            height: 300,
                            zoom: {
                                enabled: false
                            },
                            toolbar: {
                                show: false
                            }
                        },
                        colors: ['#219ebc', '#ffb703'],
                        stroke: {
                            curve: 'smooth',
                            width: 2,
                        },
                        title: {
                            text: 'Weekly',
                            align: 'left'
                        },
                        grid: {
                            show: true,
                            padding: {
                                bottom: 0
                            }
                        },
                        xaxis: {
                            title: {
                                text: 'Hour'
                            },
                            labels: {
                                rotate: -90,
                                show: false,
                                // formatter: function(val) {
                                //     if (val % 24 == 0) {
                                //         return 1
                                //     }
                                //     return ''
                                // }
                            },

                        },
                        yaxis: {
                            title: {
                                text: 'Giga bit per second'
                            },
                        },
                        legend: {
                            position: 'top',
                            horizontalAlign: 'right',
                            floating: true,
                            offsetY: -25,
                            offsetX: -5
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#week"), options);
                    chart.render();

                    $('#traffic_week').text(data['traffic'] + ' Gbps')
                }
            })
        }
    </script>
@endsection
