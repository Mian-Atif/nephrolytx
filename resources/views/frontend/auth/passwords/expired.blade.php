@extends('frontend.layouts.login')
@section('content-new')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-2 reset-panel">
                <div class="panel panel-default">
                    <div class="panel-heading reset-password mt-5">Reset Password</div>

                    <div class="panel-body mt-4">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                            <a href="{{route('admin.practiceDashboard')}}">Return to homepage</a>
                        @else
                            <div class="alert alert-info">
                                Your password has expired, please change it.
                            </div>
                            <form class="form-horizontal" method="POST" action="{{ route('password-expired.store') }}">
                                {{ csrf_field() }}

                                <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                                    <label for="current_password" class="col-md-12 control-label">Current Password</label>

                                    <div class="col-md-12">
                                        <input id="current_password" type="password" class="form-control " name="current_password" required="required">

                                        @if ($errors->has('current_password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('current_password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-12 control-label">New Password</label>

                                    <div class="col-md-12">
                                        <input id="password" type="password" class="form-control" name="password" required="required">

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                    <label for="confirm_password" class="col-md-12 control-label">Confirm New Password</label>
                                    <div class="col-md-12">
                                        <input id="confirm_password" type="password" class="form-control" name="confirm_password" required="required">

                                        @if ($errors->has('confirm_password'))
                                            <span class="help-block">
                                        <strong>{{ $errors->first('confirm_password') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12 col-md-offset-4" style="text-align: center;">
                                        <button type="submit"  class="btn btn-lg btn-primary">
                                            Reset Password
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection