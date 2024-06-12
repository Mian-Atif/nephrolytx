{{--@extends('backend.layouts.app')--}}
@extends('backend.layouts.backend')

{{--@section('page-header')--}}
{{--<h1>--}}
{{--{{ app_name() }}--}}
{{--<small>{{ trans('strings.backend.dashboard.title') }}</small>--}}
{{--</h1>--}}
{{--@endsection--}}




@section('content-new')
    <div class="content-wrapper">

        <div class="row">
            <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="patients" >
                                <h4 class="pt-1 text-purple" style="border-left: 4px solid #f7af27; border-radius: 2px;
                                        height: 24px;padding: 0 29px;margin-left: -24px;">Practices</h4>
                                <h4 class="text-white mt-3 pl-2" style="font-size: 24px;">{{ $countPractice  }}</h4>
                                <!--<h6 class="text-muted">35.19% Since last month</h6>-->
                            </div>
                            <!-- <div class="icon-box icon-box-bg-image-warning">
                                 <i class="fas fa-users gradient-card-icon"></i>
                             </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="pt-1 text-purple" style="border-left: 4px solid #3add99; border-radius: 2px;
                                        height: 24px;padding: 0 29px;margin-left: -24px;">Users</h4>
                                <h4 class="text-white mt-3 pl-2" style="font-size: 24px;">{{ $countUser  }}</h4>
                                <!--<h6 class="text-muted">73.52% Since last month</h6>-->
                            </div>
                            <!--  <div class="icon-box icon-box-bg-image-info">
                                  <i class="fas fa-users gradient-card-icon"></i>
                              </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="pt-1 text-purple" style="border-left: 4px solid #04b4f0; border-radius: 2px;
                                        height: 24px;padding: 0 29px;margin-left: -24px;">Persons</h4>
                                <h4 class="text-white mt-3 pl-2" style="font-size: 24px;">{{ $countPerson  }}</h4>
                                <!--<h6 class="text-muted">49.39% Since last month</h6>-->
                            </div>
                            <!--  <div class="icon-box icon-box-bg-image-danger">
                                  <i class="fas fa-users gradient-card-icon"></i>
                              </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-xl-3 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="pt-1 text-purple" style="border-left: 4px solid #744af4; border-radius: 2px;
                                        height: 24px;padding: 0 29px;margin-left: -24px;">Providers</h4>
                                <h4 class="text-white mt-3 pl-2" style="font-size: 24px;">{{ $countProvider  }}</h4>
                                <!--<h6 class="text-muted">18.33% Since last month</h6>-->
                            </div>
                            <!--  <div class="icon-box icon-box-bg-image-success">
                                  <i class="fas fa-users gradient-card-icon"></i>
                              </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('after-scripts')
    {{ Html::script(asset('js/template/js/dashboard2.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}
@endsection