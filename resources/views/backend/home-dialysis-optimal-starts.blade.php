@extends('backend.layouts.dashboard')


@section('content-new')

    <div class="content-wrapper">
        <div class="home-background esrd-card-box">
                <div class="row">
                    
                    <div class="col-md-6 grid-margin esrd-card-box-hd stretch-card ">   
                        <div class="card card-shadow">     
                            <div class="card-body" >
                            
                                 <h4> Home Patients</h4>
                                    <div class="">
                                        <div id="patientData"></div>
                                    </div> 
                            </div>
                        </div>   
                    </div>                 
                    <div class="col-md-6 grid-margin esrd-card-box-hd stretch-card ">
                        <div class="card card-shadow">
                                
                            <div class="card-body" >                     
                                <h4> New Home Patients </h4>
                                    <div class="">
                                    <div id="patientData4"></div>
                                    </div>
                            </div>
                        </div>   
                    </div>
                </div>   
                <div class="row">
                    <div class="col-md-6 grid-margin  stretch-card ">   
                    <div class="card card-shadow">
                                <h3 class="home-design1">
                                Home% VS Home Count Per FTE 
                                </h3>
                            <div class="card-body" >
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="myChart3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>
                    <div class="col-md-6 grid-margin stretch-card ">
                        <div class="card card-shadow">
                                <h3 class="home-design1">
                                Home% VS New Home Per FTE 
                                </h3>
                            <div class="card-body" >
                                <div class="row">
                                    <div class="col-md-12">
                                    <div id="myChart4"></div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div>  
                <div class="row">
                    <div class="col-md-6 grid-margin  stretch-card ">   
                        <div class="card card-shadow">
                                <h3 class="home-design1">
                                Home% VS Incident Home Per FTE 
                                </h3>
                            <div class="card-body" >
                                <div class="row">
                                    <div class="col-md-12">
                                    <div id="myChart5"></div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>
                    <div class="col-md-6 grid-margin stretch-card ">
                        <div class="card card-shadow">
                                <h3 class="home-design1">
                                Home% VS Home Patients 
                                </h3>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 height-graph-6">
                                    <div id="myChart6"></div>
                                    </div>
                                </div>
                            </div>
                        </div>   
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12 grid-margin  stretch-card ">   
                    <div class="card card-shadow">
                                <h3 class="home-design1">
                                Home% 
                                </h3>
                            <div class="card-body" >
                                <div class="row">
                                    <div class="col-md-12">
                                    <div id="patientData3"></div>
                                    </div>
                                </div>
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
            /* Apex chart start */

    var patientDataOptions = {
        series: [{
            name: 'No. of Patients',
            type: 'column',
            data: [   
                @foreach($homePatientsHD as $homePatientsHDD)
                '{{$homePatientsHDD->vls}}',
            @endforeach
            ]
        }, {
            name: 'No. of Patients',
            type: 'line',
            data: [ @foreach($homePatientsHD as $homePatientsHDD)
                '{{$homePatientsHDD->vls}}',
            @endforeach]
        }],
        colors:['#842d72','#02BC77'],
        chart: {
            fontFamily: 'Quicksand',
            height: 250,
            type: 'line',
            stacked: false,
            toolbar: {
                show: false
            },
        },
        stroke: {
            width: [0, 2],
            curve: 'smooth'
        },
        plotOptions: {
            bar: {
                columnWidth: '25%'
            }
        },
        markers: {
            size: 3,
            colors: ['#ffffff'],
            shape: "circle",
            radius: 12,
            strokeColors: '#02bc77',
            strokeWidth: 2,
        },
        fill: {
            opacity: 1,
            colors: ['#9F528F']
        },
        legend: {
            show: false
        },
        xaxis: {
            categories: [
                @foreach($homePatientsHD as $homePatientsHDD)
                '{{$homePatientsHDD->kys}}',
            @endforeach
            ]
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(y) {
                    if (typeof y !== "undefined") {
                        return y.toFixed(0) + " points";
                    }
                    return y;

                }
            }
        }
    };
    var patientDataChart = new ApexCharts(document.querySelector("#patientData"), patientDataOptions);
    patientDataChart.render();

      /* Apex chart start */


      var patientDataOptions4 = {
        series: [{
            name: 'No. of Patients',
            type: 'column',
            data: [ @foreach($newHomePatientsHD as $newHomePatientsHDD)
                '{{$newHomePatientsHDD->vls}}',
            @endforeach
        ]
        }],
        colors:['#842d72'],
        chart: {
          fontFamily: 'Quicksand',
            height: 250,
            type: 'line',
            stacked: false,
            toolbar: {
                show: false
            },
        },
        stroke: {
            width: [0, 2],
            curve: 'smooth'
        },
        plotOptions: {
            bar: {
                columnWidth: '25%'
            }
        },
        fill: {
            opacity: 1,
            colors: ['#9F528F']
        },
        legend: {
            show: false
        },
        xaxis: {
            categories: [
                @foreach($newHomePatientsHD as $newHomePatientsHDD)
                '{{$newHomePatientsHDD->kys}}',
            @endforeach
            ]
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(y) {
                    if (typeof y !== "undefined") {
                        return y.toFixed(0) + " points";
                    }
                    return y;

                }
            },
            color:['#9F528F'],
        }
    };
    var patientData4Chart = new ApexCharts(document.querySelector("#patientData4"), patientDataOptions4);
    patientData4Chart.render();

     /* Apex chart start */

     var patientDataOptions = {
        series: [{
            name: 'No. of Patients',
            type: 'column',
            data: [  @foreach($homePercentHD as $homePercentHDD)
                '{{$homePercentHDD->homeper}}',
            @endforeach]
        }, {
            name: 'No. of Patients',
            type: 'line',
            data:  [ 
                 @foreach($homePercentHD as $homePercentHDD)
                '{{$homePercentHDD->homeper}}',
            @endforeach
        ]
        }],
        colors:['#02BC77','#842d72'],
        chart: {
          fontFamily: 'Quicksand',
            height: 250,
            type: 'line',
            stacked: false,
            toolbar: {
                show: false
            },
        },
        stroke: {
            width: [0, 2],
            curve: 'smooth'
        },
        plotOptions: {
            bar: {
                columnWidth: '25%'
            }
        },
        markers: {
            size: 3,
            colors: ['#ffffff'],
            shape: "circle",
            radius: 12,
            strokeColors: '#842d72',
            strokeWidth: 2,
        },
        fill: {
            opacity: 1,
            colors: ['#02BC77']
        },
        legend: {
            show: false
        },
        xaxis: {
            categories: [
                @foreach($homePercentHD as $homePercentHDD)
                '{{$homePercentHDD->kys}}',
            @endforeach
            ]
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(y) {
                    if (typeof y !== "undefined") {
                        return y.toFixed(0) + " points";
                    }
                    return y;

                }
            }
        }
    };
   
    var patientDataChart = new ApexCharts(document.querySelector("#patientData3"), patientDataOptions);
    patientDataChart.render();


    // Apex Chart Start Chart 3

    var patientDataOptions = {
  series: [
    // {
    //   name: 'Home Patients',
    //   type: 'scatter',
    //   data: [
    //     @foreach($homePatientsHD as $homePatientsHDD)
    //       '{{$homePatientsHDD->vls}}',
    //     @endforeach
    //   ]
    // },
    {
      name: 'Home %',
      type: 'scatter',
      data: [
        @foreach($homePercentHD as $homePercentHDD)
                '{{$homePercentHDD->homeper}}',
            @endforeach
       
      ]
    }
  ],
  colors: ['#842d72', '#02BC77'],
  chart: {
    fontFamily: 'Quicksand',
    height: 250,
    stacked: false,
    toolbar: {
      show: false
    }
  },
  stroke: {
    width: [0, 2],
    curve: 'smooth'
  },
  plotOptions: {
    bar: {
      columnWidth: '25%'
    }
  },
  markers: {
    size: 3,
    colors: ['#842d72', '#02BC77'],
    shape: 'circle',
    radius: 12,
    strokeColors: ['#842d72', '#02BC77'],
    strokeWidth: 2
  },
  fill: {
    opacity: 1,
    colors: ['#9F528F']
  },
  legend: {
    show: false
  },
  xaxis: {
            categories: [
                @foreach($homeCountPerFteHD as $homeCountPerFteHDD)
                '{{$homeCountPerFteHDD->home_fte}}',
            @endforeach
            ]
        },
  yaxis: {
    axisTicks: {
      show: true
    }
  }
};

