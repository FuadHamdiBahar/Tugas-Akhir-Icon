@extends('layouts.main')

@section('body')
    <div id="day" class="day"></div>
@endsection

@section('script')
    <script>
        $.ajax({
            type: 'GET',
            url: '/list/SBU-GI.ACEH-NE8000.M14-NPE-02/SBU-SIGLI-NE8000.M14-UPE-04/2024-06-05/2024-06-05',
            success: function(data) {
                var options = {
                    series: [{
                            name: "Inbound",
                            data: data['in'].map(obj => obj.value_max)
                        },
                        {
                            name: "Outbound",
                            data: data['out'].map(obj => obj.value_max)
                        }
                    ],
                    chart: {
                        height: 350,
                        type: 'line',
                        dropShadow: {
                            enabled: true,
                            color: '#000',
                            top: 18,
                            left: 7,
                            blur: 10,
                            opacity: 0.2
                        },
                        zoom: {
                            enabled: false
                        },
                        toolbar: {
                            show: false
                        }
                    },
                    colors: ['#77B6EA', '#545454'],
                    dataLabels: {
                        enabled: false,
                    },
                    stroke: {
                        curve: 'smooth'
                    },
                    title: {
                        text: data['origin'] + ' to ' + data['terminating'],
                        align: 'left'
                    },
                    grid: {
                        borderColor: '#e7e7e7',
                        row: {
                            colors: ['#f3f3f3',
                                'transparent'
                            ], // takes an array which will be repeated on columns
                            opacity: 0.5
                        },
                    },
                    // markers: {
                    //     size: 1
                    // },
                    xaxis: {
                        // categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
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

                var chart = new ApexCharts(document.querySelector("#day"), options);
                chart.render();
            }
        })

        // $.ajax({
        //     type: 'GET',
        //     url
        // })
    </script>
@endsection
