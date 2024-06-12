@extends ('backend.layouts.dashboard')
@section('title', 'Procedure Analysis')
@section('content-new')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h3 class="table-color text-center" style="font-weight: 600;">Procedure Analysis</h3>
                <h3 class="table-color text-center"
                    style="font-weight: 600;">{{!is_null(Auth::user()->practice)?Auth::user()->practice->name:''}}</h3>
                <h3 class="table-color text-center"
                    style="font-weight: 600;">{{\Carbon\Carbon::parse($currentMonth)->format('m/d/Y')}}-
                    {{\Carbon\Carbon::parse($currentDate)->format('m/d/Y')}}</h3>
                <div class="row">
                    <div class="col-12">
                        <form method="POST" enctype="multipart/form-data" id="formDatePicker"
                              action="{{route('admin.procedure-analysis.store')}}">
                            @csrf
                            <div class="daterange-picker-input1">
                                {{--                                <input type="text" class="form-control date-range" />--}}
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
                                    <th>Billing Providers</th>
                                    <th>Units
                                    </th>
                                    <th>Units%
                                    </th>
                                    <th>Work
                                        <br>
                                        RVUs
                                    </th>
                                    <th>Pract. Exp.
                                        <br>
                                        RUV's
                                    </th>
                                    <th>Malpract <br>
                                        RUV's
                                    </th>
                                    <th>Total <br>
                                        RUV's
                                    </th>
                                    <th>Charges</th>
                                    <th>Chg%</th>

                                </tr>
                                </thead>
                                <tbody class="table-body">
                                @if(count($procedureAnalysis)>0)
                                    @foreach($procedureAnalysis as $key => $procedures)
                                        @if($key)
                                            <th class="text-white">{{ $key }}</th>
                                        @endif
                                        @foreach($procedures as $row)
                                            <tr class="text-white">
                                                <td>
                                                    Totals for Procedure Code
                                                    ({{!is_null($row->cptcode)?$row->cptcode:0}})
                                                </td>
                                                <td>
                                                    {{normalPrettyPrice2(!is_null($row->units)?$row->units:0)}}
                                                </td>
                                                <td>
                                                    {{prettyPricePercent(!is_null($row->units)?(truncate_number($row->units/($unitTotal > 0 ? $unitTotal : 1)*100)):0)}}

                                                </td>
                                                <td>
                                                    {{normalPrettyPrice2(!is_null($row->workRVUs)?$row->workRVUs:0)}}

                                                </td>
                                                <td>
                                                    {{normalPrettyPrice2(!is_null($row->pracRVUs)?$row->pracRVUs:0)}}
                                                </td>
                                                <td>
                                                    {{normalPrettyPrice2(!is_null($row->malpractRVUs)?$row->malpractRVUs:0)}}

                                                </td>
                                                <td>
                                                    {{normalPrettyPrice2(!is_null($row->totalRVUs)?$row->totalRVUs:0)}}

                                                </td>
                                                <td>
                                                    {{prettyPrice(!is_null($row->charges)?$row->charges:0)}}

                                                </td>
                                                <td>
                                                    {{prettyPricePercent(!is_null($row->charges)?(truncate_number($row->charges/($chargeTotal > 0 ? $chargeTotal : 1)*100)):0)}}

                                                </td>
                                            </tr>
                                        @endforeach

                                        <tr class="text-white">
                                            @if($key)
                                                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">
                                                    Total for {{ $key }}</th>
                                            @endif
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($procedures)->sum('units'))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPricePercent((truncate_number(collect($procedures)->sum('units')/($unitTotal > 0 ? $unitTotal : 1)*100)))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($procedures)->sum('workRVUs'))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($procedures)->sum('pracRVUs'))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($procedures)->sum('malpractRVUs'))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{normalPrettyPrice2(collect($procedures)->sum('totalRVUs'))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($procedures)->sum('charges'))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPricePercent(truncate_number($chargeTotal/($chargeTotal > 0 ? $chargeTotal : 1)*100))}}</th>
                                        </tr>
                                    @endforeach
                                    <tr class="text-white">
                                        @if($key)
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Grand
                                                Total
                                            </th>
                                        @endif
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($frProcedures)->sum('units'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">-- --
                                            --
                                        </th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($frProcedures)->sum('workRVUs'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($frProcedures)->sum('pracRVUs'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($frProcedures)->sum('malpractRVUs'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{normalPrettyPrice2(collect($frProcedures)->sum('totalRVUs'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($frProcedures)->sum('charges'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">-- --
                                            --
                                        </th>

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