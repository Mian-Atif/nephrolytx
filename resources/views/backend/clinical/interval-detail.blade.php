@extends('backend.layouts.dashboard')
@section('after-styles')
    <style>
        #chart-container, #chart-container-yearly {
            position: relative;
        }
 
        #chart-container::after, #chart-container-yearly::after {
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
        {{ Form::open(['route' => 'admin.patient-analysis-search', 'class' => 'form', 'role' => 'form', 'method' => 'post','id'=>'ClinicalFilter']) }}
        @include('widgets.search_filter_interval')
        {{ Form::close() }}
        <br>
        <div class="table-body">
        @php
            $intervalStageBoxOne = array_values((array) $intervalStageBoxOne);
            $intervalStageBoxOneTwo = array_values((array) $intervalStageBoxOne[0]);
            
        @endphp               
        <div class="row row1">
                    <div class="col-md-3 card-box-mr">
                        <div class="card card-height-adjust card-bcolors">
                            <div class="card-body ckd-box ckd-box-none text-center pad-space-0 card-center-ct">
                                    {{$intervalStageBoxOneTwo['3']}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 card-box-mr">
                        <div class="card">
                            <div class="card-body ckd-box ckd-box-none text-center pad-space-0">
                                <h5 class="card-title vit-heading">CKD Visit Interval By Stage</h5>
                                <div class="visit-interval-table">
                                   
                                <table class="table table-bordered">
                                        <tr>
                                            <th></th>
                                            <th>Expected Visits</th>
                                            <th>Actual Visits</th>
                                            <th>Interval</th>
                                        </tr>
                                        @foreach ($intervalStageBoxOne as $intervalStage)
                                        <tr>
                                            <td>
                                                <strong>{{$intervalStage->category}}</strong>
                                            </td>
                                            <td>
                                                <strong>{{$intervalStage->expected_visits}}</strong>
                                            </td>
                                            <td>
                                                <strong>{{$intervalStage->actual_visits}}</strong>
                                            </td>
                                            <td>
                                                <strong>{{$intervalStage->visit_interval}}</strong>
                                            </td>
                                        </tr>
@endforeach
                                        
                                   </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            <div class="row">
                
            <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center">Visit Interval by Month</h4>

                            <div class="d-md-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-2 mb-md-3"></h5>
                                </div>
                            </div>
                            <div class=" mt-12">
                                <canvas id="payer-bar-chart" width="800" height="450"></canvas>

                            </div>

                        </div>
                    </div>
                </div>
  
                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">CKD Patients Comparison</h4>
                            <!--<canvas id="orders-chart-azure"></canvas>-->
                            <canvas id="bar-chart-grouped-new" width="800" height="450" ></canvas>

                        </div>
                    </div>
                </div>
                

            </div>
        </div>
    </div>


@endsection

@section('after-scripts')
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    {{ Html::script(asset('js/template/js/fusioncharts.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/0.5.7/chartjs-plugin-annotation.js"></script>
    @include('backend.partials.interval-detail-script')

    <script>$("body").on("change","#provider,#location,#payer",function(){

var provider = $("#provider").val();
var location = $("#location").val();
var payer = $("#payer").val();
var token = $('input[name=_token]').val();


    $.ajax({   
        type: "POST",
        url: "{{ route('admin.interval-filter') }}",
        data: {provider:provider,location:location,payer:payer,_token:token},
        beforeSend: function(){
            $('.fas.fa-search').addClass('fa-spin fa-spinner').removeClass('fa-search');
        },
        success: function(data){
            var data = JSON.parse(data);
            var html_1 = data.html_1;
            $('.table-body .row1').html(html_1);

           // multiLineChart.data.datasets=data.canvas_html;
           // multiLineChart.update();

            // myChart.data.datasets=data.canvas1c_html;
            // myChart.update();
            
            $('.fas.fa-spinner').removeClass('fa-spin fa-spinner').addClass('fa-search');
        }
    });

});

</script>

@endsection