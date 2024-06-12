@extends ('backend.layouts.dashboard')
@section('content-new')
<div class="content-wrapper">
            <div class="row no-gutters">
                <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h4 class="text-purple pt-1 active-patients">Active Patients</h4>
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
                                    <h4 class="text-purple pt-1 new-patients">New Patients</h4>
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
                                    <h4 class="text-purple pt-1 ckd-patients">CKD Patients</h4>
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
                                    <h4 class="text-purple pt-1 esrd-patients">ESRD Patients</h4>
                                    <h4 class="text-white mt-3 pl-2" style="font-size: 24px;">250</h4>
                                    <!--<h6 class="text-muted">18.33% Since last month</h6>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Check Reconciliation Report</h4>
                    <div class="row">
                        <div class="col-12">
                            <div class="daterange-picker-input">
                            <input type="text"class="daterange form-control " /> <i class="fa fa-calendar" style="position: absolute;
                            right: 10px;
                            bottom: 10px;color:#bce0ea" aria-hidden="true"></i>
                        </div>
                            <div class="table-responsive">
                                <table id="order-listing" class="table">
                                    <thead>
                                    <tr class="table-color">
                                        <th>Sr.</th>
                                        <th>Insurance</th>
                                        <th>Check No</th>
                                        <th>Check Date</th>
                                        <th>Check Amt</th>
                                        <th>Posted Amt</th>
                                        <th>Remarks</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr class="text-white">

                                        <td>


                                            1
                                        </td>

                                        <td>

                                            Medicare

                                        </td>
                                        <td >000000000</td>
                                        <td >3/2/2020</td>
                                        <td >$733.13 </td>
                                        <td >$733.13</td>
                                        <td > </td>

                                    </tr>
                                    <tr class="text-white">

                                        <td>


                                            2
                                        </td>

                                        <td>

                                            Blue Cross

                                        </td>
                                        <td >000000000</td>
                                        <td >3/2/2020</td>
                                        <td >$733.13 </td>
                                        <td >$733.13</td>
                                        <td ></td>

                                    </tr>
                                    <tr class="text-white">

                                        <td>


                                            3
                                        </td>

                                        <td>

                                            Aetna Health Plan

                                        </td>
                                        <td >000000000</td>
                                        <td >3/2/2020</td>
                                        <td >$733.13 </td>
                                        <td >$733.13</td>
                                        <td ></td>

                                    </tr>
                                    <tr class="text-white">

                                        <td>


                                            4
                                        </td>

                                        <td>

                                            Tricare for Life

                                        </td>
                                        <td >000000000</td>
                                        <td >3/2/2020</td>
                                        <td >$733.13 </td>
                                        <td >$733.13</td>
                                        <td ></td>

                                    </tr>
                                    <tr class="text-white">

                                        <td>


                                            5
                                        </td>

                                        <td>

                                            Colonial Life Penn

                                        </td>
                                        <td >000000000</td>
                                        <td >3/2/2020</td>
                                        <td >$733.13 </td>
                                        <td >$733.13</td>
                                        <td ></td>

                                    </tr>
                                    <tr class="text-white">

                                        <td>


                                            6
                                        </td>

                                        <td>

                                            Allied Benefits System Inc

                                        </td>
                                        <td >000000000</td>
                                        <td >3/2/2020</td>
                                        <td >$733.13 </td>
                                        <td >$733.13</td>
                                        <td ></td>

                                    </tr>
                                    <tr class="text-white">

                                        <td>


                                            7
                                        </td>

                                        <td>

                                            Select Health

                                        </td>
                                        <td >000000000</td>
                                        <td >3/2/2020</td>
                                        <td >$733.13 </td>
                                        <td >$733.13</td>
                                        <td ></td>

                                    </tr>
                                    <tr class="text-white">

                                        <td>


                                            8
                                        </td>

                                        <td>

                                            Wausau

                                        </td>
                                        <td >000000000</td>
                                        <td >3/2/2020</td>
                                        <td >$733.13 </td>
                                        <td >$733.13</td>
                                        <td ></td>

                                    </tr>
                                    <tr class="text-white">

                                        <td>


                                            9
                                        </td>

                                        <td>

                                            Cigna

                                        </td>
                                        <td >000000000</td>
                                        <td >3/2/2020</td>
                                        <td >$733.13 </td>
                                        <td >$733.13</td>
                                        <td ></td>

                                    </tr>



                                    </tbody>


                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
@endsection