@extends('layouts.main')

@section('body')
    <div class="row">
        <div class="col-lg-12">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="mb-3">Summary Distribution Ring {{ $sbu_name }}</h4>
                </div>
                <div>
                    {{-- <h4></h4> --}}
                    <h4><span class="badge badge-primary">{{ $date }}</span> </h4>
                </div>
            </div>
        </div>
        {{-- <div class="col-lg-6">
            <div class="card car-transparent">
                <div class="card-body p-0">
                    <div class="profile-image position-relative">
                        <img src="../assets/images/sbu/{{ $image }}" class="img-fluid rounded w-100"
                            alt="profile-image">
                    </div>
                </div>
            </div>
        </div> --}}

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
                    <div class="profile-image position-relative p-1 m-1" id="weeklyTrend">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card car-transparent">
                <div class="card-body p-0">
                    <div class="profile-image position-relative p-1 m-1" id="barChart">
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
            <table class="data-table table mb-0 tbl-server-info" id="table">
                <thead class="bg-white text-uppercase">
                    <tr class="ligth ligth-data">
                        <th>Ring</th>
                        <th>Hostname</th>
                        <th>Interface</th>
                        <th>Utilisation (Gbps)</th>
                        <th>Capacity (Gbps)</th>
                    </tr>
                </thead>
                <tbody class="ligth-body">

                </tbody>
            </table>
        </div>

        <div class="col-lg-6">
            <table class="table" id="tableLink">
                <thead>
                    <tr class="ligth">
                        <th scope="col">Ring</th>
                        <th scope="col">Location</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-lg-12">
        <small>*Click this link if the line chart is not synchronized with ring table <a
                href="/updatetrend/{{ $sbu }}">Update.</a> If the summary of this month is not added <a
                href="/createtrend/{{ $sbu }}">Create</a>.</small>
    </div>
@endsection


