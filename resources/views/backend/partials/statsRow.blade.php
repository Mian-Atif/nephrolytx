
<div class="row patient-stats">

    <div class="col-12 col-sm-6 col-xl-3 ">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-left">
                    <div class="col-9">
                        <span class="text-purple active-patients">
                            <a href="{{route('admin.patients-list.index','active')}}">
                                <span>Active Patients</span>
                            </a>
                        </span>
                        <span class="text-white">
                            {{!is_null($activePatientStats[0])?$activePatientStats[0]->activePts:0}}
                        </span>
                        <!--<h6 class="text-muted">35.19% Since last month</h6>-->
                    </div>
                    <div class="col-3">
                        <img src="{{asset('img/images/patient-icon-1.png')}}"  alt="" height="30px">
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-left ">
                    <div class="col-9">
                        <span class="text-purple  new-patients">
                            <a href="{{route('admin.patients-list.index','new')}}" >
                                <span>New Patients</span>
                            </a>
                        </span>
                        <span class="new-patient-stats text-white">
                            {{!is_null($newPatientStats[0])?$newPatientStats[0]->newPts:0}}
                        </span>
                    </div>
                    <div class="col-3">
                        <img src="{{asset('img/images/patient-icon-2.png')}}" alt="" height="30px">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 grid-margin">
        <div class="card">
            <div class="card-body  stats-padding">
                <div class="d-flex align-items-left justify-content-between">

                    <div class="col-9">
                    
                        <span class="text-purple ckd-patients">
                            <a href="{{route('admin.patients-list.index','ckd')}}" >
                                <span>Non-ESRD Patients</span>
                            </a>
                            </span>
                        <span class="non-esrd-patient-stats text-white ">
{{--                            {{!is_null($nonEsrdStats[0])?$nonEsrdStats[0]->nonESRDPts:0}}--}}
{{--                            {{!is_null($esrdStats[0])?--}}
                            {{(int)$activePatientStats[0]->activePts-(int)$esrdStats[0]->esrdPts}}
{{--                            :0}}--}}
                        </span>
                    </div>
                    <div class="col-3">

                        <img src="{{asset('img/images/patient-icon-3.png')}}" alt="" height="30px">
                    </div>
                
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-left  justify-content-between">

                <div class="col-9">
                    
                        <span class="text-purple esrd-patients">
                            <a href="{{route('admin.patients-list.index','esrd')}}" >
                                <span>ESRD Patients</span>
                            </a></span>
                        <span class="esrd-patient-stats text-white">
                            
                            {{!is_null($esrdStats[0])?$esrdStats[0]->esrdPts:0}}</span>
                        <!--<h6 class="text-muted">18.33% Since last month</h6>-->
                        </div>
                        <div class="col-3">

                        <img src="{{asset('img/images/patient-icon-4.png')}}" alt="" height="30px">
                    </div>
                    </div>
                
            </div>
        </div>

    </div>

    <div>
    </div>

</div>