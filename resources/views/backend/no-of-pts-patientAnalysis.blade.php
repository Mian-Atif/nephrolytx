@extends('backend.layouts.dashboard')


@section('content-new')



<div class="content-wrapper">
    <div class="home-background esrd-card-box-2">
        <div class="row">
            <div class="col-md-6">
                <div class="graph-box-3">
                    <h4>Number of Patients Per Month </h4>
                    <div class="card card-shadow">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="patientData"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="graph-box-3">
                    <h4> Total number of patients per provider per month </h4>
                    <div class="card card-shadow">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="patientData4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="graph-box-3">
                    <h4> New Patients per month</h4>
                    <div class="card card-shadow">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="patientData2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="graph-box-3">
                    <h4> Number of Patients by who paid bills per month</h4>
                    <div class="card card-shadow">

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div id="patientData3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="graph-box-3">
                        <h4> Target Vs Achieve</h4>
                        <div class="card card-shadow">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="targetVsAchieve"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

</div>



<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

Chart.defaults.font.family = 'Quicksand'; 

    const grideHide = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    display: false
                }
            }
        },
        plugins: {
            legend: {
                display: false
            },
        }
    };

    /* active_patients_count_per_physician Start */
    const labels2 = [
        'Marry',
        'Jhon',
        'Jeo',
        'Leo',
        'Pique',
        'Messi',
    ];

    const data2 = {
        labels: labels2,
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
            borderColor: 'rgb(132,45,114)',
            borderWidth: 10,
            maxBarThickness: 18,
            data: [

                50, 10, 30, 40, 10, 50, 30, 50, 35, 10, 30, 50

            ],
        }]
    };

    const config2 = {
        type: 'bar',
        data: data2,
        options: grideHide
    };

    const myChart2 = new Chart(
        document.getElementById('myChart2'),
        config2
    );


    var patientDataOptions = {
        series: [{
            name: 'No. of Patients',
            type: 'column',
            data: [
                @foreach($numberOfPatientsPerMonthPTS as $numberOfPatientsPerMonthPTSS)
                '{{$numberOfPatientsPerMonthPTSS->vls}}',
            @endforeach
        ]
        }, {
            name: 'No. of Patients',
            type: 'line',
            data: [ @foreach($numberOfPatientsPerMonthPTS as $numberOfPatientsPerMonthPTSS)
                '{{$numberOfPatientsPerMonthPTSS->vls}}',
            @endforeach]
        }],
        colors:['#842d72','#02BC77'],
        chart: {
            fontFamily: 'Quicksand',
            height: 250,
            type: 'line',
            stacked: false,
            toolbar: {
                show: false
            },
        },
        stroke: {
            width: [0, 2],
            curve: 'smooth'
        },
        plotOptions: {
            bar: {
                columnWidth: '25%'
            }
        },
        markers: {
            size: 3,
            colors: ['#ffffff'],
            shape: "circle",
            radius: 12,
            strokeColors: '#02bc77',
            strokeWidth: 2,
        },
        fill: {
            opacity: 1,
            colors: ['#9F528F']
        },
        legend: {
            show: false
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
                "Dec"
            ]
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(y) {
                    if (typeof y !== "undefined") {
                        return y.toFixed(0) + " points";
                    }
                    return y;

                }
            }
        }
    };
    var patientDataChart = new ApexCharts(document.querySelector("#patientData"), patientDataOptions);
    patientDataChart.render();

    
    var options = {
        series: [{
                name: 'Target',
                data: [@foreach($ckdvisitintervaltargetachieved as $ckdvisitintervaltargetachieved1)
                    '{{$ckdvisitintervaltargetachieved1->target}}',
                @endforeach]
            },
            {
                name: 'Achieve',
                data: [@foreach($ckdvisitintervaltargetachieved as $ckdvisitintervaltargetachieved1)
                    '{{$ckdvisitintervaltargetachieved1->achieved}}',
                @endforeach]
            }
        ],
        chart: {
            fontFamily: 'Quicksand',
            type: 'bar',
            height: 400,
            stacked: false,
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
                @foreach($ckdvisitintervaltargetachieved as $ckdvisitintervaltargetachieved1)
                    '{{$ckdvisitintervaltargetachieved1->month_year}}',
                @endforeach
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

    var patientDataOptions2 = {
        series: [{
            name: 'No. of Patients',
            type: 'column',
                data: [@foreach($newpatientscountactualmonth as $newpatientscountactualmonthM)
                    '{{$newpatientscountactualmonthM->vals}}',
                @endforeach]
        }, {
            name: 'No. of Patients',
            type: 'line',
            data: [@foreach($newpatientscountactualmonth as $newpatientscountactualmonthM)
                '{{$newpatientscountactualmonthM->vals}}',
            @endforeach]
        }],
        colors:['#842d72','#02BC77'],
        chart: {
            fontFamily: 'Quicksand',
            height: 250,
            type: 'line',
            stacked: false,
            toolbar: {
                show: false
            },
        },
        stroke: {
            width: [0, 2],
            curve: 'smooth'
        },
        plotOptions: {
            bar: {
                columnWidth: '25%'
            }
        },
        markers: {
            size: 3,
            colors: ['#ffffff'],
            shape: "circle",
            radius: 12,
            strokeColors: '#02bc77',
            strokeWidth: 2,
        },
        fill: {
            opacity: 1,
            colors: ['#9F528F']
        },
        legend: {
            show: false
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
                "Dec"
            ]
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(y) {
                    if (typeof y !== "undefined") {
                        return y.toFixed(0) + " points";
                    }
                    return y;

                }
            }
        }
    };
    var patientData2Chart = new ApexCharts(document.querySelector("#patientData2"), patientDataOptions2);
    patientData2Chart.render();


    var patientDataOptions3 = {
        series: [{
            name: 'No. of Patients',
            type: 'column',
            data: [@foreach($numberOfPatientsByWhoPaidBillsPerMonthPTS as $numberOfPatientsByWhoPaidBillsPerMonthPTSS)
                '{{$numberOfPatientsByWhoPaidBillsPerMonthPTSS->vls}}',
            @endforeach]
        }, {
            name: 'No. of Patients',
            type: 'line',
            data: [@foreach($numberOfPatientsByWhoPaidBillsPerMonthPTS as $numberOfPatientsByWhoPaidBillsPerMonthPTSS)
                '{{$numberOfPatientsByWhoPaidBillsPerMonthPTSS->vls}}',
            @endforeach]
        }],
        colors:['#842d72','#02BC77'],
        chart: {
            fontFamily: 'Quicksand',
            height: 250,
            type: 'line',
            stacked: false,
            toolbar: {
                show: false
            },
        },
        stroke: {
            width: [0, 2],
            curve: 'smooth'
        },
        plotOptions: {
            bar: {
                columnWidth: '25%'
            }
        },
        markers: {
            size: 3,
            colors: ['#ffffff'],
            shape: "circle",
            radius: 12,
            strokeColors: '#02bc77',
            strokeWidth: 2,
        },
        fill: {
            opacity: 1,
            colors: ['#9F528F']
        },
        legend: {
            show: false
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
                "Dec"
            ]
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(y) {
                    if (typeof y !== "undefined") {
                        return y.toFixed(0) + " points";
                    }
                    return y;

                }
            },
            color:['#9F528F'],
        }
    };
    var patientData3Chart = new ApexCharts(document.querySelector("#patientData3"), patientDataOptions3);
    patientData3Chart.render();


    
    var patientDataOptions4 = {
        series: [{
            name: 'No. of Patients',
            type: 'column',
            data: [
                @foreach($totalNumberOfPatientsPerProviderPerMonthPTS as $totalNumberOfPatientsPerProviderPerMonthPTSS)
                '{{$totalNumberOfPatientsPerProviderPerMonthPTSS->vls}}',
            @endforeach
        ]
        }],
        colors:['#842d72'],
        chart: {
            fontFamily: 'Quicksand',
            height: 250,
            type: 'line',
            stacked: false,
            toolbar: {
                show: false
            },
        },
        stroke: {
            width: [0, 2],
            curve: 'smooth'
        },
        plotOptions: {
            bar: {
                columnWidth: '25%'
            }
        },
        fill: {
            opacity: 1,
            colors: ['#9F528F']
        },
        legend: {
            show: false
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
                "Dec"
            ]
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(y) {
                    if (typeof y !== "undefined") {
                        return y.toFixed(0) + " points";
                    }
                    return y;

                }
            },
            color:['#9F528F'],
        }
    };
    var patientData4Chart = new ApexCharts(document.querySelector("#patientData4"), patientDataOptions4);
    patientData4Chart.render();
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>



@endsection

@section('after-scripts')