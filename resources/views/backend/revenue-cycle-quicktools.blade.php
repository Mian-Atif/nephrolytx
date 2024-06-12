@extends('backend.layouts.dashboard')


@section('content-new')



<div class="content-wrapper">

    <div class="row">
        <div class="mt-5 col-md-12 quicksummarycard pos-rel">
            <div class="text-center">
               
                <div class="mt-2 quicksummarytext">
                    <h3>Revenue Cycle</h3>
                </div>
            </div>
          
            <div class="row">
                <div class="col-md-3">
                    <div class="card quicktool-card">
                        <div class="card-img">
                            <img src="{{ asset('img/images/quicktoolscard/summary-optimal-summary.png') }}" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title-head fw-bold">Summary</h5>
                            <a href="{{ route('admin.summary-revenue-cycle') }}" class="btn btn-primary stretched-link">Click Image for the Report</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">

                    <div class="card quicktool-card">
                        <div class="card-img">
                            <img src="{{ asset('img/images/quicktoolscard/office-services.png') }}" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title-head fw-bold">Office Service</h5>
                            <a href="{{ route('admin.office-services') }}" class="btn btn-primary stretched-link">Click Image for the Report</a>
                        </div>
                    </div>

                </div>
                <div class="col-md-3">

                    <div class="card quicktool-card">
                        <div class="card-img">
                            <img src="{{ asset('img/images/quicktoolscard/Hospital-services.png') }}" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title-head fw-bold">Hospital Services</h5>
                            <a href="{{ route('admin.hospital-services-revenue-cycle') }}" class="btn btn-primary stretched-link">Click Image for the Report</a>
                        </div>
                    </div>

                </div>
                <div class="col-md-3">

                    <div class="card quicktool-card">
                        <div class="card-img">
                            <img src="{{ asset('img/images/quicktoolscard/Mcp-services.png') }}" class="card-img-top" alt="...">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title-head fw-bold">MCP Services</h5>
                            <a href="{{ route('admin.mcp-services') }}" class="btn btn-primary stretched-link">Click Image for the Report</a>
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
{{-- {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
{{ Html::script(asset('js/template/js/fusioncharts.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}