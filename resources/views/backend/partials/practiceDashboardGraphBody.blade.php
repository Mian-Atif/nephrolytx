
<div class="table-body">
        <div class="row">
            <div class="col-md-12 col-lg-7 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Projected/Actual Collection</h4>

                        <div class="d-md-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-2 mb-md-3"></h5>
                            </div>
                        </div>
                        <div class=" mt-12">
                            <canvas class="graph-height" id="chart-sales"></canvas>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-5 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Target VS Achievement</h4>
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="text-center">Year To Date</h5>
                                <div class="chart-container-2-outer">
                                    <div class="chart-container-2">
                                        <div id="chart-container"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <h5 class="text-center">Month To Date</h5>
                                <div class="chart-container-2-outer">
                                    <div class="chart-container-2">
                                        <div id="chart-container-yearly"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- </div>--}}

        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-md-flex justify-content-between align-items-center">
                            <div>

                                <h5 class="card-title mb-2 mb-md-3">Account Receivables</h5>
                                <!--<h6 class="text-muted font-weight-normal">Your sales and referral earnings over the last 30 days.</h6>-->
                            </div>

                        </div>
                        <div class="mt-4" style="width:100%;">


                            <canvas id="Chart1" class="practice-Chart2"></canvas>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="row barchartbottom">
                                    <div class="col-md-4">
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

            <div class="col-md-12">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-xl-6 col-md-6  grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body background-image-graph">

                                <h6 class="card-title">
                                    Revenue / Patient Type <br/> 
                                    <small>(Based on 12 months trend)</small>

                                    <span class="graph-left-filter-btn z-index"> 
                                        <a href="#" data-canvas=".rev-in-wrap" class="btn btn-secondary rev-inout active ">In Patient</a> 
                                        <a href="#" data-canvas=".rev-out-wrap"  class="btn btn-secondary rev-inout">Out Patient</a>
                                    </span>

                                </h6>
                                
                    
                                <div class="rev-inout-wrap">
                                    <div class="rev-in-wrap active">

                                        <div class="row">
                                            <div class="col-md-6" style="padding-top:27px">
                                                <div class="mt-4">
                                                    <canvas id="traffic-chart" width="200" height="200"></canvas>
                                                    <!-- <canvas id="piechart"></canvas> -->
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="padding-top: 48px;">
                                                <div id="traffic-chart-legend" class="chartjs-legend traffic-chart-legend mt-5">

                                                </div>
                                                <!-- <ul><li><h2 class="mb-2">40%</h2><div class="legend-content"><span class="legend-dots" style="background:linear-gradient(145deg, #8433f7, #006699)"></span>CKD </div></li><li><h2 class="mb-2">40%</h2><div class="legend-content"><span class="legend-dots" style="background:linear-gradient(to right, rgba(238, 143, 154, 1), rgba(233, 79, 133, 1))"></span>ESRD</div></li><li><h2 class="mb-2">20%</h2><div class="legend-content"><span class="legend-dots" style="background:linear-gradient(145deg, #ffc173, #ff6491)"></span>Non CKD</div></li></ul> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rev-out-wrap">

                                        <div class="row">
                                            <div class="col-md-6" style="padding-top:27px">
                                                <div class="mt-4">
                                                    <canvas id="traffic2-chart" width="200" height="200"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="padding-top: 48px;">
                                                <div id="traffic2-chart-legend" class="chartjs-legend traffic-chart-legend mt-5">

                                                </div>
                                                <!-- <ul><li><h2 class="mb-2">40%</h2><div class="legend-content"><span class="legend-dots" style="background:linear-gradient(145deg, #8433f7, #006699)"></span>CKD </div></li><li><h2 class="mb-2">40%</h2><div class="legend-content"><span class="legend-dots" style="background:linear-gradient(to right, rgba(238, 143, 154, 1), rgba(233, 79, 133, 1))"></span>ESRD</div></li><li><h2 class="mb-2">20%</h2><div class="legend-content"><span class="legend-dots" style="background:linear-gradient(145deg, #ffc173, #ff6491)"></span>Non CKD</div></li></ul> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-6 col-xl-6 grid-margin">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="card-title">Revenue Forecast Based on Patient Volume <small>(Based on 12 months trend)</small></h4>
                                <div class="row ">
                                    <div class="col-lg-6 col-md-6 col-lg-6 col-xl-6">
                                        <div class=" align-items-center justify-content-between block-revenueforecast mb-30">
                                            <div>
                                                <div class="header-revenueforecast">

                                                    <h6 class="text-purple ">Patients Increase / Decrease </h6>
                                                </div>
                                                <div class="inner-revenueforecast">
                                                    <h6>
                                                        <div class="row">
                                                            <div class="col-md-8">New pts:</div>
                                                            <div class="col-md-4 text-end">{{$patientVolume[0]->avgincreasepatientPercentage+$patientVolume[0]->DeactivePts}}</div>
                                                        </div>
                                                    </h6>
                                                    <h6>
                                                        <div class="row">
                                                            <div class="col-md-8">Less inactive pts:</div>
                                                            <div class="col-md-4 text-end">{{$patientVolume[0]->DeactivePts}}</div>
                                                        </div>
                                                    </h6>
                                                    <h6>

                                                        <div class="row">
                                                            <div class="col-md-8">Net impact:</div>
                                                            <div class="col-md-4 text-end">{{$patientVolume[0]->avgincreasepatientPercentage}}</div>
                                                        </div>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6  col-lg-6 col-xl-6 ">
                                        <div class=" align-items-center justify-content-between block-revenueforecast mb-30">
                                            <div class="header-revenueforecast">
                                                <h6 class="text-purple">Expected Encounters</h6>
                                            </div>
                                            <div class="inner-revenueforecast-2">
                                                <div class="icon-box-2">
                                                    {{number_format((float)(count($patientVolume)> 0)?$patientVolume[0]->increaseexpectedencounter:0, 0, '.', '')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row ">

                                    <div class="col-md-6 col-lg-6 col-xl-6 ">
                                        <div class=" align-items-center justify-content-between block-revenueforecast">
                                            <div class="header-revenueforecast">
                                                <h6 class="text-purple">Avg Revenue / Encounter</h6>
                                            </div>
                                            <div class="inner-revenueforecast-2">
                                                <div class="icon-box-2">
                                                    ${{number_format((float)(count($patientVolume)> 0)?$patientVolume[0]->avgRevenuPerEncounter:0, 2, '.', '')}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-xl-6 ">
                                        <div class=" align-items-center justify-content-between block-revenueforecast ">
                                            <div class="header-revenueforecast">
                                                <h6 class="text-purple">Expected Increase in Revenue</h6>
                                            </div>
                                            <div class="inner-revenueforecast-2">
                                                <div class="icon-box-2 ">
                                                    ${{number_format((float)((count($patientVolume)> 0)?$patientVolume[0]->avgRevenuPerEncounter:0) *((count($patientVolume)> 0)?$patientVolume[0]->increaseexpectedencounter:0))}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 grid-margin">
                        <div class="card">

                            <div class="card-body">
                            <ul class="graph-label-ul graph-label-ul-2">
                            <li>
                                <span class="greenish-label-color"></span>
                                <span>Collection Amount</span>
                            </li>
                            <li>
                                <span class="purple-label-color"></span>
                                <span>Charge Amount</span>
                            </li>
                        </ul>
                            
                                <canvas id="payer-bar-charts" class="practice-Chart1" width="800" height="450"></canvas>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12 grid-margin ">

                        <div class="card">
                            <div class="extra-pad">

                                <div class="card-body">
                                <h6 class="card-title">
                                    Top 10 Services
                                    <span class="graph-left-filter-btn z-index"> 
                                        <a href="#" id="cpt-code-chart" data-type="month" data-chart_type="actual" data-actual_data =""   class="btn btn-secondary active activity-cpt">Units</a> 
                                        <a href="#" id="cpt-revenue-chart" data-type="quarter" data-chart_type="actual" data-actual_data="" class="btn btn-secondary activity-revenue activity-direction">Revenue</a>
                                    </span>
                                </h6>
                                    <!--<canvas id="orders-chart-azure"></canvas>-->
                                    <div class="cpt-rev-wrap">
                                        <div class="bar-chart-cptcode active">
                                            <canvas id="bar-chart-cptcode" class="practice-Chart1" width="600" height="250"></canvas>
                                        </div>
                                        <div class="bar-chart-cptcode-revenue">
                                            <canvas id="bar-chart-cptcode-revenue" class="practice-Chart1" width="600" height="250"></canvas>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

            </div>

        </div>
    </div>

{{ Html::script('vendors/js/vendor.bundle.base.js') }}
{{ Html::script('js/template/js/tooltips.js') }}
{{ Html::script(asset('js/template/js/fusioncharts.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}

@include('backend.partials.graph-script')
