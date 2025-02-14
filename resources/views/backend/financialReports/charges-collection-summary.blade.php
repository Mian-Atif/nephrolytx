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
                        <h4 class="card-title">Charges & Detail Report</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="daterange-picker-input1">
                                <input type="text"class="daterange form-control " /> <i class="fa fa-calendar" style="position: absolute;
                                right: 10px;
                                bottom: 10px;color:#bce0ea" aria-hidden="true"></i>
                            </div>
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                        <thead>
                                        <tr class="table-color">
                                            <th>Month</th>
                                            <th>Povider Name</th>
                                            <th>Total Charges </th>
                                            <th>Total Collection</th>
                                            <th>Insurance Collection</th>
                                            <th>Patient Payments</th>
                                            <th>Adjustments</th>
                                            <th>Patients & Insurance Aging</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="text-white">

                                            <td rowspan="3">


                                                Jun-2019
                                            </td>


                                            <td >Provider 1</td>
                                            <td >$104,173.00</td>
                                            <td >$43,255.56</td>
                                            <td >40,409.59</td>
                                            <td >$2,845.97</td>
                                            <td >55,361.03</td>
                                            <td>

                                                $97,324.01

                                            </td>
                                        </tr>
                                        <tr class="text-white">




                                            <td >Provider 2</td>
                                            <td >$145,841.00</td>
                                            <td >$60,557.78</td>
                                            <td >$56,573.42</td>
                                            <td >$3,984.36</td>
                                            <td >$77,505.44</td>
                                            <td>

                                                $136,253.62

                                            </td>
                                        </tr>
                                        <tr class="text-white">




                                            <td >Provider 3</td>
                                            <td >$166,675.00</td>
                                            <td >$69,208.90</td>
                                            <td >$64,655.34</td>
                                            <td >$4,553.56</td>
                                            <td >$88,577.64</td>
                                            <td>$155,718.42</td>
                                        </tr>
                                        <tr class="text-white">

                                            <td  colspan="2">


                                                Total
                                            </td>



                                            <td >$526,689.00</td>
                                            <td >$283,022.24</td>
                                            <td >$271,638.35</td>
                                            <td >$19,383.89</td>
                                            <td >$351,444.11</td>
                                            <td>$289,396.05</td>
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