@extends('frontend.layouts.login')

@section('content-new')
<style>
    .navbar{
        display:none !important;
    }
</style>
    <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
                <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                    <div class="text-center">
                        <img width="180px" src="{{ asset('img/images/newlogo.png') }}" alt="logo"/>
                    </div>
                    <br>
                    @if(session()->has('success'))
                        <p class="alert alert-info" style="display: block !important;">
                            {{ session()->get('success') }}
                        </p>
                    @elseif(session()->has('error'))
                        <p class="alert alert-danger" style="display: block !important;">
                            {{ session()->get('error') }}
                        </p>
                    @endif
                    
                    <form method="POST" action="{{ route('verify.store') }}">
                        {{ csrf_field() }}
                        <h3 class="panel-heading">Two Factor Verification</h3>
                        <p class="text-muted">
                            You have received an email which contains two factor login code.
                            If you haven't received it, press <a href="{{ route('verify.resend') }}">here</a>.
                        </p>
                        <br>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-lock"></i>
                            </span>
                            </div>
                            <input name="two_factor_code" type="text"
                                   class="form-control{{ $errors->has('two_factor_code') ? ' is-invalid' : '' }}"
                                   required autofocus placeholder="Two Factor Code">
                            @if($errors->has('two_factor_code'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('two_factor_code') }}
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                {{ Form::submit('Verify', ['class' => 'login-btn btn btn-primary','style'=>'width:50%']) }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center">
                                <br><br>
                                <a href="{{ url('logout') }}">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
