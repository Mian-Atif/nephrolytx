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
        @include('backend.partials.stats')
        {{ Form::open(['route' => 'admin.patient-analysis-search', 'class' => 'form', 'role' => 'form', 'method' => 'post','id'=>'locationFilter']) }}
        @include('widgets.search_filter')
        {{ Form::close() }}
        <br>
        <div class="table-body">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">No. Of Patients/Month</h4>

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
                            <!--<canvas id="orders-chart-azure"></canvas>-->
                            <canvas id="bar-chart-grouped" width="800" height="450"></canvas>

                        </div>
                    </div>
                </div>
                <div class="col-md-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <canvas id="payer-bar-charts" width="800" height="450"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 grid-margin">

                    <div class="card">
                        <form method="POST" class="cptDatePickers form-padding" action="{{route('admin.patient-analysis-to-from-date')}}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-3 mt-3 ml-5"> <!-- Date input -->
                                    <label class="control-label" for="date">Start Date</label>
                                    <input class="form-control date startDate" id="datetimepicker1"
                                           name="dateStartfilter" placeholder="MM/DD/YYY" type="text" value="{{$currentMonth}}"/>
                                </div>
                                <div class="form-group col-sm-3 mt-3"> <!-- Date input -->
                                    <label class="control-label" for="date">End Date</label>
                                    <input class="form-control date endDate" id="datetimepicker2" name="dateEndfilter"
                                           placeholder="MM/DD/YYY" type="text" value="{{$currentDate}}"/>
                                </div>

                                <div class="form-group col-sm-3 mt-3"> <!-- Date input -->
                                    <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="card-body chart-cptcode">
                            <canvas id="bar-chart-cptcode" width="800" height="450"></canvas>
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
    @include('backend.partials.graph-patients-script')

@endsection