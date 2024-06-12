@extends ('backend.layouts.dashboard')
@section('content-new')
    <div class="content-wrapper">
        @include('backend.partials.stats')

        <div class="card">
            <div class="card-body">
                <h3 class="table-color text-center" style="font-weight: 600;">Analysis Report by Location</h3>
                <h3 class="table-color text-center"
                    style="font-weight: 600;">{{!is_null(Auth::user()->practice)?Auth::user()->practice->name:''}}</h3>
                <h3 class="table-color text-center"
                    style="font-weight: 600;">{{\Carbon\Carbon::parse($currentMonth)->format('m/d/Y')}}-
                    {{\Carbon\Carbon::parse($currentDate)->format('m/d/Y')}}</h3>
                <div class="row">
                    <div class="col-12">
                        <form method="POST" class="formDatePickers" action="{{route('admin.ar-analysis-by-location.store')}}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-3"> <!-- Date input -->
                                    <label class="control-label" for="date">Start Date</label>
                                    <input class="form-control date startDate" id="datetimepicker1" name="date" placeholder="MM/DD/YYY" type="text"/>
                                </div>
                                <div class="form-group col-sm-3"> <!-- Date input -->
                                    <label class="control-label" for="date">End Date</label>
                                    <input class="form-control date endDate" id="datetimepicker2" name="date" placeholder="MM/DD/YYY" type="text"/>
                                </div>

                                <div class="form-group col-sm-3"> <!-- Date input -->
                                    <label class="control-label" for="date">Submit</label><br>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
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
                                    <th>Trans-Out</th>
                                    <th>Trans-In</th>
                                    <th>New A/R<br> #Days</th>
                                </tr>
                                </thead>
                                <tbody class="table-body">
                                @if(count($analysisLocations)>0)
                                    @foreach($analysisLocations as $analysisLocation )
                                        <tr class="text-white">
                                            <td>
                                                {{!is_null($analysisLocation->locationName)?$analysisLocation->locationName:'-- -- --'}}</td>
                                            <td>{{prettyPrice(!is_null($analysisLocation->prevAR)?$analysisLocation->prevAR:0)}}</td>
                                            <td>{{prettyPrice(!is_null($analysisLocation->charges)?$analysisLocation->charges:0)}}
                                                <br>
                                                {{prettyPricePercent(!is_null($analysisLocation->charges)?(truncate_number($analysisLocation->charges/($chargeTotal > 0 ? $chargeTotal : 1)*100)):0)}}
                                            </td>
                                            <td>{{prettyPrice(!is_null($analysisLocation->payments)?$analysisLocation->payments:0)}}
                                                <br>
                                                {{prettyPricePercent(!is_null($analysisLocation->payments)?(truncate_number($analysisLocation->payments/($paymentTotal > 0 ? $paymentTotal : 1)*100)):0)}}
                                            </td>
                                            <td>{{prettyPrice(!is_null($analysisLocation->refund)?$analysisLocation->refund:0)}}</td>
                                            <td>{{prettyPrice(!is_null($analysisLocation->adjustment)?$analysisLocation->adjustment:0)}}</td>
                                            <td>{{prettyPrice(!is_null($analysisLocation->trans_out)?$analysisLocation->trans_out:0)}}</td>
                                            <td>{{prettyPrice(!is_null($analysisLocation->trnas_in)?$analysisLocation->trnas_in:0)}}</td>
                                            <td>{{prettyPrice(!is_null($analysisLocation->newAR)?$analysisLocation->newAR:0)}}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="text-white">
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Grand Total</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisLocations)->sum('prevAR'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPrice(collect($analysisLocations)->sum('charges'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisLocations)->sum('payments'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisLocations)->sum('refund'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisLocations)->sum('adjustment'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisLocations)->sum('trans_out'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisLocations)->sum('trnas_in'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisLocations)->sum('newAR'))}}</th>

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