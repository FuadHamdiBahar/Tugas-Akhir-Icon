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
            <div class="card car-transparent">
                <div class="card-body p-0">
                    <div class="profile-image position-relative p-1 m-1" id="chart">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card car-transparent">
                <div class="card-body p-0">
                    <div class="profile-image position-relative p-1 m-1" id="topEachSBU">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card car-transparent">
                <div class="card-body p-0">
                    <div class="profile-image position-relative p-1 m-1" id="utilized">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card car-transparent">
                <div class="card-body p-0">
                    <div class="profile-image position-relative p-1 m-1" id="topEachMonth">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card car-transparent">
                <div class="card-body p-0">
                    <div class="profile-image position-relative p-1 m-1" id="utilizedEachMonth">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card car-transparent">
                <div class="card-body p-0">
                    <div class="profile-image position-relative p-1 m-1" id="monthDifference">
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection


@section('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $(document).ready(function() {
            var month = "{{ date('m') }}"
            var year = "{{ date('Y') }}"
            topFive(month);
            topEachSBU(month);
            utilized(year, month);
            topEachMonth(year);
            utilizedEachMonth(year)
            monthDifference(month);
        })

        function getMonthName(monthNumber) {
            // Array of month names
            const monthNames = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            // Adjust monthNumber to be zero-based
            const index = monthNumber - 1;

            // Check if monthNumber is valid
            if (index >= 0 && index < 12) {
                return monthNames[index];
            } else {
                return "Invalid month number";
            }
        }

        function utilizedEachMonth(year) {
            $.ajax({
                type: 'GET',
                url: '/api/totalUtilization/' + year,
                success: function(data) {
                    var options = {
                        series: [{
                            name: 'Utilized',
                            data: data['utilized']
                        }, {
                            name: 'Idle',
                            data: data['idle']
                        }],
                        chart: {
                            type: 'bar',
                            height: 400,
                            stacked: true,
                            stackType: '100%'
                        },
                        responsive: [{
                            breakpoint: 480,
                            options: {
                                legend: {
                                    position: 'bottom',
                                    offsetX: -10,
                                    offsetY: 0
                                }
                            }
                        }],
                        xaxis: {
                            categories: data['categories'],
                        },
                        yaxis: {
                            title: {
                                text: 'Percentage'
                            }
                        },
                        fill: {
                            opacity: 1
                        },
                        legend: {
                            position: 'bottom',
                            // offsetX: 0,
                            // offsetY: 50
                        },
                        title: {
                            text: 'National Utilization Every Month in ' + year,
                            align: 'center',
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#utilizedEachMonth"), options);
                    chart.render();
                }
            })
        }

        function utilized(year, month) {
            $.ajax({
                url: '/api/totalUtilization/' + year + '/' + month,
                type: 'GET',
                success: function(result) {
                    var options = {
                        series: result['data'],
                        chart: {
                            width: 500,
                            type: 'donut',
                        },
                        plotOptions: {
                            pie: {
                                startAngle: 0,
                                endAngle: 360
                            }
                        },
                        dataLabels: {
                            enabled: true,
                        },
                        // fill: {
                        //     type: 'gradient',
                        // },
                        legend: {
                            formatter: function(val, opts) {
                                return val + " - " + opts.w.globals.series[opts.seriesIndex] + ' Gbps'
                            },
                            position: 'bottom',
                        },
                        title: {
                            text: 'National Utilization in ' + year + ' (' + result['capacity'] + ' Gbps)',
                            align: 'center',
                        },
                        labels: ['Utilized', 'Idle'],
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val + " Gbps"
                                }
                            }
                        },
                        responsive: [{
                            breakpoint: 400,
                            options: {
                                chart: {
                                    width: 200
                                },
                                legend: {
                                    position: 'bottom'
                                }
                            }
                        }]
                    };

                    var natChart = new ApexCharts(document.querySelector("#utilized"), options);
                    natChart.render();
                }
            })
        }

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
                            show: true
                        },
                        title: {
                            text: 'Traffic Increase Of The Highest Traffic Each SBU in ' + getMonthName(
                                month)
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
                            name: 'Traffic',
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
                            align: 'center',
                        },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val + ' Gbps'
                                }
                            }
                        },
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
                    // console.log(data);
                    var options = {
                        series: data['data'],
                        chart: {
                            height: 400,
                            type: 'radar',
                        },
                        dataLabels: {
                            enabled: true
                        },
                        plotOptions: {
                            radar: {
                                size: 140,
                                polygons: {
                                    strokeColors: '#e9e9e9',
                                    fill: {
                                        colors: ['#f8f8f8', '#fff']
                                    }
                                }
                            }
                        },
                        title: {
                            text: 'The Highest Traffic Each SBU in ' + getMonthName(month)
                        },
                        // colors: ['#FF4560'],
                        // markers: {
                        //     size: 4,
                        //     colors: ['#fff'],
                        //     strokeColor: '#FF4560',
                        //     strokeWidth: 2,
                        // },
                        tooltip: {
                            y: {
                                formatter: function(val) {
                                    return val
                                }
                            }
                        },
                        xaxis: {
                            categories: data['categories']
                        },
                        yaxis: {
                            labels: {
                                formatter: function(val, i) {
                                    if (i % 2 === 0) {
                                        return val
                                    } else {
                                        return ''
                                    }
                                }
                            }
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
                            text: 'Top 5 Highest Traffic Ring in ' + getMonthName(month),
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