var patientDataChart = new ApexCharts(
  document.querySelector('#myChart3'),
  patientDataOptions
);
patientDataChart.render();
   
    /* Apex chart end Chart 3*/


      // Apex Chart Start Chart 4

    var patientDataOptions = {
  series: [
    // {
    //   name: 'Home Patients',
    //   type: 'scatter',
    //   data: [
    //     @foreach($homePatientsHD as $homePatientsHDD)
    //       '{{$homePatientsHDD->vls}}',
    //     @endforeach
    //   ]
    // },
    {
      name: 'Home %',
      type: 'scatter',
      data: [
        @foreach($homePercentHD as $homePercentHDD)
                '{{$homePercentHDD->homeper}}',
            @endforeach
       
      ]
    }
  ],
  colors: ['#842d72', '#02BC77'],
  chart: {
    fontFamily: 'Quicksand',
    height: 250,
    stacked: false,
    toolbar: {
      show: false
    }
  },
  stroke: {
    width: [0, 2],
    curve: 'smooth'
  },
  plotOptions: {
    bar: {
      columnWidth: '25%'
    }
  },
  markers: {
    size: 3,
    colors: ['#842d72', '#02BC77'],
    shape: 'circle',
    radius: 12,
    strokeColors: ['#842d72', '#02BC77'],
    strokeWidth: 2
  },
  fill: {
    opacity: 1,
    colors: ['#9F528F']
  },
  legend: {
    show: false
  },
  xaxis: {
            categories: [
                @foreach($newHomePerFteHD as $newHomePerFteHDD)
                '{{$newHomePerFteHDD->new_home_fte}}',
            @endforeach
            ]
        },
  yaxis: {
    axisTicks: {
      show: true
    }
  }
};

