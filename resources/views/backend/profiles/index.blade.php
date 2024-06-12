@extends ('backend.layouts.backend')

@section('content-new')


{{--    @if ($errors->any())--}}
{{--        <div class="row">--}}
{{--            <div class="col-12">--}}
{{--                <div class="alert alert-danger">--}}
{{--                    <ul>--}}
{{--                        @foreach ($errors->all() as $error)--}}
{{--                            <li>{{ $error }}</li>--}}
{{--                        @endforeach--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}

    @if(session()->has('message'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            </div>
        </div>

    @endif
    <div class="row">
        <div class="col-12">
            {{ Form::open(['route' => 'admin.updateprofile', 'class' => 'form', 'role' => 'form', 'method' => 'post', 'files' => true]) }}


            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Name</label>
                        {{ Form::text('name', !is_null($user)?$user->name:'', ['class' => 'form-control', 'placeholder' => 'Name', 'required' => 'required']) }}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Email</label>
                        {{ Form::email('email', !is_null($user)?$user->email:'', ['class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required', 'readonly' => 'readonly','disabled' => true,'style'=>'color:#000;' ]) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Current Password </label>
                        {{ Form::password('current_password',['class' => 'form-control','required' => 'required'],null) }}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>New Password <span> </span></label>
                        {{ Form::password('password',  ['class' => 'form-control','required' => 'required'],null) }}
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label>Confirm Password</label>
                        {{ Form::password('confirm_password',['class' => 'form-control','required' => 'required'],null) }}
                    </div>
                </div>
            </div>


            {{ Form::submit(trans('Update'), ['class' => 'btn btn-primary btn-md']) }}
        </div>

    </div>
@endsection

@section('after-scripts')

@endsection
