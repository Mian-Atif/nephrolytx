@extends ('backend.layouts.dashboard')
@section('title', 'Performance Report')
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

                        <form method="POST" class="formDatePickers" action="{{route('admin.performance-reports.store')}}">
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
                                    <th class="table-height1 month-heading">Billing Providers</th>
                                    <th class="table-height1 month-heading">Service Location</th>
                                    <th class="table-height1 month-heading">Pt Visits</th>
                                    <th class="table-height1 month-heading">Units</th>
                                    <th class="table-height1 month-heading">Charges</th>
                                    <th class="table-height1 month-heading">Work RVUs</th>
{{--                                    <th class="table-height1 month-heading"></th>--}}
                                </tr>
                                </thead>

                                <tbody class="table-body">

                                @if(count($performanceReports) > 0)
                                    @foreach($performanceReports as $key=> $subPerformanceReport)
{{--                                        <th class="text-white">{{ $key }}</th>--}}
                                        <tr class="text-white">
                                            {{--            <td>Billing Provider: Provider 1</td>--}}
                                            <th class="text-white">{{ $key }}</th>
                                            <th class="text-white"></th>
                                            <th class="text-white"> </th>
                                            <th class="text-white"></th>
                                            <th class="text-white"> </th>
                                            <th class="text-white"> </th>
                                        </tr>
                                        @foreach($subPerformanceReport as $performanceReport)

                                            <tr class="text-white">
                                                <td></td>
                                                <td>{{!is_null($performanceReport->Service_Location)?$performanceReport->Service_Location:''}}</td>
                                                <td>{{!is_null($performanceReport->patientVisit)?$performanceReport->patientVisit:'-- -- --'}}</td>
                                                <td>{{!is_null($performanceReport->Units)?standardPrettyFormat($performanceReport->Units):'-- -- --'}}</td>
                                                <td>{{!is_null($performanceReport->charges)?prettyPrice($performanceReport->charges):'-- -- --'}}</td>
                                                <td>{{!is_null($performanceReport->workRVU)?standardPrettyFormat($performanceReport->workRVU):'-- -- --'}}</td>
{{--                                                <td></td>--}}
                                            </tr>
                                        @endforeach
                                        <tr class="text-white">
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{$key}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{$subPerformanceReport->sum('patientVisit')}} </th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{standardPrettyFormat($subPerformanceReport->sum('Units'))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice($subPerformanceReport->sum('charges'))}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{standardPrettyFormat($subPerformanceReport->sum('workRVU'))}}</th>
{{--                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>--}}
                                        </tr>
                                    @endforeach

                                    <tr class="text-white">
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Grand Totals: </th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{collect($performance)->sum('patientVisit')}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{standardPrettyFormat(collect($performance)->sum('Units'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($performance)->sum('charges'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{standardPrettyFormat(collect($performance)->sum('workRVU'))}}</th>
{{--                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>--}}
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

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
@section('before-scripts')
    <script>
        $(window).scroll(function () {
            if ($(window).scrollTop() >= 100) {
                $('.sticky_bar').addClass('fixed-nav');
            } else {
                $('.sticky_bar').removeClass('fixed-nav');
            }
        });
    </script>
@endsection