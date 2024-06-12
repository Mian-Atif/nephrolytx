{{--@extends ('backend.layouts.app')--}}
@extends ('backend.layouts.dashboard')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.change_password'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.access.users.management') }}
        <small>{{ trans('labels.backend.access.users.change_password') }}</small>
    </h1>

@endsection
@section('content-new')
    <div class="content-wrapper">
    <div class="row">
    <div class="col-12 grid-margin stretch-card">
    <div class="card">
    <div class="card-body">
        {{ Form::open(['route' => ['admin.access.user.change-password', $user], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'patch']) }}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="box-body">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ trans('labels.backend.access.users.change_password_for', ['user' => $user->name]) }}</h3>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                {{ Form::label('old password', trans('validation.attributes.backend.access.users.old_password'), ['class' => 'col-lg-12 control-label required', 'placeholder' => trans('validation.attributes.backend.access.users.password')]) }}

                                <div class="col-lg-12">
                                    {{ Form::password('old_password', ['class' => 'form-control  box-size']) }}
                                </div><!--col-lg-10-->
                            </div><!--form control-->

                            <div class="form-group col-md-4">
                                {{ Form::label('password', trans('validation.attributes.backend.access.users.password'), ['class' => 'col-lg-12 control-label required', 'placeholder' => trans('validation.attributes.backend.access.users.password')]) }}

                                <div class="col-lg-12 mce-box">
                                    {{ Form::password('password', ['class' => 'form-control  box-size']) }}
                                </div><!--col-lg-10-->
                            </div><!--form control-->
                            <div class="form-group col-md-4">
                                {{ Form::label('password_confirmation', trans('validation.attributes.backend.access.users.password_confirmation'), ['class' => 'col-lg-12 control-label', 'placeholder' => trans('validation.attributes.backend.access.users.password_confirmation')]) }}

                                <div class="col-lg-12">
                                    {{ Form::password('password_confirmation', ['class' => 'form-control  box-size']) }}
                                </div><!--col-lg-10-->
                            </div><!--form control-->

                        </div>
                    </div>

                    {{--                @include("backend.person.form")--}}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            {{ link_to_route('admin.access.user.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
            {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
        </div>
        {{ Form::close() }}
    </div>
    </div>
    </div>
    </div>
    </div>


@endsection