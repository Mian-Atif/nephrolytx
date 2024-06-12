@extends('backend.layouts.dashboard')
@section('after-styles')
    <style>
        #chart-container, #chart-container-yearly{
            position: relative;
        }

        #chart-container::after, #chart-container-yearly::after{
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
        @include('backend.partials.stats')
        {{ Form::open(['route' => 'admin.patient-analysis-search', 'class' => 'form', 'role' => 'form', 'method' => 'post','id'=>'searchFilter']) }}
        @include('widgets.search_filter')
        {{ Form::close() }}
        <br>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body" >
                        <h4 class="card-title">No. Of Patients/Month</h4>

                        <div class="d-md-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-2 mb-md-3"></h5>
                            </div>
                        </div>
                        <div class=" mt-12">
                            <canvas id="chart-sales"></canvas>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin">

                <div class="card">
                    <div>
                    <form method="POST" class="formDatePickers" action="{{route('patient-analysis-store')}}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-sm-3"> <!-- Date input -->
                                <label class="control-label" for="date">Start Date</label>
                                <input class="form-control date startDate" id="datetimepicker1" name="dateStartfilter" placeholder="MM/DD/YYY" type="text"/>
                            </div>
                            <div class="form-group col-sm-3"> <!-- Date input -->
                                <label class="control-label" for="date">End Date</label>
                                <input class="form-control date endDate" id="datetimepicker2" name="dateEndfilter" placeholder="MM/DD/YYY" type="text"/>
                            </div>

                            <div class="form-group col-sm-3"> <!-- Date input -->
                                <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Submit</button>
                            </div>
                        </div>
                    </form>
                    <div class="card-body">
                        <!--<canvas id="orders-chart-azure"></canvas>-->
                        <canvas id="bar-chart-cptcode" width="800" height="450"></canvas>

                    </div>
                    
                </div>
            </div>
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <!--<canvas id="orders-chart-azure"></canvas>-->
                        <canvas id="bar-chart-grouped" width="800" height="450"></canvas>

                    </div>
                </div>
            </div>



        </div>
    </div>


@endsection

