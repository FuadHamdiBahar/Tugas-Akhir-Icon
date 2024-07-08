@extends('layouts.main')

@section('body')
    <div class="row">
        <div class="col-lg-8">
            <div class="card card-transparent card-block card-stretch card-height border-none">
                <div class="card-body p-0 mt-lg-2 mt-0">
                    <h3 class="mb-3">Hi, Good Morning</h3>
                    <p class="mb-0 mr-4">Your dashboard gives you views of key performance or business
                        process.
                        Please read the <a href="/documentation">documentation</a> for more information.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="row">
                <div class="d-flex align-items-center mb-4 card-total-sale">
                    <div class="icon iq-icon-box-2 bg-info-light">
                    </div>
                    <div>
                        <p class="mb-2">Date</p>
                        <h4>{{ date('d M Y') }}</h4>
                    </div>
                </div>

                {{-- <div class="col-lg-4 col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 card-total-sale">
                                <div class="icon iq-icon-box-2 bg-info-light">
                                    <img src="../assets/images/product/1.png" class="img-fluid" alt="image">
                                </div>
                                <div>
                                    <p class="mb-2">Total Sales</p>
                                    <h4>31.50</h4>
                                </div>
                            </div>
                            <div class="iq-progress-bar mt-2">
                                <span class="bg-info iq-progress progress-1" data-percent="85"
                                    style="transition: width 2s ease 0s; width: 85%;">
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-4 card-total-sale">
                                <div class="icon iq-icon-box-2 bg-danger-light">
                                    <img src="../assets/images/product/2.png" class="img-fluid" alt="image">
                                </div>
                                <div>
                                    <p class="mb-2">Total Cost</p>
                                    <h4>$ 4598</h4>
                                </div>
                            </div>
                            <div class="iq-progress-bar mt-2">
                                <span class="bg-danger iq-progress progress-1" data-percent="70"
                                    style="transition: width 2s ease 0s; width: 70%;">
                                </span>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="col-lg-12 col-md-12">
                    <div class="card card-block card-stretch card-height">
                        <div class="card-body">
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>


        <div class="col-lg-4">
            <div class="profile-image position-relative p-1 m-1" id="chart">
            </div>
            {{-- <div class="card car-transparent">
                <div class="card-body p-0">
                </div>
            </div> --}}
        </div>

        <div class="col-lg-8">
            <div class="profile-image position-relative p-1 m-1" id="topEachSBU">
            </div>
            {{-- <div class="card car-transparent">
                <div class="card-body p-0">
                </div>
            </div> --}}
        </div>

        <div class="col-lg-6">
            <div class="profile-image position-relative p-1 m-1" id="topEachMonth">
            </div>
        </div>
        <div class="col-lg-6"></div>

        <div class="col-lg-12">
            <div class="profile-image position-relative p-1 m-1" id="monthDifference">
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $(document).ready(function() {
            var month = "{{ date('F') }}"
            var year = "{{ date('Y') }}"
            topFive(month);
            topEachSBU(month);
            topEachMonth(year);
            monthDifference(month);
        })

        function monthDifference(month) {
            $.ajax({
                type: 'GET',
                url: '/api/diff',
                success: function(data) {
                    var options = {
                        series: data['data'],
                        chart: {
                            type: 'bar',
                            height: 400
                        },

                        dataLabels: {
                            enabled: true
                        },
                        xaxis: {
                            categories: data['name'],
                            labels: {
                                rotate: -90,
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Giga bits per second'
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val + " Gbps"
                                }
                            }
                        },
                        legend: {
                            show: false
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#monthDifference"), options);
                    chart.render();
                }
            })

        }

        function topEachMonth(year) {
            $.ajax({
                type: 'GET',
                url: '/api/topMonth',
                success: function(data) {

                    var options = {
                        series: [{
                            name: 'Servings',
                            data: data['traffic']
                        }],
                        annotations: {
                            points: data['points']
                        },
                        chart: {
                            height: 400,
                            type: 'bar',
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 10,
                                columnWidth: '50%',
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            width: 0
                        },
                        grid: {
                            row: {
                                colors: ['#fff', '#f2f2f2']
                            }
                        },
                        xaxis: {
                            labels: {
                                rotate: -45
                            },
                            categories: data['month'],
                            tickPlacement: 'on'
                        },
                        yaxis: {
                            title: {
                                text: 'Giga bits per second',
                            },
                        },
                        title: {
                            text: 'The Highest Ring Traffic Each Month in 2024',
                            align: 'center'
                        }
                        // fill: {
                        //     type: 'gradient',
                        //     gradient: {
                        //         shade: 'light',
                        //         type: "horizontal",
                        //         shadeIntensity: 0.25,
                        //         gradientToColors: undefined,
                        //         inverseColors: true,
                        //         opacityFrom: 0.85,
                        //         opacityTo: 0.85,
                        //         stops: [50, 0, 100]
                        //     },
                        // }
                    };

                    var chart = new ApexCharts(document.querySelector("#topEachMonth"), options);
                    chart.render();
                }
            })
        }

        function topEachSBU(month) {
            $.ajax({
                type: 'GET',
                url: '/api/topSbu',
                success: function(data) {
                    console.log(data);
                    var options = {
                        series: [{
                            name: 'Current',
                            data: data,
                        }],
                        chart: {
                            height: 400,
                            type: 'bar'
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 10,
                                dataLabels: {
                                    position: 'top', // top, center, bottom
                                },
                            }
                        },
                        // colors: ['#00E396'],
                        dataLabels: {
                            enabled: true,
                            formatter: function(val) {
                                return val + "Gbps";
                            },
                            offsetY: -20,
                            style: {
                                fontSize: '12px',
                                colors: ["#304758"]
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Giga bits per second'
                            }
                        },
                        xaxis: {
                            labels: {
                                rotate: -90
                            }
                        },
                        title: {
                            text: 'Top Highest Traffic Ring Each SBU in ' + month,
                            align: 'center'
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#topEachSBU"), options);
                    chart.render();
                }
            })

        }

        function topFive(month) {

            $.ajax({
                type: 'GET',
                url: '/api/top',
                success: function(data) {
                    var options = {
                        series: [{
                            name: 'Actual',
                            data: data,
                        }],
                        chart: {
                            height: 400,
                            type: 'bar'
                        },
                        plotOptions: {
                            bar: {
                                horizontal: true,
                            }
                        },
                        dataLabels: {
                            formatter: function(val, opt) {
                                const goals =
                                    opt.w.config.series[opt.seriesIndex].data[opt.dataPointIndex]
                                    .goals

                                if (goals && goals.length) {
                                    // return `${val} / ${goals[0].value}`
                                    return `${val} Gbps`
                                }
                                return val
                            }
                        },
                        title: {
                            text: 'Top 5 Highest Traffic Ring in ' + month,
                            align: 'center'
                        },
                        xaxis: {
                            title: {
                                text: 'Giga bits per second'
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();
                }
            })
        }
    </script>
@endsection
