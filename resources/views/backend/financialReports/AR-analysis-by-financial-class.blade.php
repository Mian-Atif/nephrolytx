@extends ('backend.layouts.dashboard')
@section('content-new')
    <div class="content-wrapper">
        @include('backend.partials.stats')
        <div class="card">
            <div class="card-body">
                <h3 class="table-color text-center" style="font-weight: 600;">Analysis By Insurance</h3>
                <h3 class="table-color text-center"
                    style="font-weight: 600;">{{!is_null(Auth::user()->practice)?Auth::user()->practice->name:''}}</h3>
                <h3 class="table-color text-center"
                    style="font-weight: 600;">{{\Carbon\Carbon::parse($currentMonth)->format('m/d/Y')}}-
                    {{\Carbon\Carbon::parse($currentDate)->format('m/d/Y')}}</h3>
                <div class="row">
                    <div class="col-12">
                        <form method="POST" enctype="multipart/form-data" id="formDatePicker"
                              action="{{route('admin.ar-analysis-by-financial-class.store')}}">
                            @csrf
                            <div class="daterange-picker-input1">
                                <input type="text" class="form-control" name="datefilter" value=""/>
                                <input type="hidden" name="dateStartfilter" value=""/>
                                <input type="hidden" name="dateEndfilter" value=""/>

                                <i class="fa fa-calendar calnedar-icon" aria-hidden="true"></i>
                            </div>
                        </form>

                        <div class="table-responsive">
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
                                <tbody>
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