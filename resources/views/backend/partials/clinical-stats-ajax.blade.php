@php
    use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\DB;
    $user = Auth::user();
    $practice_id = $user->practice_id;
    
    $esrdStats =DB::select("CALL ESRD_patients_count($practice_id,'','','','')");
    $nonEsrdStats =DB::select("CALL nonESRD_patient_count($practice_id,'','','','')");

 

@endphp
{{--we need to make composer for all these php functionalities--}}


    <div class="col-12 col-sm-6 col-xl-3 grid-margin">
        <div class="card">
            <div class="card-body stats-padding">
                <div class="d-flex align-items-center justify-content-between">

                    <div>
                        <h4 class="text-purple active-patients"><a
                                    href="{{route('admin.patients-list.index','active')}}" class="nav-link">
                                <span>Active Patients</span>
                            </a></h4>
                        <h4 class="text-white mt-3 pl-2 active-patient-stats"
                            >{{!is_null($activePatientStats[0])?$activePatientStats[0]->activePts:0}}</h4>
                        <!--<h6 class="text-muted">35.19% Since last month</h6>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 grid-margin">
        <div class="card">
            <div class="card-body stats-padding">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="text-purple  new-patients">
                            <a href="{{route('admin.patients-list.index','new')}}" class="nav-link">
                                <span>New Patients</span>
                            </a>
                        </h4>
                        <h4 class="new-patient-stats text-white mt-3 pl-2"
                            >{{!is_null($newPatientStats[0])?$newPatientStats[0]->newPts:0}}</h4>
                        <!--<h6 class="text-muted">73.52% Since last month</h6>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 grid-margin">
        <div class="card">
            <div class="card-body  stats-padding">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="text-purple ckd-patients">
                            <a href="{{route('admin.patients-list.index','early')}}" class="nav-link">
                                <span>Early Stage CKD Patients</span>
                            </a>
                        </h4>
                        <h4 class="non-esrd-patient-stats text-white mt-3 pl-2"
                            >
{{--                            {{!is_null($earlyStats[0])?$earlyStats[0]->EarlyStageCnt:0}}--}}
{{--                            {{!is_null($lateStats[0])?--}}
                            {{(int)$earlyStats[0]->EarlyStageCnt}}
{{--                            :0}}--}}
                        </h4>
                        <!--<h6 class="text-muted">49.39% Since last month</h6>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h4 class="text-purple esrd-patients">
                            <a href="{{route('admin.patients-list.index','late')}}" class="nav-link">
                                <span>Late Stage CKD Patients</span>
                            </a></h4>
                        <h4 class="esrd-patient-stats text-white mt-3 pl-2"
                            >{{!is_null($lateStats[0])?$lateStats[0]->LateStageCnt:0}}</h4>
                        <!--<h6 class="text-muted">18.33% Since last month</h6>-->
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div>
    </div>