@section('after-scripts')
    {{--    {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
    {{ Html::script(asset('js/template/js/fusioncharts.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}

    <script>

        new Chart(document.getElementById("bar-chart-grouped"), {
            type: 'bar',
            data: {
                labels: [
                    @if(count($newPatientAnalysisLabeles)>0)
                            @foreach($newPatientAnalysisLabeles as $projectedMonthLable)
                        '{{$projectedMonthLable}}',
                    @endforeach
                            @else
                        'Sep-2019", "Feb-2019", "Mar-2019", "Apr-2019", "May-2019", "June-2019',
                    @endif


                    // "1900", "1950", "1999", "2050"
                ],
                datasets: [
                    {
                        label: "Target",
                        backgroundColor: "#00A4DB",
                        data: [
                            @if(count($newPatientAnalysisTargets)>0)
                                    @foreach($newPatientAnalysisTargets as $newPatientAnalysisTarget)
                                '{{number_format($newPatientAnalysisTarget, 0, ".", "")}}',
                            @endforeach
                                    @else
                                '10000, 18940, 36000, 44000, 38000, 39000, 40000',
                            @endif
                        ]
                    },
                    {
                        label: "Achieve",
                        backgroundColor: "#00FF95",
                        data: [
                            @if(count($newPatientAnalysisAchieves)>0)
                                    @foreach($newPatientAnalysisAchieves as $newPatientAnalysisAchieve)
                                '{{number_format($newPatientAnalysisAchieve, 0, ".", "")}}',
                            @endforeach
                                    @else
                                '20000, 18000, 17230, 26000, 22000, 10000',
                            @endif


                            // 408,547,675,734

                        ]
                    }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'Patient Analysis'
                },
                onClick:
                    function (evt, item) {
                        var activePoint = this.getElementAtEvent(evt)[0];
                        var data = activePoint._chart.data;
                        var datasetIndex = activePoint._datasetIndex;
                        var label = data.datasets[datasetIndex].label;

                        var value = data.datasets[datasetIndex].data[activePoint._index];

                        var monthYear = this.data.labels[activePoint._index];
                        var provider = $('#provider').val();
                        var location = $('#location').val();
                        var payer = $('#payer').val();
                        /*  if(label == 'Projected Collection $')
                          {*/
                        let url = "/admin/monthly-patient-analysis?monthYear=" + monthYear + "&provider=" + provider + "&location=" + location + "&payer=" + payer;
                        // window.location.replace(url);
                        window.location.href = url;
                        /* }
                       else{
                            let url = "/admin/under-paid-cases?monthYear=" + monthYear+"&provider="+provider+"&location="+location+"&payer=" + payer;
                            window.location.replace(url);
                        }*/

                    },

                scales: {
                    yAxes: [
                        {
                            ticks: {
                                fontColor: "#296a81",
                                min: 0,
                            },
                            gridLines: {
                                drawBorder: false,
                                color: "rgba(101, 103, 119, 0.21)"
                            }
                        }]
                },
            },

        })
        ;
    </script>
    <script>

        new Chart(document.getElementById("bar-chart-cptcode"), {
            type: 'bar',
            data: {
                labels: [
                    @if(count($cptCodeLabeles)>0)
                            @foreach($cptCodeLabeles as $cptCodeLabel)
                        '{{$cptCodeLabel}}',
                    @endforeach
                            @else
                        'Sep-2019", "Feb-2019", "Mar-2019", "Apr-2019", "May-2019", "June-2019',
                    @endif


                    // "1900", "1950", "1999", "2050"
                ],
                datasets: [
                    {
                        label: "Unit",
                        backgroundColor: "#00A4DB",
                        data: [
                            @if(count($cptCodeUnits)>0)
                                    @foreach($cptCodeUnits as $cptCodeUnit)
                                '{{number_format($cptCodeUnit, 0, ".", "")}}',
                            @endforeach
                                    @else
                                '10000, 18940, 36000, 44000, 38000, 39000, 40000',
                            @endif
                        ]
                    },
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'Top 10 Services'
                },


                scales: {
                    yAxes: [
                        {
                            ticks: {
                                fontColor: "#296a81",
                                min: 0,
                            },
                            gridLines: {
                                drawBorder: false,
                                color: "rgba(101, 103, 119, 0.21)"
                            }
                        }]
                },
            },

        })
        ;
    </script>
    <script>

        //Chart Sales
        if ($("#chart-sales").length) {
            var chartSalesCanvas = $("#chart-sales").get(0).getContext("2d");

            var areaData = {
                labels: [
                    @if(count($patientMonth)>0)
                            @foreach($patientMonth as $patientMnth)
                        '{{$patientMnth}}',
                    @endforeach
                            @else
                        '0',
                    @endif

                ],
                datasets: [{
                    data: [
                        // 10000, 18940, 36000, 44000, 38000, 39000, 40000  ],
                        @if(count($patientCount)>0)
                                @foreach($patientCount as $patient)
                            '{{number_format($patient, 0, ".", "")}}',
                        @endforeach
                                @else
                            '10000, 18940, 36000, 44000, 38000, 39000, 40000',
                        @endif
                    ],

                    backgroundColor: "#04b4f0",
                    borderColor: [
                        '#04b4f0'
                    ],
                    borderWidth: 2,
                    pointBorderColor: "#04b4f0",
                    pointBorderWidth: 4,
                    pointRadius: 1,
                    fill: '#04b4f0',
                    label: "No. Of Patients"
                },
                ]
            };
            var areaOptions = {
                responsive: true,
                onClick:
                    function (evt, item) {
                        var activePoint=this.getElementAtEvent(evt)[0];
                        var data = activePoint._chart.data;
                        var datasetIndex = activePoint._datasetIndex;
                        var label = data.datasets[datasetIndex].label;
                        var value = data.datasets[datasetIndex].data[activePoint._index];
                        var monthYear=this.data.labels[activePoint._index];
                        var provider=$('#provider').val();
                        var location=$('#location').val();
                        var payer=$('#payer').val();
                        if(label == 'Projected Collection $')
                        {
                            let url = "/admin/open-cases?monthYear=" + monthYear+"&provider="+provider+"&location="+location+"&payer=" + payer;
                            // window.location.replace(url);
                            window.location.href = url;
                        }
                        else{
                            let url = "/admin/under-paid-cases?monthYear=" + monthYear+"&provider="+provider+"&location="+location+"&payer=" + payer;
                            // window.location.replace(url);
                            window.location.href = url;
                        }

                    },
                maintainAspectRatio: true,
                plugins: {
                    filler: {
                        propagate: false
                    }
                },
                scales: {
                    /* xAxes: [{
                       ticks: {
                         fontColor: "#fff"
                       },
                       gridLines: {
                         display: false,
                         color: "rgba(101, 103, 119, 0.21)"
                       }
                     }],*/
                    yAxes: [{
                        ticks: {
                            fontColor: "#296a81",
                            stepSize: 50000,//10000
                            min: 0,
                            max: {{$patients}},//50000  $actualCollectionMax
                        },
                        gridLines: {
                            drawBorder: false,
                            color: "rgba(101, 103, 119, 0.21)"
                        }
                    }]
                },
                legend: {
                    display: true,
                    labels: {
                        fontColor: "#04151b",

                    }
                },
                legendCallback : function(chart) {
                    var text = [];
                    text.push(' <div class="d-flex justify-content-between justify-content-lg-start flex-wrap">');
                    text.push('<div class="mr-5 mb-2">');
                    text.push('<div class="d-flex">');
                    text.push('<i class="ti-briefcase" style="color: ' + chart.data.datasets[0].borderColor[0] +' "></i>');
                    text.push('<h3 class="text-white ml-3">'+ chart.data.datasets[0].data[1] + '</h3>');
                    text.push('</div>');
                    text.push('<h6 class="font-weight-normal mb-0">Online sales</h6>');
                    text.push('</div>');
                    text.push('<div class="mb-2">');
                    text.push('<div class="d-flex">');
                    text.push('<i class="ti-apple" style="color: ' + chart.data.datasets[1].borderColor[0] +' "></i>');
                    text.push('<h3 class="text-white ml-3">'+ chart.data.datasets[1].data[2] + '</h3>');
                    text.push('</div>');
                    text.push('<h6 class="font-weight-normal mb-0">Sales in store</h6>');
                    text.push('</div>');
                    text.push('</div>');
                    return text.join('');
                },
                tooltips: {
                    enabled: true
                }
            }
            var salesChartCanvas = $("#chart-sales").get(0).getContext("2d");
            var salesChart = new Chart(salesChartCanvas, {
                type: 'line',
                data: areaData,
                options: areaOptions
            });
            document.getElementById('sales-legend').innerHTML = salesChart.generateLegend();
        }
    </script>
@endsection