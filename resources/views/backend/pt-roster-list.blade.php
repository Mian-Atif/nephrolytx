@extends('backend.layouts.dashboard')


@section('content-new')



<div class="content-wrapper">
    <div class="bg-white-wrap">
        <div class="row">
            <div class="col-md-12">
                <div class="table-card">
                    <div class="card-header-2">
                        <h4>Total Patients by Stage</h4>
                    </div>
                    <table class="table table-bordered nephro-table">
                        <thead>
                            <tr>
                                <th>Early CKD</th>
                                <th>ESRD</th>
                                <th>Non-ESRD</th>
                                <th>Stage 4-CKD</th>
                                <th>Stage 5-CKD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{$totalBalanceofPatientsbyStagePT1}}</td>
                                <td>{{$totalBalanceofPatientsbyStagePT2}}</td>
                                <td>{{$totalBalanceofPatientsbyStagePT3}}</td>
                                <td>{{$totalBalanceofPatientsbyStagePT4}}</td>
                                <td>{{$totalBalanceofPatientsbyStagePT5}}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-card">
                    <div class="card-header-2">
                        <h4>Active ESRD Patients (Billing)</h4>
                    </div>
                    <table class="table table-bordered nephro-table ">
                        <thead>
                            <tr>
                                <th class="bg-white"></th>
                                <th class=".bg-secondary">Base</th>
                                <th class=".bg-secondary">Reactivated</th>
                                <th class=".bg-secondary">New</th>
                                <th class=".bg-secondary">Overall Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total</td>
                                <td>{{$activeESRDBalanceBillingTablePTT1}}</td>
                                <td>{{$activeESRDBalanceBillingTablePTT2}}</td>
                                <td>{{$activeESRDBalanceBillingTablePTT3}}</td>
                                <td>{{$activeESRDBalanceBillingTablePTT4}}</td>
                            </tr>
                            <tr>
                                <td>Billed As MCP</td>
                                <td>{{$activeESRDBalanceBillingTablePTBase1}}</td>
                                <td>{{$activeESRDBalanceBillingTablePTReA1}}</td>
                                <td>{{$activeESRDBalanceBillingTablePTN1}}</td>
                                <td>{{$activeESRDBalanceBillingTablePTOT1}}</td>
                            </tr>
                            <tr>
                                <td>Billed As Non MCP</td>
                                <td>{{$activeESRDBalanceBillingTablePTBase2}}</td>
                                <td>{{$activeESRDBalanceBillingTablePTReA2}}</td>
                                <td>{{$activeESRDBalanceBillingTablePTN2}}</td>
                                <td>{{$activeESRDBalanceBillingTablePTOT2}}</td>
                            </tr>
                            <tr>
                                <td>Not Billed</td>
                                <td>{{$activeESRDBalanceBillingTablePTBase3}}</td>
                                <td>{{$activeESRDBalanceBillingTablePTReA2}}</td>
                                <td>{{$activeESRDBalanceBillingTablePTN3}}</td>
                                <td>{{$activeESRDBalanceBillingTablePTOT3}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="table-card">
                    <div class="card-header-2">
                        <h4>Patient Roster</h4>
                    </div>
                    <table id="dtBasicExample1" class="table table-bordered table-responsive nephro-table ">
                        <thead>
                            <tr>
                                <th>Stage Name</th>
                                <th>Patient Number</th>
                                <th>Patient Name</th>
                                <th>Zip Code</th>
                                <th>Current Month Billed Activity</th>
                                <th>Last Location</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patientRosterPT as $patientRosterPTT)
                                <tr>
                                    <td>{{ $patientRosterPTT->Stage_name }}</td>
                                    <td>{{ $patientRosterPTT->patient_number }}</td>
                                    <td>{{ $patientRosterPTT->patient_name }}</td>
                                    <td>{{ $patientRosterPTT->ZIPCode }}</td>
                                    <td>{{ $patientRosterPTT->Current_month_Billed_Activity }}</td>
                                    <td>{{ $patientRosterPTT->Office_Location }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $patientRosterPT->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- 
    <script>
            $(document).ready(function () {
        $('#dtBasicExample1').DataTable();
        $('.dataTables_length').addClass('bs-select');
        });
    </script> -->


@endsection

@section('after-scripts')
{{-- {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
{{ Html::script(asset('js/template/js/fusioncharts.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}