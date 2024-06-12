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
                        <h4 class="card-title">Patients Payment Report</h4>
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
                                            <th>Claim ID</th>
                                            <th>Patient Name</th>
                                            <th>DOS</th>
                                            <th>Reference</th>
                                            <th>Category</th>
                                            <th>Posting Date</th>
                                            <th>Payment Date</th>
                                            <th>Paid Amount</th>
                                            <th>Remarks</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="text-white">

                                            <td>


                                                 1
                                            </td>                 <td>


                                            2741
                                        </td>

                                            <td>

                                                patient 1

                                            </td>
                                            <td >3/13/2019</td>
                                            <td >**2664</td>
                                            <td >Patient Paid</td>
                                            <td >3/13/2020</td>
                                            <td >3/13/2019</td>
                                            <td >$20.00</td>
                                            <td >no remarks</td>
                                        </tr>

                                        <tr class="text-white">

                                            <td>


                                                2
                                            </td>                 <td>


                                            2742
                                        </td>

                                            <td>

                                                patient 1

                                            </td>
                                            <td >3/13/2019</td>
                                            <td >**2664</td>
                                            <td >Patient Paid</td>
                                            <td >3/13/2020</td>
                                            <td >3/13/2019</td>
                                            <td >$20.00</td>
                                            <td >no remarks</td>
                                        </tr>
                                        <tr class="text-white">

                                            <td>


                                                3
                                            </td>                 <td>


                                            2743
                                        </td>

                                            <td>

                                                patient 1

                                            </td>
                                            <td >3/13/2019</td>
                                            <td >**2664</td>
                                            <td >Patient Paid</td>
                                            <td >3/13/2020</td>
                                            <td >3/13/2019</td>
                                            <td >$20.00</td>
                                            <td >no remarks</td>
                                        </tr>
                                        <tr class="text-white">

                                            <td>


                                                4
                                            </td>                 <td>


                                            2744
                                        </td>

                                            <td>

                                                patient 1

                                            </td>
                                            <td >3/13/2019</td>
                                            <td >**2664</td>
                                            <td >Patient Paid</td>
                                            <td >3/13/2020</td>
                                            <td >3/13/2019</td>
                                            <td >$20.00</td>
                                            <td >no remarks</td>
                                        </tr>
                                        <tr class="text-white">

                                            <td>


                                                5
                                            </td>                 <td>


                                            2745
                                        </td>

                                            <td>

                                                patient 1

                                            </td>
                                            <td >3/13/2019</td>
                                            <td >**2664</td>
                                            <td >Patient Paid</td>
                                            <td >3/13/2020</td>
                                            <td >3/13/2019</td>
                                            <td >$20.00</td>
                                            <td >no remarks</td>
                                        </tr>
                                        <tr class="text-white">

                                            <td>


                                                6
                                            </td>                 <td>


                                            2746
                                        </td>

                                            <td>

                                                patient 1

                                            </td>
                                            <td >3/13/2019</td>
                                            <td >**2664</td>
                                            <td >Patient Paid</td>
                                            <td >3/13/2020</td>
                                            <td >3/13/2019</td>
                                            <td >$20.00</td>
                                            <td >no remarks</td>
                                        </tr>
                                        <tr class="text-white">

                                            <td>


                                                7
                                            </td>                 <td>


                                            2747
                                        </td>

                                            <td>

                                                patient 1

                                            </td>
                                            <td >3/13/2019</td>
                                            <td >**2664</td>
                                            <td >Patient Paid</td>
                                            <td >3/13/2020</td>
                                            <td >3/13/2019</td>
                                            <td >$20.00</td>
                                            <td >no remarks</td>
                                        </tr>
                                        <tr class="text-white">

                                            <td>


                                                8
                                            </td>                 <td>


                                            2748
                                        </td>

                                            <td>

                                                patient 1

                                            </td>
                                            <td >3/13/2019</td>
                                            <td >**2664</td>
                                            <td >Patient Paid</td>
                                            <td >3/13/2020</td>
                                            <td >3/13/2019</td>
                                            <td >$20.00</td>
                                            <td >no remarks</td>
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