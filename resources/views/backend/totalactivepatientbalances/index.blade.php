@extends ('backend.layouts.dashboard')
@section('title', 'Charges & Payments Analysis')
@section('after-styles')
{{--  {{ Html::style(asset('datatables/bootstrap.min.css')) }}--}}
{{--    {{ Html::style(asset('datatables/dataTables.bootstrap.min.css')) }}--}}
{{--    {{ Html::style(asset('datatables/buttons.bootstrap.min.css')) }}--}}
    <style>
        .dt-buttons {
            display: none;
        }
        .month-heading{
            font-weight: bold !important;
        }

        .fixed-nav {
            position: fixed;
            top: 0;
            left: 286px;
            width: 76%;
            z-index: 999;
            box-shadow: 0 0px 0 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
        }

        .fixed-nav .grid-margin{
            margin: 0;
        }

    </style>
@endsection

@section('content-new')
    <div class="content-wrapper">
        @include('backend.partials.stats')
        {{Form::open(['route' => 'admin.charge-payment-analysis.store', 'class' => 'form', 'role' => 'form', 'method' => 'post','id'=>'searchFilter'])}}
        @include('widgets.search_filter')

        {{Form::close()}}
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Charges & Payments Analysis</h4>
                <div class="row">
                    <div class="col-12">
                        {{--  <div class="daterange-picker-input1">
                              <input type="text" class="daterange form-control "/> <i class="fa fa-calendar calnedar-icon"aria-hidden="true"></i>
                          </div>--}}
                    @include('backend.partials.exportReportDropdown')
                        <div class="table-responsive tableFixHead">
                            <div id="buttons"></div>
                                  <table id="order-listing" class="table">
                                      <thead>
                                      <tr class="table-color" >
                                          <th class="month-heading">Month</th>
                                          <th class="month-heading">No Of Claims</th>
                                          <th class="table-height month-heading">Charge Amount</th>
                                          <th class="table-height1 month-heading">Actual <br> Collection</th>
                                          <th class="table-height1 month-heading">Projected <br> Collection</th>
                                          <th class="table-height1 month-heading">Variance</th>
                                          <th class="table-height1 month-heading">Collection <br> %age</th>
                                          <th class="table-height1 month-heading">Contractual <br>Adj.</th>
                                      </tr>
                                      </thead>

                                      <tbody class="table-body">
                                      @php
                                          $totalCount= count($analysisReports);
                                          $clamsTotal = 0;
                                          $totalChargeAmount = 0;
                                          $actualCollection = 0;
                                          $projectCollection= 0;
                                          $totalVarience = 0;
                                          $collectionPercentage = 0;
                                          $totalContractualAdj = 0;
                                      @endphp
                                      @if(count($analysisReports) > 0)
                                          @foreach($analysisReports as $analysisReport)
                                              @php
                                                  $clamsTotal += !is_null($analysisReport->No_Of_Claims)?truncate_number($analysisReport->No_Of_Claims):0.00;
                                                  $totalChargeAmount += !is_null($analysisReport->Total_Charges_Amount)?truncate_number($analysisReport->Total_Charges_Amount):0.00;
                                                  $actualCollection += !is_null($analysisReport->Actual_Collection)?truncate_number($analysisReport->Actual_Collection):0.00;
                                                  $projectCollection+= !is_null($analysisReport->Projected_Collection)?truncate_number($analysisReport->Projected_Collection):0.00;
                                                  $totalVarience += !is_null($analysisReport->Varience)?truncate_number($analysisReport->Varience):0.00;
                                                  $collectionPercentage += !is_null($analysisReport->Collection_age)?truncate_number($analysisReport->Collection_age):0.00;
                                                  $totalContractualAdj += !is_null($analysisReport->Contractual_Adj)?truncate_number($analysisReport->Contractual_Adj):0.00;
                                              @endphp
                                              <tr class="text-white">

                                                  <td>
                                                      {{!is_null($analysisReport->MONTH)?$analysisReport->MONTH:'-- -- --'}}
                                                  </td>
                                                  <td>
                                                      {{!is_null($analysisReport->No_Of_Claims)?truncate_number($analysisReport->No_Of_Claims):0.00}}

                                                  </td>
                                                  <td>
                                                      {{!is_null($analysisReport->Total_Charges_Amount)?prettyPrice($analysisReport->Total_Charges_Amount):0.00}}
                                                  </td>
                                                  <td>
                                                      {{!is_null($analysisReport->Actual_Collection)?prettyPrice($analysisReport->Actual_Collection):0.00}}
                                                  </td>
                                                  <td>
                                                      {{!is_null($analysisReport->Projected_Collection)?prettyPrice($analysisReport->Projected_Collection):0.00}}

                                                  </td>
                                                  <td>
                                                      {{!is_null($analysisReport->Varience)?prettyPrice($analysisReport->Varience):0.00}}
                                                  </td>
                                                  <td>
                                                      {{!is_null($analysisReport->Collection_age)?truncate_number($analysisReport->Collection_age):0.00}}
                                                  </td>
                                                  <td>
                                                      {{!is_null($analysisReport->Contractual_Adj)?prettyPrice($analysisReport->Contractual_Adj):0.00}}
                                                  </td>
                                              </tr>

                                          @endforeach
                                          <tr class="text-white" style="font-weight: bold;">
                                              <td>
                                                  Total
                                              </td>
                                              <td>
                                                  {{$clamsTotal}}

                                              </td>
                                              <td>
                                                  {{prettyPrice($totalChargeAmount)}}
                                              </td>
                                              <td>
                                                  {{prettyPrice($actualCollection)}}

                                              </td>
                                              <td>
                                                  {{prettyPrice($projectCollection)}}
                                              </td>
                                              <td>
                                                  {{prettyPrice($totalVarience)}}
                                              </td>
                                              <td>
                                                  -- -- --
                                              </td>

                                              <td>
                                                  {{prettyPrice($totalContractualAdj)}}
                                              </td>
                                          </tr>
                                          <tr class="text-white" style="font-weight: bold;">
                                              <td>
                                                  Average
                                              </td>
                                              <td>
                                                  {{truncate_number($clamsTotal/ $totalCount)}}

                                              </td>
                                              <td>
                                                  {{prettyPrice($totalChargeAmount/$totalCount)}}
                                              </td>
                                              <td>
                                                  {{prettyPrice($actualCollection/$totalCount)}}

                                              </td>
                                              <td>
                                                  {{prettyPrice($projectCollection/$totalCount)}}
                                              </td>
                                              <td>
                                                  {{prettyPrice($totalVarience/$totalCount)}}
                                              </td>
                                              <td>
                                                  {{truncate_number($collectionPercentage/$totalCount)}}
                                              </td>

                                              <td>
                                                  {{prettyPrice($totalContractualAdj/$totalCount)}}
                                              </td>

                                          </tr>
                                      @endif
                                      </tbody>
                                  </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('after-scripts')

