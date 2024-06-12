@extends('backend.layouts.dashboard')


@section('content-new')



<div class="content-wrapper">
    <div class="home-background esrd-card-box">
        <div class="row">
            <div class="col-md-6 margin-bottom-1">
                <h4> Revenue (Dialysis & E&M) </h4>
            </div>
           <!-- <div class="col-md-6">
                <form class="form-inline graph-filter">
                    <div class="form-group mb-2">
                        <label for="staticEmail2" class="">Select Date</label>
                        <input type="date" class="form-control" id="staticEmail2" value="">
                    </div>
                    <button type="submit" class="btn btn-primary btn-primary-quick mb-2">Search</button>
                </form>
            </div> -->
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin  stretch-card ">
                <div class="card-shadow table-scroll width-100">
                    <table class="table table-graph">
                        <thead class="th-color">
                            <tr>
                                <th>Population</th>
                                <th>Current Year</th>
                                <th>Prior Year</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Revenue / FTE</td>
                                <td>{{"$".number_format($revenueperfteyearOTA->cy)}}</td>
                                <td>{{"$".number_format($revenueperfteyearOTA->p1y)}}</td>
                                <td><canvas id="myChart21" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Unique Patients Seen / FTE</td>
                                <td>{{$revenueperfteyearOTB->cy}}</td>
                                <td>{{$revenueperfteyearOTB->p1y}}</td>
                                <td><canvas id="myChart22" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Encounters / Patients</td>
                                <td>{{$revenueperfteyearOTC->cy}}</td>
                                <td>{{$revenueperfteyearOTC->p1y}}</td>
                                <td><canvas id="myChart23" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Total RVU / Encounter</td>
                                <td>${{$revenueperfteyearOTD->cy}}</td>
                                <td>${{$revenueperfteyearOTD->p1y}}</td>
                                <td><canvas id="myChart24" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Revenue / Total RVU</td>
                                <td>{{$revenueperfteyearOTE->cy}}%</td>
                                <td>{{$revenueperfteyearOTE->p1y}}%</td>
                                <td><canvas id="myChart25" class="single-line-chart"></canvas></td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                        Revenue Posted per FTE
                    </h3>
                    <div class="card-body canvasheight">
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="myChart1"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="home-background esrd-card-box">
        <div class="row">
            <div class="col-md-6 margin-bottom-1">
                <h4> Office </h4>
            </div>
           <!-- <div class="col-md-6 ">
                <form class="form-inline graph-filter">
                    <div class="form-group mb-2">
                        <label for="staticEmail2" class="">Select Date</label>
                        <input type="date" class="form-control" id="staticEmail2" value="">
                    </div>
                    <button type="submit" class="btn btn-primary btn-primary-quick mb-2">Search</button>
                </form>
            </div> -->
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin  stretch-card ">
                <div class="card-shadow table-scroll width-100">
                    <table class="table table-graph">
                        <thead class="th-color">
                            <tr>
                                <th>Office</th>
                                <th>Current Month</th>
                                <th>Prior Month</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Office New Encounter / FTE / Day</td>
                                <td>{{$officeNewPatientEncounterM1}}</td>
                                <td>{{$officeNewPatientEncounterM2}}</td>
                                <td><canvas id="myChart26" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Office Estab. Encounter / FTE / Day</td>
                                <td>{{$officeEstbdPatientEncounterM1}}</td>
                                <td>{{$officeEstbdPatientEncounterM2}}</td>
                                <td><canvas id="myChart27" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Office New Patient Avg. Code Level</td>
                                <td>{{$officeNewPatientAvgCodeLevelM1}}</td>
                                <td>{{$officeNewPatientAvgCodeLevelM2}}</td>
                                <td><canvas id="myChart28" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Office Estab. Patient Avg. Code Level</td>
                                <td>{{$officeEstabPatientAvgCodeLevelM1}}</td>
                                <td>{{$officeEstabPatientAvgCodeLevelM2}}</td>
                                <td><canvas id="myChart29" class="single-line-chart"></canvas></td>
                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                        Office New Encounters
                    </h3>
                    <div class="card-body canvasheight">
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="myChart2"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="home-background esrd-card-box">
        <div class="row">
            <div class="col-md-6 margin-bottom-1 ">
                <h4> Hospital </h4>
            </div>
            <!-- <div class="col-md-6">
                <form class="form-inline graph-filter">
                    <div class="form-group mb-2">
                        <label for="staticEmail2" class="">Select Date</label>
                        <input type="date" class="form-control" id="staticEmail2" value="">
                    </div>
                    <button type="submit" class="btn btn-primary btn-primary-quick mb-2">Search</button>
                </form>
            </div> -->
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin  stretch-card ">
                <div class="card-shadow table-scroll width-100">
                    <table class="table table-graph">
                        <thead class="th-color">
                            <tr>
                                <th>Hospital</th>
                                <th>Current Month</th>
                                <th>Prior Month</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Hospital New Encounter / FTE / Day</td>
                                <td>{{$hospitalNewPatientEncounterM1}}</td>
                                <td>{{$hospitalNewPatientEncounterM2}}</td>
                                <td><canvas id="myChart30" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Hospital Estab.Encounters / FTE / day</td>
                                <td>{{$hospitalEstbdPatientEncounterM1}}</td>
                                <td>{{$hospitalEstbdPatientEncounterM2}}</td>
                                <td><canvas id="myChart31" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Hospital New Patient Avg. Code Level</td>
                                <td>{{$hospitalNewPatientAvgCodeLevelM1}}</td>
                                <td>{{$hospitalNewPatientAvgCodeLevelM2}}</td>
                                <td><canvas id="myChart32" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Hospital Estab. Patient Avg. Code level</td>
                                <td>{{$hospitalEstabPatientAvgCodeLevelM1}}</td>
                                <td>{{$hospitalEstabPatientAvgCodeLevelM2}}</td>
                                <td><canvas id="myChart33" class="single-line-chart"></canvas></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                        Hospital New Encounters
                    </h3>
                    <div class="card-body canvasheight">
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="myChart3"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="home-background esrd-card-box">

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3 margin-bottom-1">
                        <h4> Dialysis </h4>
                    </div>
                    <!--<div class="col-md-9">
                        <form class="form-inline graph-filter">
                            <div class="form-group mb-2">
                                <label for="staticEmail2" class="">Select Date</label>
                                <input type="date" class="form-control" id="staticEmail2" value="">
                            </div>
                            <button type="submit" class="btn btn-primary btn-primary-quick mb-2">Search</button>
                        </form>
                    </div> -->
                </div>
                <div class=" grid-margin  stretch-card ">
                    <div class="card-shadow table-scroll width-100">
                        <table class="table table-graph">
                            <thead class="th-color">
                                <tr>
                                    <th>Dialysis</th>
                                    <th>Current Month</th>
                                    <th>Prior Month</th>
                                    <th>Trend</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>MCP 4 Visit %</td>
                                    <td>{{$inCenterDialysisM1}}</td>
                                    <td>{{$inCenterDialysisM2}}</td>    
                                    <td><canvas id="myChart34" class="single-line-chart"></canvas></td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h3 class="h3-color-home">Dialysis</h3>
                <p class="p-color">Dialysis claims: The claims for the dialysis.
                    Incenter: The office where the dialysis is done.
                    Dialysis: Percentage of Incenter monthly dialysis claims billed under 4 visit CPT code.</p>
            </div>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

