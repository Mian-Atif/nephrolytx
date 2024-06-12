@extends ('backend.layouts.dashboard')
@section('title', 'Charges & Collections Summary')
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
                        <form method="POST" class="formDatePickers" action="{{route('admin.charge-and-collection-summaries.store')}}">
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
                                    <th class="month-heading">Provider Name</th>
                                    <th class="month-heading">Total Charge</th>
                                    <th class="table-height month-heading">Total Collections</th>
                                    <th class="table-height1 month-heading">Insurance<br/>
                                        Collections
                                    </th>
                                    <th class="table-height1 month-heading">Patient Payments</th>
                                    <th class="table-height1 month-heading">Adjustments</th>
                                    <th class="table-height1 month-heading">Patient and<br/>
                                        Insurance Aging
                                    </th>
{{--                                    <th class="table-height1 month-heading"></th>--}}
                                </tr>
                                </thead>
                                <tbody class="table-body">
                                @if(count($chargeCollectionSummaries) > 0)
                                    @foreach($chargeCollectionSummaries as $chargeCollectionSummary)
                                        <tr class="text-white">
                                            <td>
                                                {{!is_null($chargeCollectionSummary->provider)?$chargeCollectionSummary->provider:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($chargeCollectionSummary->totalCharges)?prettyPrice($chargeCollectionSummary->totalCharges):'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($chargeCollectionSummary->totalCollection)?prettyPrice($chargeCollectionSummary->totalCollection):'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($chargeCollectionSummary->InsuranceCollection)?prettyPrice($chargeCollectionSummary->InsuranceCollection):'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($chargeCollectionSummary->patientCollection)?prettyPrice($chargeCollectionSummary->patientCollection):'-- -- --'}}

                                            </td>
                                            <td>
                                                {{!is_null($chargeCollectionSummary->Adjustments)?prettyPrice($chargeCollectionSummary->Adjustments):'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($chargeCollectionSummary->patientInsuranceAging)?prettyPrice($chargeCollectionSummary->patientInsuranceAging):'-- -- --'}}
                                            </td>
                                        </tr>
                                    @endforeach
                                   {{-- <tr class="text-white">
                                        <th>Total</th>
                                        <th>{{prettyPrice(array_sum(array_column($chargeCollectionSummaries, 'totalCharges')))}}</th>
                                        <th>{{prettyPrice(array_sum(array_column($chargeCollectionSummaries, 'totalCollection')))}}</th>
                                        <th>{{prettyPrice(array_sum(array_column($chargeCollectionSummaries, 'InsuranceCollection')))}}</th>
                                        <th>{{prettyPrice(array_sum(array_column($chargeCollectionSummaries, 'patientCollection')))}}</th>
                                        <th>{{prettyPrice(array_sum(array_column($chargeCollectionSummaries, 'Adjustments')))}}</th>
                                        <th>{{prettyPrice(array_sum(array_column($chargeCollectionSummaries, 'patientInsuranceAging')))}}</th>
                                    </tr>--}}
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