{{--    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>--}}
{{--{{ Html::script('datatables/jQuey v1.11.3.js') }}--}}
{{--<!-- {{ Html::script('datatables/jquery.dataTables.min.js') }} -->--}}
{{--{{ Html::script('datatables/dataTables.bootstrap.min.js') }}--}}
{{--{{ Html::script('datatables/dataTables.buttons.min.js') }}
{{ Html::script('datatables/buttons.bootstrap.min.js') }}
{{ Html::script('datatables/jszip.min.js') }}
{{ Html::script('datatables/buttons.html5.min.js') }}
{{ Html::script('datatables/jszip.min.js') }}
{{ Html::script('datatables/pdfmake.min.js') }}
{{ Html::script('datatables/buttons.print.min.js') }}
{{ Html::script('datatables/vfs_font.js') }}--}}

{{--<script src="jQuey v1.11.3.js"></script>--}}
{{--<script src="jquery.dataTables.min.js"></script>--}}
{{--<script src="dataTables.bootstrap.min.js"></script>
<script src="dataTables.buttons.min.js"></script>
<script src="buttons.bootstrap.min.js"></script>
<script src="buttons.html5.min.js"></script>
<script src="jszip.min.js"></script>
<script src="pdfmake.min.js"></script>
<script src="buttons.print.min.js"></script>--}}
<script>
  /*  function initFilterDataTable() {
        var table = $('#example').DataTable();

        var buttons = new $.fn.dataTable.Buttons(table, {
            buttons:
                [
                    {extend: 'copy', className: 'copyButton', exportOptions: {columns: [0, 1,3,4,5]}},
                    {extend: 'csv', className: 'csvButton', exportOptions: {columns: [0, 1,2,3,4,5]}},
                    {extend: 'excel', className: 'excelButton', exportOptions: {columns: [0, 1,2,3,4,5]}},
                    {extend: 'pdf', className: 'pdfButton', exportOptions: {columns: [0, 1,2,3,4,5]}},
                    {extend: 'print', className: 'printButton', exportOptions: {columns: [0, 1,2,3,4,5]}}
                ]
            /!* [
             'copyHtml5',
             'excelHtml5',
             'csvHtml5',
             'pdfHtml5'
             ]*!/
        }).container().appendTo($('#buttons'));


        (function (table) {


            //Copy button
            $('#copyButton').click(function () {
                $('.copyButton').trigger('click');
            });
            //Download csv
            $('#csvButton').click(function () {
                $('.csvButton').trigger('click');
            });
            //Download excelButton
            $('#excelButton').click(function () {
                $('.excelButton').trigger('click');
            });
            //Download pdf
            $('#pdfButton').click(function () {
                $('.pdfButton').trigger('click');
            });
            //Download printButton
            $('#printButton').click(function () {
                $('.printButton').trigger('click');
            });


        }(table));
    }

    initFilterDataTable();*/
</script>

<script>
    $(window).scroll(function(){
        if ($(window).scrollTop() >= 100) {
            $('.sticky_bar').addClass('fixed-nav');
        }
        else {
            $('.sticky_bar').removeClass('fixed-nav');
        }
    });
    </script>
@endsection