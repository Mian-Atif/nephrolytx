@extends ('backend.layouts.dashboard')
@section('title', 'Under Paid Cases')
@section('content-new')
    <div class="content-wrapper">
        @include('backend.partials.stats')
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Under Paid Cases</h4>
                <div class="row">
                    <div class="col-12">
                        {{--<div class="daterange-picker-input1">
                            <input type="text"class="daterange form-control " /> <i class="fa fa-calendar calnedar-icon" aria-hidden="true"></i>
                        </div>--}}
                        @include('backend.partials.exportReportDropdown')

                        <div class="table-responsive tableFixHead">
                            <div id="buttons"></div>

                            <table id="order-listing" class="table">
                                <thead>
                                <tr class="table-color">
                                    <th>A/C #</th>
                                    <th>Patient Name</th>
                                    <th>Date Of Service</th>
                                    <th>Payer</th>
                                    <th>CPT</th>
                                    <th>Charge Amount</th>
                                    <th>Actual Allowed</th>
                                    <th>Expected Allowed</th>
                                    <th>Variance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($openCases))
                                    <tr class="text-white">
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Grand Total</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">-- -- --</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">-- -- --</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">-- -- --</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($openCases)->sum('chargeAmount'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($openCases)->sum('actualAllowed'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($openCases)->sum('expectedAllowed'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($openCases)->sum('variance'))}}</th>

                                    </tr>
                                    @foreach($openCases as $openCase)
                                        @if(!is_null($openCase))
                                            <tr class="text-white">
                                                <td>{{!is_null($openCase->account_nbr)?$openCase->account_nbr:''}}</td>
                                                <td > {{!is_null($openCase->Patient_Name)?$openCase->Patient_Name:''}}</td>
                                                <td > {{!is_null($openCase->Date_of_Service)?\Carbon\Carbon::parse($openCase->Date_of_Service)->format('m/d/Y'):''}}</td>
                                                <td >{{!is_null($openCase->Primary_Insurance_Name)? $openCase->Primary_Insurance_Name:''}}</td>
                                                <td > {{!is_null($openCase->cptcode)?$openCase->cptcode:''}}</td>
                                                <td > {{prettyPrice(!is_null($openCase->chargeAmount)?$openCase->chargeAmount:'')}}</td>
                                                <td > {{prettyPrice(!is_null($openCase->actualAllowed)?$openCase->actualAllowed:0)}}</td>
                                                <td > {{prettyPrice(!is_null($openCase->expectedAllowed)?$openCase->expectedAllowed:0)}}</td>
                                                <td > {{ prettyPrice(!is_null($openCase->variance)?$openCase->variance:0)}}</td>
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