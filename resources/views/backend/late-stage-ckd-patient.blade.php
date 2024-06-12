@extends('backend.layouts.dashboard')


@section('content-new')



<div class="content-wrapper">
    <div class="home-background esrd-card-box">
        <div class="row">
            <div class="col-md-6 margin-bottom-1">
                <h4> Population </h4>   
            </div>
          <!-- <div class="col-md-6">
                <form class="form-inline graph-filter">
                    <div class="form-group mb-2">
                        <label for="staticEmail2" class="">Select Date</label>
                        <input type="date" class="form-control" id="staticEmail2" value="">
                    </div>
                    <button type="submit" class="btn btn-primary btn-primary-quick mb-2">Search</button>
                </form>
            </div> //-->
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
                                <td>Active late Stage Patients</td>
                                <td>{{$activeLateStagePB->cy}}</td>
                                <td>{{$activeLateStagePB->p1y}}</td>
                                <td><canvas id="myChart21" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>   
                                <td>Late Stage Patient Growth vs Last Year</td>
                                <td>{{$lateStageGLY->cy}}%</td>
                                <td>{{$lateStageGLY->p1y}}%</td>
                                <td><canvas id="myChart22" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Last Stage Ratio (CKD 4 & 5 vs ESRD)</td>
                                <td>{{$lateStageRatioCE->cy}}</td>
                                <td>{{$lateStageRatioCE->p1y}}</td>
                                <td><canvas id="myChart23" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Last Stage Ratio (CKD 4 & 5) as % of Total Patients</td>
                                <td>{{$lateStageRatioTP->cy}}%</td>
                                <td>{{$lateStageRatioTP->p1y}}%</td>
                                <td><canvas id="myChart24" class="single-line-chart"></canvas></td>
                            </tr>
                        
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                        Active Late Stage Patients
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
                                <th>New Patients</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Newly Referred Late Stage Patients</td>
                                <td>{{$newLateStageCKDPatientNW->cy}}</td>
                                <td>{{$newLateStageCKDPatientNW->p1y}}</td>
                                <td><canvas id="myChart25" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Newly Referred Late stage Patient Growth</td>
                                <td>{{$LateStageCKDPatientGLY->cy}}%</td>
                                <td>{{$LateStageCKDPatientGLY->p1y}}%</td>
                                <td><canvas id="myChart26" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Late Stage as % of Total New Patients</td>
                                <td>{{$LateStageCKDPatientCE->cy}}%</td>
                                <td>{{$LateStageCKDPatientCE->p1y}}%</td>
                                <td><canvas id="myChart27" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>% Newly Referred Late Stage Conversion to ESRD</td>
                                <td>{{$LateStageCKDPatientTP->cy}}%</td>
                                <td>{{$LateStageCKDPatientTP->p1y}}%</td>
                                <td><canvas id="myChart28" class="single-line-chart"></canvas></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                        Newly Referred Late Stage CKD Patients
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
            <div class="col-md-6 margin-bottom-1">
                <h4> Late Stage Visit Performance </h4>
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
                                <th>Late Stage Visit Performance</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Hosp.To Office Follow Up < 30 days (3 Mo.Avg.)</td>
                                <td>{{$latestagehospitalizationOFY->cy}}%</td>
                                <td>{{$latestagehospitalizationOFY->p1y}}%</td>
                                <td><canvas id="myChart29" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Avg.Time to Follow up in Weeks (3 Mo. Avg.)</td>
                                <td>{{$latestagehospitalizationATF->cy}}</td>
                                <td>{{$latestagehospitalizationATF->p1y}}</td>
                                <td><canvas id="myChart30" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Late Stage CKD Visit Interval</td>
                                <td>{{$latestagehospitalizationCKD->cy}}</td>
                                <td>{{$latestagehospitalizationCKD->p1y}}</td>
                                <td><canvas id="myChart31" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Late Stage Patient Lost to follow up %</td>
                                <td>{{$latestagehospitalizationLFU->cy}}%</td>
                                <td>{{$latestagehospitalizationLFU->p1y}}%</td>
                                <td><canvas id="myChart33" class="single-line-chart"></canvas></td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                            Hospital to Office Follow-up Late CKD
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
            @foreach($activeLateStageMonths as $key => $activeLateStageMonth)
            @if($key>0)
                '{{$activeLateStageMonth->kys}}',
            @endif
            @endforeach
    ];

    const data1 = {
        labels: labels1,
        datasets: [{
        label: '',
        backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(50,103,155)',
        data: [
            @foreach($activeLateStageMonths as $key => $activeLateStageMonth)
            @if($key>0)
                '{{$activeLateStageMonth->vals}}',
            @endif
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
            @foreach($newactiveLateStageMonths as $newactiveLateStageMonth)
                '{{$newactiveLateStageMonth->kys}}',
            @endforeach
    ];

    const data2 = {
        labels: labels2,
        datasets: [{
        label: '',
        backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(50,103,155)',
        data: [
            @foreach($newactiveLateStageMonths as $newactiveLateStageMonth)
                '{{$newactiveLateStageMonth->vals}}',
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
            @foreach($lateStageHospOfcFYMonths as $lateStageHospOfcFYMonth)
                '{{$lateStageHospOfcFYMonth->kys}}',
            @endforeach
    ];

    const data3 = {
        labels: labels3,
        datasets: [{
        label: '',
        backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(50,103,155)',
        data: [
            @foreach($lateStageHospOfcFYMonths as $lateStageHospOfcFYMonth)
                '{{$lateStageHospOfcFYMonth->vals}}',
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
        data: [{{$activeLateStagePB->p2y}}, {{$activeLateStagePB->p1y}},{{$activeLateStagePB->cy}}],
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
        data: [{{$lateStageGLY->p2y}}, {{$lateStageGLY->p1y}},{{$lateStageGLY->cy}}],
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
        data: [{{$lateStageRatioCE->p2y}}, {{$lateStageRatioCE->p1y}},{{$lateStageRatioCE->cy}}],
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
        data: [{{$lateStageRatioTP->p2y}}, {{$lateStageRatioTP->p1y}},{{$lateStageRatioTP->cy}}],
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
        data: [{{$newLateStageCKDPatientNW->p2y}}, {{$newLateStageCKDPatientNW->p1y}},{{$newLateStageCKDPatientNW->cy}}],
        }]
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
        data: [{{$LateStageCKDPatientGLY->p2y}}, {{$LateStageCKDPatientGLY->p1y}},{{$LateStageCKDPatientGLY->cy}}],
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
        data: [{{$LateStageCKDPatientCE->p2y}}, {{$LateStageCKDPatientCE->p1y}},{{$LateStageCKDPatientCE->cy}}],
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
        data: [{{$LateStageCKDPatientTP->p2y}}, {{$LateStageCKDPatientTP->p1y}},{{$LateStageCKDPatientTP->cy}}],
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
        data: [{{$latestagehospitalizationOFY->p2y}}, {{$latestagehospitalizationOFY->p1y}},{{$latestagehospitalizationOFY->cy}}],
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
        data: [{{$latestagehospitalizationATF->p2y}}, {{$latestagehospitalizationATF->p1y}},{{$latestagehospitalizationATF->cy}}],
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
        data: [{{$latestagehospitalizationCKD->p2y}}, {{$latestagehospitalizationCKD->p1y}},{{$latestagehospitalizationCKD->cy}}],
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
        data: [40, 30, 40],
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
        data: [{{$latestagehospitalizationLFU->p2y}}, {{$latestagehospitalizationLFU->p1y}},{{$latestagehospitalizationLFU->cy}}],        }]
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
        data: [40, 40, 10],
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
        labels:  [
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(50,103,155)',
        data: [5, 30, 40],
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

     

    
     
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
   var tbody = jQuery('.table-graph tbody');
    var height = tbody.height();
    console.log('Height '+height);
    $('#myChart1').css('height',height+'px');
    $('#myChart2').css('height',height+'px');
    $('#myChart3').css('height',height+'px');
</script>

@endsection

@section('after-scripts')
    {{--    {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
    {{ Html::script(asset('js/template/js/fusioncharts.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}
    