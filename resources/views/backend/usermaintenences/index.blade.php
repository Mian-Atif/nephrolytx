@extends ('backend.layouts.dashboard')
@section('content-new')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>Active Patients</h4>
                                <h4 class="text-white mt-3">800</h4>
                                <!--<h6 class="text-muted">35.19% Since last month</h6>-->
                            </div>
                            <div class="icon-box icon-box-bg-image-warning">
                                <i class="fas fa-users gradient-card-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>New Patients</h4>
                                <h4 class="text-white mt-3">176</h4>
                                <!--<h6 class="text-muted">73.52% Since last month</h6>-->
                            </div>
                            <div class="icon-box icon-box-bg-image-info">
                                <i class="fas fa-users gradient-card-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>CKD Patients</h4>
                                <h4 class="text-white mt-3">400</h4>
                                <!--<h6 class="text-muted">49.39% Since last month</h6>-->
                            </div>
                            <div class="icon-box icon-box-bg-image-danger">
                                <i class="fas fa-users gradient-card-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4>ESRD Patients</h4>
                                <h4 class="text-white mt-3">250</h4>
                                <!--<h6 class="text-muted">18.33% Since last month</h6>-->
                            </div>
                            <div class="icon-box icon-box-bg-image-success">
                                <i class="fas fa-users gradient-card-icon"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-md-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-2 mb-md-3"></h5>
                                <!--<h6 class="text-muted font-weight-normal">Your sales and referral earnings over-->
                                <!--the last 30 days.</h6>-->
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-6 col-xl-4 grid-margin">
                                <div class="card icon-box-bg-image-danger">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">

                                            <div>
                                                <h6>Average Collection</h6>
                                                <h6>12 Month Trend</h6>
                                                <h4 class="text-white mt-3">$50k</h4>
                                                <!--<h6 class="text-muted">35.19% Since last month</h6>-->
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-xl-4 grid-margin">
                                        <span style="float:left;font-size: 40px;    position: relative;
    top: 30%;left: -7%;">-</span>
                                <div class="card icon-box-bg-image-danger">
                                    <div class="card-body" style="position:relative;">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="">

                                                <h6>Benchmark</h6>
                                                <h6 style="color:transparent">Projected </h6>
                                                <h4 class="text-white mt-3">$60k</h4>
                                                <!--<h6 class="text-muted">73.52% Since last month</h6>-->
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-xl-4 grid-margin">
                                        <span style="float:left;font-size: 40px;    position: relative;
    top: 30%;left: -7%;">=</span>
                                <div class="card icon-box-bg-image-danger">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>

                                                <h6>Variance</h6>
                                                <h6 style="color:transparent">text</h6>
                                                <h4 class="text-white mt-3">($10k)</h4>
                                                <!--<h6 class="text-muted">49.39% Since last month</h6>-->
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class=" mt-4">
                            <canvas id="chart-sales"></canvas>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Target VS Achievement</h4>
                        <div id="chart-container"></div>
                        <div class="mb-4"></div>
                        <div id="chart-container-yearly"></div>
                    </div>
                </div>
            </div>
        </div>

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
                        <div class="row">

                            <div class="col-md-8 grid-margin stretch-card">

                                <div class="mt-4" style="width:100%;">
                                    <!--<canvas id="orders-chart-azure"></canvas>-->
                                    <canvas id="Chart1"></canvas>
                                </div>
                            </div>
                            <div class="col-md-4 grid-margin stretch-card">

                                <!--<div class="card">-->
                                <div class="card-body">
                                    <!--<h4 class="card-title">Provider Balance</h4>-->

                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div>
                                            <h6 class="text-white">Primary Open Balance</h6>
                                        </div>
                                        <div class="icon-box icon-box-bg-image-success">
                                            50k
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div>
                                            <h6 class="text-white">Secondary Open Balance</h6>
                                        </div>
                                        <div class="icon-box icon-box-bg-image-warning">
                                            60k
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <div>
                                            <h6 class="text-white">Patients Balance</h6>
                                        </div>
                                        <div class="icon-box icon-box-bg-image-info">
                                            10k
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-xl-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Revenue / Patient Type</h6>
                        <h6 class="card-description">12 months trending</h6>
                        <div class="">
                            <canvas id="traffic-chart" width="200" height="200"></canvas>
                            <!--<canvas id="piechart"></canvas>-->
                        </div>

                        <div id="traffic-chart-legend" class="chartjs-legend traffic-chart-legend mt-5"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Profit & Loss / Provider</h4>

                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-white">Avg Cost / Provider</h6>
                            </div>
                            <div class="icon-box">
                                50k
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-white">Avg Revenue / Provider </h6>
                            </div>
                            <div class="icon-box">
                                60k
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-white">Net Profit / Loss</h6>
                            </div>
                            <div class="icon-box">
                                10k
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-4 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" style="line-height: 25px;">Revenue Forecast Based on Patient Volume</h4>
                        <h6 class="card-description">12 months trending</h6>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-white">Avg Patients Inc / Dec</h6>
                            </div>
                            <div class="icon-box">
                                12%
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-white">Expected Encounters</h6>
                            </div>
                            <div class="icon-box">
                                250
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-white">Avg Revenue / Encounter</h6>
                            </div>
                            <div class="icon-box">
                                100
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="text-white">Expected Increase in Revenue</h6>
                            </div>
                            <div class="icon-box">
                                $25000
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-center text-sm-left d-block d-sm-inline-block">Copyright © {{date('Y')}} Nephrolytics, LLC. All rights reserved.</span>
            </div>
        </footer>
        <!-- partial -->
    </div>

@endsection