@extends('layouts.main')

@section('body')
    <div class="row">
        <div class="col-lg-6">
            <div class="chart" id="week"></div>
        </div>
        <div class="col-lg-6">

            <div class="chart" id="month"></div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            let origin = '{{ $origin }}'
            let terminating = '{{ $terminating }}'
            monthWeek(origin, terminating)
            monthTrend(origin, terminating)
        })

        function monthTrend(origin, terminating) {

            $.ajax({
                url: '/api/trendmonth/' + origin + '/' + terminating,
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    var options = {
                        series: data,
                        chart: {
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
                            tickAmount: 100,
                            stepSize: 100
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
                }
            })
        }

        function monthWeek(origin, terminating) {
            $.ajax({
                url: '/api/trendweek/' + origin + '/' + terminating,
                type: 'GET',
                success: function(data) {
                    let numbers = [];
                    for (let i = 0; i < 300; i++) {
                        numbers.push(i);
                    }
                    var options = {
                        series: data,
                        chart: {
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
                            }
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
                }
            })
        }
    </script>
@endsection
