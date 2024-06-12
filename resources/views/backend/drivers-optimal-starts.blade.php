@extends('backend.layouts.dashboard')


@section('content-new')



<div class="content-wrapper">
    <div class="home-background esrd-card-box">
        <div class="row">
            <div class="col-md-6">
                <h4> Late-Stage CKD Visit Interval </h4>
                    </br>
            </div>
            <div class="col-md-6">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin  stretch-card ">   
                <div class="card-shadow table-scroll width-100">  
                    <table class="table table-graph card-shadow">
                        <thead class="th-color">
                            <tr>
                                <th>Late-Stage CKD Visit Interval</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Percentage change (Current year vs Last Year)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Late-Stage CKD Visit Interval</td>
                                <td>{{$latestageckdvisitintervalD1}}</td>
                                <td>{{$latestageckdvisitintervalD2}}</td>
                                <td>{{$latestageckdvisitintervalD3}}%</td>
                            </tr>
                         </tbody>

                    </table>
                    <div class="padding-p">
                        <p class="p-color">The visit interval of Late-stage CKD patient varies between 30 to 90 days. Stage 5 CKD patients who visit every 30 days. The stage 4 CKD patients who visit every 90 days.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                        Late-Stage CKD Visit Interval
                        </h3>
                    <div class="card-body" >
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
            <div class="col-md-6">
                <h4> Late-Stage CKD Wait Time </h4>
                    </br>
            </div>
            <div class="col-md-6">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin  stretch-card ">   
                <div class="card-shadow table-scroll width-100">  
                    <table class="table table-graph card-shadow">
                        <thead class="th-color">
                            <tr>
                                <th>Late-Stage CKD Wait Time</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Percentage Change (Current year vs Last Year)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Late-Stage CKD Wait Time</td>
                                <td>{{$latestageckdwaittimeT1}}</td>
                                <td>{{$latestageckdwaittimeT2}}</td>
                                <td>{{$latestageckdwaittimeT3}}%</td>
                            </tr>
                            <tr>
                                
                         </tbody>

                    </table>
                    <div class="padding-p">
                        <p class="p-color">The time taken by patients or need to do the dialysis. It is mostly in the weeks. It is a estimated time.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow ">
                        <h3 class="home-design1">
                        Late-Stage CKD Wait Time
                        </h3>
                    <div class="card-body" >
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
                <h4> Timely Referrals </h4>
                    </br>
            </div>
            <div class="col-md-6">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin  stretch-card ">   
                <div class="card-shadow table-scroll width-100">  
                    <table class="table table-graph card-shadow">
                        <thead class="th-color">
                            <tr>
                                <th>Timely Referrals</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Percentage Change (Current year vs Last Year)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Timely Referrals</td>
                                <td>{{$timelyreferralD1}}%</td>
                                <td>{{$timelyreferralD2}}%</td>
                                <td>{{$timelyreferralD3}}%</td>
                            </tr>
                         </tbody>

                    </table>
                    <div class="padding-p">
                        <p class="p-color">The patients which are timely referred from other providers. It is percentage of patients with at least one encounter more than six month prior to the dialysis.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                        Timely Referrals
                        </h3>
                    <div class="card-body" >
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
                <h4> Hospital To Office Follow Up </h4>
                    </br>
            </div>
            <div class="col-md-6">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin  stretch-card ">   
                <div class="card-shadow table-scroll width-100">  
                    <table class="table table-graph card-shadow">
                        <thead class="th-color">
                            <tr>
                                <th>Hospital To Office Follow Up</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Percentage Change (Current year vs Last Year)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Hospital To Office Follow Up</td>
                                <td>{{$hospitaltoofficefollowupD1}}%</td>
                                <td>{{$hospitaltoofficefollowupD2}}%</td>
                                <td>{{$hospitaltoofficefollowupD3}}%</td>
                            </tr>
                         </tbody>

                    </table>
                    <div class="padding-p">
                        <p class="p-color">The percentage of stage 4 and stage 5 CKD patients that are follow up (visit the office) in the office within next a month after the hospital discharge.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                        Hospital To Office Follow Up
                        </h3>
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="myChart4"></canvas>
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
                <h4> New Start With Hospital With 30-days Prior </h4>
                    </br>
            </div>
            <div class="col-md-6">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin  stretch-card ">   
                <div class="card-shadow table-scroll width-100">  
                    <table class="table table-graph card-shadow">
                        <thead class="th-color">
                            <tr>
                                <th>New Start With Hosp. With 30-days Prior</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Percentage change (Current year vs Last Year)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>New Start With Hospital With 30-days Prior</td>
                                <td>{{$newstarthosp30priorD1}}%</td>
                                <td>{{$newstarthosp30priorD2}}%</td>
                                <td>{{$newstarthosp30priorD3}}%</td>
                            </tr>
                         </tbody>

                    </table>
                    <div class="padding-p">
                        <p class="p-color">The percentage of new start patients of ESRD that were seen in the CKD practice clinic, but they also had an hospital visit/event one month prior to dialysis.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                        New Start With Hospital With 30-days Prior
                        </h3>
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="myChart5"></canvas>
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
            @foreach($latestageckdvisitintervalmonthM as $key => $latestageckdvisitintervalmonthMM)
                '{{$latestageckdvisitintervalmonthMM->month_year}}',
            @endforeach
    ];

    const data1 = {
        labels: labels1,
        datasets: [{
        label: '',
        backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(50,103,155)',
        data: [
            
            @foreach($latestageckdvisitintervalmonthM as $latestageckdvisitintervalmonthMM)
                '{{$latestageckdvisitintervalmonthMM->visit_interval}}',
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
           
           @foreach($latestageckdwaittimemonthM as $latestageckdwaittimemonthMM)
               '{{$latestageckdwaittimemonthMM->kys}}',
           @endforeach
    ];

    const data2 = {
        labels: labels2,
        datasets: [{
        label: '',
        backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(50,103,155)',
        data: [
           
            @foreach($latestageckdwaittimemonthM as $latestageckdwaittimemonthMM)
                '{{$latestageckdwaittimemonthMM->vals}}',
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
            @foreach($timelyreferralmonthM as $timelyreferralmonthMM)
                '{{$timelyreferralmonthMM->kys }}',
            @endforeach
    ];

    const data3 = {
        labels: labels3,
        datasets: [{
        label: '%',
        backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(50,103,155)',
        data: [
             
            @foreach($timelyreferralmonthM as $timelyreferralmonthMM)
                '{{$timelyreferralmonthMM->vals }}',
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
     
    /* active_patients_count_per_physician Start */
      const labels4 = [
            
            @foreach($hospitaltoofficefollowupmonthM as $hospitaltoofficefollowupmonthMM)
                '{{$hospitaltoofficefollowupmonthMM->kys}}',
            @endforeach
    ];

    const data4 = {
        labels: labels4,
        datasets: [{
        label: '%',
        backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(50,103,155)',
        data: [
            
            @foreach($hospitaltoofficefollowupmonthM as $hospitaltoofficefollowupmonthMM)
                '{{$hospitaltoofficefollowupmonthMM->vls}}',
            @endforeach
            
            ],
        }]
    };

    const config4 = {
        type: 'line',
        data: data4,
        options: grideHide
    };

    const myChart4 = new Chart(
        document.getElementById('myChart4'),
        config4
    );
    /* active_patients_count_per_physician Start */
    const labels5 = [
            @foreach($newstarthosp30priormonthM as $newstarthosp30priormonthMM)
                '{{$newstarthosp30priormonthMM->kys}}',
            @endforeach
    ];

    const data5 = {
        labels: labels5,
        datasets: [{
        label: '%',
        backgroundColor: 'rgb(132,45,114)',
        borderColor: 'rgb(50,103,155)',
        data: [
           
            @foreach($newstarthosp30priormonthM as $newstarthosp30priormonthMM)
                '{{$newstarthosp30priormonthMM->vls}}',
            @endforeach
            
            ],
        }]
    };

    const config5 = {
        type: 'line',
        data: data5,
        options: grideHide
    };

    const myChart5 = new Chart(
        document.getElementById('myChart5'),
        config5
    );
    /* active_patients_count_per_physician Start */

    
     
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>



@endsection

@section('after-scripts')
    {{--    {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
    {{ Html::script(asset('js/template/js/fusioncharts.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}
    