@extends('backend.layouts.dashboard')


@section('content-new')



<div class="content-wrapper">

    <div class="home-background">
        <h4 class="h3-color-home"> Optimal Start % </h4>

        <div class="row">   
            <div class="col-md-12 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="myChart66"></canvas>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
        </div>
    </div>
    <div class="home-background">
        <h4 class="h3-color-home"> Optimal Start </h4>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="myChart67"></canvas>
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
                <h4> Optimal Start Components </h4>
                <br/>
            </div>
            <div class="col-md-6">
           
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin  stretch-card ">   
                <div class="card-shadow table-scroll width-100">  
                    <table class="table table-graph">
                        <thead class="th-color">
                            <tr>
                                <th>Optimal Start Components</th>
                                <th>Current Month</th>   
                                <th>Prior Month</th>
                                <th>Prior year </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Optimal Start %</td>
                                <td>{{$optimalStarts12MonthPriorPercentCM}}%</td>
                                <td>{{$optimalStarts12MonthPriorPercentPM}}%</td>
                                <td>{{$optimalStarts12MonthPriorPercentPY}}%</td>
                            </tr>
                            <tr>
                                <td>Optimal Start</td>
                                <td>{{$optimalStarts12MonthPriorCM}}</td>
                                <td>{{$optimalStarts12MonthPriorPM}}</td>
                                <td>{{$optimalStarts12MonthPriorPY}}</td>
                            </tr>
                            <tr>
                                <td>InCenter No Catheter</td>
                                <td>{{$inCenterNoCatheter12MonthPriorCM}}</td>
                                <td>{{$inCenterNoCatheter12MonthPriorPM}}</td>
                                <td>{{$inCenterNoCatheter12MonthPriorPY}}</td>   
                            </tr>
                            <tr>
                                <td>Incident Home</td>
                                <td>{{$incidentHome12MonthPriorCM}}</td>
                                <td>{{$incidentHome12MonthPriorPM}}</td>
                                <td>{{$incidentHome12MonthPriorPY}}</td>   
                            </tr>
                            <tr>
                                <td>Total New Starts</td>
                                <td>{{$totalNewStarts12MonthPriorCM}}</td>
                                <td>{{$totalNewStarts12MonthPriorPM}}</td>
                                <td>{{$totalNewStarts12MonthPriorPY}}</td>   
                            </tr>
                        
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                
              
                <p class="p-color">Optimal Starts is defined as patients who meet the following criteria when they develop End stage renal disease and require renal replace therapy:
                    1. Peritoneal dialysis (PD)
                    2. Home hemodialysis with permanent vascular access
                    3. In-center hemodialysis with permanent vascular access
                    4. Preemptive kidney transplantation.
                    For patients initiating dialysis, their first day of outpatient dialysis will be either on peritoneal dialysis or hemodialysis with permanent access. Patients who initiate outpatient hemodialysis with central venous Catheter are considered optimal starts.
                    The formula of the Optimal starts %= (Total Optimal Starts)/(Total New ESRD Starts).</p>
            </div>
        </div>   
    </div>
    <div class="home-background esrd-card-box">
        <h4 > Optimal Start Components Trend </h4>
            </br>
        <div class="row">
       
            <!-- <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                        Optimal Start %
                        </h3>
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="myChart68"></canvas>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                            Optimal Start
                        </h3>
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="myChart69"></canvas>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>  -->
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                        InCenter No Cather
                        </h3>
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="myChart70"></canvas>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                        Incident Home
                        </h3>
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="myChart71"></canvas>
                            </div>
                        </div>
                    </div>
                </div>   
            </div> 
            <div class="col-md-12 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                        Total New Starts
                        </h3>
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="myChart72"></canvas>
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
                    beginAtZero: true,
                    grid:{
                        display: false
                    }
                },
                x:{
                    beginAtZero: true,
                    grid:{
                        display: false
                    }
                }
            },
            plugins: { 
                    legend: { display: false },
                }
    };

    /* active_patients_count_actual_month Start */
    const labels66 = [
            
            @foreach($optimalStartsPercentY as $optimalStartsPercentYY)
                '{{$optimalStartsPercentYY->kys}}',
            @endforeach
    ];

    const data66 = {
        labels: labels66,
        datasets: [{
        label: '',
        fill: true  ,
        backgroundColor: 'rgb(97 174 209 / 100%)',
        borderColor: 'rgb(97 174 209)',
        data: [
            
            @foreach($optimalStartsPercentY as $optimalStartsPercentYY)
                '{{$optimalStartsPercentYY->vals}}',
            @endforeach
            
            ],
        }]
    };

    const config66 = {
        type: 'line',
        data: data66,
        options: grideHide
    };

    const myChart66 = new Chart(
        document.getElementById('myChart66'),
        config66
    );
    /* active_patients_count_actual_month End */

     /* active_patients_count_actual_month Start */
     const labels67 = [
            @foreach($optimalStartsY as $optimalStartsYY)
                '{{$optimalStartsYY->kys}}',
            @endforeach
    ];

    const data67 = {
        labels: labels67,
        datasets: [{
        label: '',
        fill: true  ,
        backgroundColor: 'rgb(97 174 209 / 100%)',
        borderColor: 'rgb(97 174 209)',
        data: [
           
            @foreach($optimalStartsY as $optimalStartsYY)
                '{{$optimalStartsYY->vals}}',
            @endforeach
            
            ],
        }]
    };

    const config67 = {
        type: 'line',
        data: data67,
        options: grideHide
    };

    const myChart67 = new Chart(
        document.getElementById('myChart67'),
        config67
    );
    /* active_patients_count_actual_month End */
    //   /* active_patients_count_actual_month Start */
    //   const labels68 = [
    //         @foreach($optimalStartsY as $optimalStartsYY)
    //             '{{$optimalStartsYY->kys}}',
    //         @endforeach
    // ];

    // const data68 = {
    //     labels: labels68,
    //     datasets: [{
    //     label: '',
    //     fill: true  ,
    //     backgroundColor: 'rgb(97 174 209 / 100%)',
    //     borderColor: 'rgb(97 174 209)',
    //     data: [
           
    //         @foreach($optimalStartsY as $optimalStartsYY)
    //             '{{$optimalStartsYY->vals}}',
    //         @endforeach
            
    //         ],
    //     }]
    // };

    // const config68 = {
    //     type: 'line',
    //     data: data66,
    //     options: grideHide2
    // };

    // const myChart68 = new Chart(
    //     document.getElementById('myChart68'),
    //     config68
    // );
    // /* active_patients_count_actual_month End */
    //   /* active_patients_count_actual_month Start */
    //   const labels69 = [
    //         @foreach($optimalStartsY as $optimalStartsYY)
    //             '{{$optimalStartsYY->kys}}',
    //         @endforeach
    // ];

    // const data69 = {
    //     labels: labels69,
    //     datasets: [{
    //     label: '',
    //     fill: true  ,
    //     backgroundColor: 'rgb(97 174 209 / 100%)',
    //     borderColor: 'rgb(97 174 209)',
    //     data: [
            
    //         @foreach($optimalStartsY as $optimalStartsYY)
    //             '{{$optimalStartsYY->vals}}',
    //         @endforeach
            
    //         ],
    //     }]
    // };

    // const config69 = {
    //     type: 'line',
    //     data: data69,
    //     options: grideHide2
    // };

    // const myChart69 = new Chart(
    //     document.getElementById('myChart69'),
    //     config69
    // );
    /* active_patients_count_actual_month End */
      /* active_patients_count_actual_month Start */
      const labels70 = [
            
            @foreach($inCenterNoCatheterY as $inCenterNoCatheterYY)
                '{{$inCenterNoCatheterYY->kys}}',
            @endforeach
    ];

    const data70 = {
        labels: labels70,
        datasets: [{
        label: '',
        fill: true  ,
        backgroundColor: 'rgb(97 174 209 / 100%)',
        borderColor: 'rgb(97 174 209)',
        data: [
            
            @foreach($inCenterNoCatheterY as $inCenterNoCatheterYY)
                '{{$inCenterNoCatheterYY->vls}}',
            @endforeach
           
            ],
        }]
    };

    const config70 = {
        type: 'line',
        data: data70,
        options: grideHide2
    };

    const myChart70 = new Chart(
        document.getElementById('myChart70'),
        config70
    );
    /* active_patients_count_actual_month End */
      /* active_patients_count_actual_month Start */
      const labels71 = [
            @foreach($incidentHomeY as $incidentHomeYY)
                '{{$incidentHomeYY->kys}}',
            @endforeach
    ];

    const data71 = {
        labels: labels71,
        datasets: [{
        label: '',
        fill: true  ,
        backgroundColor: 'rgb(97 174 209 / 100%)',
        borderColor: 'rgb(97 174 209)',
        data: [
            @foreach($incidentHomeY as $incidentHomeYY)
                '{{$incidentHomeYY->vals}}',
            @endforeach
            ],
        }]
    };

    const config71 = {
        type: 'line',
        data: data71,
        options: grideHide2
    };

    const myChart71 = new Chart(
        document.getElementById('myChart71'),
        config71
    );
    /* active_patients_count_actual_month End */
      /* active_patients_count_actual_month Start */
      const labels72 = [
            @foreach($totalNewStartsY as $totalNewStartsYY)
                '{{$totalNewStartsYY->kys}}',
            @endforeach   
    ];

    const data72 = {
        labels: labels72,
        datasets: [{
        label: '',
        fill: true  ,
        backgroundColor: 'rgb(97 174 209 / 100%)',
        borderColor: 'rgb(97 174 209)',
        data: [
            @foreach($totalNewStartsY as $totalNewStartsYY)
                '{{$totalNewStartsYY->vals}}',
            @endforeach    
            ],
        }]
    };

    const config72 = {
        type: 'line',
        data: data72,
        options: grideHide2
    };

    const myChart72 = new Chart(
        document.getElementById('myChart72'),
        config72
    );
    /* active_patients_count_actual_month End */

    /* active_patients_count_per_physician Start */
    const labels1 = [
        'Jan',
        'Feb',
        'March',
        'Apr',
        'May',
        'Jun',
        'July',
        'Aug',
        'Sep',
        'Oct',
        'Nov',
        'Dec',
    ];

    const data1 = {
        labels: labels1,
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [
          
                10, 10, 5, 60, 20, 30, 45, 30, 2, 60, 30, 45
            
            ],
        }]
    };

    const config1 = {
        type: 'line',
        data: data1,
        options: grideHide2
    };


    
     
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>



@endsection

@section('after-scripts')
    {{--    {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
    {{ Html::script(asset('js/template/js/fusioncharts.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}
    