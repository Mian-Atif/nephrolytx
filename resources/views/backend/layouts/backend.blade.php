<!doctype html>
<html class="no-js" lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="icon" sizes="16x16" type="image/png" href="{{route('frontend.index')}}/img/favicon_icon/{{settings()->favicon}}"> --}}
    <title>@yield('title', app_name())</title>
    <!-- Meta -->
    <meta name="description" content="@yield('meta_description', 'Default Description')">
    <meta name="author" content="@yield('meta_author', 'Viral Solani')">
    <link href="https://fonts.googleapis.com/css?family=Fira+Sans" rel="stylesheet">
    @yield('meta')
<!-- Styles -->

<!-- {{-- {{ Html::style(mix('css/backend.css')) }} --}} -->
    @yield('before-styles')

<!-- Check if the language is set to RTL, so apply the RTL layouts -->
    <!-- Otherwise apply the normal LTR layouts -->



    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.1/css/all.min.css">
    <!-- Styles -->
    @yield('before-styles')
{{--    @langrtl--}}
{{--    {{ Html::style(getRtlCss(mix('css/backend.css'))) }}--}}
{{--    --}}{{--@else--}}
{{--        {{ Html::style(mix('css/backend.css')) }}--}}
{{--        @endlangrtl--}}
{{--        {{ Html::style(mix('css/backend-custom.css')) }}--}}

{{--    {{ Html::style(mix('css/backend-custom.css')) }}--}}

    {{--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.1/css/all.min.css">
    <!-- Styles -->
    @yield('before-styles')
 {{--   @langrtl
        {{ Html::style(getRtlCss(mix('css/backend.css'))) }}
        @else
            {{ Html::style(mix('css/backend.css')) }}
            @endlangrtl--}}
{{--        {{ Html::style(mix('css/backend-custom.css')) }}--}}

{{--    {{ Html::style(mix('css/backend-custom.css')) }}--}}
{{--   --}}
     {{ Html::style(asset('css/ti-icons/css/themify-icons.css')) }}
    {{ Html::style('css/vendor.bundle.base.css') }}
    {{ Html::style('vendors/select2/select2.min.css') }}
    {{ Html::style('vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}
    {{ Html::style('vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}
    {{ Html::style('vendors/jquery-asColorPicker/css/asColorPicker.min.css') }}
    {{ Html::style('vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}
    {{ Html::style('vendors/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}
    {{ Html::style('vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}
    {{ Html::style('css/style-old.css') }}

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    @yield('after-styles')
        <!--[endif]-->

        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([ 'csrfToken' => csrf_token() ]) !!};
        </script>
        <?php
        if (!empty($google_analytics)) {
            echo $google_analytics;
        }
        ?>
    <style>
        .twitter-typeahead { display:block !important; }
        .raphael-group-152-background rect, .raphael-group-226-background rect, .raphael-group-thkhLZUh text{ fill: #f7fdff !important;}
        .raphael-group-17-caption text, .raphael-group-92-caption text,
        .raphael-group-54-dataset-top-label text, .raphael-group-90-datalabel text,
        .raphael-group-129-dataset-top-label text, .raphael-group-15-datalabel text{fill:#fff !important;}
        .profile-wrap {list-style:none;}
        .profile-wrap li {
            margin-bottom: 8px;
        }
        .profile-wrap li div.profile-title {
            width: 150px;
            margin-right: 20px;
            text-transform: capitalize;
            color: #000;
            display: inline-block;
        }
        .profile-wrap li .profile-desc {
            display: inline-block;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: solid black 1px;
            outline: 0;
            background: none !important;
            height: 40px !important;
            overflow-y: scroll !important;
        }
        .select2-container--default .select2-selection--multiple{
            background:none !important;
            height: 40px !important;
            border: 1px solid #bce0ea !important;
        }
        .dropdown-menu-right li{padding: 0 5px;color:#fff;font-size: 13px;}
        .dropdown-menu-right li a{color:#fff;}
        .dropdown-menu-right li a i{margin-right: 5px;}
    </style>
</head>
<body>
<div class="loading" style="display:none"></div>
@include('includes.partials.logged-in-as')
<div class="container-scroller">
    <!-- partial:partials/_sidebar.html -->
@include('backend.includes.backend-sidebar-new')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        @include('backend.includes.header-nav')
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="card-title">@yield('page-header')</h3>
                                @include('includes.partials.messages')
                                @yield('content-new')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('backend.includes.footer')
        </div>
        <!-- content-wrapper ends -->

    </div>
    <!-- main-panel ends -->
</div>
<!-- JavaScripts -->
@yield('before-scripts')

{{ Html::script('vendors/js/vendor.bundle.base.js') }}

{{ Html::script('vendors/flot/jquery.flot.js') }}
{{ Html::script('vendors/flot/jquery.flot.resize.js') }}
{{ Html::script('vendors/chart.js/Chart.min.js') }}
<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
<script type="text/javascript" src="https://unpkg.com/jquery-fusioncharts@1.1.0/dist/fusioncharts.jqueryplugin.js"></script>

{{ Html::script('js/template/js/off-canvas.js') }}
{{ Html::script('js/template/js/hoverable-collapse.js') }}
{{ Html::script('js/template/js/template.js') }}
{{ Html::script('js/template/js/dashboard2.js') }}
{{ Html::script('vendors/inputmask/jquery.inputmask.bundle.js') }}
{{ Html::script('vendors/typeahead.js/typeahead.bundle.min.js') }}
{{ Html::script('js/template/js/inputmask.js') }}
{{ Html::script('vendors/select2/select2.min.js') }}
{{ Html::script('js/template/js/typeahead.js') }}
{{ Html::script('js/template/js/select2.js') }}

{{ Html::script('js/backend.js') }}
{{--{{ Html::script(mix('js/backend-custom.js')) }}--}}

{{ Html::script('vendors/jquery-asColor/jquery-asColor.min.js') }}
{{ Html::script('vendors/jquery-asGradient/jquery-asGradient.min.js') }}
{{ Html::script('vendors/jquery-asColorPicker/jquery-asColorPicker.min.js') }}
{{ Html::script('vendors/moment/moment.min.js') }}
{{ Html::script('vendors/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js') }}
{{ Html::script('vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}
{{ Html::script('vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}

{{ Html::script('js/template/js/formpickers.js') }}
{{ Html::script('js/template/js/tooltips.js') }}

{{ Html::script('vendors/datatables.net/jquery.dataTables.js') }}
{{ Html::script('vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}
{{ Html::script(('js/template/js/data-table.js')) }}
{{--{{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js') }}--}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>
<link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css'/>
<script type="text/javascript">
    $('.daterange').daterangepicker();
</script>
<!-- End plugin js for this page -->
<!-- Custom js for this page-->

<script>
     $(document).ready(function () {
              $('#profileDropdown').on('click', function () {
                  
                  if ($('.dropdown-menu').hasClass('show')) {
                      $('.dropdown-menu').removeClass('show');
                  }
                  else {
                      $('.dropdown-menu').addClass('show');
                  }
              });
          });
          function closeMenu(){
            if ($('.dropdown-menu').hasClass('show')) {
                      $('.dropdown-menu').removeClass('show');
                  } 
}

$(document.body).click( function(e) {
     closeMenu();
});

</script>

@yield('after-scripts')
</body>
</html>