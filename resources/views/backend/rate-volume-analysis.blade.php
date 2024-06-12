@extends('backend.layouts.dashboard')


@section('content-new')



<div class="content-wrapper">
    <div class="home-background esrd-card-box">
        <div class="row">
            <div class="col-md-6">
                <h4> Active ESRD Patients </h4>
            </div>
            <div class="col-md-6">
                <form class="form-inline graph-filter">
                    <div class="form-group mb-2">
                        <label for="staticEmail2" class="">Select Date</label>
                        <input type="date" class="form-control" id="staticEmail2" value="">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Search</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin  stretch-card ">   
                <div class="card-shadow width-100">  
                    <table class="table table-graph">
                        <thead class="th-color">
                            <tr>
                                <th>Active ESRD Patients</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Trends</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Active ESRD Patient Balance</td>
                                <td>2022</td>
                                <td>2021</td>
                                <td><canvas id="myChart21" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>ESRD Patient Growth Vs Last Year</td>
                                <td>2022</td>
                                <td>2021</td>
                                <td><canvas id="myChart22" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>ESRD Patients/FTE</td>
                                <td>2022</td>
                                <td>2021</td>
                                <td><canvas id="myChart23" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>ESRD as % of Total patients</td>
                                <td>2022</td>
                                <td>2021</td>
                                <td><canvas id="myChart24" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Population</td>
                                <td>2022</td>
                                <td>2021</td>
                                <td><canvas id="myChart25" class="single-line-chart"></canvas></td>
                            </tr>
                        
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                        Active ESRD Patients Balance
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
                <h4> New Dialysis Starts </h4>
            </div>
            <div class="col-md-6">
                <form class="form-inline graph-filter">
                    <div class="form-group mb-2">
                        <label for="staticEmail2" class="">Select Date</label>
                        <input type="date" class="form-control" id="staticEmail2" value="">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Search</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin  stretch-card ">   
                <div class="card-shadow width-100">  
                    <table class="table table-graph">
                        <thead class="th-color">
                            <tr>
                                <th>ASPB</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Trends</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ASPB</td>
                                <td>1</td>
                                <td>2</td>
                                <td><canvas id="myChart26" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Epgl</td>
                                <td>1</td>
                                <td>2</td>
                                <td><canvas id="myChart27" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>EP/F</td>
                                <td>1</td>
                                <td>2</td>
                                <td><canvas id="myChart28" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>E%TP</td>
                                <td>1</td>
                                <td>2</td>
                                <td><canvas id="myChart29" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Population</td>
                                <td>1</td>
                                <td>2</td>
                                <td><canvas id="myChart30" class="single-line-chart"></canvas></td>
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
                <h4> ESRD Patient Retention </h4>
                <br/>
            </div>
            <div class="col-md-6">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin  stretch-card ">   
                <div class="card-shadow width-100">  
                    <table class="table table-graph">
                        <thead class="th-color">
                            <tr>
                                <th>ASPB</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Trends</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ASPB</td>
                                <td>1</td>
                                <td>2</td>
                                <td><canvas id="myChart31" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Epgl</td>
                                <td>1</td>
                                <td>2</td>
                                <td><canvas id="myChart32" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>EP/F</td>
                                <td>1</td>
                                <td>2</td>
                                <td><canvas id="myChart33" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>E%TP</td>
                                <td>1</td>
                                <td>2</td>
                                <td><canvas id="myChart34" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Population</td>
                                <td>1</td>
                                <td>2</td>
                                <td><canvas id="myChart35" class="single-line-chart"></canvas></td>
                            </tr>
                        
                            
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                
                <h3>ESRD Patient Retention</h3>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages,</p>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
            </div>
        </div>   
    </div>
    <div class="home-background esrd-card-box">
        <div class="row">
            <div class="col-md-6">
                <h4> Active Home penetration </h4>
            </div>
            <div class="col-md-6">
                <form class="form-inline graph-filter">
                    <div class="form-group mb-2">
                        <label for="staticEmail2" class="">Select Date</label>
                        <input type="date" class="form-control" id="staticEmail2" value="">
                    </div>
                    <button type="submit" class="btn btn-primary mb-2">Search</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin  stretch-card ">   
                <div class="card-shadow width-100">  
                    <table class="table table-graph">
                        <thead class="th-color">
                            <tr>
                                <th>ASPB</th>
                                <th>Current Year</th>   
                                <th>Prior Year</th>
                                <th>Trends</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>ASPB</td>
                                <td>1</td>
                                <td>2</td>
                                <td><canvas id="myChart36" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Epgl</td>
                                <td>1</td>
                                <td>2</td>
                                <td><canvas id="myChart37" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>EP/F</td>
                                <td>1</td>
                                <td>2</td>
                                <td><canvas id="myChart38" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>E%TP</td>
                                <td>1</td>
                                <td>2</td>
                                <td><canvas id="myChart39" class="single-line-chart"></canvas></td>
                            </tr>
                            <tr>
                                <td>Population</td>
                                <td>1</td>
                                <td>2</td>
                                <td><canvas id="myChart40" class="single-line-chart"></canvas></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                            Home penetration
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
   

    
</div>


    

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

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
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [
            @if(count($activePatientPerPhysicians)>0)
                @foreach($activePatientPerPhysicians as $activePatientPerPhysician)
                    {{$activePatientPerPhysician->active_patients}},
                @endforeach
            @else
                0, 10, 5, 2, 20, 30, 45, 5, 2, 20, 30, 45
            @endif
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
    const myChart2 = new Chart(
        document.getElementById('myChart2'),
        config1
    );
    const myChart4 = new Chart(
        document.getElementById('myChart4'),
        config1
    );
    /* active_patients_count_per_physician End */


    /* active_patients_count_per_physician Start */

    const data21 = {
        labels:  [
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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
        labels:  [
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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
        labels:  [
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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
        labels:  [
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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
        labels:  [
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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
        labels:  [
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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
        labels:  [
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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

    
     /* active_patients_count_per_physician Start */

     const data37 = {
        labels:  [
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
        }]
    };

    const config37 = {
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
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
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

     const data40 = {
        labels:  [
        '1',
        '2',
        '3',
        ],
        datasets: [{
        label: '',
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: [2, 30, 8],
        }]
    };

    const config40 = {
        type: 'line',
        data: data26,
        options: grideHide2
    };

    const myChart40 = new Chart(
        document.getElementById('myChart40'),
        config40
    );
    /* active_patients_count_per_physician End */

    
     
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>



@endsection

@section('after-scripts')
    {{--    {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
    {{ Html::script(asset('js/template/js/fusioncharts.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}
    