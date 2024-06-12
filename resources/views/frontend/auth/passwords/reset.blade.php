@extends('frontend.layouts.login')
@section('content-new')
    <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
                <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                    <div class="brand-logo text-center">
                        <img src="{{ asset('img/images/newlogo.png') }}" alt="logo">
                    </div>

                    <h4 class="login">{{ trans('labels.frontend.passwords.reset_password_box_title') }}</h4>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @include('includes.partials.messages')
                    {{ Form::open(['route' => 'frontend.auth.password.reset', 'class' => 'form pt-3']) }}
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
{{--                        <p class="form-control-static">{{ $email }}</p>--}}
                        <div class="col-md-12">
                        {{ Form::input('email', 'email', $email, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.email'),'readonly']) }}
                        </div>
                        {{--                    <!-- {{ Form::label('email', trans('validation.attributes.frontend.register-user.email'), ['class' => 'col-md-12 control-label']) }} -->--}}
                    </div>

                        <div class="form-group">

                        <div class="col-md-12">
                            {{ Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.password'),'required' =>'required']) }}
                        </div><!--col-md-6-->
                        </div><!--form-group-->
                    <div class="form-group">
                        {{--                        {{ Form::label('password_confirmation', trans('validation.attributes.frontend.register-user.password_confirmation'), ['class' => 'col-md-4 control-label']) }}--}}
                        <div class="col-md-12">
                            {{ Form::input('password', 'confirm_password', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.password_confirmation'),'required' =>'required']) }}
                        </div><!--col-md-6-->
                    </div>
                    {{--                    </div> -->--}}
                    <div class="form-group">
                        <div class="col-md-12">
                            {{ Form::submit(trans('labels.frontend.passwords.send_password_reset_link_button'), ['class' => 'btn btn-block btn-lg font-weight-medium auth-form-btn', 'style' => 'margin-right:15px']) }}

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

@endsection