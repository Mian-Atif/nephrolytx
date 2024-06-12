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
                        <h4 class="card-title">Transaction Analysis Report</h4>
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
                                            <th></th>
                                            <th>Transaction Abbrev</th>
                                            <th>Transaction Description</th>
                                            <th>Amount</th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="text-white">

                                            <td>


                                                Provider 1
                                            </td>
                                            <td>



                                            </td>
                                            <td>



                                            </td>
                                            <td>



                                            </td>


                                        </tr>

                                        <tr class="text-white">

                                            <td>
                                            </td>
                                            <td>
                                                Medicaid of ID


                                            </td>
                                            <td>

                                                 Insurance Adjustment

                                            </td>
                                            <td>
                                                347.90


                                            </td>


                                        </tr>
                                        <tr class="text-white">

                                            <td>
                                            </td>
                                            <td>
                                                Medicare of Idaho


                                            </td>
                                            <td>

                                                Insurance Adjustment

                                            </td>
                                            <td>
                                                347.90


                                            </td>


                                        </tr>
                                        <tr class="text-white">

                                            <td>
                                            </td>
                                            <td>
                                                Molina Healthcare of Idaho


                                            </td>
                                            <td>

                                                Insurance Adjustment

                                            </td>
                                            <td>
                                                347.90


                                            </td>


                                        </tr>
                                        <tr class="text-white">

                                            <td>
                                            </td>
                                            <td>
                                                PacificSource Health Plan


                                            </td>
                                            <td>

                                                Insurance Adjustment

                                            </td>
                                            <td>
                                                347.90


                                            </td>


                                        </tr>
                                        <tr class="text-white">

                                            <td>
                                            </td>
                                            <td>
                                                University of Utah Health Plans


                                            </td>
                                            <td>

                                                Insurance Adjustment

                                            </td>
                                            <td>
                                                347.90


                                            </td>


                                        </tr>
                                        <tr class="text-white">

                                            <td>
                                            </td>
                                            <td>
                                                Insurance Adjustment


                                            </td>
                                            <td>



                                            </td>
                                            <td>
                                               1739.50


                                            </td>


                                        </tr>
                                        <tr class="text-white">

                                            <td>
                                            </td>
                                            <td>
                                                AARP Medicare Supplemen


                                            </td>
                                            <td>

                                                 Insurance Paid

                                            </td>
                                            <td>
                                                336.14


                                            </td>


                                        </tr>

                                        <tr class="text-white">

                                            <td>
                                            </td>
                                            <td>
                                                Bankers Life & Casualty


                                            </td>
                                            <td>

                                                Insurance Paid

                                            </td>
                                            <td>
                                                336.14


                                            </td>


                                        </tr>
                                        <tr class="text-white">

                                            <td>
                                            </td>
                                            <td>
                                                Medicaid of ID


                                            </td>
                                            <td>

                                                Insurance Paid

                                            </td>
                                            <td>
                                                336.14


                                            </td>


                                        </tr>
                                        <tr class="text-white">

                                            <td>
                                            </td>
                                            <td>
                                                Medicare of Idah


                                            </td>
                                            <td>

                                                Insurance Paid

                                            </td>
                                            <td>
                                                336.14


                                            </td>


                                        </tr>
                                        <tr class="text-white">

                                            <td>
                                            </td>
                                            <td>
                                                Insurance Paid Totals


                                            </td>
                                            <td>

                                                Insurance Paid

                                            </td>
                                            <td>
                                                1344.56


                                            </td>


                                        </tr>

                                        <tr class="text-white">

                                            <td>
                                            </td>
                                            <td>
                                               Patient


                                            </td>
                                            <td>

                                                Patient Paid

                                            </td>
                                            <td>
                                                70.14


                                            </td>


                                        </tr>
                                        <tr class="text-white">

                                            <td>
                                            </td>
                                            <td>
                                                Patient Paid Totals


                                            </td>
                                            <td>



                                            </td>
                                            <td>
                                                70.14


                                            </td>


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