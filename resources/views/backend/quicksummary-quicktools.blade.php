@extends('backend.layouts.dashboard')


@section('content-new')



<div class="content-wrapper">
    
    <div class="row">
        <div class="mt-5 col-md-12 quicksummarycard pos-rel">
            <div class="text-center">
                <div class="mt-2 quicksummarytext"> <h3>Quick Summary</h3> </div>
            </div>  
            <div class="row">
                <div class="col-md-3">
                    <div class="card quicktool-card">
                        <div class="card-img">
                            <img src="{{ asset('img/images/quicktoolscard/QuickSummary1.png') }}" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title-head">ESRD Patient</h5>
                            <a href="{{ route('admin.esrdpatients') }}" class="btn btn-primary stretched-link">Click Image for the Report</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    
                        <div class="card quicktool-card">
                            <div class="card-img">
                                <img src="{{ asset('img/images/quicktoolscard/late-stage-ckd.png') }}" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title-head">Late Stage CKD</h5>
                                <a href="{{ route('admin.late-stage-ckd-patient') }}" class="btn btn-primary stretched-link">Click Image for the Report</a>
                            </div>
                        </div>
                    
                </div>
                <div class="col-md-3">
                    
                        <div class="card quicktool-card">
                            <div class="card-img">
                                <img src="{{ asset('img/images/quicktoolscard/practice-revenue.png') }}" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title-head">Practice Revenue</h5>
                                <a href="{{ route('admin.practice-revenue') }}" class="btn btn-primary stretched-link">Click Image for the Report</a>
                            </div>
                        </div>
                
                </div>
                <div class="col-md-3">
                    
                        <div class="card quicktool-card">
                            <div class="card-img">
                                <img src="{{ asset('img/images/quicktoolscard/productivity-others.png') }}" class="card-img-top" alt="...">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title-head">Productivity/Other</h5>
                                <a href="{{ route('admin.productivity-others') }}" class="btn btn-primary stretched-link">Click Image for the Report</a>
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
    