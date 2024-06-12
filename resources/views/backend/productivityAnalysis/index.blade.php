@extends ('backend.layouts.dashboard')
@section('title', 'Productivity Analysis')
@section('after-styles')
    <style>
        .month-heading {
            font-weight: bold !important;
        }

        .fixed-nav {
            position: fixed;
            top: 0;
            left: 286px;
            width: 76%;
            z-index: 999;
            box-shadow: 0 0px 0 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        }

        .fixed-nav .grid-margin {
            margin: 0;
        }
    </style>
@endsection
@section('content-new')
    <div class="content-wrapper">
        @include('backend.partials.stats')

        <div class="card">
            <div class="card-body">
                @include('backend.partials.financialReportsHeader')
                <div class="row">
                    <div class="col-12">
                        <form method="POST" class="formDatePickers" action="{{route('admin.productivity-analysis.store')}}">
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
                        <div class="table-responsive">
                            <div id="buttons"></div>

                            <table id="order-listing" class="table">
                                <thead>
                                <tr class="table-color">
                                    <th></th>
                                    <th>Units</th>
                                    <th>Total RVU</th>
                                    <th>Charge</th>
                                    <th>Chg %</th>
                                    <th>Payments</th>
                                    <th>Prof%</th>
                                    <th>Refunds & Debit</th>
                                    <th>Adjust</th>
                                    <th>Transf. In/Ou</th>
                                    <th>Net</th>

                                </tr>
                                </thead>
                                <tbody class="table-body">

                                @if(count($productivityAnalysis)>0)
                                    @foreach($productivityAnalysis as $key=> $productivity)
                                        @if($key)
                                            <tr>
                                                <th class="text-white">{{ $key }}</th>
                                                <th class="text-white"></th>
                                                <th class="text-white"></th>
                                                <th class="text-white"></th>
                                                <th class="text-white"></th>
                                                <th class="text-white"></th>
                                                <th class="text-white"></th>
                                                <th class="text-white"></th>
                                                <th class="text-white"></th>
                                                <th class="text-white"></th>
                                                <th class="text-white"></th>
{{--                                                <th class="text-white"></th>--}}
                                            </tr>
                                        @endif
                                        @foreach($productivity as $row)
                                            <tr class="text-white">

                                                <td>
                                                    {{!is_null($row->Service_Location)?$row->Service_Location:'-- -- --'}}
                                                </td>
                                                <td>
                                                    {{normalPrettyPrice2(!is_null($row->units)?$row->units:0)}}
                                                </td>
                                                <td>
                                                    {{normalPrettyPrice2(!is_null($row->rvus)?$row->rvus:0)}}
                                                </td>
                                                <td>
                                                    {{prettyPrice(!is_null($row->charges)?$row->charges:0)}}
                                                </td>
                                                <td>
                                                    {{prettyPricePercent(!is_null($row->charges)?(truncate_number($row->charges/($chargeTotal > 0 ? $chargeTotal : 1)*100)):0)}}
                                                </td>
                                                <td>
                                                    {{prettyPrice(!is_null($row->payments)?$row->payments:0)}}
                                                </td>
                                                <td>
                                                    {{prettyPricePercent(!is_null($row->payments)?(truncate_number($row->payments/($paymentTotal > 0 ? $paymentTotal : 1)*100)):0)}}</td>
                                                <td>
                                                    {{prettyPrice(!is_null($row->refunds)?$row->refunds:0)}}
                                                </td>
                                                <td>
                                                    {{prettyPrice(!is_null($row->adjustment)?$row->adjustment:0)}}
                                                </td>
                                                <td>
                                                    {{prettyPrice(!is_null($row->transOouIn)?$row->transOouIn:0)}}
                                                </td>
                                                <td>
                                                    {{prettyPrice(!is_null($row->net)?$row->net:0)}}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="text-white">
{{--                                            @if($key)--}}
                                                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Total For {{ $key }}</th>
{{--                                            @endif--}}
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{normalPrettyPrice2($productivity->sum('units'))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2($productivity->sum('rvus'))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPrice($productivity->sum('charges'))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPricePercent(truncate_number($productivity->sum('charges')/($chargeTotal > 0 ? $chargeTotal : 1)*100))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPrice($productivity->sum('payments'))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPricePercent(truncate_number($productivity->sum('payments')/($paymentTotal > 0 ? $paymentTotal : 1)*100))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">  {{prettyPrice($productivity->sum('refunds'))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">  {{prettyPrice($productivity->sum('adjustment'))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">  {{prettyPrice($productivity->sum('transOouIn'))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">  {{prettyPrice($productivity->sum('net'))}}</th>
                                        </tr>
                                    @endforeach
                                    <tr class="text-white">
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Grand Total</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{normalPrettyPrice2(collect($productivities)->sum('units'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($productivities)->sum('rvus'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPrice(collect($productivities)->sum('charges'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPricePercent(truncate_number(collect($productivities)->sum('charges')/($chargeTotal > 0 ? $chargeTotal : 1)*100))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPrice(collect($productivities)->sum('payments'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPricePercent(truncate_number(collect($productivities)->sum('payments')/($paymentTotal > 0 ? $paymentTotal : 1)*100))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">  {{prettyPrice(collect($productivities)->sum('refunds'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">  {{prettyPrice(collect($productivities)->sum('adjustment'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">  {{prettyPrice(collect($productivities)->sum('transOouIn'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">  {{prettyPrice(collect($productivities)->sum('net'))}}</th>
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