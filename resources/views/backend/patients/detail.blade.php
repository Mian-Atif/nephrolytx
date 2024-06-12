@extends ('backend.layouts.dashboard')
@section('content-new')
<div class="content-wrapper patient-detail-wrap">
    <div class="row">
        <div class="col-12 col-sm-4 col-xl-4 mb-30">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <strong>CKD Stage:</strong> {{$patientSearch->ckd_stage}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-left">
                        <div class="card-body">
                            <strong>BMI:</strong> {{$patientSearch->bmi}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 mt-30">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                            <strong>Acc No:</strong> {{$patientSearch->account_nbr}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 mt-30 ">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <strong>Patient Name:</strong> {{$patientSearch->patient_name}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-30">
                    <div class="card">
                        <div class="card-body">
                            <strong>Insurance Name:</strong> {{$patientSearch->Insurance}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-8 col-xl-8 mb-30">
            <div class="row">
                <div class="col-md-6 mb-30">
                    <div class="card text-center">
                        <div class="card-body">
                            <strong>Next Appointment:</strong> {{$patientSearch->Next_Visit_Due}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-30">
                    <div class="card text-center">
                        <div class="card-body">
                           <strong>Hosp in 30 days:</strong>  {{$patientSearch->hosp_30_days}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <strong>DOB: </strong>
                            {{$patientSearch->DOB}}             
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <strong>Gender:</strong> -    
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                        <strong>Contact No:</strong> -
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                        <strong>Physician:</strong> {{$patientSearch->rendering_provider}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 mt-30">
                    <div class="card">
                        <div class="card-body">
                        <strong>Address:</strong> {{$patientSearch->zipcode}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-header">
                    Visit History
                </div>
                <div class="card-body padding-0">
                    <table class="table table-bordered">
                        <tr>
                            <th>Date</th>
                            <th>Reason Of Visit</th>
                        </tr>
                        @foreach ($patientVisitHistory as $patientVisit)
                        <tr>
                            <td>{{$patientVisit->Date_of_Service}}</td>
                            <td>{{$patientVisit->ckd_stage}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    Lab History
                </div>
                <div class="card-body padding-0">
                    <table class="table table-bordered">
                        <tr>
                            <th>Date</th>
                            <th>GFR</th>
                            <th>Albumin</th>
                            <th>Creatine</th>
                        </tr>
                        @foreach ($patientLabHistory as $patientLab)
                        <tr>
                            <td>{{$patientLab->Lab_Date}}</td>
                            <td>{{$patientLab->gfr}}</td>
                            <td>{{$patientLab->albumin}}</td>
                            <td>{{$patientLab->cr}}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-30">
            <div class="card">
                <div class="card-header">
                    Remarks:
                </div>
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
</div>

@endsection