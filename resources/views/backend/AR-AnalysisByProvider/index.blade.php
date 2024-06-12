@extends ('backend.layouts.dashboard')
@section('title', 'AR Analysis by Provider')
@section('content-new')
    <div class="content-wrapper">
        @include('backend.partials.stats')
        <div class="card">
            <div class="card-body">
                @include('backend.partials.financialReportsHeader')
                <div class="row">
                    <div class="col-12">

                        <form method="POST" class="formDatePickers" action="{{route('admin.ar-analysis-by-provider.store')}}">
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

                        <div class="table-responsive">
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