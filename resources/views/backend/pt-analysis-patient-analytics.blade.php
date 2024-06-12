@extends('backend.layouts.dashboard')


@section('content-new')



<div class="content-wrapper">
    <div class="bg-white-wrap">
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="box-data">
                    <div class="box-head-data">
                        <h4 class="h3-color-home"> Target Vs Achieve </h4>
                    </div>
                    <div class="box-content-data chartBorder">
                        <div id="targetVsAchieve"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="box-data">
                    <div class="box-head-data">
                        <h4 class="h3-color-home"> Actual Vs Forcast (Patients) </h4>
                    </div>
                    <div class="box-content-data chartBorder">
                        <div id="actualVsForcast"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="box-data">
                    <div class="box-head-data">
                        <h4 class="h3-color-home"> Actual Vs Forcast Stage Wise(Patients) </h4>
                    </div>
                    <div class="box-content-data chartBorder">
                        <div id="stageWise"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    var patientOption = {
        width: '250px',
        series: [23, 68, 68, 68, 68],
        colors: ['#776acf', '#163888', '#6acfc8', '#88cf6a', '#842d72'],
        labels: ["Early CKD", "ESRD", "CKD", "Stage-4 CKD", "Stage-5 CKD"],
        chart: {
            fontFamily: 'Quicksand',
            type: 'donut',
        },
        legend: {
            show: true,
            markers: {
                fillColors: ['#776acf', '#163888', '#6acfc8', '#88cf6a', '#842d72'],
                radius: 12,
            },
        },
        dataLabels: {
            formatter: function(val) {
                const percent = (val / 1);
                return percent.toFixed(0)
            },
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                }
            }
        }]
    };

    var PatientChart = new ApexCharts(document.querySelector("#patientByStage"), patientOption);
    PatientChart.render();


    var options = {
        series: [{
                name: 'Target',
                data: [44, 55, 41, 67, 22, 43, 44, 55, 41, 67, 22, 43]
            },
            {
                name: 'Achieve',
                data: [13, 23, 20, 8, 13, 27, 13, 23, 20, 8, 13, 27]
            }
        ],
        chart: {
            fontFamily: 'Quicksand',
            type: 'bar',
            height: 400,
            stacked: true,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
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
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '41%',
                borderRadius: 1,
                dataLabels: {
                    total: {
                        enabled: true,
                        style: {
                            fontSize: '0',
                            fontWeight: 900
                        }
                    }
                }
            },
        },
        grid: {
            borderColor: '#b4b1bd',
            strokeDashArray: 7,
        },
        xaxis: {
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
                "Jan"
            ]
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            labels: {
                useSeriesColors: false
            },
            markers: {
                fillColors: ['#9F528F', '#7FB444'],
                radius: 12,
            },
            fontWeight: '600',
        },
        fill: {
            opacity: 1,
            colors: ['#9F528F', '#7FB444']
        }
    };

    var chart = new ApexCharts(document.querySelector("#targetVsAchieve"), options);
    chart.render();


    var actualVsForcastOptions = {
        series: [{
                name: 'Actual (Patients)',
                data: [{
                        x: 'Jan',
                        y: 240000
                    },
                    {
                        x: 'Feb',
                        y: 220000
                    },
                    {
                        x: 'Mar',
                        y: 180000
                    },
                    {
                        x: 'Apr',
                        y: 250000
                    },
                    {
                        x: 'May',
                        y: 220000
                    },
                    {
                        x: 'Jun',
                        y: 170000
                    },
                    {
                        x: 'Jul',
                        y: 150000
                    },
                    {
                        x: 'Aug',
                        y: 200000
                    },
                    {
                        x: 'Sep',
                        y: 220000
                    },
                    {
                        x: 'Oct',
                        y: 150000
                    },
                    {
                        x: 'Nov',
                        y: 160000
                    },
                    {
                        x: 'Dec',
                        y: 120000
                    }
                ]
            },
            {
                name: 'Forcast (Patients)',
                data: [{
                        x: 'Jan',
                        y: 70000
                    },
                    {
                        x: 'Feb',
                        y: 90000
                    },
                    {
                        x: 'Mar',
                        y: 100000
                    },
                    {
                        x: 'Apr',
                        y: 60000
                    },
                    {
                        x: 'May',
                        y: 50000
                    },
                    {
                        x: 'Jun',
                        y: 70000
                    },
                    {
                        x: 'Jul',
                        y: 170000
                    },
                    {
                        x: 'Aug',
                        y: 140000
                    },
                    {
                        x: 'Sep',
                        y: 150000
                    },
                    {
                        x: 'Oct',
                        y: 190000
                    },
                    {
                        x: 'Nov',
                        y: 240000
                    },
                    {
                        x: 'Dec',
                        y: 300000
                    }
                ]
            },

        ],
        colors: ['#842D72', '#02BC77'],
        chart: {
            fontFamily: 'Quicksand',
            type: 'area',
            height: 350,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false,
        },
        stroke: {
            curve: 'smooth',
        },
        grid: {
            borderColor: '#e9e9e9',
            strokeDashArray: 8,
        },
        xaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            }
        },
        yaxis: {
            tickAmount: 6,
            floating: false,
            labels: {
                style: {
                    colors: '#8e8da4',
                },
                offsetY: -6,
                offsetX: 0,
                formatter: function(value) {
                    var val = Math.abs(value)
                    if (val >= 1000) {
                        val = (val / 1000).toFixed(0) + 'K'
                    }
                    return val
                }
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false
            }
        },
        fill: {
            type: 'solid',
            colors: ['transparent'],
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            labels: {
                useSeriesColors: false
            },
            markers: {
                fillColors: ['#842D72', '#02BC77'],
                radius: 12,
            },
            fontWeight: '600',
        },
        markers: {
            size: 4,
            colors: ['#ffffff'],
            shape: "circle",
            radius: 12,
            strokeColors: ['#842D72', '#02BC77'],
            strokeWidth: 3,
        },
    };

    var actualVsForcastChart = new ApexCharts(document.querySelector("#actualVsForcast"), actualVsForcastOptions);
    actualVsForcastChart.render();


    var options = {
        series: [{
            name: 'Net Profit',
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
        }, {
            name: 'Revenue',
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
        }],
        chart: {
            fontFamily: 'Quicksand',
            type: 'bar',
            height: 350,
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '55%',
                endingShape: 'rounded'
            },
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['transparent']
        },
        legend: {
            show: false
        },
        xaxis: {
            categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        },

        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return "$ " + val + " thousands"
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#stageWise"), options);
    chart.render();
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>



@endsection

@section('after-scripts')
{{-- {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
{{ Html::script(asset('js/template/js/fusioncharts.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}