Chart.defaults.font.family = 'Quicksand';    

    const grideHide = {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            yAxes: [{
                ticks: {
                    // format the y-axis labels here
                    callback: function(value, index, values) {
                        return '$' + value; // format as currency
                    }
                }
            }]
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

    /* active_patients_count_per_physician Start */
    const labels1 = [
    @foreach($revenueperftemonthA as $revenueperftemonth)
    '{{$revenueperftemonth->kys}}',
    @endforeach
    ];

    const data1 = {
        labels: labels1,
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
            borderColor: 'rgb(50,103,155)',
            data: [

                @foreach($revenueperftemonthA as $revenueperftemonth)
                '{{$revenueperftemonth->vals}}',
            @endforeach
            
        ],
        }]
    };

    const config1 = {
        type: 'line',
        data: data1,
        options: grideHide
    };

    const myChart1 = new Chart(
        document.getElementById('myChart1'),
        config1
    );
    /* active_patients_count_per_physician Start */
    const labels2 = [
                @foreach($officeNewPatientEncounterM as $officeNewPatientEncountermm)
                '{{$officeNewPatientEncountermm->kys}}',
            @endforeach
    ];

    const data2 = {
        labels: labels2,
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
            borderColor: 'rgb(50,103,155)',
            data: [
                @foreach($officeNewPatientEncounterM as $officeNewPatientEncountermm)
                '{{$officeNewPatientEncountermm->vals}}',
            @endforeach
            ],
        }]
    }; 

    const config2 = {
        type: 'line',
        data: data2,
        options: grideHide
    };

    const myChart2 = new Chart(
        document.getElementById('myChart2'),
        config2
    );
    /* active_patients_count_per_physician Start */
    const labels3 = [
@foreach($hospitalNewPatientEncounterM as $hospitalNewPatientEncountermm)
'{{$hospitalNewPatientEncountermm->kys}}',
@endforeach
    ];

    const data3 = {
        labels: labels3,
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
            borderColor: 'rgb(50,103,155)',
    
       
            data: [

                @foreach($hospitalNewPatientEncounterM as $hospitalNewPatientEncountermm)
                '{{$hospitalNewPatientEncountermm->vals}}',
            @endforeach

            ],
        }]
    };

    const config3 = {
        type: 'line',
        data: data3,
        options: grideHide
    };

    const myChart3 = new Chart(
        document.getElementById('myChart3'),
        config3
    );

    /* active_patients_count_per_physician End */

    var gLabels = [
        '{{Auth::user()->practiceP2EndDate() }}',
        '{{Auth::user()->practiceP1EndDate() }}',
        '{{Auth::user()->practiceEndDateYear() }}',
        ];


    /* active_patients_count_per_physician Start */

    const data21 = {
        labels:  gLabels,
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(132,45,114)',
        borderWidth: 2,
        pointRadius: 4,
        segment: {
            borderDash: [4,4]
        },
        data: [{{$revenueperfteyearOTA->p2y}}, {{$revenueperfteyearOTA->p1y}},{{$revenueperfteyearOTA->cy}}],
        }]
    };

    const config21 = {
        type: 'line',
        data: data21,
        options: grideHide2
    };

    const myChart21 = new Chart(
        document.getElementById('myChart21'),
        config21
    );
    /* active_patients_count_per_physician End */
    /* active_patients_count_per_physician Start */

    const data22 = {
        labels:  gLabels,
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(132,45,114)',
        borderWidth: 2,
        pointRadius: 4,
        segment: {
            borderDash: [4,4]
        },
        data: [{{$revenueperfteyearOTB->p2y}}, {{$revenueperfteyearOTB->p1y}},{{$revenueperfteyearOTB->cy}}],        }]
    };

    const config22 = {
        type: 'line',
        data: data22,
        options: grideHide2
    };

    const myChart22 = new Chart(
        document.getElementById('myChart22'),
        config22
    );
    /* active_patients_count_per_physician End */
    /* active_patients_count_per_physician Start */

    const data23 = {
        labels:  gLabels,
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(132,45,114)',
        borderWidth: 2,
        pointRadius: 4,
        segment: {
            borderDash: [4,4]
        },
        data: [{{$revenueperfteyearOTC->p2y}}, {{$revenueperfteyearOTC->p1y}},{{$revenueperfteyearOTC->cy}}],        }]
    };

    const config23 = {
        type: 'line',
        data: data23,
        options: grideHide2
    };

    const myChart23 = new Chart(
        document.getElementById('myChart23'),
        config23
    );
    /* active_patients_count_per_physician End */
    /* active_patients_count_per_physician Start */

    const data24 = {
        labels:  gLabels,
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(132,45,114)',
        borderWidth: 2,
        pointRadius: 4,
        segment: {
            borderDash: [4,4]
        },
        data: [{{$revenueperfteyearOTD->p2y}}, {{$revenueperfteyearOTD->p1y}},{{$revenueperfteyearOTD->cy}}],        }]
    };

    const config24 = {
        type: 'line',
        data: data24,
        options: grideHide2
    };

    const myChart24 = new Chart(
        document.getElementById('myChart24'),
        config24
    );
    /* active_patients_count_per_physician End */

    /* active_patients_count_per_physician Start */

    const data25 = {
        labels:  gLabels,
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(132,45,114)',
        borderWidth: 2,
        pointRadius: 4,
        segment: {
            borderDash: [4,4]
        },
        data: [{{$revenueperfteyearOTE->p2y}}, {{$revenueperfteyearOTE->p1y}},{{$revenueperfteyearOTE->cy}}],        }]
    };

    const config25 = {
        type: 'line',
        data: data25,
        options: grideHide2
    };

    const myChart25 = new Chart(
        document.getElementById('myChart25'),
        config25
    );
    /* active_patients_count_per_physician End */



    /* active_patients_count_per_physician Start */

    const data26 = {
        labels:  [
            '{{$officeEstbdkys3}}',
            '{{$officeEstbdkys2}}',
            '{{$officeEstbdkys1}}',
        ],
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(132,45,114)',
        borderWidth: 2,
        pointRadius: 4,
        segment: {
            borderDash: [4,4]
        },
            data: [{{$officeNewPatientEncounterM3}}, {{$officeNewPatientEncounterM2}}, {{$officeNewPatientEncounterM1}}],
        }]
    };

    const config26 = {
        type: 'line',
        data: data26,
        options: grideHide2
    };

    const myChart26 = new Chart(
        document.getElementById('myChart26'),
        config26
    );
    /* active_patients_count_per_physician End */

    /* active_patients_count_per_physician Start */

    const data27 = {
        labels:  [
            '{{$officeEstbdkys3}}',
            '{{$officeEstbdkys2}}',
            '{{$officeEstbdkys1}}',
        ],
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(132,45,114)',
        borderWidth: 2,
        pointRadius: 4,
        segment: {
            borderDash: [4,4]
        },
        data: [{{$officeEstbdPatientEncounterM3}}, {{$officeEstbdPatientEncounterM2}}, {{$officeEstbdPatientEncounterM1}}],

        }]
    };

    const config27 = {
        type: 'line',
        data: data27,
        options: grideHide2
    };

    const myChart27 = new Chart(
        document.getElementById('myChart27'),
        config27
    );
    /* active_patients_count_per_physician End */


    /* active_patients_count_per_physician Start */

    const data28 = {
        labels:  [
            '{{$officeEstbdkys3}}',
            '{{$officeEstbdkys2}}',
            '{{$officeEstbdkys1}}',
        ],
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(132,45,114)',
        borderWidth: 2,
        pointRadius: 4,
        segment: {
            borderDash: [4,4]
        },
        data: [{{$officeNewPatientAvgCodeLevelM3}}, {{$officeNewPatientAvgCodeLevelM2}}, {{$officeNewPatientAvgCodeLevelM1}}],
        }]
    };

    const config28 = {
        type: 'line',
        data: data28,
        options: grideHide2
    };

    const myChart28 = new Chart(
        document.getElementById('myChart28'),
        config28
    );
    /* active_patients_count_per_physician End */


    /* active_patients_count_per_physician Start */

    const data29 = {
        labels:  [
            '{{$officeEstbdkys3}}',
            '{{$officeEstbdkys2}}',
            '{{$officeEstbdkys1}}',
        ],
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(132,45,114)',
        borderWidth: 2,
        pointRadius: 4,
        segment: {
            borderDash: [4,4]
        },
        data: [{{$officeEstabPatientAvgCodeLevelM3}}, {{$officeEstabPatientAvgCodeLevelM2}}, {{$officeEstabPatientAvgCodeLevelM1}}],
        }]
    };

    const config29 = {
        type: 'line',
        data: data29,
        options: grideHide2
    };

    const myChart29 = new Chart(
        document.getElementById('myChart29'),
        config29
    );
    /* active_patients_count_per_physician End */


    /* active_patients_count_per_physician Start */

    const data30 = {
        labels:  [
            '{{$hospitalNewPkys3}}',
            '{{$hospitalNewPkys2}}',
            '{{$hospitalNewPkys1}}',
        ],
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(132,45,114)',
        borderWidth: 2,
        pointRadius: 4,
        segment: {
            borderDash: [4,4]
        },
        data: [{{$hospitalNewPatientEncounterM3}}, {{$hospitalNewPatientEncounterM2}}, {{$hospitalNewPatientEncounterM1}}],
        }]
    };

    const config30 = {
        type: 'line',
        data: data30,
        options: grideHide2
    };

    const myChart30 = new Chart(
        document.getElementById('myChart30'),
        config30
    );
    /* active_patients_count_per_physician End */


    /* active_patients_count_per_physician Start */

    const data31 = {
        labels:  [
            '{{$hospitalNewPkys3}}',
            '{{$hospitalNewPkys2}}',
            '{{$hospitalNewPkys1}}',
        ],
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(132,45,114)',
        borderWidth: 2,
        pointRadius: 4,
        segment: {
            borderDash: [4,4]
        },
        data: [{{$hospitalEstbdPatientEncounterM3}}, {{$hospitalEstbdPatientEncounterM2}}, {{$hospitalEstbdPatientEncounterM1}}],
        }]
    };

    const config31 = {
        type: 'line',
        data: data31,
        options: grideHide2
    };

    const myChart31 = new Chart(
        document.getElementById('myChart31'),
        config31
    );
    /* active_patients_count_per_physician End */


    /* active_patients_count_per_physician Start */

    const data32 = {
        labels:  [
            '{{$hospitalNewPkys3}}',
            '{{$hospitalNewPkys2}}',
            '{{$hospitalNewPkys1}}',
        ],
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(132,45,114)',
        borderWidth: 2,
        pointRadius: 4,
        segment: {
            borderDash: [4,4]
        },
        data: [{{$hospitalNewPatientAvgCodeLevelM3}}, {{$hospitalNewPatientAvgCodeLevelM2}}, {{$hospitalNewPatientAvgCodeLevelM1}}],
        }]
    };

    const config32 = {
        type: 'line',
        data: data32,
        options: grideHide2
    };

    const myChart32 = new Chart(
        document.getElementById('myChart32'),
        config32
    );
    /* active_patients_count_per_physician End */


    /* active_patients_count_per_physician Start */

    const data33 = {
        labels:  [
            '{{$hospitalNewPkys3}}',
            '{{$hospitalNewPkys2}}',
            '{{$hospitalNewPkys1}}',
        ],
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(132,45,114)',
        borderWidth: 2,
        pointRadius: 4,
        segment: {
            borderDash: [4,4]
        },
        data: [{{$hospitalEstabPatientAvgCodeLevelM3}}, {{$hospitalEstabPatientAvgCodeLevelM2}}, {{$hospitalEstabPatientAvgCodeLevelM1}}],
        }]
    };

    const config33 = {
        type: 'line',
        data: data33,
        options: grideHide2
    };

    const myChart33 = new Chart(
        document.getElementById('myChart33'),
        config33
    );
    /* active_patients_count_per_physician End */


    /* active_patients_count_per_physician Start */

    const data34 = {
        labels:  [
            '{{$inCenterkys3}}',
            '{{$inCenterkys2}}',
            '{{$inCenterkys1}}',
        ],
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(132,45,114)',
        borderWidth: 2,
        pointRadius: 4,
        segment: {
            borderDash: [4,4]
        },
        data: [{{$inCenterDialysisM3}}, {{$inCenterDialysisM2}}, {{$inCenterDialysisM1}}],
        }]
    };

    const config34 = {
        type: 'line',
        data: data34,
        options: grideHide2
    };

    const myChart34 = new Chart(
        document.getElementById('myChart34'),
        config34
    );
    /* active_patients_count_per_physician End */


    /* active_patients_count_per_physician Start */

    const data35 = {
        labels: [
            '1',
            '2',
            '3',
        ],
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(132,45,114)',
        borderWidth: 2,
        pointRadius: 4,
        segment: {
            borderDash: [4,4]
        },
            data: [10, 30, 35],
        }]
    };

    const config35 = {
        type: 'line',
        data: data35,
        options: grideHide2
    };

    const myChart35 = new Chart(
        document.getElementById('myChart35'),
        config35
    );
    /* active_patients_count_per_physician End */


    /* active_patients_count_per_physician Start */

    const data36 = {
        labels: [
            '1',
            '2',
            '3',
        ],
        datasets: [{
            label: '',
            backgroundColor: 'rgb(132,45,114)',
            borderColor: 'rgb(50,103,155)',
            data: [30, 30, 30],
        }]
    };

    const config36 = {
        type: 'line',
        data: data36,
        options: grideHide2
    };

    const myChart36 = new Chart(
        document.getElementById('myChart36'),
        config36
    );
    /* active_patients_count_per_physician End */
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>




<script>
    var tbody = jQuery('.table-graph tbody');
    var height = tbody.height();
    console.log('Height ' + height);
    $('#myChart1').css('height', height + 'px');
    $('#myChart2').css('height', height + 'px');
    $('#myChart3').css('height', height + 'px');
</script>




@endsection

@section('after-scripts')
{{-- {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
{{ Html::script(asset('js/template/js/fusioncharts.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}