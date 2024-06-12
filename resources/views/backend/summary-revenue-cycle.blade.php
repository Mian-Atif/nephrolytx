@extends('backend.layouts.dashboard')


@section('content-new')



<div class="content-wrapper">
    <div class="home-background-summary esrd-card-box">

        <div class="row chart-row">

            <div class="col-md-8 grid-margin  stretch-card ">
                <div class="card">
                    <div class="card-header-summary">
                        <h2 class="home-design123">
                            Total Revenue Posted in a Year
                        </h2>
                        <ul class="graph-label-ul">
                            <li>
                                <span></span>
                                <span>Revenue Posted</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body card-border">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="chargesAndPaymentsAnalysis1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card ">
                <div class="card">
                    <h2 class="home-design123">
                        Trend
                    </h2>
                    <div class="card-body card-body-colr card-border">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="bill-stat-lists">
                                    <li class="status-ready-to-bill">
                                        <span>Current Year Total Revenue</span>
                                        <span>${{$cashPostedCyS1F}}</span>
                                    </li>
                                    <li class="status-no-resp">
                                        <span>Previous Year</span>
                                        <span>${{$cashPostedP1ySF}}</span>
                                    </li>
                                    <li class="status-denials">
                                    @if($cashPostedTrendS == 0)
                                        <span>% Equal</span>
                                        <span>{{$cashPostedTrendS}}%</span>
                                        @elseif($cashPostedTrendS > 0)
                                        <span>% Increases</span>
                                        <span>{{$cashPostedTrendS}}%</span>
                                        @else
                                        <span>% Decreases</span>
                                        <span>{{$cashPostedTrendS}}%</span>
                                        @endif
                                    </li>
                                </ul>
                                <div class="pbi-bottom svg-icon-purple">
                                @php 
                                    if($cashPostedTrendS == 0){
                                        $finalVal = 0;
                                    }elseif($cashPostedTrendS < 0){
                                        $finalVal = 2;
                                    }else{
                                        $finalVal = 1;
                                    }
                                        App\Http\Controllers\nepanalysis\AnalysisController::svgTrend($finalVal);
                                     @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row chart-row ">

            <div class="col-md-8 grid-margin  stretch-card ">
                <div class="card">
                    <div class="card-header-summary">
                        <h2 class="home-design123">
                            Total Encounters in a Year
                        </h2>
                        <ul class="graph-label-ul graph-label-ul-color-lite-green">
                            <li>
                                <span></span>
                                <span>Encounters</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body card-border">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="chargesAndPaymentsAnalysis2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card ">
                <div class="card">
                    <h2 class="home-design123">
                        Trend
                    </h2>
                    <div class="card-body card-body-colr card-border">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="bill-stat-lists">
                                    <li class="status-ready-to-bill">
                                        <span>Current Year Total Encounters</span>
                                        <span>{{$encounterCySF}}</span>
                                    </li>
                                    <li class="status-no-resp">
                                        <span>Previous Year</span>
                                        <span>{{$encounterP1ySF}}</span>
                                    </li>
                                    <li class="status-denials">
                                    @if($encountersTrendS == 0)
                                        <span>% Equal</span>
                                        <span>{{$encountersTrendS}}%</span>
                                        @elseif($encountersTrendS > 0)
                                        <span>% Increases</span>
                                        <span>{{$encountersTrendS}}%</span>
                                        @else
                                        <span>% Decreases</span>
                                        <span>{{$encountersTrendS}}%</span>
                                        @endif
                                    </li>
                                </ul>
                                <div class="pbi-bottom svg-icon-lite-green">
                                    @php 
                                    if($encountersTrendS == 0){
                                        $finalVal = 0;
                                    }elseif($encountersTrendS < 0){
                                        $finalVal = 2;
                                    }else{
                                        $finalVal = 1;
                                    }
                                        App\Http\Controllers\nepanalysis\AnalysisController::svgTrend($finalVal);
                                     @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row chart-row">

            <div class="col-md-8 grid-margin  stretch-card ">
                <div class="card">
                    <div class="card-header-summary">
                        <h2 class="home-design123">
                            Total Patients Seen in a Year
                        </h2>
                        <ul class="graph-label-ul graph-label-ul-color-blue">
                            <li>
                                <span></span>
                                <span>Patients Seen</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body card-border">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="chargesAndPaymentsAnalysis3"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card ">
                <div class="card">
                    <h2 class="home-design123">
                        Trend
                    </h2>
                    <div class="card-body card-body-colr card-border">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="bill-stat-lists">
                                    <li class="status-ready-to-bill">
                                        <span>Current Year Total Patients Seen</span>
                                        <span>{{$patientsSeenCyS1}}</span>
                                    </li>
                                    <li class="status-no-resp">
                                        <span>Previous Year</span>
                                        <span>{{$patientsSeenP1ySF}}</span>
                                    </li>
                                    <li class="status-denials">
                                    @if($patientsSeenTrendS == 0)
                                        <span>% Equal</span>
                                        <span>{{$patientsSeenTrendS}}%</span>
                                        @elseif($patientsSeenTrendS > 0)
                                        <span>% Increases</span>
                                        <span>{{$patientsSeenTrendS}}%</span>
                                        @else
                                        <span>% Decreases</span>
                                        <span>{{$patientsSeenTrendS}}%</span>
                                        @endif
                                    </li>
                                </ul>
                                <div class="pbi-bottom svg-icon-blue">
                                @php 
                                    if($patientsSeenTrendS == 0){
                                        $finalVal = 0;
                                    }elseif($patientsSeenTrendS < 0){
                                        $finalVal = 2;
                                    }else{
                                        $finalVal = 1;
                                    }
                                        App\Http\Controllers\nepanalysis\AnalysisController::svgTrend($finalVal);
                                     @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row chart-row">

            <div class="col-md-8 grid-margin  stretch-card ">
                <div class="card">
                    <div class="card-header-summary">
                        <h2 class="home-design123">
                            Total New Patients in a Year
                        </h2>
                        <ul class="graph-label-ul graph-label-ul-color-green">
                            <li>
                                <span></span>
                                <span>New Patients</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body card-border">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="chargesAndPaymentsAnalysis4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card ">
                <div class="card">
                    <h2 class="home-design123">
                        Trend
                    </h2>
                    <div class="card-body card-body-colr card-border">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="bill-stat-lists">
                                    <li class="status-ready-to-bill">
                                        <span>Current Year Total New Patients</span>
                                        <span>{{$newPatientsCySF}}</span>
                                    </li>
                                    <li class="status-no-resp">
                                        <span>Previous Year</span>
                                        <span>{{$newPatientsP1ySF}}</span>
                                    </li>
                                    <li class="status-denials">
                                    @if($newPatientsTrendS == 0)
                                        <span>% Equal</span>
                                        <span>{{$newPatientsTrendS}}%</span>
                                        @elseif($newPatientsTrendS > 0)
                                        <span>% Increases</span>
                                        <span>{{$newPatientsTrendS}}%</span>
                                        @else
                                        <span>% Decreases</span>
                                        <span>{{$newPatientsTrendS}}%</span>
                                        @endif
                                    </li>
                                </ul>
                                <div class="pbi-bottom svg-icon-green">
                                @php 
                                    if($newPatientsTrendS == 0){
                                        $finalVal = 0;
                                    }elseif($newPatientsTrendS < 0){
                                        $finalVal = 2;
                                    }else{
                                        $finalVal = 1;
                                    }
                                        App\Http\Controllers\nepanalysis\AnalysisController::svgTrend($finalVal);
                                     @endphp

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="summary-total-payments">
            <div class="card-header-summary">
                <h2 class="home-design1234">
                    Total Revenue (Service Wise)
                </h2>
                <ul class="graph-label-ul">
                    <li>
                        <span class="green-label-color"></span>
                        <span>Current Year</span>
                    </li>
                    <li>
                        <span class="purple-label-color"></span>
                        <span>Prior Year</span>
                    </li>
                </ul>
            </div>
            <div class="total-payments-graph">
                <div class="graph-item">
                    <div class="summary-Early-ckd">
                        Early CKD
                    </div>
                    <div id="chargesAndPaymentsAnalysis11"></div>
                </div>
                <div class="graph-item">
                    <div class="summary-Early-ckd">
                        Stage 4 CKD
                    </div>
                    <div id="chargesAndPaymentsAnalysis12"></div>
                </div>
                <div class="graph-item">
                    <div class="summary-Early-ckd">
                        Stage 5 CKD
                    </div>
                    <div id="chargesAndPaymentsAnalysis13"></div>
                </div>
                <div class="graph-item">
                    <div class="summary-Early-ckd">
                        ESRD
                    </div>
                    <div id="chargesAndPaymentsAnalysis14"></div>
                </div>
                <div class="graph-item">
                    <div class="summary-Early-ckd">
                        NON CKD
                    </div>
                    <div id="chargesAndPaymentsAnalysis15"></div>
                </div>
            </div>
        </div>
        <div class="row row-margin-less">
            <div class="col-md-6">
                <div class="chart-row pad-chart">
                    <div class="card-header-summary">
                        <h2 class="home-design123  rccard-summarybox">
                            Revenue Per Patient
                        </h2>
                        <ul class="graph-label-ul">
                            <li>
                                <span class="green-label-color"></span>
                                <span>Current Year</span>
                            </li>
                            <li>
                                <span class="purple-label-color"></span>
                                <span>Prior Year</span>
                            </li>
                        </ul>
                    </div>

                    <div class="card-border">
                        <div id="collectionComparison1"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-row pad-chart">
                    <div class="card-header-summary">
                        <h2 class="home-design123  rccard-summarybox">
                            Total Revenue
                        </h2>
                        <ul class="graph-label-ul">
                            <li>
                                <span class="green-label-color"></span>
                                <span>Current Year</span>
                            </li>
                            <li>
                                <span class="purple-label-color"></span>
                                <span>Prior Year</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-border">
                        <div id="collectionComparison2"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row row-margin-less">
            <div class="col-md-6">
                <div class="chart-row pad-chart">
                    <div class="card-header-summary">
                        <h2 class="home-design123  rccard-summarybox">
                            Revenue Per Encounter
                        </h2>
                        <ul class="graph-label-ul">
                            <li>
                                <span class="green-label-color"></span>
                                <span>Current Year</span>
                            </li>
                            <li>
                                <span class="purple-label-color"></span>
                                <span>Prior Year</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-border">
                        <div id="collectionComparison3"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-row pad-chart">
                    <div class="card-header-summary">
                        <h2 class="home-design123  rccard-summarybox">
                            Total Encounters
                        </h2>
                        <ul class="graph-label-ul">
                            <li>
                                <span class="green-label-color"></span>
                                <span>Current Year</span>
                            </li>
                            <li>
                                <span class="purple-label-color"></span>
                                <span>Prior Year</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-border">
                        <div id="collectionComparison4"></div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row row-margin-less">
            <div class="col-md-6">
                <div class="chart-row pad-chart">
                    <div class="card-header-summary">
                        <h2 class="home-design123  rccard-summarybox">
                            Encounters Per Patients
                        </h2>
                        <ul class="graph-label-ul">
                            <li>
                                <span class="green-label-color"></span>
                                <span>Current Year</span>
                            </li>
                            <li>
                                <span class="purple-label-color"></span>
                                <span>Prior Year</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-border">
                        <div id="collectionComparison5"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="chart-row pad-chart">
                    <div class="card-header-summary">
                        <h2 class="home-design123  rccard-summarybox">
                            Total Patients
                        </h2>
                        <ul class="graph-label-ul">
                            <li>
                                <span class="green-label-color"></span>
                                <span>Current Year</span>
                            </li>
                            <li>
                                <span class="purple-label-color"></span>
                                <span>Prior Year</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-border">
                        <div id="collectionComparison6"></div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row row-margin-less">
            <div class="col-md-6">
                <div class="chart-row pad-chart">
                    <div class="card-header-summary">
                        <h2 class="home-design123  rccard-summarybox">
                            New Patients
                        </h2>
                        <ul class="graph-label-ul">
                            <li>
                                <span class="green-label-color"></span>
                                <span>Current Year</span>
                            </li>
                            <li>
                                <span class="purple-label-color"></span>
                                <span>Prior Year</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-border">
                        <div id="collectionComparison7"></div>
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


    const grideHide2 = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                display: false
            },
            x: {
                display: false
            }
        },
        plugins: {
            legend: {
                display: false
            },
        }

    };

    // Apex chart
    var chargesAndPaymentsAnalysisOptions = {
        series: [{
            name: 'Revenue Posted',
            data: [ @foreach($cashPostedMonthGraph1 as $cashPostedMonthGraph1M)
                '{{$cashPostedMonthGraph1M->vls}}',
            @endforeach
        ]
        }, ],
        chart: {
            fontFamily: 'Quicksand',
            type: 'bar',
            height: 200,
            stacked: true,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
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
                columnWidth: '35%',
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
            borderColor: '#e9e9e9',
            strokeDashArray: 8,
        },
        xaxis: {
            categories: [ @foreach($cashPostedMonthGraph1 as $cashPostedMonthGraph1M)
                '{{$cashPostedMonthGraph1M->kys}}',
            @endforeach],
            labels: {
                style: {
                    fontSize: '10px'     
                },
            },
        },
        yaxis: {
            tickAmount: 6,
            floating: false,
            labels: {
                style: {
                    colors: '#8e8da4'
                },
                offsetY: -6,
                offsetX: 0,
                formatter: function(value) {
                    var val = Math.abs(value)
                    console.log(val);
                    val = '$'+ val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
        },
        fill: {
            opacity: 1,
            colors: ['#842d72', '#7FB444']
        },
        dataLabels: {
            enabled: false,
            style: {
                fontSize: '12px',
                colors: ['#fff']
            }
        },
    };

    var chargesAndPaymentsAnalysisChart = new ApexCharts(document.querySelector("#chargesAndPaymentsAnalysis1"), chargesAndPaymentsAnalysisOptions);
    chargesAndPaymentsAnalysisChart.render();

    // Apex chart 
    var chargesAndPaymentsAnalysisOptions = {
        series: [{
            name: 'Encounters',
            data: [
                @foreach($encounterMonthGraphS as $encounterMonthGraphSS)
                '{{$encounterMonthGraphSS->total_encounter}}',
            @endforeach
            ]
        }, ],
        chart: {
            fontFamily: 'Quicksand',
            type: 'bar',
            height: 200,
            stacked: true,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
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
                columnWidth: '35%',
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
            borderColor: '#e9e9e9',
            strokeDashArray: 8,
        },
        xaxis: {
            categories: [   @foreach($encounterMonthGraphS as $encounterMonthGraphSS)
                '{{$encounterMonthGraphSS->kys}}',
            @endforeach],
            labels: {
                style: {
                    fontSize: '10px'     
                },
            },
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
                
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            labels: {
                useSeriesColors: false
            },
            markers: {
                fillColors: ['#6DCBA3', '#6DCBA3'],
                radius: 12,
            },
        },
        fill: {
            opacity: 1,
            colors: ['#6DCBA3']
        },
        dataLabels: {
            enabled: false,
            style: {
                fontSize: '12px',
                colors: ['#fff']
            }
        },
    };

    var chargesAndPaymentsAnalysisChart = new ApexCharts(document.querySelector("#chargesAndPaymentsAnalysis2"), chargesAndPaymentsAnalysisOptions);
    chargesAndPaymentsAnalysisChart.render();

    // Apex Chart
    var chargesAndPaymentsAnalysisOptions = {
        series: [{
            name: 'Patient Seen',
            data: [
                @foreach($patientsSeenMonthGraphS as $patientsSeenMonthGraphSS)
                '{{$patientsSeenMonthGraphSS->total_patient_seen}}',
            @endforeach
            ]
        }, ],
        chart: {
            fontFamily: 'Quicksand',
            type: 'bar',
            height: 200,
            stacked: true,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
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
                columnWidth: '35%',
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
            borderColor: '#e9e9e9',
            strokeDashArray: 8,
        },
        xaxis: {
            categories: [  @foreach($patientsSeenMonthGraphS as $patientsSeenMonthGraphSS)
                '{{$patientsSeenMonthGraphSS->kys}}',
            @endforeach],
            labels: {
                style: {
                    fontSize: '10px'     
                },
            },
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
                
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            labels: {
                useSeriesColors: false
            },
            markers: {
                fillColors: ['#842D73', '#842D73'],
                radius: 12,
            },
        },
        fill: {
            opacity: 1,
            colors: ['#776ACF']
        },
        dataLabels: {
            enabled: false,
            style: {
                fontSize: '12px',
                colors: ['#fff']
            }
        },
    };

    var chargesAndPaymentsAnalysisChart = new ApexCharts(document.querySelector("#chargesAndPaymentsAnalysis3"), chargesAndPaymentsAnalysisOptions);
    chargesAndPaymentsAnalysisChart.render();



    // Charges & Payments Analysis
    var chargesAndPaymentsAnalysisOptions = {
        series: [{
            name: 'New Patients',
            data: [
                @foreach($newPatientsMonthGraphS as $newPatientsMonthGraphSS)
                '{{$newPatientsMonthGraphSS->new_patient}}',
            @endforeach
            ]
        }, ],
        chart: {
            fontFamily: 'Quicksand',
            type: 'bar',
            height: 200,
            stacked: true,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
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
                columnWidth: '35%',
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
            borderColor: '#e9e9e9',
            strokeDashArray: 8,
        },
        xaxis: {
            categories: [  @foreach($newPatientsMonthGraphS as $newPatientsMonthGraphSS)
                '{{$newPatientsMonthGraphSS->kys}}',
            @endforeach],
            labels: {
                style: {
                    fontSize: '10px'     
                },
            },
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
                
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            labels: {
                useSeriesColors: false
            },
            markers: {
                fillColors: ['#6DCBA3', '#6DCBA3'],
                radius: 12,
            },
        },
        fill: {
            opacity: 1,
            colors: ['#02BC77']
        },
        dataLabels: {
            enabled: false,
            style: {
                fontSize: '12px',
                colors: ['#fff']
            }
        },
    };

    var chargesAndPaymentsAnalysisChart = new ApexCharts(document.querySelector("#chargesAndPaymentsAnalysis4"), chargesAndPaymentsAnalysisOptions);
    chargesAndPaymentsAnalysisChart.render();

    // Apex Chart 2


    var collectionComparisonOptions = {
        series: [{
                name: 'Prior Year',
                data: [ 
                    @foreach($cashPerPatientS as $cashPerPatientSS)
                '{{$cashPerPatientSS->cash_per_pts_p1y}}',
            @endforeach
                ]
            },
            {
                name: 'Current Year',
                data: [ @foreach($cashPerPatientS as $cashPerPatientSS)
                '{{$cashPerPatientSS->cash_per_pts_cy}}',
            @endforeach
                ]
            }
        ],
        colors:['#842d72', '#02BC77'],
        chart: {
            fontFamily: 'Quicksand',
            type: 'area',
            height: 180,
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
        stroke: {
            curve: 'smooth',
            width: [1, 1],
            colors: ['#842d72', '#02BC77'],

        },
        grid: {
            borderColor: '#e9e9e9',
            strokeDashArray: 6,
        },
        xaxis: {
            categories: [ 
                @foreach($cashPerPatientS as $cashPerPatientSS)
                '{{$cashPerPatientSS->kys}}',
            @endforeach
        ],
        },
        yaxis: {
            tickAmount: 6,
            floating: false,
            labels: {
                style: {
                    colors: '#842d72',
                },
                offsetY: -6,
                offsetX: 0,
                formatter: function(value) {
                    var val = Math.abs(value)
                    console.log(val);
                    val = '$'+ val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.4,
                stops: [0, 100, 100]
            },
            colors: ['#842d72', '#02BC77'],
        },
        legend: {
            show: false,
            position: 'top',
            horizontalAlign: 'right',
            labels: {
                useSeriesColors: false
            },
            markers: {
                fillColors: ['#02BC77', '#842d72'],
                radius: 14,
            },
        },
        markers: {
            size: 4,
            colors: ['#fff'],
            shape: "circle",
            radius: 12,
            strokeColors: ['#842d72', '#02BC77'],
            strokeWidth: 2,
        },
    };

    var collectionComparisonChart = new ApexCharts(document.querySelector("#collectionComparison1"), collectionComparisonOptions);
    collectionComparisonChart.render();

    // Apex Chart 2

    var collectionComparisonOptions = {
        series: [{
                name: 'Prior Year',
                data: [ @foreach($totalPaymentsS as $totalPaymentsSS)
                '{{$totalPaymentsSS->total_payment_p1y}}',
            @endforeach
                ]
            },
            {
                name: 'Current Year',
                data: [@foreach($totalPaymentsS as $totalPaymentsSS)
                '{{$totalPaymentsSS->total_payment_cy}}',
            @endforeach
                ]
            }
        ],
        colors:['#842d72','#02BC77'],
        chart: {
            fontFamily: 'Quicksand',
            type: 'area',
            height: 180,
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
        stroke: {
            curve: 'smooth',
            width: [1, 1],
            colors: ['#842d72', '#02BC77'],

        },
        grid: {
            borderColor: '#e9e9e9',
            strokeDashArray: 6,
        },
        xaxis: {
            categories: [ 
                @foreach($totalPaymentsS as $totalPaymentsSS)
                '{{$totalPaymentsSS->kys}}',
            @endforeach
        ],
        },
        yaxis: {
            tickAmount: 6,
            floating: false,
            labels: {
                style: {
                    colors: '#842d72',
                },
                offsetY: -6,
                offsetX: 0,
                formatter: function(value) {
                    var val = Math.abs(value)
                    console.log(val);
                    val = '$'+ val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.4,
                stops: [0, 100, 100]
            },
            colors: ['#842d72', '#02BC77'],
        },
        legend: {
            show: false,
            position: 'top',
            horizontalAlign: 'right',
            labels: {
                useSeriesColors: false
            },
            markers: {
                fillColors: ['#02BC77', '#842d72'],
                radius: 14,
            },
        },
        markers: {
            size: 4,
            colors: ['#fff'],
            shape: "circle",
            radius: 12,
            strokeColors: ['#842d72', '#02BC77'],
            strokeWidth: 2,
        },
    };

    var collectionComparisonChart = new ApexCharts(document.querySelector("#collectionComparison2"), collectionComparisonOptions);
    collectionComparisonChart.render();

    // Apex Chart 2



    var collectionComparisonOptions = {
        series: [{
                name: 'Prior Year',
                data: [ 
                    @foreach($cashPerEncountersS as $cashPerEncountersSS)
                '{{$cashPerEncountersSS->cash_per_encounter_p1y}}',
            @endforeach
                ]
            },
            {
                name: 'Current Year',
                data: [ @foreach($cashPerEncountersS as $cashPerEncountersSS)
                '{{$cashPerEncountersSS->cash_per_encounter_cy}}',
            @endforeach
                ]
            }
        ],
        colors:['#842d72', '#02BC77'],
        chart: {
            fontFamily: 'Quicksand',
            type: 'area',
            height: 180,
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
        stroke: {
            curve: 'smooth',
            width: [1, 1],
            colors: ['#842d72', '#02BC77'],

        },
        grid: {
            borderColor: '#e9e9e9',
            strokeDashArray: 6,
        },
        xaxis: {
            categories: [
                @foreach($cashPerEncountersS as $cashPerEncountersSS)
                '{{$cashPerEncountersSS->kys}}',
            @endforeach
            ],
        },
        yaxis: {
            tickAmount: 6,
            floating: false,
            labels: {
                style: {
                    colors: '#842d72',
                },
                offsetY: -6,
                offsetX: 0,
                formatter: function(value) {
                    var val = Math.abs(value)
                    console.log(val);
                    val = '$'+ val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.4,
                stops: [0, 100, 100]
            },
            colors: ['#842d72', '#02BC77'],
        },
        legend: {
            show: false,
            position: 'top',
            horizontalAlign: 'right',
            labels: {
                useSeriesColors: false
            },
            markers: {
                fillColors: ['#02BC77', '#842d72'],
                radius: 14,
            },
        },
        markers: {
            size: 4,
            colors: ['#fff'],
            shape: "circle",
            radius: 12,
            strokeColors: ['#842d72', '#02BC77'],
            strokeWidth: 2,
        },
    };

    var collectionComparisonChart = new ApexCharts(document.querySelector("#collectionComparison3"), collectionComparisonOptions);
    collectionComparisonChart.render();

    // Apex Chart 2



    var collectionComparisonOptions = {
        series: [{
                name: 'Prior Year',
                data: [ 
                    @foreach($totalEncountersS as $totalEncountersSS)
                '{{$totalEncountersSS->total_encounter_p1y}}',
            @endforeach
                ]
            },
            {
                name: 'Current Year',
                data: [ @foreach($totalEncountersS as $totalEncountersSS)
                '{{$totalEncountersSS->total_encounter_cy}}',
            @endforeach
                ]
            }
        ],
        colors:['#842d72', '#02BC77'],
        chart: {
            fontFamily: 'Quicksand',
            type: 'area',
            height: 180,
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
        stroke: {
            curve: 'smooth',
            width: [1, 1],
            colors: ['#842d72', '#02BC77'],

        },
        grid: {
            borderColor: '#e9e9e9',
            strokeDashArray: 6,
        },
        xaxis: {
            categories: [
                @foreach($totalEncountersS as $totalEncountersSS)
                '{{$totalEncountersSS->kys}}',
            @endforeach
            ],
        },
        yaxis: {
            tickAmount: 6,
            floating: false,
            labels: {
                style: {
                    colors: '#842d72',
                },
                offsetY: -6,
                offsetX: 0,
                
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.4,
                stops: [0, 100, 100]
            },
            colors: ['#842d72', '#02BC77'],
        },
        legend: {
            show: false,
            position: 'top',
            horizontalAlign: 'right',
            labels: {
                useSeriesColors: false
            },
            markers: {
                fillColors: ['#02BC77', '#842d72'],
                radius: 14,
            },
        },
        markers: {
            size: 4,
            colors: ['#fff'],
            shape: "circle",
            radius: 12,
            strokeColors: ['#842d72', '#02BC77'],
            strokeWidth: 2,
        },
    };

    var collectionComparisonChart = new ApexCharts(document.querySelector("#collectionComparison4"), collectionComparisonOptions);
    collectionComparisonChart.render();

    // Apex Chart 2



    var collectionComparisonOptions = {
        series: [{
                name: 'Prior Year',
                data: [ 
                    @foreach($encounterPerPatientS as $encounterPerPatientSS)
                '{{$encounterPerPatientSS->encounter_per_patient_p1y}}',
            @endforeach
                ]
            },
            {
                name: 'Current Year',
                data: [ @foreach($encounterPerPatientS as $encounterPerPatientSS)
                '{{$encounterPerPatientSS->encounter_per_patient_cy}}',
            @endforeach
                ]
            }
        ],
        colors:['#842d72', '#02BC77'],
        chart: {
            fontFamily: 'Quicksand',
            type: 'area',
            height: 180,
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
        stroke: {
            curve: 'smooth',
            width: [1, 1],
            colors: ['#842d72', '#02BC77'],

        },
        grid: {
            borderColor: '#e9e9e9',
            strokeDashArray: 6,
        },
        xaxis: {
            categories: [
                @foreach($encounterPerPatientS as $encounterPerPatientSS)
                '{{$encounterPerPatientSS->kys}}',
            @endforeach
            ],
        },
        yaxis: {
            tickAmount: 6,
            floating: false,
            labels: {
                style: {
                    colors: '#842d72',
                },
                offsetY: -6,
                offsetX: 0,
                
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.4,
                stops: [0, 100, 100]
            },
            colors: ['#842d72', '#02BC77'],
        },
        legend: {
            show: false,
            position: 'top',
            horizontalAlign: 'right',
            labels: {
                useSeriesColors: false
            },
            markers: {
                fillColors: ['#02BC77', '#842d72'],
                radius: 14,
            },
        },
        markers: {
            size: 4,
            colors: ['#fff'],
            shape: "circle",
            radius: 12,
            strokeColors: ['#842d72', '#02BC77'],
            strokeWidth: 2,
        },
    };

    var collectionComparisonChart = new ApexCharts(document.querySelector("#collectionComparison5"), collectionComparisonOptions);
    collectionComparisonChart.render();

    // Apex Chart 2



    var collectionComparisonOptions = {
        series: [{
                name: 'Prior Year',
                data: [ 
                    @foreach($totalPatientsS as $totalPatientsSS)
                '{{$totalPatientsSS->total_patient_p1y}}',
            @endforeach
                ]
            },
            {
                name: 'Current Year',
                data: [ @foreach($totalPatientsS as $totalPatientsSS)
                '{{$totalPatientsSS->total_patient_cy}}',
            @endforeach
                ]
            }
        ],
        colors:['#842d72', '#02BC77'],
        chart: {
            fontFamily: 'Quicksand',
            type: 'area',
            height: 180,
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
        stroke: {
            curve: 'smooth',
            width: [1, 1],
            colors: ['#842d72', '#02BC77'],

        },
        grid: {
            borderColor: '#e9e9e9',
            strokeDashArray: 6,
        },
        xaxis: {
            categories: [
                @foreach($totalPatientsS as $totalPatientsSS)
                '{{$totalPatientsSS->kys}}',
            @endforeach
            ],
        },
        yaxis: {
            tickAmount: 6,
            floating: false,
            labels: {
                style: {
                    colors: '#842d72',
                },
                offsetY: -6,
                offsetX: 0,
                
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.4,
                stops: [0, 100, 100]
            },
            colors: ['#842d72', '#02BC77'],
        },
        legend: {
            show: false,
            position: 'top',
            horizontalAlign: 'right',
            labels: {
                useSeriesColors: false
            },
            markers: {
                fillColors: ['#02BC77', '#842d72'],
                radius: 14,
            },
        },
        markers: {
            size: 4,
            colors: ['#fff'],
            shape: "circle",
            radius: 12,
            strokeColors: ['#842d72', '#02BC77'],
            strokeWidth: 2,
        },
    };

    var collectionComparisonChart = new ApexCharts(document.querySelector("#collectionComparison6"), collectionComparisonOptions);
    collectionComparisonChart.render();

    // Apex Chart 2



    var collectionComparisonOptions = {
        series: [{
                name: 'Prior Year',
                data: [ 
                    @foreach($totalNewPatientsS as $totalNewPatientsSS)
                '{{$totalNewPatientsSS->total_encounter_p1y}}',
            @endforeach
                ]
            },
            {
                name: 'Current Year',
                data: [ @foreach($totalNewPatientsS as $totalNewPatientsSS)
                '{{$totalNewPatientsSS->total_encounter_cy}}',
            @endforeach
                ]
            }
        ],
        colors:['#842d72', '#02BC77'],
        chart: {
            fontFamily: 'Quicksand',
            type: 'area',
            height: 180,
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
        stroke: {
            curve: 'smooth',
            width: [1, 1],
            colors: ['#842d72', '#02BC77'],

        },
        grid: {
            borderColor: '#e9e9e9',
            strokeDashArray: 6,
        },
        xaxis: {
            categories: [
                @foreach($totalNewPatientsS as $totalNewPatientsSS)
                '{{$totalNewPatientsSS->kys}}',
            @endforeach
            ],
        },
        yaxis: {
            tickAmount: 6,
            floating: false,
            labels: {
                style: {
                    colors: '#842d72',
                },
                offsetY: -6,
                offsetX: 0,
                
            },
            axisBorder: {
                show: false,
            },
            axisTicks: {
                show: false
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.4,
                opacityTo: 0.4,
                stops: [0, 100, 100]
            },
            colors: ['#842d72', '#02BC77'],
        },
        legend: {
            show: false,
            position: 'top',
            horizontalAlign: 'right',
            labels: {
                useSeriesColors: false
            },
            markers: {
                fillColors: ['#02BC77', '#842d72'],
                radius: 14,
            },
        },
        markers: {
            size: 4,
            colors: ['#fff'],
            shape: "circle",
            radius: 12,
            strokeColors: ['#842d72', '#02BC77'],
            strokeWidth: 2,
        },
    };

    var collectionComparisonChart = new ApexCharts(document.querySelector("#collectionComparison7"), collectionComparisonOptions);
    collectionComparisonChart.render();

    // Apex chart 11
    var chargesAndPaymentsAnalysisOptions = {
        series: [{
                name: 'Current Year',
                data: [{{$totalPaymentEarlyStageSCY1}}]
            },

            {
                name: 'Prior Year',
                data: [{{$totalPaymentEarlyStageSCPY1}}]
            },
        ],
        chart: {
            fontFamily: 'Quicksand',
            type: 'bar',
            height: 300,
            width: '100%',
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['#fff']
        },
        grid: {
            borderColor: '#ffffff',
            strokeDashArray: 8,
        },
        xaxis: {
            categories: [
                "2023",
                "2022"
            ],
            axisBorder: {
                show: false,
            },
            labels: {
                show: false,
            }
        },
        yaxis: {
            show: false
        },
        fill: {
            type: 'solid',
            colors: ['#02BC77','#842d72'],
        },
        legend: {
            show: false,
        },
        dataLabels: {
            enabled: false,
        },
    };

    var chargesAndPaymentsAnalysisChart = new ApexCharts(document.querySelector("#chargesAndPaymentsAnalysis11"), chargesAndPaymentsAnalysisOptions);
    chargesAndPaymentsAnalysisChart.render();

    // Apex chart 12
    var chargesAndPaymentsAnalysisOptions = {
        series: [{
                name: 'Current Year',
                data: [{{$totalPaymentStage4ckdSCY1}}]
            },

            {
                name: 'Prior Year',
                data: [{{$totalPaymentStage4ckdSPY1}}]
            },
        ],
        chart: {
            fontFamily: 'Quicksand',
            type: 'bar',
            height: 300,
            width: '100%',
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['#fff']
        },
        grid: {
            borderColor: '#ffffff',
            strokeDashArray: 8,
        },
        xaxis: {
            categories: [
                "2023",
                "2022"
            ],
            axisBorder: {
                show: false,
            },
            labels: {
                show: false,
            }
        },
        yaxis: {
            show: false
        },
        fill: {
            type: 'solid',
            colors: ['#02BC77','#842d72'],
        },
        legend: {
            show: false,
        },
        dataLabels: {
            enabled: false,
        },
    };


    var chargesAndPaymentsAnalysisChart = new ApexCharts(document.querySelector("#chargesAndPaymentsAnalysis12"), chargesAndPaymentsAnalysisOptions);
    chargesAndPaymentsAnalysisChart.render();


    // Apex chart 13
    var chargesAndPaymentsAnalysisOptions = {
        series: [{
                name: 'Current Year',
                data: [{{$totalPaymentStage5ckdSCY1}}]
            },

            {
                name: 'Prior Year',
                data: [{{$totalPaymentStage5ckdSPY1}}]
            },
        ],
        chart: {
            fontFamily: 'Quicksand',
            type: 'bar',
            height: 300,
            width: '100%',
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['#fff']
        },
        grid: {
            borderColor: '#ffffff',
            strokeDashArray: 8,
        },
        xaxis: {
            categories: [
                "2023",
                "2022"
            ],
            axisBorder: {
                show: false,
            },
            labels: {
                show: false,
            }
        },
        yaxis: {
            show: false
        },
        fill: {
            type: 'solid',
            colors: ['#02BC77','#842d72'],
        },
        legend: {
            show: false,
        },
        dataLabels: {
            enabled: false,
        },
    };


    var chargesAndPaymentsAnalysisChart = new ApexCharts(document.querySelector("#chargesAndPaymentsAnalysis13"), chargesAndPaymentsAnalysisOptions);
    chargesAndPaymentsAnalysisChart.render();


    // Apex chart 14
    var chargesAndPaymentsAnalysisOptions = {
        series: [{
                name: 'Current Year',
                data: [{{$totalPaymentEsrdSCY1}}]
            },

            {
                name: 'Prior Year',
                data: [{{$totalPaymentEsrdSPY1}}]
            },
        ],
        chart: {
            fontFamily: 'Quicksand',
            type: 'bar',
            height: 300,
            width: '100%',
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['#fff']
        },
        grid: {
            borderColor: '#ffffff',
            strokeDashArray: 8,
        },
        xaxis: {
            categories: [
                "2023",
                "2022"
            ],
            axisBorder: {
                show: false,
            },
            labels: {
                show: false,
            }
        },
        yaxis: {
            show: false
        },
        fill: {
            type: 'solid',
            colors: ['#02BC77','#842d72'],
        },
        legend: {
            show: false,
        },
        dataLabels: {
            enabled: false,
        },
    };


    var chargesAndPaymentsAnalysisChart = new ApexCharts(document.querySelector("#chargesAndPaymentsAnalysis14"), chargesAndPaymentsAnalysisOptions);
    chargesAndPaymentsAnalysisChart.render();


    // Apex chart 15
    var chargesAndPaymentsAnalysisOptions = {
        series: [{
                name: 'Current Year',
                data: [{{$totalPaymentNonCkdSCY1}}]
            },

            {
                name: 'Prior Year',
                data: [{{$totalPaymentNonCkdSPY1}}]
            },
        ],
        chart: {
            fontFamily: 'Quicksand',
            type: 'bar',
            height: 300,
            width: '100%',
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        stroke: {
            show: true,
            width: 2,
            colors: ['#fff']
        },
        grid: {
            borderColor: '#ffffff',
            strokeDashArray: 8,
        },
        xaxis: {
            categories: [
                "2023",
                "2022"
            ],
            axisBorder: {
                show: false,
            },
            labels: {
                show: false,
            }
        },
        yaxis: {
            show: false
        },
        fill: {
            type: 'solid',
            colors: ['#02BC77','#842d72'],
        },
        legend: {
            show: false,
        },
        dataLabels: {
            enabled: false,
        },
    };

    var chargesAndPaymentsAnalysisChart = new ApexCharts(document.querySelector("#chargesAndPaymentsAnalysis15"), chargesAndPaymentsAnalysisOptions);
    chargesAndPaymentsAnalysisChart.render();


    /* active_patients_count_per_physician Start */
    const labels1 = [
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
    ];

    const data1 = {
        labels: labels1,
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
            borderColor: 'rgb(132,45,114)',
            borderWidth: 10,
            maxBarThickness: 18,
            data: [

                20, 10, 50, 40, 20, 10, 10, 5, 50, 10, 30, 10

            ],
        }]
    };

    const config1 = {
        type: 'bar',
        data: data1,
        options: grideHide
    };

    const myChart1 = new Chart(
        document.getElementById('myChart1'),
        config1
    );

    /* active_patients_count_per_physician Start */
    const labels2 = [
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
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


    /* active_patients_count_per_physician Start */
    const labels3 = [
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
    ];

    const data3 = {
        labels: labels3,
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
            borderColor: 'rgb(132,45,114)',
            data: [

                0, 10, 5, 2, 20, 30, 45, 5, 2, 20, 30, 45

            ],
        }]
    };

    const config3 = {
        type: 'scatter',
        data: data3,
        options: grideHide
    };

    const myChart3 = new Chart(
        document.getElementById('myChart3'),
        config3
    );

    /* active_patients_count_per_physician End */

    /* active_patients_count_per_physician Start */
    const labels4 = [
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
    ];

    const data4 = {
        labels: labels4,
        datasets: [{
            label: '',
            backgroundColor: 'rgb(2,188,119)',
            borderColor: 'rgb(2,188,119)',
            data: [

                5, 10, 50, 5, 20, 10, 10, 5, 30, 10, 30, 10

            ],
        }]
    };

    const config4 = {
        type: 'scatter',
        data: data4,
        options: grideHide
    };

    const myChart4 = new Chart(
        document.getElementById('myChart4'),
        config4
    );
    /* active_patients_count_per_physician Start */
    const labels5 = [
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
    ];

    const data5 = {
        labels: labels5,
        datasets: [{
            label: '',
            backgroundColor: 'rgb(127,180,68)',
            borderColor: 'rgb(127,180,68)',
            data: [

                10, 25, 5, 30, 20, 55, 45, 5, 20, 20, 30, 10

            ],
        }]
    };

    const config5 = {
        type: 'scatter',
        data: data5,
        options: grideHide
    };

    const myChart5 = new Chart(
        document.getElementById('myChart5'),
        config5
    );
    /* active_patients_count_per_physician Start */

    /* active_patients_count_per_physician Start */
    const labels6 = [
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
    ];

    const data6 = {
        labels: labels6,
        datasets: [{
            label: '',
            backgroundColor: 'rgb(119,106,207)',
            borderColor: 'rgb(119,106,207)',
            data: [

                10, 25, 5, 30, 20, 55, 45, 5, 20, 20, 30, 10

            ],
        }]
    };

    const config6 = {
        type: 'scatter',
        data: data6,
        options: grideHide
    };

    const myChart6 = new Chart(
        document.getElementById('myChart6'),
        config6
    );
    /* active_patients_count_per_physician Start */

    /* active_patients_count_per_physician Start */
    const labels7 = [
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
        '13',
        '14',
        '15',
    ];

    const data7 = {
        labels: labels7,
        datasets: [{
            label: '',
            backgroundColor: 'rgb(2,188,119)',
            borderColor: 'rgb(2,188,119)',
            borderWidth: 15,
            maxBarThickness: 18,
            data: [

                10, 25, 50, 30, 40, 55, 45, 5, 20, 20, 30, 10, 40, 30, 50, 20

            ],
        }]
    };

    const config7 = {
        type: 'bar',
        data: data7,
        options: grideHide
    };

    const myChart7 = new Chart(
        document.getElementById('myChart7'),
        config7
    );
    /* active_patients_count_per_physician Start */

    /* active_patients_count_per_physician Start */
    const labels8 = [
        '1',
        '2',
        '3',
        '4',
        '5',
        '6',
        '7',
        '8',
        '9',
        '10',
        '11',
        '12',
    ];

    const data8 = {
        labels: labels8,
        datasets: [{
            label: '',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [

                10, 25, 5, 30, 20, 55, 45, 5, 20, 20, 30, 10

            ],
        }]
    };

    const config8 = {
        type: 'bar',
        data: data8,
        options: grideHide
    };

    const myChart8 = new Chart(
        document.getElementById('myChart8'),
        config8
    );
    /* active_patients_count_per_physician Start */
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>



@endsection

@section('after-scripts')
{{-- {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
{{ Html::script(asset('js/template/js/fusioncharts.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}