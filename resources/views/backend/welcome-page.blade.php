@extends('frontend.layouts.login')

@section('content-new')

    <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
                <div class="auth-form-light text-left py-5 px-4 px-sm-5">

                    <div class="text-center">
                        <img width="85px" src="{{ asset('img/images/newlogo.png') }}" alt="logo"/>
                    </div>
                    <div class="text-center">
                        <h4 class="client-portal mt-2 font-weight-bold">{{ env('APP_NAME')}}</h4>
                    </div>
                    <br>
                    @include('includes.partials.messages')
                    @if(session()->has('success'))
                        <p class="alert alert-info" style="display: block !important;">
                            {{ session()->get('success') }}
                        </p>
                    @elseif(session()->has('error'))
                        <p class="alert alert-danger" style="display: block !important;">
                            {{ session()->get('error') }}
                        </p>
                    @endif
                    {{ Form::open(['route' => 'changePassword', 'class' => 'form-horizontal']) }}
                    <input type="hidden" name="token" value="{{ request()->segment(count(request()->segments())) }}">

                    <div class="form-group mt-4">
                        {{ Form::label('email', trans('validation.attributes.frontend.register-user.email'), ['class' => 'col-md-12 login-labels control-label']) }}
                        <div class="col-md-12">
                            {{ Form::input('text', 'email', $user->email, ['class' => 'form-control', 'readonly','placeholder' => 'Email']) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->


                    <div class="form-group">
                        {{ Form::label('first_name', trans('validation.attributes.frontend.register-user.firstName').'*', ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-12">
                            {{ Form::input('name', 'first_name', $user->first_name, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.firstName')]) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    <div class="form-group">
                        {{ Form::label('last_name', trans('validation.attributes.frontend.register-user.lastName').'*', ['class' => 'col-md-4 control-label']) }}
                        <div class="col-md-12">
                            {{ Form::input('name', 'last_name', $user->last_name, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.lastName')]) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    {{--<div class="form-group">--}}
                    {{--{{ Form::label('phone', 'Phone'.'*', ['class' => 'col-md-4 control-label']) }}--}}
                    {{--<div class="col-md-12">--}}
                    {{--{{ Form::input('name', 'phone', $user->person->phone, ['class' => 'form-control', 'placeholder' => 'Phone']) }}--}}
                    {{--</div><!--col-md-6-->--}}
                    {{--</div><!--form-group-->--}}

                    {{--<div class="form-group">--}}
                    {{--{{ Form::label('dob', 'Date of Birth'.'*', ['class' => 'col-md-4 control-label']) }}--}}
                    {{--<div class="col-md-12">--}}
                    {{--{{ Form::input('name', 'dob', $user->person->date_birth, ['class' => 'form-control', 'placeholder' => 'date']) }}--}}
                    {{--</div><!--col-md-6-->--}}
                    {{--</div><!--form-group-->--}}


                    <div class="form-group">
                        {{ Form::label('password', 'New Password', ['class' => 'col-md-12 login-labels control-label']) }}
                        <div class="col-md-12">
                            {{ Form::input('password', 'password', null, ['class' => 'form-control','required','title' => 'At least one uppercase letter, one lowercase letter, one number and one special character.' ,'pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$' ,'placeholder' => trans('validation.attributes.frontend.register-user.password')]) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    <div class="form-group">
                        {{ Form::label('confirm_password', 'Confirm Password', ['class' => 'col-md-12 login-labels control-label']) }}
                        <div class="col-md-12">
                            {{ Form::input('password', 'confirm_password', null, ['class' => 'form-control','required' ,'placeholder' => 'Confirm Password']) }}
                        </div><!--col-md-6-->
                    </div><!--form-group-->


                    <div class="form-group mt-2">
                        <div class="col-md-12 col-md-offset-4">
                            {{ Form::submit('Complete Registration', ['class' => 'login-btn btn btn-primary','style'=>'width:100%']) }}

                        </div><!--col-md-6-->
                    </div><!--form-group-->

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

@endsection