@extends ('backend.layouts.dashboard')
@section('title', 'AR Analysis By Financial Class')
@section('content-new')
    <div class="content-wrapper">
        @include('backend.partials.stats')
        <div class="card">
            <div class="card-body">
                @include('backend.partials.financialReportsHeader')
                <div class="row">
                    <div class="col-12">
                        <form method="POST" class="formDatePickers" action="{{route('admin.ar-analysis-by-financial-class.store')}}">
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
                                    <th></th>
                                    <th>Prev A/R</th>
                                    <th>Charges <br>Charge %</th>
                                    <th>Payments<br> Profile%</th>
                                    <th>Refunds & Debits</th>
                                    <th>Adjust</th>
                                    <th>Trans-in</th>
                                    <th>Trans-out</th>
                                    <th>New A/R<br> #Days</th>
                                </tr>
                                </thead>
                                <tbody class="table-body">
                                @if(count($analysisInsurances)>0)
                                    @foreach($analysisInsurances as $analysisInsurance)
                                        <tr class="text-white">
                                            <td>{{!is_null($analysisInsurance->insuranceName)?$analysisInsurance->insuranceName:'-- -- --'}}</td>
                                            <td>{{prettyPrice(!is_null($analysisInsurance->prevAR)?$analysisInsurance->prevAR:0)}}</td>
                                            <td>{{prettyPrice(!is_null($analysisInsurance->charges)?$analysisInsurance->charges:0)}}
                                                <br>
                                                {{prettyPricePercent(!is_null($analysisInsurance->charges)?(truncate_number($analysisInsurance->charges/($chargeTotal > 0 ? $chargeTotal : 1)*100)):0)}}
                                            </td>
                                            <td>{{prettyPrice(!is_null($analysisInsurance->payments)?$analysisInsurance->payments:0)}}
                                                <br>
                                                {{prettyPricePercent(!is_null($analysisInsurance->payments)?(truncate_number($analysisInsurance->payments/($paymentTotal > 0 ? $paymentTotal : 1)*100)):0)}}
                                            </td>
                                            <td>{{prettyPrice(!is_null($analysisInsurance->refund)?$analysisInsurance->refund:0)}}</td>
                                            <td>{{prettyPrice(!is_null($analysisInsurance->adjustment)?$analysisInsurance->adjustment:0)}}</td>
                                            <td>{{prettyPrice(!is_null($analysisInsurance->trans_out)?$analysisInsurance->trans_out:0)}}</td>
                                            <td>{{prettyPrice(!is_null($analysisInsurance->trnas_in)?$analysisInsurance->trnas_in:0)}}</td>
                                            <td>{{prettyPrice(!is_null($analysisInsurance->newAR)?$analysisInsurance->newAR:0)}}</td>
                                        </tr>
                                    @endforeach

                                    <tr class="text-white">
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Grand Total</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisInsurances)->sum('prevAR'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(!is_null($chargeTotal)?$chargeTotal:0)}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(!is_null($paymentTotal)?$paymentTotal:0)}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisInsurances)->sum('refund'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisInsurances)->sum('adjustment'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisInsurances)->sum('trans_out'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisInsurances)->sum('trnas_in'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisInsurances)->sum('newAR'))}}</th>
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