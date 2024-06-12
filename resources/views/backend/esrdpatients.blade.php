@extends('backend.layouts.dashboard')


@section('content-new')



<div class="content-wrapper">
    <div class="home-background esrd-card-box">
        <div class="row">
            <div class="col-md-6 margin-bottom-1">
                <h4> Active ESRD Patients </h4>
            </div>
             <!--   <div class="col-md-6">
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
                                <th>Active ESRD Patients</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Active ESRD Patients</td>
                                <td>{{$aEsrd1->cy}}</td>
                                <td>{{$aEsrd1->p1y}}</td>
                                <td><canvas id="myChart21" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>ESRD Patients Growth Vs Last Year</td>
                                <td>{{$aEsrd2->cy}}%</td>
                                <td>{{$aEsrd2->p1y}}%</td>
                                <td><canvas id="myChart22" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>ESRD Patients/FTE</td>
                                <td>{{$aEsrd3->cy}}</td>
                                <td>{{$aEsrd3->p1y}}</td>
                                <td><canvas id="myChart23" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>ESRD as % of Total Patients</td>
                                <td>{{$aEsrd4->cy}}%</td>
                                <td>{{$aEsrd4->p1y}}%</td>
                                <td><canvas id="myChart24" class="single-line-chart"></canvas></td>
                            </tr>
                        
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card table-scroll card-shadow">
                        <h3 class="home-design1">
                        Active ESRD Patients
                        </h3>
                    <div class="card-body canvasheight" >
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
                <h4> New Dialysis Starts </h4>
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
                                <th>New Dialysis Starts</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>New Dialysis Starts</td>
                                <td>{{$nDailysis1->cy}}</td>
                                <td>{{$nDailysis1->p1y}}</td>
                                <td><canvas id="myChart26" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>New Start Growth vs Last Year</td>
                                <td>{{$nDailysis2->cy}}%</td>
                                <td>{{$nDailysis2->p1y}}%</td>
                                <td><canvas id="myChart27" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>In Center New Start % (3 month Avg.)</td>
                                <td>{{$nDailysis3->cy}}%</td>
                                <td>{{$nDailysis3->p1y}}%</td>
                                <td><canvas id="myChart28" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Hospital New Start %  (3 month Avg.)</td>
                                <td>{{$nDailysis4->cy}}%</td>
                                <td>{{$nDailysis4->p1y}}%</td>
                                <td><canvas id="myChart37" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Home New Start % (3 month Avg.)</td>
                                <td>{{$nDailysis5->cy}}%</td>
                                <td>{{$nDailysis5->p1y}}%</td>
                                <td><canvas id="myChart38" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Early Referrals % (3 month Avg.)</td>
                                <td>{{$nDailysis6->cy}}%</td>
                                <td>{{$nDailysis6->p1y}}%</td>
                                <td><canvas id="myChart39" class="single-line-chart"></canvas></td>
                            </tr>
                        
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                            New Dialysis Starts
                        </h3>
                    <div class="card-body canvasheight" >
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
            <div class="col-md-6">
                <h4> ESRD Patient Retention </h4>
                <br/>
            </div>
            <div class="col-md-6">
            <h4>ESRD Patients (Glossary)</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin  stretch-card ">   
                <div class="card-shadow table-scroll width-100">  
                    <table class="table table-graph">
                        <thead class="th-color">
                            <tr>
                                <th>ESRD Patient Retention</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>120 Days Retention - Early Referrals</td>
                                <td>90.5%</td>
                                <td>80.5%</td>
                                <td><canvas id="myChart30" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>120 Days Retention - Late Referrals</td>
                                <td>.5%</td>
                                <td>40%</td>
                                <td><canvas id="myChart31" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>1 Year Retention - Early Referrals</td>
                                <td>32.5%</td>
                                <td>42.3%</td>
                                <td><canvas id="myChart32" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>1 Year Retention - Late Referrals</td>
                                <td>32.1%</td>
                                <td>.5%</td>
                                <td><canvas id="myChart33" class="single-line-chart"></canvas></td>
                            </tr>
                           
                        
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                
                
                <p class="p-color">Active ESRD Patients: Count of distinct ESRD patients at the end of period. Includes patients that are both billed (MCPs) and unbilled as well as In-center and home modalities.
        <p class="p-color">New Dialysis start: Number of new dialysis start</p>
        <p class="p-color">ESRD Retention:Referred at least six months prior to their first dialysis. Percentage of ESRD patient which are no longer active after certain period</p>
        <p class="p-color">Home dialysis: Percentage Active ESRD Patients billed as Home</p>
            </div>
        </div>
    </div>
    <div class="home-background esrd-card-box">
        <div class="row">
            <div class="col-md-6 margin-bottom-1">
                <h4> Home Dialysis </h4>
            </div>
        <!--    <div class="col-md-6">
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
                                <th>Home Dialysis</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Incident Home % </td>
                                <td>{{$incident_home->cy}}%</td>
                                <td>{{$incident_home->p1y}}%</td>
                                <td><canvas id="myChart34" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Home Training Capture</td>
                                <td>{{$home_training_capture->cy}}%</td>
                                <td>{{$home_training_capture->p1y}}%</td>
                                <td><canvas id="myChart35" class="single-line-chart"></canvas></td>
                            </tr>
                          
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                            Home Penetration
                        </h3>
                    <div class="card-body canvasheight" >
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
   

    
</div>


    

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
        Chart.defaults.font.family = 'Quicksand';    

    const grideHide = {
            responsive: true,
            maintainAspectRatio: false,
            scales:{
                y:{
                    beginAtZero: true,
                    grid:{
                        display: false
                    }
                }
            },
            plugins: { legend: { display: false }, }
    };

    
    const grideHide2 = {
            responsive: true,
            maintainAspectRatio: false,
            scales:{
                y:{
                    display: false
                },
                x:{
                    display: false
                }
            },
            plugins: { 
                    legend: { display: false },
                }
    };

    /* active_patients_count_per_physician Start */
    const labels1 = [
            @foreach($activePatientsActual12Months as $activePatientsMonth)
                '{{$activePatientsMonth->kys}}',
            @endforeach
    ];

    const data1 = {
        labels: labels1,
        datasets: [{
        label: '',
        backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(50,103,155)',
        data: [
            @foreach($activePatientsActual12Months as $activePatientsMonth)
                {{$activePatientsMonth->vals}},
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
            @foreach($newDialysisStartYearGraph12Months as $key => $newDialysisStartYearGraphMonth)
                @if($key > 0)
                '{{$newDialysisStartYearGraphMonth->kys}}',
                @endif
            @endforeach
    ];

    const data2 = {
        labels: labels2,
        datasets: [{
        label: '',
        backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(50,103,155)',
        data: [
            @foreach($newDialysisStartYearGraph12Months as $key => $newDialysisStartYearGraphMonth)
                @if($key > 0)
                '{{$newDialysisStartYearGraphMonth->vals}}',
                @endif
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
            @foreach($incidentHomeMonthGraph as $incidentHomeMonthGraphmm)
                '{{$incidentHomeMonthGraphmm->kys}}',
            @endforeach
    ];

    const data3 = {
        labels: labels3,
        datasets: [{
        label: '',
        backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(50,103,155)',
        data: [
            @foreach($incidentHomeMonthGraph as $incidentHomeMonthGraphmm)
                '{{$incidentHomeMonthGraphmm->incident_home}}',
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
        data: ['{{$aEsrd1->p2y}}','{{$aEsrd1->p1y}}','{{$aEsrd1->cy}}'],
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
        data: [{{$aEsrd2->p2y}}, {{$aEsrd2->p1y}}, {{$aEsrd2->cy}}],
        }]
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
        data: [{{$aEsrd3->p2y}}, {{$aEsrd3->p1y}}, {{$aEsrd3->cy}}],
        }]
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
        data: [{{$aEsrd4->p2y}}, {{$aEsrd4->p1y}}, {{$aEsrd4->cy}}],
        }]
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

    //  /* active_patients_count_per_physician Start */

    //  const data25 = {
    //     labels:  [
    //     '1',
    //     '2',
    //     '3',
    //     ],
    //     datasets: [{
    //     label: '',
    //     backgroundColor: 'rgb(132,45,114)',
    //     borderColor: 'rgb(132,45,114)',
    //     borderWidth: 2,
    //     pointRadius: 4,
    //     segment: {
    //         borderDash: [4,4]
    //     },
    //     data: [2, 30, 35],
    //     }]
    // };

    // const config25 = {
    //     type: 'line',
    //     data: data25,
    //     options: grideHide2
    // };

    // const myChart25 = new Chart(
    //     document.getElementById('myChart25'),
    //     config25
    // );
    // /* active_patients_count_per_physician End */


    
     /* active_patients_count_per_physician Start */

     const data26 = {
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
        data: [{{$nDailysis1->p2y}}, {{$nDailysis1->p1y}}, {{$nDailysis1->cy}}],
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
        data: [{{$nDailysis2->p2y}}, {{$nDailysis2->p1y}}, {{$nDailysis2->cy}}],
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
        data: [{{$nDailysis3->p2y}}, {{$nDailysis3->p1y}}, {{$nDailysis3->cy}}],
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

     const data30 = {
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
        data: [30, 10, 20],
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
        data: [10, 30, 10],
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
        data: [10, 10, 8],
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
        data: [20, 10, 40],
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
        data: [{{$incident_home->p2y}}, {{$incident_home->p1y}}, {{$incident_home->cy}}],
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
        data: [{{$home_training_capture->p2y}}, {{$home_training_capture->p1y}}, {{$home_training_capture->cy}}],
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

    const data37 = {
        labels:  [
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
        data: [{{$nDailysis4->p2y}}, {{$nDailysis4->p1y}}, {{$nDailysis4->cy}}],
        }]
    };

    const config37= {
        type: 'line',
        data: data37,
        options: grideHide2
    };

    const myChart37 = new Chart(
        document.getElementById('myChart37'),
        config37
    );
    /* active_patients_count_per_physician End */

        /* active_patients_count_per_physician Start */

        const data38 = {
        labels:  [
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
        data: [{{$nDailysis5->p2y}}, {{$nDailysis5->p1y}}, {{$nDailysis5->cy}}],
        }]
    };

    const config38 = {
        type: 'line',
        data: data38,
        options: grideHide2
    };

    const myChart38 = new Chart(
        document.getElementById('myChart38'),
        config38
    );
    /* active_patients_count_per_physician End */

    
     /* active_patients_count_per_physician Start */

     const data39 = {
        labels:  [
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
        data: [{{$nDailysis6->p2y}}, {{$nDailysis6->p1y}}, {{$nDailysis6->cy}}],
        }]
    };

    const config39 = {
        type: 'line',
        data: data39,
        options: grideHide2
    };

    const myChart39 = new Chart(
        document.getElementById('myChart39'),
        config39
    );
    /* active_patients_count_per_physician End */


    
     /* active_patients_count_per_physician Start */

     const data36 = {
        labels:  [
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
        data: [40, 25, 40],
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
// jQuery(window).on('load',function(){
//    var tbody = jQuery('.table-graph tbody');
//     var height = tbody.height();
//     console.log('Height '+height);
//     $('#myChart1').css('height',height+'px');
//     $('#myChart2').css('height',height+'px');
// }  );
</script>


@endsection

@section('after-scripts')
    {{--    {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
    {{ Html::script(asset('js/template/js/fusioncharts.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}
    