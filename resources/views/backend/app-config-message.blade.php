@extends('frontend.layouts.login')

{{--@section('after-styles')--}}

{{--@endsection--}}

@section('content-new')

    <div class="row w-100 mx-0">
        <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 ">

                <div class="text-center">
                    <img width="85px" src="{{ asset('img/images/newlogo.png') }}" alt="logo"/>
                </div>
{{--                <div class="text-center">--}}
{{--                    <h4 class="client-portal mt-2 font-weight-bold">{{ env('APP_NAME')}}</h4>--}}
{{--                </div>--}}
                <br>
                @include('includes.partials.messages')
                <p class="alert alert-info" >
                    Application configured successfully and activation email has been sent.
                </p>
                @if(session()->has('error'))
                    <p class="alert alert-danger">
                        {{ session()->get('error') }}
                    </p>
                @endif

            </div>
        </div>
    </div>
@endsection
