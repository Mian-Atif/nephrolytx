@extends ('backend.layouts.dashboard')
@section('content-new')
<div class="content-wrapper">
    <div class="row no-gutters">
        <div class="col-12 col-sm-6 col-xl-3 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="pt-1 text-purple active-patients">Active Patients</h4>
                            <h4 class="text-white mt-3 pl-2" style="font-size: 24px;">800</h4>
                            <!--<h6 class="text-muted">35.19% Since last month</h6>-->
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
                            <h4 class="pt-1 text-purple new-patients">New Patients</h4>
                            <h4 class="text-white mt-3 pl-2" style="font-size: 24px;">176</h4>
                            <!--<h6 class="text-muted">73.52% Since last month</h6>-->
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
                            <h4 class="pt-1 text-purple ckd-patients">CKD Patients</h4>
                            <h4 class="text-white mt-3 pl-2" style="font-size: 24px;">400</h4>
                            <!--<h6 class="text-muted">49.39% Since last month</h6>-->
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
                            <h4 class="pt-1 text-purple esrd-patients">ESRD Patients</h4>
                            <h4 class="text-white mt-3 pl-2" style="font-size: 24px;">250</h4>
                            <!--<h6 class="text-muted">18.33% Since last month</h6>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection