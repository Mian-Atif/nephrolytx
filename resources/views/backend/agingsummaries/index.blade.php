@extends ('backend.layouts.dashboard')
@section('title', 'AR Analysis By Insurance')
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
                        <form method="POST" class="formDatePickers" action="{{route('admin.aging-summaries.store')}}">
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
                                    <th class="month-heading"></th>
                                    <th class="month-heading">Prev A/R</th>
                                    <th class="table-height month-heading">Charges<br/>Charge%</th>
                                    <th class="table-height1 month-heading">Payments<br/>Profile%</th>
                                    <th class="table-height1 month-heading">Refunds<br/>& Debits</th>
                                    <th class="table-height1 month-heading">Adjust</th>
                                    <th class="table-height1 month-heading">Trans-Out</th>
                                    <th class="table-height1 month-heading">Trans-In</th>
                                    <th class="table-height1 month-heading">New A/R<br># Days </th>
{{--                                    <th class="table-height1 month-heading"></th>--}}
                                </tr>
                                </thead>

                                <tbody class="table-body">

                                @if(count($agingSummaries) > 0)
                                    @foreach($agingSummaries as $agingSummary)
                                        <tr class="text-white">
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Grand Total</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(!is_null($agingSummary->prevAR)?$agingSummary->prevAR:0)}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPrice(!is_null($agingSummary->charges)?$agingSummary->charges:0)}}<br/>
                                                {{prettyPricePercent(!is_null($agingSummary->charges)?(truncate_number($agingSummary->charges/($grandTotal > 0 ? $grandTotal : 1)*100)):0)}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(!is_null($agingSummary->payments)?$agingSummary->payments:0)}}<br/>
                                            {{prettyPricePercent(!is_null($agingSummary->paymentPercentage)?$agingSummary->paymentPercentage:0)}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(!is_null($agingSummary->refunds)?$agingSummary->refunds:0)}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(!is_null($agingSummary->adjustment)?$agingSummary->adjustment:0)}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(!is_null($agingSummary->trans_out)?$agingSummary->trans_out:0)}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(!is_null($agingSummary->trnas_in)?$agingSummary->trnas_in:0)}}</th>
                                            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPrice(!is_null($agingSummary->newAR)?$agingSummary->newAR:0)}}</th>


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