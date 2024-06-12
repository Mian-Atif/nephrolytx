
@extends('frontend.layouts.app')

@section('title',  'Be right back.')
@section('meta')
    <meta name="viewport" content="width=device-width, initial-scale=1">
@endsection

@section('content')

    <div class="row w-100 mx-0">
        <div class="col-lg-8 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 ">

                <div class="text-center">
                    <img width="85px" src="{{ asset('img/backend/logo-white.png') }}" alt="logo"/>
                </div>
                <div class="text-center">
                    <h4 class="client-portal mt-2 font-weight-bold">{{ env('APP_NAME')}}</h4>
                </div>
                <br>
                <div class="text-center"><a href="">Be right back.</a></div>

            </div>
        </div>
    </div>
@endsection