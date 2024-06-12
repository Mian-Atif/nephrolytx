<!doctype html>
<html class="no-js" lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon_icon/nephro-fav.png')}}">
    <title>@yield('title', app_name())</title>
    <!-- Meta -->
    <meta name="description" content="@yield('meta_description', 'Default Description')">
    <meta name="author" content="@yield('meta_author', 'Viral Solani')">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet">

    @yield('meta')
<!-- Styles -->
    @yield('before-styles')

<!-- Check if the language is set to RTL, so apply the RTL layouts -->
    <!-- Otherwise apply the normal LTR layouts -->
    @yield('meta')
    {{--    <link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">--}}
    {{--    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">--}}

    {{--<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.1/css/all.min.css">
    <!-- Styles -->
    @yield('before-styles')

    {{ Html::style(asset('css/ti-icons/css/themify-icons.css')) }}
    {{ Html::style(asset('css/vendor.bundle.base.css')) }}
    {{ Html::style(asset('css/style.css')) }}

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

</head>
<body>
<div class="container-scroller">

    <!-- partial:partials/_sidebar.html -->
<!-- partial -->
    <div class="container-fluid page-body-wrapper full-page-wrapper">

    @if (Auth::check())
    @include('frontend.includes.header-nav')
    @endif
        @if(isset($msg) && !is_null($msg))
            jksahdksadhk
            @endif

            @yield('content-new')


        <!-- content-wrapper ends -->

    </div>
    <!-- main-panel ends -->
</div>
<!-- JavaScripts -->
@yield('before-scripts')

{{ Html::script(asset('vendors/js/vendor.bundle.base.js')) }}
{{ Html::script(asset('js/template/js/off-canvas.js')) }}
{{ Html::script(asset('js/template/js/hoverable-collapse.js')) }}
{{ Html::script(asset('js/template/js/template.js')) }}


<!-- End plugin js for this page -->
<!-- Custom js for this page-->
<script src=""></script>

@yield('after-scripts')
</body>
</html>