@extends('backend.layouts.dashboard')


@section('content-new')



<div class="content-wrapper">
    <div class="home-background esrd-card-box">
        <div class="row">
            <div class="col-md-6 margin-bottom-1">
                <h4> Productivity </h4>
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
                                <th>Productivity</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Trend </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>FTE</td>
                                <td>{{$ProductivityPerYearTableC1}}</td>
                                <td>{{$ProductivityPerYearTableP1}}</td>
                                <td><canvas id="myChart21" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Encounters / FTE</td>
                                <td>{{$ProductivityPerYearTableENC1}}</td>
                                <td>{{$ProductivityPerYearTableENP1}}</td>
                                <td><canvas id="myChart22" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Total RVU / FTE</td>
                                <td>{{$ProductivityPerYearTableTRC1}}</td>
                                <td>{{$ProductivityPerYearTableTRP1}}</td>
                                <td><canvas id="myChart23" class="single-line-chart"></canvas></td>
                            </tr>
                        
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                        Total RVU / FTE
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
                <h4> Total Patients </h4>
            </div>
            <!--<div class="col-md-6 ">
                <form class="form-inline graph-filter">
                    <div class="form-group mb-2">
                        <label for="staticEmail2" class="">Select Date</label>
                        <input type="date" class="form-control" id="staticEmail2" value="">
                    </div>
                    <button type="submit" class="btn btn-primary btn-primary-quick mb-2">Search</button>
                </form>
            </div>-->
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin  stretch-card ">   
                <div class="card-shadow table-scroll width-100">  
                    <table class="table table-graph">
                        <thead class="th-color">
                            <tr>
                                <th>Total Patients</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Trend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Active Patients</td>
                                <td>{{$activePatientsPerYearTableYAPBC1}}</td>
                                <td>{{$activePatientsPerYearTableYAPBP1}}</td>
                                <td><canvas id="myChart24" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Total Patient growth</td>
                                <td>{{$activePatientsPerYearTableYPGC1}}%</td>
                                <td>{{$activePatientsPerYearTableYPGP1}}%</td>
                                <td><canvas id="myChart25" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Total New CKD Patients (Last12 Mo.)</td>
                                <td>{{$activePatientsPerYearTableYNCPC1}}</td>
                                <td>{{$activePatientsPerYearTableYNCPP1}}</td>
                                <td><canvas id="myChart26" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Total New CKD Patient Growth (Last 12 Mo.)</td>
                                <td>{{$activePatientsPerYearTableYCPGC1}}%</td>
                                <td>{{$activePatientsPerYearTableYCPGP1}}%</td>
                                <td><canvas id="myChart27" class="single-line-chart"></canvas></td>
                            </tr>
                           
                        
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                        Total Patients
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
            <div class="col-md-12">  
                <div class="row">
                    <div class="col-md-3 margin-bottom-1">
                        <h4> CKD Re-Admission & TCM </h4>
                    </div>
                    <!-- <div class="col-md-9">
                        <form class="form-inline graph-filter">
                            <div class="form-group mb-2">
                                <label for="staticEmail2" class="">Select Date</label>
                                <input type="date" class="form-control" id="staticEmail2" value="">
                            </div>
                            <button type="submit" class="btn btn-primary btn-primary-quick mb-2">Search</button>
                        </form>
                    </div> -->
                </div> 
            </div>
        </div>   

        <div class="row">
            <div class="col-md-6">
                
            <div class=" grid-margin  stretch-card ">
                    <div class="card-shadow table-scroll width-100">  
                        <table class="table table-graph">
                            <thead class="th-color">
                                <tr>
                                    <th>CKD Re-Admission & TCM</th>
                                    <th>Current Year</th>   
                                    <th>Prior Year</th>
                                    <th>Trend</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>CKD Hospital Readmission %</td>
                                    <td>{{$CkdHospReAdmissionAndTcmPerYearTableHRC1}}%</td>
                                    <td>{{$CkdHospReAdmissionAndTcmPerYearTableHRP1}}%</td>
                                    <td><canvas id="myChart28" class="single-line-chart"></canvas></td>
                                </tr>
                                <tr>
                                    <td>CKD TCM Postdischarge %</td>
                                    <td>{{$CkdHospReAdmissionAndTcmPerYearTableTCMC1}}%</td>
                                    <td>{{$CkdHospReAdmissionAndTcmPerYearTableTCMP1}}%</td>
                                    <td><canvas id="myChart29" class="single-line-chart"></canvas></td>
                                </tr>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
            <p>CKD TCM Post Discharge Percentage: Percentage of CKD patients receiving a Transitional Care management office visit after hospital discharge in 12 months.
                    CKD Hospital readmission Percentage: Percentage of CKD patients that are readmitted to hospital within the thirty days post charge over the last 365 days.</p>

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
            
            @foreach($ProductivityPerMonthGraphM as $ProductivityPerMonthGraphMM)
                '{{$ProductivityPerMonthGraphMM->kys}}',
            @endforeach
    ];

    const data1 = {
        labels: labels1,
        datasets: [{
        label: '',
        backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(50,103,155)',
        data: [
            
            @foreach($ProductivityPerMonthGraphM as $ProductivityPerMonthGraphMM)
                '{{$ProductivityPerMonthGraphMM->vals}}',
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
           @foreach($activePatientsPerMonthGraphM as $activePatientsPerMonthGraphMM)
               '{{$activePatientsPerMonthGraphMM->kys}}',
           @endforeach
    ];

    const data2 = {
        labels: labels2,
        datasets: [{
        label: '',
        backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(50,103,155)',
        data: [
           
            @foreach($activePatientsPerMonthGraphM as $activePatientsPerMonthGraphMM)
                '{{$activePatientsPerMonthGraphMM->activePts}}',
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
        data: [{{$ProductivityPerYearTableP2}},{{$ProductivityPerYearTableP1}},{{$ProductivityPerYearTableC1}}],
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
        data: [{{$ProductivityPerYearTableENP2}}, {{$ProductivityPerYearTableENP1}}, {{$ProductivityPerYearTableENC1}}],
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
        data: [{{$ProductivityPerYearTableTRP2}}, {{$ProductivityPerYearTableTRP1}}, {{$ProductivityPerYearTableTRC1}}],
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
        data: [{{$activePatientsPerYearTableYAPBP2}}, {{$activePatientsPerYearTableYAPBP1}}, {{$activePatientsPerYearTableYAPBC1}}],
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
        data: [{{$activePatientsPerYearTableYPGP2}}, {{$activePatientsPerYearTableYPGP1}}, {{$activePatientsPerYearTableYPGC1}}],
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
        data: [{{$activePatientsPerYearTableYNCPP2}}, {{$activePatientsPerYearTableYNCPP1}}, {{$activePatientsPerYearTableYNCPC1}}],
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
        data: [{{$activePatientsPerYearTableYCPGP2}}, {{$activePatientsPerYearTableYCPGP1}}, {{$activePatientsPerYearTableYCPGC1}}],
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
        data: [{{$CkdHospReAdmissionAndTcmPerYearTableHRP2}}, {{$CkdHospReAdmissionAndTcmPerYearTableHRP1}}, {{$CkdHospReAdmissionAndTcmPerYearTableHRC1}}],
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
        data: [{{$CkdHospReAdmissionAndTcmPerYearTableTCMP2}}, {{$CkdHospReAdmissionAndTcmPerYearTableTCMP1}}, {{$CkdHospReAdmissionAndTcmPerYearTableTCMC1}}],
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
        data: [5, 30, 15],
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
        data: [10, 10, 40],
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
        data: [30, 30, 30],
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


    
     
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script>
   var tbody = jQuery('.table-graph tbody');
    var height = tbody.height();
    console.log('Height '+height);
    $('#myChart1').css('height',height+'px');
    $('#myChart2').css('height',height+'px');
</script>



@endsection

@section('after-scripts')
    {{--    {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
    {{ Html::script(asset('js/template/js/fusioncharts.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}
    