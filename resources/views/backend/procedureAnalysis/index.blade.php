@extends ('backend.layouts.dashboard')
@section('title', 'Procedure Analysis')
@section('content-new')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                @include('backend.partials.financialReportsHeader')
                <div class="row">
                    <div class="col-12">
                        <form method="POST" class="formDatePickers" action="{{route('admin.procedure-analysis.store')}}">
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

                                            </tr>

                                        @endif
                                        @foreach($procedures as $row)
                                            <tr class="text-white">
                                                <td>
                                                    Totals for Procedure Code
                                                    {{!is_null($row->cptcode)?$row->cptcode:0}}
                                                    <br>
                                                    Description: {{!is_null($row->cptcode_description)?$row->cptcode_description:'-- -- --'}}
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
@section('before-scripts')
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>

@endsection