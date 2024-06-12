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

            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                        CKD PTS/BMI
                    </h3>
                    <div class="card-body canvasheight">
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="ckdPatients"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                    ESRD-CKD PTS/BMI
                    </h3>
                    <div class="card-body canvasheight">
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="esrdPatients"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                        Stage 4-CKD PTS/BMI
                    </h3>
                    <div class="card-body canvasheight">
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="stage4patients"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                        Stage 5-CKD PTS/BMI
                    </h3>
                    <div class="card-body canvasheight">
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="stage5patients"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('after-scripts')


<script>

    
    //chartjs

    new Chart(document.getElementById("ckdPatients"), {
        type: 'bar',
        data: {
            labels: [
                '18.6', '18.6-24.9', '25.0-29.0', '30.0 & above'
            ],
            datasets: [{
                label: "Charge Amount $",
                backgroundColor: "#842d72",
                data: [
                    {{$clinicalckdpatientsbmi1}},{{$clinicalckdpatientsbmi2}},{{$clinicalckdpatientsbmi3}},{{$clinicalckdpatientsbmi4}}
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        display: false
                    }
                },
                xAxes: [{
                    barPercentage: 0.7
                }]
            },

            legend: {
                display: false
            },

        },

    });

    new Chart(document.getElementById("esrdPatients"), {
        type: 'bar',
        data: {
            labels: [
                '<18', '18.6-24.9', '25-34.9', '35>='
            ],
            datasets: [{
                label: "Charge Amount $",
                backgroundColor: "#842d72",
                data: [
                    {{$clinicalckdpatientsbmistageESRD1}},{{$clinicalckdpatientsbmistageESRD2}},{{$clinicalckdpatientsbmistageESRD3}},{{$clinicalckdpatientsbmistageESRD4}}
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        display: false
                    }
                },
                xAxes: [{
                    barPercentage: 0.7
                }]
            },

            legend: {
                display: false
            },

        },

    });
    new Chart(document.getElementById("stage4patients"), {
        type: 'bar',
        data: {
            labels: [
                '<18', '18.6-24.9', '25-34.9', '35>='
            ],
            datasets: [{
                label: "Charge Amount $",
                backgroundColor: "#842d72",
                data: [
                    {{$clinicalckdpatientsbmistage41}},{{$clinicalckdpatientsbmistage42}},{{$clinicalckdpatientsbmistage43}},{{$clinicalckdpatientsbmistage44}}
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        display: false
                    }
                },
                xAxes: [{
                    barPercentage: 0.7
                }]
            },

            legend: {
                display: false
            },

        },

    });

    new Chart(document.getElementById("stage5patients"), {
        type: 'bar',
        data: {
            labels: [
                '<18', '18.6-24.9', '25-34.9', '35>='
            ],
            datasets: [{
                label: "Charge Amount $",
                backgroundColor: "#842d72",
                data: [
                    {{$clinicalckdpatientsbmistage51}},{{$clinicalckdpatientsbmistage52}},{{$clinicalckdpatientsbmistage53}},{{$clinicalckdpatientsbmistage54}}
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        display: false
                    }
                },
                xAxes: [{
                    barPercentage: 0.7
                }]
            },

            legend: {
                display: false
            },
            
        },

    });

    //chartjs end
</script>



@endsection