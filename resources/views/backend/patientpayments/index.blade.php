@extends ('backend.layouts.dashboard')
@section('title', 'Patient Payments Report')
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

                        <form method="POST" class="formDatePickers" action="{{route('admin.patient-payments.store')}}">
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
                                    <th class="month-heading">Sr #</th>
                                    <th class="month-heading">Claim ID</th>
                                    <th class="table-height month-heading">Patient Name</th>
                                    <th class="table-height1 month-heading">Date of<br/>Services</th>
                                    <th class="table-height1 month-heading">Reference</th>
                                    <th class="table-height1 month-heading">Category</th>
                                    <th class="table-height1 month-heading">Posting Date</th>
                                    <th class="table-height1 month-heading">Payment Date</th>
                                    <th class="table-height1 month-heading">Paid Amount</th>
                                    <th class="table-height1 month-heading">Remarks</th>
{{--                                    <th class="table-height1 month-heading"></th>--}}
                                </tr>
                                </thead>

                                <tbody class="table-body">
                                @if(count($patientPayments) > 0)
                                    <tr class="text-white">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>{{prettyPrice(array_sum(array_column($patientPayments, 'Patient_Payment')))}}</th>
                                        <th></th>
{{--                                        <th></th>--}}
                                    </tr>

                                    @foreach($patientPayments as $patientPayment)
                                        <tr class="text-white">
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                {{!is_null($patientPayment->claimID)?$patientPayment->claimID:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($patientPayment->Patient_Name)?$patientPayment->Patient_Name:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($patientPayment->dateofservice)?$patientPayment->dateofservice:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($patientPayment->reference)?$patientPayment->reference:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($patientPayment->category)?$patientPayment->category:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($patientPayment->postingDate)?$patientPayment->postingDate:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($patientPayment->paymentDate)?$patientPayment->paymentDate:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($patientPayment->Patient_Payment)?prettyPrice($patientPayment->Patient_Payment):'-- -- --'}}

                                            </td>
                                            <td>
                                                {{isset($patientPayment->Remarks)?$patientPayment->Remarks:'-- -- --'}}
                                            </td>

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