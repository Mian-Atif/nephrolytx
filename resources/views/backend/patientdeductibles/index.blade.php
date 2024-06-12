@extends ('backend.layouts.dashboard')
@section('title', 'Patient Deductibles')
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
                        <form method="POST" class="formDatePickers" action="{{route('admin.patient-deductibles.store')}}">
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
                                    <button type="submit" class="btn btn-primary"  style="margin-top: 30px;">Submit</button>
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
                                    <th class="month-heading">Insurance</th>
                                    <th class="table-height month-heading">Check No</th>
                                    <th class="table-height1 month-heading">DOS</th>
                                    <th class="table-height1 month-heading">Patient Name</th>
                                    <th class="table-height1 month-heading">Amount</th>
{{--                                    <th class="table-height1 month-heading"></th>--}}
                                </tr>
                                </thead>

                                <tbody class="table-body">
                                @if(count($patientDeductables) > 0)
                                    <tr class="text-white">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>{{prettyPrice(array_sum(array_column($patientDeductables, 'deductibleAmount')))}}</th>
{{--                                        <th></th>--}}

                                    </tr>

                                    @foreach($patientDeductables as $patientPayment)
                                        <tr class="text-white">
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                {{!is_null($patientPayment->Primary_Insurance_Name)?$patientPayment->Primary_Insurance_Name:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($patientPayment->Primary_CheckNo_ReferenceNo)?$patientPayment->Primary_CheckNo_ReferenceNo:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($patientPayment->dateofservice)?$patientPayment->dateofservice:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($patientPayment->Patient_Name)?$patientPayment->Patient_Name:'-- -- --'}}
                                            </td>
                                            <td>
                                                {{!is_null($patientPayment->deductibleAmount)?prettyPrice($patientPayment->deductibleAmount):'-- -- --'}}
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