@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            let sbu = '{{ $sbu }}'.toLowerCase()
            let month = '{{ $month }}'
            let date = '{{ $date }}'

            showTrend(sbu, month)
            showWeeklyTrend(sbu)
            showBar(sbu, month, date)
            showTable(sbu, month, date)
            showLocation(sbu)
        })

        function showWeeklyTrend(sbu) {
            $.ajax({
                type: 'GET',
                url: '/api/weekly/' + sbu,
                success: function(data) {
                    console.log(data);
                    var options = {
                        series: data['data'],
                        chart: {
                            height: 350,
                            type: 'line',
                            zoom: {
                                enabled: false
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            width: 3,
                            curve: 'smooth',
                        },
                        title: {
                            text: 'Page Statistics',
                            align: 'left'
                        },
                        legend: {
                            tooltipHoverFormatter: function(val, opts) {
                                return val + ' - <strong>' + opts.w.globals.series[opts.seriesIndex][
                                    opts.dataPointIndex
                                ] + '</strong>'
                            }
                        },
                        colors: ['#FF5733', '#33FF57', '#3357FF', '#F1C40F', '#8E44AD', '#2980B9',
                            '#2ECC71', '#E74C3C', '#000347', '#34495E'
                        ],
                        markers: {
                            size: 0,
                            hover: {
                                sizeOffset: 6
                            }
                        },
                        xaxis: {
                            categories: data['categories'],
                        },
                        yaxis: {
                            text: {
                                title: 'Giga bits per second'
                            }
                        },
                        title: {
                            text: 'Max Traffic In Last 4 Weeks',
                            align: 'left'
                        },
                        tooltip: {
                            y: [{
                                title: {
                                    formatter: function(val) {
                                        return val;
                                    }
                                }
                            }]
                        },
                        grid: {
                            borderColor: '#f1f1f1',
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#weeklyTrend"), options);
                    chart.render();
                }
            })
        }

        function showBar(sbu, month, date) {
            $.ajax({
                url: '/api/summary/' + sbu,
                type: 'GET',
                success: function(data) {
                    // console.log(data);
                    const dataList = data.map(ring => ring.traffic);
                    const nameList = data.map(ring => ring.ring);

                    var options = {
                        series: [{
                            name: 'Bar',
                            data: dataList
                        }],
                        chart: {
                            height: 350,
                            type: 'bar',
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 10,
                                dataLabels: {
                                    position: 'top', // top, center, bottom
                                },
                            }
                        },
                        dataLabels: {
                            enabled: true,
                            formatter: function(val) {
                                return val + "%";
                            },
                            offsetY: -20,
                            style: {
                                fontSize: '12px',
                                colors: ["#304758"]
                            }
                        },

                        xaxis: {
                            categories: nameList,
                            position: 'below',
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            },
                            crosshairs: {
                                fill: {
                                    type: 'gradient',
                                    gradient: {
                                        colorFrom: '#D8E3F0',
                                        colorTo: '#BED1E6',
                                        stops: [0, 100],
                                        opacityFrom: 0.4,
                                        opacityTo: 0.5,
                                    }
                                }
                            },
                            tooltip: {
                                enabled: true,
                            }
                        },
                        yaxis: {
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false,
                            },
                            labels: {
                                show: false,
                                formatter: function(val) {
                                    return val + "%";
                                }
                            },
                            title: {
                                text: 'Percentage',
                            },

                        },
                        title: {
                            text: 'Utilization Percentage Each Ring in ' + date
                        },
                    };

                    var chart = new ApexCharts(document.querySelector("#barChart"), options);
                    chart.render();
                }
            })

        }

        function showTable(sbu, month, date) {
            $.ajax({
                type: 'GET',
                url: '/api/list/' + sbu,
                success: function(data) {
                    var resulttag = "";

                    data.forEach(element => {
                        resulttag += "<tr>"
                        resulttag += "<td>" + element.ring + "</td>"
                        resulttag += "<td>" + element.host_name + "</td>"
                        resulttag += "<td>" + element.interface_name + "</td>"
                        resulttag += "<td>" + element.traffic + "</td>"
                        resulttag += "<td>" + element.capacity + "</td>"
                        resulttag += "</tr>"
                    });

                    $("#table tbody").append(resulttag);
                }
            })
        }

        function showTrend(sbu, month) {
            $.ajax({
                type: 'GET',
                url: '/api/trend/' + sbu,
                success: function(data) {
                    var options = {
                        series: data,
                        chart: {
                            height: 350,
                            type: 'line',
                            zoom: {
                                enabled: false
                            },
                        },
                        dataLabels: {
                            enabled: false
                        },
                        stroke: {
                            width: 3,
                            curve: 'smooth',
                        },
                        title: {
                            text: 'Max Traffic Each Ring in ' + month,
                            align: 'left'
                        },
                        colors: ['#FF5733', '#33FF57', '#3357FF', '#F1C40F', '#8E44AD', '#2980B9',
                            '#2ECC71', '#E74C3C', '#000347', '#34495E'
                        ],
                        legend: {
                            tooltipHoverFormatter: function(val, opts) {
                                return val + ' - <strong>' + opts.w.globals.series[opts.seriesIndex][
                                    opts.dataPointIndex
                                ] + '</strong>'
                            }
                        },
                        markers: {
                            size: 0,
                            hover: {
                                sizeOffset: 6
                            }
                        },
                        xaxis: {
                            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                        },
                        yaxis: {
                            title: {
                                text: 'Giga bits per second'
                            }
                        },
                        tooltip: {
                            y: [{
                                title: {
                                    formatter: function(val) {
                                        return val;
                                    }
                                }
                            }]
                        },
                        grid: {
                            borderColor: '#f1f1f1',
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();

                }
            })
        }

        function showLocation(sbu) {
            $.ajax({
                type: 'GET',
                url: '/api/link/' + sbu,
                success: function(data) {
                    var resulttag = "";

                    data.forEach(element => {
                        resulttag += "<tr>"
                        resulttag += "<td>" + element.ring + "</td>"
                        resulttag += "<td>" + element.location + "</td>"
                        resulttag +=
                            `<td>
                                <a class="badge badge-info mr-2" data-toggle="tooltip" 
                                data-placement="top" title data-original-title="View" 
                                href="/` + sbu + `/ring/` + element.ring + `"><i class="ri-eye-line mr-0"></i></a>
                            </td>`
                        resulttag += "</tr>"
                    });

                    // then finally
                    $("#tableLink tbody").append(resulttag);
                    // console.log(resulttag);
                }
            })
        }
    </script>
@endsection