var patientDataChart = new ApexCharts(
  document.querySelector('#myChart4'),
  patientDataOptions
);
patientDataChart.render();
   
    /* Apex chart end Chart 4*/
     
    /* Apex chart start Chart 5*/

     var patientDataOptions = {
  series: [
    {
      name: 'Home %',
      type: 'scatter',
      data: [
        @foreach($homePercentHD as $homePercentHDD)
                '{{$homePercentHDD->homeper}}',
            @endforeach
      ]
    }
  ],
  colors: ['#842d72', '#02BC77'],
  chart: {
    fontFamily: 'Quicksand',
    height: 250,
    stacked: false,
    toolbar: {
      show: false
    }
  },
  stroke: {
    width: [0, 2],
    curve: 'smooth'
  },
  plotOptions: {
    bar: {
      columnWidth: '25%'
    }
  },
  markers: {
    size: 3,
    colors: ['#842d72', '#02BC77'],
    shape: 'circle',
    radius: 12,
    strokeColors: ['#842d72', '#02BC77'],
    strokeWidth: 2
  },
  fill: {
    opacity: 1,
    colors: ['#9F528F']
  },
  legend: {
    show: false
  },
  xaxis: {
            categories: [
                @foreach($incidentHomePerFteHD as $incidentHomePerFteHDD)
                '{{$incidentHomePerFteHDD->vals}}',
            @endforeach
            ]
        },
  yaxis: {
    axisTicks: {
      show: true
    }
  }
};

var patientDataChart = new ApexCharts(
  document.querySelector('#myChart5'),
  patientDataOptions
);
patientDataChart.render();

      /* Apex chart end Chart 5 */

    /* active_patients_count_per_physician Start */

     /* active_patients_count_per_physician Start */
    //  const labels6 = [
    //     '0',
    //     '200',
    //     '400',
    //     '600',
    //     '800',
    //     '1000',
    //     '1200',
    //     '1400',
    //     '1600',
    //     '1800',
    //     '2000',
    //     '2200',
    // ];

    // const data6 = {
    //     labels: labels6,
    //     datasets: [{
    //     label: '',
    //     backgroundColor: 'rgb(119,106,207)',
    //     borderColor: 'rgb(119,106,207)',
    //     data: [
           
    //         @foreach($homePatientsHD as $homePatientsHDD)
    //             '{{$homePatientsHDD->vls}}',
    //         @endforeach
            
    //         ],
    //     }]
    // };

    // const config6 = {
    //     type: 'scatter',
    //     data: data6,
    //     options: grideHide
    // };

    // const myChart6 = new Chart(
    //     document.getElementById('myChart6'),
    //     config6
    // );

        /* Apex chart start Chart 6 */

    var patientDataOptions = {
  series: [
    // {
    //   name: 'Home Patients',
    //   type: 'scatter',
    //   data: [
    //     @foreach($homePatientsHD as $homePatientsHDD)
    //       '{{$homePatientsHDD->vls}}',
    //     @endforeach
    //   ]
    // },
    {
      name: 'Home %',
      type: 'scatter',
      data: [
        @foreach($homePercentHD as $homePercentHDD)
                '{{$homePercentHDD->homeper}}',
            @endforeach
      ]
    }
  ],
  colors: ['#842d72', '#02BC77'],
  chart: {
    fontFamily: 'Quicksand',
    height: 250,
    stacked: false,
    toolbar: {
      show: false
    }
  },
  stroke: {
    width: [0, 2],
    curve: 'smooth'
  },
  plotOptions: {
    bar: {
      columnWidth: '25%'
    }
  },
  markers: {
    size: 3,
    colors: ['#842d72', '#02BC77'],
    shape: 'circle',
    radius: 12,
    strokeColors: ['#842d72', '#02BC77'],
    strokeWidth: 2
  },
  fill: {
    opacity: 1,
    colors: ['#9F528F']
  },
  legend: {
    show: false
  },
  xaxis: {
            categories: [
                @foreach($homePatientsHD as $homePatientsHDD)
          '{{$homePatientsHDD->vls}}',
        @endforeach
            ]
        },
  yaxis: {
    axisTicks: {
      show: true
    }
  }
};

var patientDataChart = new ApexCharts(
  document.querySelector('#myChart6'),
  patientDataOptions
);
patientDataChart.render();



      /* Apex chart end Chart 6 */

    
     
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>



@endsection

@section('after-scripts')
    {{--    {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
    {{ Html::script(asset('js/template/js/fusioncharts.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}
    