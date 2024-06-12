{{--@extends('backend.layouts.app')--}}
@extends('backend.layouts.dashboard')

@section('after-styles')
<style>
    #chart-container,
    #chart-container-yearly {
        position: relative;
    }

    #chart-container::after,
    #chart-container-yearly::after {
        position: absolute;
        content: '';
        background-color: #fff;
        height: 15px;
        width: 200px;
        bottom: 0;
        left: 0;

    }

    /* Tooltip container */
    /*  .tooltip {
            position: relative;
            display: inline-block;
            border-bottom: 1px dotted black; !* If you want dots under the hoverable text *!
        }*/

    /* Tooltip text */
    .tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: black;
        color: #fff;
        text-align: center;
        padding: 5px 0;
        border-radius: 6px;

        /* Position the tooltip text - see examples below! */
        position: absolute;
        z-index: 1;
    }

    /* Show the tooltip text when you mouse over the tooltip container */
    .tooltip:hover .tooltiptext {
        visibility: visible;
    }
</style>
@endsection
@section('content-new')
<div class="content-wrapper">
    <div class="bg-white-wrap">
        <div class="row">
            <div class="col-md-12">
                <div class="table-card">
                    
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card-header-2">
                                <h4>CKD Patients Inflow</h4>
                            </div>
                            <table class="table table-responsive table-bordered nephro-table">
                                <thead>
                                    <tr>
                                        <th class="bg-white"></th>
                                        <th>Current Year</th>
                                        <th>Prior Year</th>
                                        <th>Percentage Change</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- <tr>
                                        <td>Total New CKD Patients</td>
                                        <td>{{$CKDPatientsInflowTablePTC1}}</td>
                                        <td>{{$CKDPatientsInflowTablePTC2}}</td>
                                        <td>{{$CKDPatientsInflowTablePTC3}}%</td>

                                    </tr> -->
                                    <tr>
                                        <td>Office Consults</td>
                                        <td>{{$CKDPatientsInflowTablePTCOC1}}</td>
                                        <td>{{$CKDPatientsInflowTablePTCOC2}}</td>
                                        <td>{{$CKDPatientsInflowTablePTCOC3}}%</td>

                                    </tr>
                                    <tr>
                                        <td>Hospital Consults</td>
                                        <td>{{$CKDPatientsInflowTablePTCHC1}}</td>
                                        <td>{{$CKDPatientsInflowTablePTCHC2}}</td>
                                        <td>{{$CKDPatientsInflowTablePTCHC3}}%</td>

                                    </tr>
                                    <tr>
                                        <td>Non-CKD to CKD</td>
                                        <td>{{$CKDPatientsInflowTablePTCNC1}}</td>
                                        <td>{{$CKDPatientsInflowTablePTCNC2}}</td>
                                        <td>{{$CKDPatientsInflowTablePTCNC3}}%</td>

                                    </tr>
                                    <tr>
                                        <td>Patient In-Flow Rate</td>
                                        <td>{{$CKDPatientsInflowTablePTCPIR1}}</td>
                                        <td>{{$CKDPatientsInflowTablePTCPIR2}}</td>
                                        <td>{{$CKDPatientsInflowTablePTCPIR3}}%</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                       
                        <div class="col-md-5">
                                <div class="card-header-2">
                                     <h4>Patients Inflow Rate</h4>
                                </div>
                            <div id="topTenDiagnosis"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-card">
                    
                    <div class="row">
                        <div class="col-md-7">

                                <div class="card-header-2">
                                    <h4>CKD Patients Outflow</h4>
                                </div>
                            <table class="table table-responsive table-bordered nephro-table">
                                <thead>
                                    <tr>
                                        <th class="bg-white"></th>
                                        <th>Current Year</th>
                                        <th>Prior Year</th>
                                        <th>Percentage Change</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- <tr>
                                        <td>Total Patients Lost</td>
                                        <td>{{$CKDPatientsOutflowTablePTC1}}</td>
                                        <td>{{$CKDPatientsOutflowTablePTC2}}</td>
                                        <td>{{$CKDPatientsOutflowTablePTC3}}%</td>

                                    </tr> -->
                                    <tr>
                                        <td>New Inactive Patients</td>
                                        <td>{{$CKDPatientsOutflowTablePTCNIP1}}</td>
                                        <td>{{$CKDPatientsOutflowTablePTCNIP2}}</td>
                                        <td>{{$CKDPatientsOutflowTablePTCNIP3}}%</td>

                                    </tr>
                                    <tr>
                                        <td>Active No Longer ESRD</td>
                                        <td>{{$CKDPatientsOutflowTablePTCAE1}}</td>
                                        <td>{{$CKDPatientsOutflowTablePTCAE2}}</td>
                                        <td>{{$CKDPatientsOutflowTablePTCAE3}}%</td>

                                    </tr>
                                    <tr>
                                        <td>Late Patients</td>
                                        <td>{{$CKDPatientsOutflowTablePTCLPB1}}</td>
                                        <td>{{$CKDPatientsOutflowTablePTCLPB2}}</td>
                                        <td>{{$CKDPatientsOutflowTablePTCLPB3}}%</td>

                                    </tr>
                                    <tr>
                                        <td>Patient Out-Flow Rate</td>
                                        <td>{{$CKDPatientsOutflowTablePTCOFR1}}</td>
                                        <td>{{$CKDPatientsOutflowTablePTCOFR2}}</td>
                                        <td>{{$CKDPatientsOutflowTablePTCOFR3}}%</td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-5">

                                <div class="card-header-2">
                                    <h4>Patients Outflow Rate</h4>
                                </div>
                            <div id="topTenDiagnosis2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="table-card">
                    <div class="card-header-2">
                        <h4>CKD Patients Comparison</h4>
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
    // By the Office Provider Chart
    var topTenDiagnosisOptions = {
        series: [{
            name: 'No. Of Patients',
            data: [ 
                @foreach($patientInFlowRateGraph1 as $key => $patientInFlowRateGraph11)
                    @php
                        if($key > 0){
                            $finalVal = round($patientInFlowRateGraph11->monthly_new/$patientInFlowRateGraph1[$key-1]->monthly_active_ckd,2);
                            @endphp
                '{{$finalVal}}',
                @php } @endphp 
            @endforeach
        ]
        }, ],
        colors: ['#842D72'],
        chart: {
            fontFamily: 'Quicksand',
            type: 'area',
            height: 300,
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
                borderRadius: 2,
                dataLabels: {
                    total: {
                        enabled: true,
                        style: {
                            fontSize: '0',
                            fontWeight: 100
                        }
                    }
                }
            },
        },
        stroke: {
            width: [2, 2],
            colors: ['#842D73']
        },
        grid: {
            borderColor: '#e9e9e9',
            strokeDashArray: 8,
        },
        markers: {
            size: 4,
            colors: ['#ffffff'],
            shape: "circle",
            radius: 12,
            strokeColors: '#842D73',
            strokeWidth: 3,
        },
        dataLabels: {
            enabled: false,
            style: {
                colors: ['#842D73']
            }
        },
        xaxis: {
            categories: [
                @foreach($patientInFlowRateGraph1 as $patientInFlowRateGraph11)
                '{{$patientInFlowRateGraph11->kys_monthly_new}}',
            @endforeach
            ]
        },

        fill: {
            type: "gradient",
            gradient: {
                shade: 'light',
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [40, 100, 100],
                colorStops: [{
                        offset: 0,
                        color: "#E9E9E966",
                        opacity: 0.18
                    },
                    {
                        offset: 100,
                        color: "#E9E9E966",
                        opacity: 0.05
                    }
                ]
            }
        },
    };

    var topTenDiagnosisChart = new ApexCharts(document.querySelector("#topTenDiagnosis"), topTenDiagnosisOptions);
    topTenDiagnosisChart.render();

    // Count of Pts with Albumin Under 2.0 (Month Wise) Chart
    var topTenDiagnosisOptions = {
        series: [{
            name: 'No. Of Patients',
            data: [ @foreach($patientOutFlowRateGraph1Arr as $key => $patientOutFlowRateG1)
                                '{{$patientOutFlowRateG1}}',
                            @endforeach]
        }, ],
        colors: ['#842D72'],
        chart: {
            fontFamily: 'Quicksand',
            type: 'area',
            height: 300,
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
                borderRadius: 2,
                dataLabels: {
                    total: {
                        enabled: true,
                        style: {
                            fontSize: '0',
                            fontWeight: 100
                        }
                    }
                }
            },
        },
        stroke: {
            width: [2, 2],
            colors: ['#842D73']
        },
        grid: {
            borderColor: '#e9e9e9',
            strokeDashArray: 8,
        },
        markers: {
            size: 4,
            colors: ['#ffffff'],
            shape: "circle",
            radius: 12,
            strokeColors: '#842D73',
            strokeWidth: 3,
        },
        dataLabels: {
            enabled: false,
            style: {
                colors: ['#842D73']
            }
        },
        xaxis: {
            categories: [
                @foreach($patientOutFlowRateGraph1Arr as $key => $patientOutFlowRateG1)
                                '{{$key}}',
                            @endforeach
            ]
        },

        fill: {
            type: "gradient",
            gradient: {
                shade: 'light',
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [40, 100, 100],
                colorStops: [{
                        offset: 0,
                        color: "#E9E9E966",
                        opacity: 0.18
                    },
                    {
                        offset: 100,
                        color: "#E9E9E966",
                        opacity: 0.05
                    }
                ]
            }
        }
    };

    var topTenDiagnosisChart = new ApexCharts(document.querySelector("#topTenDiagnosis2"), topTenDiagnosisOptions);
    topTenDiagnosisChart.render();


    var options = {
        series: [
            {
            name: 'Analysis year',
            data: [{{$clinicalckdpatientscomparison2}}, {{$clinicalckdpatientscomparison4}}, {{$clinicalckdpatientscomparison6}}]
        },
        {
            name: 'Prior year',
            data: [{{$clinicalckdpatientscomparison1}}, {{$clinicalckdpatientscomparison3}}, {{$clinicalckdpatientscomparison5}}]
        }, 
    ],
        colors:['#02bc77','#842d72'],
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
        xaxis: {
            categories: ['Early-Stage CKD', 'Late-Stage CKD', 'ESRD'],
        },

        fill: {
            opacity: 1
        },
       
    };

    var chart = new ApexCharts(document.querySelector("#stageWise"), options);
    chart.render();
</script>
@endsection


@section('after-scripts')


@endsection