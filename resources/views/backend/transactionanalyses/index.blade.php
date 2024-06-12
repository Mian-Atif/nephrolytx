@extends ('backend.layouts.dashboard')
@section('title', 'Transaction Analysis')
@section('after-styles')
    <style>
       /* body .formDatePickers .table-condensed  th, body  .formDatePickers .table-condensed  td{
            padding: 7px 8px !important;
        }*/
       body .table-condensed  th, body .table-condensed  td{
           padding: 7px 8px !important;
       }
</style>
@endsection
@section('content-new')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body card-section">
               @include('backend.partials.financialReportsHeader')

                <div class="row">
                    <div class="col-12">
                        <form method="POST" class="formDatePickers" action="{{route('admin.transaction-analysis.store')}}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-3"> <!-- Date input -->
                                    <label class="control-label" for="date">Start Date</label>
                                    <input class="form-control date startDate" id="datetimepicker1" name="dateStartfilter" placeholder="MM/DD/YYY" type="text"/>
                                </div>
                                <div class="form-group col-sm-3"> <!-- Date input -->
                                    <label class="control-label" for="date">End Date</label>
                                    <input class="form-control date endDate" id="datetimepicker2" name="dateEndfilter" placeholder="MM/DD/YYY" type="text"/>
                                </div>

                                <div class="form-group col-sm-3"> <!-- Date input -->
                                    {{--                                    <label class="control-label" for="date">Submit</label><br>--}}
                                    <button type="submit" class="btn btn-primary" style="margin-top: 30px;">Submit</button>
                                </div>
                            </div>
                        </form>
                        @include('backend.partials.exportReportDropdown')

                        <div class="table-responsive tableFixHead">
                            <div id="buttons"></div>

                            <table id="order-listing" class="table">
                                <thead>
                                <tr class="table-color">
                                    <th>Billing Provider</th>
                                    <th>Transaction Abbrev</th>
                                    <th>Transaction Description</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody class="table-body">
                                @if(count($transactionAnalyses) > 0)
                                    @foreach($transactionAnalyses as $m => $service)
                                        @if(count($service) > 0)
                                            @php
                                                $insuranceGroup=$service->groupBy('Insurance_Adjustment');
                                            @endphp
                                            @if($m)
                                                <th class="text-white">{{ $m }}</th>
                                            @endif
                                            @foreach($insuranceGroup as $ks => $rows)

                                                @foreach($rows as $k => $row)
                                                    <tr class="text-white">

                                                        <td></td>
                                                        <td>{{!is_null($row->Primary_Insurance_Name)?$row->Primary_Insurance_Name:'-- -- --'}}</td>
                                                        <td>{{!is_null($row->Insurance_Adjustment)?$row->Insurance_Adjustment:'-- -- --'}}</td>
                                                        <td>{{!is_null($row->amount)?prettyPrice($row->amount):'-- -- --'}}</td>

                                                    </tr>
                                                @endforeach
                                                @if($k == count($rows) - 1)
                                                    <tr class="text-white">
                                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>
                                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{$ks}}</th>
                                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>
                                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice($rows->sum('amount'))}}</th>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            <tr class="text-white">
                                                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>
                                                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">
                                                    Total for Billing Provider : {{$m}}</th>
                                                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>
                                                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice($service->sum('amount'))}}</th>
                                            </tr>
                                        @endif

                                    @endforeach
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

{{--
@section('before-scripts')

@endsection--}}
