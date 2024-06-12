@extends('frontend.layouts.login')

{{--@section('content')--}}

{{--    <div class="row">--}}
    
{{--        <div class="col-md-6 col-md-offset-3">--}}
{{--        <div class="asas col-md-6 col-md-offset-3">--}}

{{--            <div class="panel panel-default">--}}
{{--                <div class="panel-heading">{{ trans('labels.frontend.auth.login_box_title') }}</div>--}}

{{--                <div class="panel-body">--}}
{{--                    @include('includes.partials.messages')--}}
{{--                    {{ Form::open(['route' => 'frontend.auth.login', 'class' => 'form']) }}--}}

{{--                    <div class="form-group">--}}
{{--                        {{ Form::label('email', trans('validation.attributes.frontend.register-user.email'), ['class' => 'col-md-12 control-label']) }}--}}
{{--                        <div class="col-md-12">--}}
{{--                            {{ Form::input('email', 'email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.email')]) }}--}}
{{--                        </div><!--col-md-6-->--}}
{{--                    </div><!--form-group-->--}}

{{--                    <div class="form-group">--}}
{{--                        {{ Form::label('password', trans('validation.attributes.frontend.register-user.password'), ['class' => 'col-md-12 control-label']) }}--}}
{{--                        <div class="col-md-12">--}}
{{--                            {{ Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.password')]) }}--}}
{{--                        </div><!--col-md-6-->--}}
{{--                    </div><!--form-group-->--}}

{{--                    <div class="form-group col-md-12">--}}
{{--                            <div class="checkbox">--}}
{{--                            <label>--}}
{{--                                {{ Form::checkbox('remember') }} {{ trans('labels.frontend.auth.remember_me') }}--}}
{{--                            </label>--}}
{{--                        </div><!--col-md-6-->--}}
{{--                    </div><!--form-group-->--}}

{{--                    <div class="form-group">--}}
{{--                        <div class="col-md-12">--}}
{{--                            {{ Form::submit(trans('labels.frontend.auth.login_button'), ['class' => 'btn btn-primary', 'style' => 'margin-right:15px']) }}--}}
{{--                            {{ link_to_route('frontend.auth.password.reset', trans('labels.frontend.passwords.forgot_password')) }}--}}
{{--                        </div><!--col-md-6-->--}}
{{--                    </div><!--form-group-->--}}

{{--                    {{ Form::close() }}--}}

{{--                    <div class="row text-center">--}}

{{--                    </div>--}}
{{--                </div><!-- panel body -->--}}

{{--            </div><!-- panel -->--}}

{{--        </div><!-- col-md-8 -->--}}

{{--    </div><!-- row -->--}}

{{--@endsection--}}


@section('content-new')

    <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
                <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                    <div class="brand-logo text-center">
                        <img src="{{ asset('img/images/newlogo.png') }}" alt="logo">
                    </div>

                    <h4 class="login"></h4>
{{--                    @if ($errors->any())--}}
{{--                        <div class="alert alert-danger">--}}
{{--                            <ul>--}}
{{--                                @foreach ($errors->all() as $error)--}}
{{--                                    <li>{{ $error }}</li>--}}
{{--                                @endforeach--}}
{{--                            </ul>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                    @include('includes.partials.messages')
                    {{ Form::open(['route' => 'frontend.auth.login', 'class' => 'forhow tom pt-3']) }}
                    <div class="form-group">
                    <!-- {{ Form::label('email', trans('validation.attributes.frontend.register-user.email'), ['class' => 'col-md-12 control-label']) }} -->
                        <div class="col-md-12">
                            {{ Form::input('email', 'email', null, ['class' => 'form-control form-control-lg', 'placeholder' => trans('validation.attributes.frontend.register-user.email')]) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    <div class="form-group">
                    <!-- {{ Form::label('password', trans('validation.attributes.frontend.register-user.password'), ['class' => 'col-md-12 control-label']) }} -->
                        <div class="col-md-12">
                            {{ Form::input('password', 'password', null, ['class' => 'form-control form-control-lg', 'placeholder' => trans('validation.attributes.frontend.register-user.password')]) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    <div class="my-2 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <label class="form-check-label text-muted">
                                <a href="{{route('frontend.auth.password.reset')}}" class="auth-link" style="color:#842d72;">Forgot password?</a>
                            </label>
                        </div><!--col-md-6-->
                    </div><!--form-group-->
                    <!-- <div class="form-group col-md-12">

                    </div> -->
                    <div class="form-group">
                        <div class="col-md-12 text-center login-cont">
                            {{ Form::submit(trans('labels.frontend.auth.login_button'), ['class' => 'btn btn-block btn-lg font-weight-medium auth-form-btn', 'style' => 'margin-right:15px']) }}

                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    {{ Form::close() }}
                    <div class="mt-3">
                        {{--<p style="color: #296a81;font-size: 14px; text-align: center;">Already have an account? <a href="" style="color: #04b4f0;"> Register</a></p>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
    <div class="d-sm-flex  dashboard-footer justify-content-center justify-content-sm-between">
                <div class="copyright-text">
                    <div class="text-center " style="color: #842d72;">Copyright © {{date('Y')}} Nephrolytics, LLC. All rights reserved.</div>
                </div>
    </div>
</footer>
@endsection