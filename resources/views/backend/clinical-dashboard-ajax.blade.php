
                    <div class="col-md-3 card-box-mr border-color-1">
                        <div class="card border-radius-25">
                            <div class="card-body ckd-box  pad-space-0">
                                <h5 class="card-title">Late Stage CKD Visit Interval</h5>
                                <div class="ckd-box-row ckd-box-row-pad">
                                    <strong>{{$lateStageCKDVisitInterval->analysis_year_value}}</strong><br/>
                                    Prior Year {{$lateStageCKDVisitInterval->prior_year_value}}
                                </div>
                                <div class="ckd-box-row ckd-box-col">
                                    <span>{{$lateStageCKDVisitInterval->yearly_change}}</span>
                                    <span>{{$lateStageCKDVisitInterval->trend_percent}}% 
                                        @if($lateStageCKDVisitInterval->direction == 'up')
                                        <i class="fa-solid fa-circle-arrow-up"></i>
                                        @else
                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('admin.interval-detail') }}" class="stretched-link"></a>
                        </div>
                    </div>

                    <div class="col-md-3 card-box-mr border-color-2">
                        <div class="card border-radius-25">
                            <div class="card-body ckd-box  pad-space-0">
                                <h5 class="card-title">Late Stage CKD Wait Time</h5>
                                <div class="ckd-box-row ckd-box-row-pad">
                                    <strong>{{$lateStageCKDWaitTime->analysis_year_value}}</strong><br/>
                                    Prior Year {{$lateStageCKDWaitTime->prior_year_value}}
                                </div>
                                <div class="ckd-box-row ckd-box-col">
                                    <span>{{$lateStageCKDWaitTime->yearly_change}}</span>
                                    <span> {{$lateStageCKDWaitTime->trend_percent}}%
                                        @if($lateStageCKDWaitTime->direction == 'up')
                                        <i class="fa-solid fa-circle-arrow-up"></i>
                                        @else
                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
                           
                        </div>
                    </div>

                    <div class="col-md-3 card-box-mr border-color-3">
                        <div class="card border-radius-25">
                            <div class="card-body ckd-box  pad-space-0">
                                <h5 class="card-title">Hospital To Office Follow Up</h5>
                                <div class="ckd-box-row ckd-box-row-pad">
                                    <strong>{{$hospitalToOfficeFollowUp->analysis_year_value}}%</strong><br/>
                                    Prior Year {{$hospitalToOfficeFollowUp->prior_year_value}}%
                                </div>
                                <div class="ckd-box-row ckd-box-col">
                                    <span>{{$hospitalToOfficeFollowUp->yearly_change}}%</span>
                                    <span>{{$hospitalToOfficeFollowUp->trend_percent}}% 
                                        @if($hospitalToOfficeFollowUp->direction == 'up')
                                        <i class="fa-solid fa-circle-arrow-up"></i>
                                        @else
                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
        
                        </div>
                    </div>

                    <div class="col-md-3 card-box-mr border-color-4">
                        <div class="card border-radius-25">
                            <div class="card-body ckd-box  pad-space-0">
                                <h5 class="card-title">Pts with Albumin under 2.0</h5>
                                <div class="ckd-box-row ckd-box-row-pad">
                                    <strong>{{$ptsWithAlbuminUnder2->analysis_year_value}}%</strong><br/>
                                    {{$ptsWithAlbuminUnder2->count_fraction}}<br/>
                                    Prior Year {{$ptsWithAlbuminUnder2->prior_year_value}}%
                                </div>
                                <div class="ckd-box-row ckd-box-col">
                                    <span>{{$ptsWithAlbuminUnder2->yearly_change}}%</span>
                                    <span>{{$ptsWithAlbuminUnder2->trend_percent}}% 
                                        @if($ptsWithAlbuminUnder2->direction == 'up')
                                        <i class="fa-solid fa-circle-arrow-up"></i>
                                        @else
                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 card-box-mr border-color-4">
                        <div class="card border-radius-25">
                            <div class="card-body ckd-box  pad-space-0">
                                <h5 class="card-title">Pts with GFR under 60</h5>
                                <div class="ckd-box-row ckd-box-row-pad">
                                    <strong>{{$ptsWithGFRUnder60->analysis_year_value}}%</strong><br/>
                                    {{$ptsWithGFRUnder60->count_fraction}}<br/>
                                    Prior Year {{$ptsWithGFRUnder60->prior_year_value}}%
                                </div>
                                <div class="ckd-box-row ckd-box-col">
                                    <span>{{$ptsWithGFRUnder60->yearly_change}}%</span>
                                    <span>{{$ptsWithGFRUnder60->trend_percent}}% 
                                        @if($ptsWithGFRUnder60->direction == 'up')
                                        <i class="fa-solid fa-circle-arrow-up"></i>
                                        @else
                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
    
                        </div>
                    </div>

                    <div class="col-md-3 card-box-mr  border-color-3">
                        <div class="card border-radius-25">
                            <div class="card-body ckd-box  pad-space-0">
                                <h5 class="card-title">New Start with Hosp. 30 Days Prior	</h5>
                                <div class="ckd-box-row ckd-box-row-pad">
                                    <strong>{{$newStartHosp30Prior->analysis_year_value}}%</strong><br/>
                                    Prior Year {{$newStartHosp30Prior->prior_year_value}}%
                                </div>
                                <div class="ckd-box-row ckd-box-col">
                                    <span>{{$newStartHosp30Prior->yearly_change}}%</span>
                                    <span>{{$newStartHosp30Prior->trend_percent}}% 
                                        @if($newStartHosp30Prior->direction == 'up')
                                        <i class="fa-solid fa-circle-arrow-up"></i>
                                        @else
                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
                    
                        </div>
                    </div>

                    <div class="col-md-3 card-box-mr border-color-2">
                        <div class="card border-radius-25">
                            <div class="card-body ckd-box  pad-space-0">
                                <h5 class="card-title">Timely Referral</h5>
                                <div class="ckd-box-row ckd-box-row-pad">
                                    <strong>{{$timeReferral->analysis_year_value}}%</strong><br/>
                                    Prior Year {{$timeReferral->prior_year_value}}%
                                </div>
                                <div class="ckd-box-row ckd-box-col">
                                    <span>{{$timeReferral->yearly_change}}%</span>
                                    <span>{{$timeReferral->trend_percent}}% 
                                        @if($timeReferral->direction == 'up')
                                        <i class="fa-solid fa-circle-arrow-up"></i>
                                        @else
                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        
                        </div>
                    </div>

                    <div class="col-md-3 card-box-mr border-color-1">
                        <div class="card border-radius-25">
                            <div class="card-body ckd-box  pad-space-0">
                                <h5 class="card-title">Patients Conversion to Late Stage CKD</h5>
                                <div class="ckd-box-row ckd-box-row-pad">
                                    <strong>{{$ptsConversionLateStageCKD->analysis_year_value}}%</strong><br/>
                                    Prior Year {{$ptsConversionLateStageCKD->prior_year_value}}%
                                </div>
                                <div class="ckd-box-row ckd-box-col">
                                    <span>{{$ptsConversionLateStageCKD->yearly_change}}%</span>
                                    <span>{{$ptsConversionLateStageCKD->trend_percent}}% 
                                        @if($ptsConversionLateStageCKD->direction == 'up')
                                        <i class="fa-solid fa-circle-arrow-up"></i>
                                        @else
                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
                           
                        </div>
                    </div>

         



