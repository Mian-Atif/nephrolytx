@extends ('backend.layouts.dashboard')
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
                        <form method="POST" class="formDatePickers" action="{{route('admin.charge-detail-reports.store')}}">
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
                                    <th class="month-heading">Sr #</th>
                                    <th class="month-heading">Patient Name</th>
                                    <th class="table-height month-heading">DOS</th>
                                    <th class="table-height1 month-heading">Location</th>
                                    <th class="table-height1 month-heading">Claim Type</th>
                                    <th class="table-height1 month-heading">Rendering<br> Provider</th>
                                    <th class="table-height1 month-heading">Insurance</th>
                                    <th class="table-height1 month-heading">Claim ID</th>
                                    <th class="table-height1 month-heading">Procedure <br>Code</th>
                                    <th class="table-height1 month-heading">Charge
                                        <br>Amount
                                    </th>
{{--                                    <th class="table-height1 month-heading"></th>--}}
                                </tr>
                                </thead>

                                <tbody class="table-body">

                                @if(count($chargeDetails) > 0)
                                    @foreach($chargeDetails as $chargeDetail)
                                        <tr class="text-white">
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                {{!is_null($chargeDetail->Patient_Name)?$chargeDetail->Patient_Name:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($chargeDetail->Date_of_Service)?(\Carbon\Carbon::parse($chargeDetail->Date_of_Service)->format('m/d/Y')):'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($chargeDetail->Service_Location)?$chargeDetail->Service_Location:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($chargeDetail->serviceName)?$chargeDetail->serviceName:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($chargeDetail->Rendering_Provider)?$chargeDetail->Rendering_Provider:'-- -- --'}}

                                            </td>
                                            <td>
                                                {{!is_null($chargeDetail->Primary_Insurance_Name)?$chargeDetail->Primary_Insurance_Name:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($chargeDetail->ClaimID)?$chargeDetail->ClaimID:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($chargeDetail->cptcode)?$chargeDetail->cptcode:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($chargeDetail->Billed_Amount)?prettyPrice($chargeDetail->Billed_Amount):'-- -- --'}}
                                            </td>
                                        </tr>

                                    @endforeach
                                    <tr class="text-white">
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th> {{ prettyPrice(array_sum(array_column($chargeDetails, 'Billed_Amount'))) }}</th>
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
{{--@section('before-scripts')--}}
@section('after-scripts')

{{--    <script src="https://code.jquery.com/jquery-latest.min.js"></script>--}}
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