@extends ('backend.layouts.dashboard')
@section('title', 'Aging Summary')
@section('content-new')
<div class="content-wrapper">
    @include('backend.partials.stats')

    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Aging Summary</h4>
            <div class="row">
                <div class="col-12">
                    {{--<div class="daterange-picker-input1">
                        <input type="text" class="daterange form-control " /> <i class="fa fa-calendar calnedar-icon" aria-hidden="true"></i>
                    </div>--}}
                    @include('backend.partials.exportReportDropdown')
                    <div class="table-responsive tableFixHead">
                        <div id="buttons"></div>
                        <table id="order-listing" class="table">
                            <thead>



                                <tr class="table-color">

                                    <th style="font-weight: bold;font-size: 16px;"></th>
                                    <th style="font-weight: bold;font-size: 16px;">Patient Type</th>
                                    <th style="font-weight: bold;font-size: 16px;">0-30 Days</th>
                                    <th style="font-weight: bold;font-size: 16px;">31-60 Days</th>
                                    <th style="font-weight: bold;font-size: 16px;">61-90 Days</th>
                                    <th style="font-weight: bold;font-size: 16px;">91-120 Days</th>
                                    <th style="font-weight: bold;font-size: 16px;">121-180 Days</th>
                                    <th style="font-weight: bold;font-size: 16px;">180+</th>
                                    <th style="font-weight: bold;font-size: 16px;">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($agingSummaries))
                            @foreach($agingSummaries as $key => $agingSummary)
                                @if($key == 0)
                                    <tr class="text-white">
                                        @if($key == 0)
                                            <th> {{!is_null($agingSummary->first()->Primary_Insurance)?str_replace("_"," ",ucfirst($agingSummary->first()->Primary_Insurance)):'-- -- --'}}
                                            </th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        @else
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        @endif
                                    </tr>
                                    @endif

                                @foreach($agingSummary as $keys => $agingSummaryList)
                                <tr class="text-white">
                                    <td></td>
                                    <td>{{ !is_null($agingSummaryList->dtype)?$agingSummaryList->dtype:'-- -- --' }}</td>
                                    <td>{{prettyPrice(!is_null($agingSummaryList->zero_thirty_days)?$agingSummaryList->zero_thirty_days:0)}}</td>
                                    <td>{{prettyPrice(!is_null($agingSummaryList->thirty_one_sixty_days)?$agingSummaryList->thirty_one_sixty_days:0)}}</td>
                                    <td>{{prettyPrice(!is_null($agingSummaryList->sixty_one_ninty_days)?$agingSummaryList->sixty_one_ninty_days:0)}}</td>
                                    <td>{{prettyPrice(!is_null($agingSummaryList->ninty_one_twenty_days)?$agingSummaryList->ninty_one_twenty_days:0)}}</td>
                                    <td>{{prettyPrice(!is_null($agingSummaryList->one_twenty_one_one_eighty_days)?$agingSummaryList->one_twenty_one_one_eighty_days:0)}}</td>
                                    <td>{{prettyPrice(!is_null($agingSummaryList->one_eighty_days)?$agingSummaryList->one_eighty_days:0)}} </td>
                                    <td>{{prettyPrice(!is_null($agingSummaryList->totalAmolunt)?$agingSummaryList->totalAmolunt:0)}} </td>
                                            </tr>
                                        @endforeach

                                    <tr class="text-white" >
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> Total </th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice($agingSummary->sum('zero_thirty_days'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice($agingSummary->sum('thirty_one_sixty_days'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice($agingSummary->sum('sixty_one_ninty_days'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice($agingSummary->sum('ninty_one_twenty_days'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice($agingSummary->sum('one_twenty_one_one_eighty_days'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice($agingSummary->sum('one_eighty_days'))}}</th>
                                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice($agingSummary->sum('totalAmolunt'))}}</th>
                                    </tr>
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