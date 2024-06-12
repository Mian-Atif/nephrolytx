@extends ('backend.layouts.dashboard')
@section('title', 'Monthly Patient Analysis')
@section('content-new')
    <div class="content-wrapper">
        @include('backend.partials.stats')
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Monthly Patient Analysis</h4>
                <div class="row">
                    <div class="col-12">
                        @include('backend.partials.exportReportDropdown')

                        <div class="table-responsive tableFixHead">
                            <div id="buttons"></div>
                            <table id="order-listing" class="table">
                                <thead>
                                <tr class="table-color">
                                    <th>A/C #</th>
                                    <th>Patient Name</th>
                                    <th>Date Of Birth</th>
                                    <th>First Visit</th>
                                    <th>Last Visit</th>
                                    <th>Insurance Balance</th>
                                    <th>Patient Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(count($monthlyPatientAnalysis))
                                    @foreach($monthlyPatientAnalysis as $monthlyPatient)
                                            <tr class="text-white">
                                                <td>{{!is_null($monthlyPatient->account_nbr)?$monthlyPatient->account_nbr:'-- -- --'}}</td>
                                                <td > {{!is_null($monthlyPatient->patient_name)?$monthlyPatient->patient_name:''}}</td>
                                                <td > {{!is_null($monthlyPatient->dateofbirth)?\Carbon\Carbon::parse($monthlyPatient->dateofbirth)->format('m/d/Y'):''}}</td>
                                                <td >{{!is_null($monthlyPatient->firstVisit)? $monthlyPatient->firstVisit:''}}</td>
                                                <td > {{!is_null($monthlyPatient->lastVisit)?$monthlyPatient->lastVisit:''}}</td>
                                                <td > {{prettyPrice(!is_null($monthlyPatient->insuranceBalance)?$monthlyPatient->insuranceBalance:'')}}</td>
                                                <td > {{prettyPrice(!is_null($monthlyPatient->patientBalance)?$monthlyPatient->patientBalance:0)}}</td>
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