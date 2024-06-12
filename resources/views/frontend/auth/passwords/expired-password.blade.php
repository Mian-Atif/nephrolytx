@extends('frontend.layouts.app')

@section('content')

    <div class="row w-100 mx-0">
        <div class="col-lg-4 mx-auto">


            <div class="auth-form-light text-left py-5 px-4 ">
                <div class="text-center">
                    <img width="85px" src="{{ asset('img/backend/logo-white.png') }}" alt="logo"/>
                </div>
                <div class="text-center">
                    <h4 class="client-portal mt-2 font-weight-bold">{{ env('APP_NAME')}}</h4>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <br>
                        @include('includes.partials.messages')
                        <br>
                        @if (session('status'))
                            <div class="alert alert-success" style="display: block;">
                                {{ session('status') }}
                            </div>
                            <hr>
                        @endif
                    </div>
                </div>

                <h3 class="text-center">{{ trans('labels.frontend.passwords.reset_password_box_title') }}</h3>

                {{ Form::open(['route' => 'password.post_expired', 'class' => 'form-horizontal']) }}

                <div class="form-group">
                    {{ Form::label('current_password','Current Password', ['class' => 'col-md-12 control-label']) }}
                    <div class="col-md-12">
                        {{ Form::input('password', 'current_password', null, ['class' => 'form-control', 'placeholder' => 'Current Password']) }}
                    </div><!--col-md-6-->
                </div><!--form-group-->

                <div class="form-group">
                    {{ Form::label('New password', 'New Password', ['class' => 'col-md-12 control-label']) }}
                    <div class="col-md-12">
                        {{ Form::input('password', 'password', null, ['class' => 'form-control', 'placeholder' => 'New Password']) }}
                    </div><!--col-md-6-->
                </div><!--form-group-->

                <div class="form-group">
                    {{ Form::label('password_confirmation', trans('validation.attributes.frontend.register-user.password_confirmation'), ['class' => 'col-md-12 control-label']) }}
                    <div class="col-md-12">
                        {{ Form::input('password', 'password_confirmation', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.frontend.register-user.password_confirmation')]) }}
                    </div><!--col-md-6-->
                </div><!--form-group-->

                <div class="form-group">
                    <div class="col-md-12 col-md-offset-4">
                        {{ Form::submit('Change Password', ['class' => 'btn btn-info']) }}
                    </div><!--col-md-6-->
                </div><!--form-group-->

                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
