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
        <div class="head-margin">
                 @include('widgets.search_filter')
                 {{ Form::close() }}
        </div>
    <br>
    <div class="table-body">
       
       
        {{-- </div>--}}

        <div class="row">

            {{-- <div class="col-md-6 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                 <!--<canvas id="orders-chart-azure"></canvas>-->
                                 <canvas id="bar-chart-grouped" width="800" height="450"></canvas>

                             </div>
                        </div>
                    </div>--}}
            <div class="col-md-6 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-md-flex justify-content-between align-items-center">
                            <div>
                                
                                <h5 class="card-title mb-2 mb-md-3">CKD Patient/BMI</h5>
                                <!--<h6 class="text-muted font-weight-normal">Your sales and referral earnings over the last 30 days.</h6>-->
                            </div>

                        </div>
                        <div class="mt-4" style="width:100%;">
                        
                         
                            <canvas id="Chart1" class="practice-Chart2"></canvas>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="row barchartbottom display-none">
                                    <div class="col-md-4 ">
                                        <p class="text-purple " style="font-size: 12px;font-weight: 600;" data-toggle="tooltip" data-placement="top" title="{{prettyPrice($accountReceivablesStats[0]->PrimaryBalance)}}">Primary Open Balance
                                        </p>
                                    </div>

                                    <div class="col-md-4">
                                        <p class="text-purple" style="font-size: 12px;font-weight: 600;" data-toggle="tooltip" data-placement="top" title="{{prettyPrice($accountReceivablesStats[0]->SecondaryBalance)}}">Secondary Open Balance </p>
                                    </div>

                                    <div class="col-md-4">
                                        <p class="text-purple" style="font-size: 12px;font-weight: 600;" data-toggle="tooltip" data-placement="top" title="{{prettyPrice($accountReceivablesStats[0]->PatientBalance)}}">Patient Balance </p>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
<!--             
           <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Profit & Loss / Provider</h4>

                        <div class="align-items-center justify-content-between mt-2">
                            <div>
                                <h6 class="text-purple" style="border-left: 2px solid #f7af27;
                                        height: 17px;padding: 0 29px;margin-left: -24px;">Avg Cost / Provider</h6>
                            </div>
                            <div class="icon-box pb-4" style="font-size: 24px">
                                $0
                            </div>
                        </div>

                        <div class="align-items-center justify-content-between mt-2">
                            <div>
                                <h6 class="text-purple" style="border-left: 2px solid #04b4f0;
                                        height: 17px;padding: 0 29px;margin-left: -24px;">Avg Revenue / Provider </h6>
                            </div>
                            <div class="icon-box pb-4" style="font-size: 24px">
                                $0
                            </div>
                        </div>

                        <div class="align-items-center justify-content-between mt-2">
                            <div>
                                <h6 class="text-purple" style="border-left: 2px solid #744af4;
                                        height: 17px;padding: 0 29px;margin-left: -24px;">Net Profit / Loss</h6>
                            </div>
                            <div class="icon-box pb-4" style="font-size: 24px">
                                $0
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div> -->

        <div class="col-md-12 display-none">
            <div class="row">
                

                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="payer-bar-charts" class="practice-Chart1" width="800" height="450"></canvas>
                        </div>
                    </div>
                </div>


                <div class="col-md-12 grid-margin ">

                <div class="card">
                    <div class="extra-pad">
                   
                    <div class="card-body">
                        <!--<canvas id="orders-chart-azure"></canvas>-->
                        <canvas id="bar-chart-cptcode" class="practice-Chart1" width="600" height="250"></canvas>

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
{{-- {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}

{{ Html::script(asset('js/template/js/fusioncharts.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}

<script>
    $("footer .dashboard-footer").addClass("footer-margin");
</script>
@include('backend.partials.graph-script')
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
                backgroundColor: "#842d72",
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
        responsive: true,
        maintainAspectRatio: false,
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

});

</script>
 
<script>
    new Chart(document.getElementById("payer-bar-charts"), {
        type: 'bar',
        data: {
            labels: [
                @if(count($payerLabels)>0)
                        @foreach($payerLabels as $payerLabel)
                    '{{$payerLabel}}',
                @endforeach
                        @else
                    '',
                @endif

            ],
            datasets: [
                {
                    label: "Charge Amount $",
                    backgroundColor: "#842d72",
                    data: [
                        @if(count($payercharges)>0)
                                @foreach($payercharges as $payercharge)
                            '{{number_format($payercharge, 0, ".", "")}}',
                        @endforeach
                                @else
                            '0',
                        @endif
                    ]
                },
                {
                    label: "Collection Amount $",
                    backgroundColor: "#86B420",
                    data: [
                        @if(count($payerCollections)>0)
                                @foreach($payerCollections as $payerCollection)
                            '{{number_format($payerCollection, 0, ".", "")}}',
                        @endforeach
                                @else
                            '',
                        @endif

                    ]
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            title: {
                display: true,
                text: 'Charges & Payment by Payer by Month'
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
                    },
                ],
               /* annotation: {
                    annotations: [{
                        type: 'line',
                        mode: 'horizontal',
                        scaleID: 'y-axis-0',
                        value: '26',
                        borderColor: 'tomato',
                        borderWidth: 1
                    }],
                    drawTime: "afterDraw" // (default)
                }*/


            },
            annotation: {
                annotations: [{
                    type: 'line',
                    mode: 'horizontal',
                    scaleID: 'y-axis-0',
                    value: '{{$averagePayerCharges}}',
                    borderColor: '#00A4DB',//'Chartreuse',
                    borderWidth: 2
                },
                    {
                        type: 'line',
                        mode: 'horizontal',
                        scaleID: 'y-axis-0',
                        value: '{{$averagePayerCollections}}',
                        borderColor: '#00FF95',//'tomato',
                        borderWidth: 2
                    },
                ],

                tooltips: {
                    enabled: true
                },
                drawTime: "afterDraw" // (default)
            },

        },

    });
</script>


@endsection