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
                <form method="POST" class="cptDatePickers"
                      action="{{route('admin.patient-analysis-to-from-date')}}">
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
                            <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Submit</button>
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


<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
{{ Html::script(asset('js/template/js/fusioncharts.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/0.5.7/chartjs-plugin-annotation.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>
<link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css'/>

@include('backend.partials.graph-patients-script')
