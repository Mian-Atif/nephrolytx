@extends('backend.layouts.dashboard')


@section('content-new')



<div class="content-wrapper">
    
    <div class="row">
                <div class="mt-5 col-md-12 quicksummarycard pos-rel">
                        <div class="text-center">
                            <div class="mt-2 quicksummarytext"> <h3>Optimal Start</h3> </div>
                        </div>
                      
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card quicktool-card">
                                <div class="card-img">
                                    <img src="{{ asset('img/images/quicktoolscard/summary-optimal-summary.png') }}" class="card-img-top" alt="...">
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title-head">Summary</h5>
                                    <a href="{{ route('admin.summary-optimal-starts') }}" class="btn btn-primary stretched-link">Click Image for the Report</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            
                                <div class="card quicktool-card">
                                    <div class="card-img">
                                        <img src="{{ asset('img/images/quicktoolscard/drivers-optimal-starts.png') }}" class="card-img-top" alt="...">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title-head">Drivers</h5>
                                        <a href="{{ route('admin.drivers-optimal-starts') }}" class="btn btn-primary stretched-link">Click Image for the Report</a>
                                    </div>
                                </div>
                            
                        </div>
                        <div class="col-md-3">
                            
                                <div class="card quicktool-card">
                                    <div class="card-img">
                                        <img src="{{ asset('img/images/quicktoolscard/home-dialysis.png') }}" class="card-img-top" alt="...">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title-head">Home Dialysis</h5>
                                        <a href="{{ route('admin.home-dialysis-optimal-starts') }}" class="btn btn-primary stretched-link">Click Image for the Report</a>
                                    </div>
                                </div>
                          
                        </div>
                        <div class="col-md-3">
                            
                                <div class="card quicktool-card">
                                    <div class="card-img">
                                        <img src="{{ asset('img/images/quicktoolscard/new-start-roaster.png') }}" class="card-img-top" alt="...">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title-head">New Start Roster</h5>
                                        <a href="{{ route('admin.new-start-roaster') }}" class="btn btn-primary stretched-link">Click Image for the Report</a>
                                    </div>
                                </div>
                           
                        </div>
                        <div class="col-md-3">
                            
                                <div class="card quicktool-card">
                                    <div class="card-img">
                                        <img src="{{ asset('img/images/quicktoolscard/late-stage-roaster.png') }}" class="card-img-top" alt="...">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title-head">Late Stage Roster</h5>
                                        <a href="{{ route('admin.late-stage-roaster') }}" class="btn btn-primary stretched-link">Click Image for the Report</a>
                                    </div>
                                </div>
                           
                        </div>
                    </div>
                </div>
    </div>
   

    
</div>


    

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>



@endsection

@section('after-scripts')
    {{--    {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
    {{ Html::script(asset('js/template/js/fusioncharts.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}
    