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
                                    <h4 class="text-white mt-3 pl-2"  style="font-size: 24px;">800</h4>
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
                                    <h4 class="text-white mt-3 pl-2"  style="font-size: 24px;">176</h4>
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
                                    <h4 class="text-white mt-3 pl-2"  style="font-size: 24px;">400</h4>
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
                                    <h4 class="text-white mt-3 pl-2"  style="font-size: 24px;">250</h4>
                                    <!--<h6 class="text-muted">18.33% Since last month</h6>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Aging Summary</h4>
              <div class="row">
                <div class="col-12">
                    <div class="daterange-picker-input">
                        <input type="text"class="daterange form-control " /> <i class="fa fa-calendar" style="position: absolute;
                        right: 10px;
                        bottom: 10px; color:#bce0ea" aria-hidden="true"></i>
                    </div>
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                      <tr class="table-color">
                          <th></th>
                          <th class="table-height">Prev A/R</th>
                          <th class="table-height1">Charges <br>Charge %</th>
                          <th>Payments<br> Profile%</th>
                          <th>Refunds & Debits</th>
                          <th>Adjust</th>
                          <th>Trans-in</th>
                          <th>Trans-out</th>
                          <th>New A/R<br> #Days</th>
                      </tr>
                      </thead>
                        <tbody>
      <tr class="text-white">

          <td>


              Department Totals
          </td>                 <td>


                                259496.40
                            </td>

                           <td>

                               316699.00<br>100%

                            </td>
                            <td >183092.24<br>44%</td>
                            <td >0.00</td>
                            <td >231444.15</td>
                            <td >-8637.21</td>
                            <td >0.00</td>
                            <td >289396.87</td>
                        </tr>

      <tr class="text-white">
          <td>


              Grand Total
          </td>

          <td>


              259496.40
          </td>

          <td>

              316699.00<br>100%

          </td>
          <td >183092.24<br>44%</td>
          <td >0.00</td>
          <td >231444.15</td>
          <td >-8637.21</td>
          <td >0.00</td>
          <td >289396.87</td>
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