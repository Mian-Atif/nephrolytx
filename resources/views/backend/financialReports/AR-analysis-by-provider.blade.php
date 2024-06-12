@extends ('backend.layouts.dashboard')
@section('content-new')
    <div class="content-wrapper">
        @include('backend.partials.stats')
        <div class="card">
            <div class="card-body">
                <h3 class="table-color text-center" style="font-weight: 600;">Analysis Report by Provider</h3>
                <h3 class="table-color text-center"
                    style="font-weight: 600;">{{!is_null(Auth::user()->practice)?Auth::user()->practice->name:''}}</h3>
                <h3 class="table-color text-center"
                    style="font-weight: 600;">{{\Carbon\Carbon::parse($currentMonth)->format('m/d/Y')}}-
                    {{\Carbon\Carbon::parse($currentDate)->format('m/d/Y')}}</h3>
                <div class="row">
                    <div class="col-12">
                        <form method="POST" enctype="multipart/form-data" id="formDatePicker"
                              action="{{route('admin.ar-analysis-by-provider.store')}}">
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
                                @if(count($analysisProviders)>0)
                                    @foreach($analysisProviders as $analysisProvider)
                                        <tr class="text-white">

                                            <td>
                                                {{!is_null($analysisProvider->providerName)?$analysisProvider->providerName:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{prettyPrice(!is_null($analysisProvider->prevAR)?$analysisProvider->prevAR:0)}}
                                            </td>
                                            <td>
                                                {{prettyPrice(!is_null($analysisProvider->charges)?$analysisProvider->charges:0)}}
                                                <br>
                                            {{prettyPricePercent(!is_null($analysisProvider->charges)?(truncate_number($analysisProvider->charges/($chargeTotal > 0 ? $chargeTotal : 1)*100)):0)}}
                                            </td>
                                            <td>{{prettyPrice(!is_null($analysisProvider->payments)?$analysisProvider->payments:0)}}
                                                <br>
                                                {{prettyPricePercent(!is_null($analysisProvider->payments)?(truncate_number($analysisProvider->payments/($paymentTotal > 0 ? $paymentTotal : 1)*100)):0)}}
                                            </td>
                                            <td>{{prettyPrice(!is_null($analysisProvider->refund)?$analysisProvider->refund:0)}}</td>
                                            <td>{{prettyPrice(!is_null($analysisProvider->adjustment)?$analysisProvider->adjustment:0)}}</td>
                                            <td>{{prettyPrice(!is_null($analysisProvider->trans_out)?$analysisProvider->trans_out:0)}}</td>
                                            <td>{{prettyPrice(!is_null($analysisProvider->trnas_in)?$analysisProvider->trnas_in:0)}}</td>
                                            <td>{{prettyPrice(!is_null($analysisProvider->newAR)?$analysisProvider->newAR:0)}}</td>

                                        </tr>
                                    @endforeach
                                    <tr class="text-white">
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Grand Total</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisProviders)->sum('prevAR'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPrice(collect($analysisProviders)->sum('charges'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisProviders)->sum('payments'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisProviders)->sum('refund'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisProviders)->sum('adjustment'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisProviders)->sum('trans_out'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisProviders)->sum('trnas_in'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisProviders)->sum('newAR'))}}</th>

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