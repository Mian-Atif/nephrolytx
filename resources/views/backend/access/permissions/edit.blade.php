@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.access.permissions.management') . ' | ' . trans('labels.backend.access.permissions.edit'))

@section('page-header')

        {{ trans('labels.backend.access.permissions.management') }}
        <small>{{ trans('labels.backend.access.permissions.edit') }}</small>

@endsection

@section('content-new')
    <div class="box-tools text-right" style="margin-top: -35px;">
        @include('backend.access.includes.partials.permission-header-buttons')
    </div><!--box-tools pull-right-->
    {{ Form::model($permission, ['route' => ['admin.access.permission.update', $permission], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-role']) }}


    <div class="card">
        <div class="card-body">
            {{-- Including Form --}}
            <div class="row">
                @include("backend.access.permissions.form")
            </div>

            <div class="edit-form-btn">
                {{ link_to_route('admin.access.permission.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                <div class="clearfix"></div>
            </div>
        </div>
    </div>


    {{ Form::close() }}
@endsection