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
                    <div class="col-sm-12 text-center">
                        <h4 class="client-portal mt-2 font-weight-bold"><u>Admin User Information</u></h4>
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
                    {{ Form::open(['route' => 'registerAdminUser', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-corporateclient']) }}
                    <input type="hidden" name="token" value="{{ request()->segment(count(request()->segments())) }}">

                    <div class="row">

                        <div class="form-group col-sm-12">
                            {{ Form::label('name', 'First Name', ['class' => 'control-label required']) }}
                            {{ Form::text('first_name', null, ['class' => 'form-control box-size', 'placeholder' => 'First Name', 'required' => 'required']) }}
                        </div><!--form control-->

                        <div class="form-group col-sm-12">
                            {{ Form::label('name', 'Last Name', ['class' => 'control-label required']) }}
                            {{ Form::text('last_name', null, ['class' => 'form-control box-size', 'placeholder' => 'Last Name', 'required' => 'required']) }}

                        </div><!--form control-->


                        <div class="form-group col-sm-12">
                            {{ Form::label('name', 'Email', ['class' => 'control-label required']) }}
                            {{ Form::text('email', null, ['class' => 'form-control box-size', 'placeholder' => 'Email', 'required' => 'required']) }}
                        </div><!--form control-->

                    </div>


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