@extends ('backend.layouts.dashboard')
@section('title', $page_title)
@section('content-new')
    <div class="content-wrapper">
        @include('backend.partials.stats')
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{$page_title}}</h4>
                <div class="row">
                    <div class="col-12">
                        {{--<div class="daterange-picker-input1">
                            <input type="text"class="daterange form-control " /> <i class="fa fa-calendar calnedar-icon" aria-hidden="true"></i>
                        </div>--}}
                        <div class="row">
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6">
                                @include('backend.partials.exportReportDropdown')
                            </div>
                        </div>
                        

                        <div class="table-responsive tableFixHead">
                            <div id="buttons"></div>
                            <table id="order-listing" class="table">
                                <thead>
                                <tr class="table-color">
                                    <th class="font-bold">A/C #</th>
                                    <th class="font-bold">Patient Name</th>
                                    <th class="font-bold">DOB</th>
                                    <th class="font-bold">Insurance</th>
                                    <th class="font-bold">Provider</th>
                                    <th class="font-bold">Location</th>
                                    <th class="font-bold">CKD Stage</th>
                                    <th class="font-bold">Last Seen in Office</th>
                                    <th class="font-bold">Last Hospitalization</th>
                                    <th class="font-bold">Next Visit Due</th>
                                    <th class="font-bold">Last Lab</th>
                                    <th class="font-bold">BMI</th>
                                    <th class="font-bold">GFR</th>
                                    <th class="font-bold">Albumin</th>
                                    <th class="font-bold">1st Visit Date</th>
                                    <th class="font-bold">Ins Open</th>
                                    <th class="font-bold">Pt Open</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($patientLists))
                                    @foreach($patientLists as $patientList)
                                    <tr>
                                        <td>{{!is_null($patientList->account_nbr)?$patientList->account_nbr:''}}</td>
                                        <td><a href="{{route('admin.patient-detail',$patientList->account_nbr)}}">{{!is_null($patientList->Patient_Name)?$patientList->Patient_Name:''}}</a></td>
                                        <td>{{!is_null($patientList->DOB)?$patientList->DOB:''}}</td>
                                        <td>{{!is_null($patientList->Insurance)?$patientList->Insurance:''}}</td>
                                        <td>{{!is_null($patientList->provider)?$patientList->provider:''}}</td>
                                        <td>{{!is_null($patientList->Location)?$patientList->Location:''}}</td>
                                        <td>{{!is_null($patientList->ckd_Stage)?$patientList->ckd_Stage:''}}</td>
                                        <td>{{!is_null($patientList->Last_Seen_in_Office)?$patientList->Last_Seen_in_Office:''}}</td>
                                        <td>{{!is_null($patientList->Last_Hospitalization)?$patientList->Last_Hospitalization:''}}</td>
                                        <td>{{!is_null($patientList->Next_Visit_Due)?$patientList->Next_Visit_Due:''}}</td>
                                        <td>{{!is_null($patientList->Last_Lab)?$patientList->Last_Lab:''}}</td>
                                        <td>{{!is_null($patientList->bmi)?$patientList->bmi:''}}</td>
                                        <td>{{!is_null($patientList->GFR)?$patientList->GFR:''}}</td>
                                        <td>{{!is_null($patientList->Albumin)?$patientList->Albumin:''}}</td>
                                        <td>{{!is_null($patientList->first_visit_date)?$patientList->first_visit_date:''}}</td>
                                        <td>{{!is_null($patientList->Ins_Open)?$patientList->Ins_Open:''}}</td>
                                        <td>{{!is_null($patientList->Pt_Open)?$patientList->Pt_Open:''}}</td>
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