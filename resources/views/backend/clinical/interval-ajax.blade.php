     
                      @php
            $intervalStageBoxOne = array_values((array) $intervalStageBoxOne);
            $intervalStageBoxOneTwo = array_values((array) $intervalStageBoxOne[0]);
            
        @endphp  
                    
                    
                    <div class="col-md-3 card-box-mr">
                        <div class="card card-height-adjust card-bcolors">
                            <div class="card-body ckd-box ckd-box-none text-center pad-space-0 card-center-ct">
                            {{$intervalStageBoxOneTwo['3']}}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 card-box-mr">
                        <div class="card">
                            <div class="card-body ckd-box ckd-box-none text-center pad-space-0">
                                <h5 class="card-title vit-heading">CKD Visit Interval By Stage</h5>
                                <div class="visit-interval-table">
                                   
                                <table class="table table-bordered">
                                        <tr>
                                            <th></th>
                                            <th>Expected Visits</th>
                                            <th>Actual Visits</th>
                                            <th>Interval</th>
                                        </tr>
                                        @foreach ($intervalStageBoxOne as $intervalStage)
                                        <tr>
                                            <td>
                                                <strong>{{$intervalStage->category}}</strong>
                                            </td>
                                            <td>
                                                <strong>{{$intervalStage->expected_visits}}</strong>
                                            </td>
                                            <td>
                                                <strong>{{$intervalStage->actual_visits}}</strong>
                                            </td>
                                            <td>
                                                <strong>{{$intervalStage->visit_interval}}</strong>
                                            </td>
                                        </tr>
@endforeach
                                        
                                   </table>
                                </div>
                            </div>
                        </div>
                    </div>
