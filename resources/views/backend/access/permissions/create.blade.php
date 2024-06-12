@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.access.permissions.management') . ' | ' . trans('labels.backend.access.permissions.create'))

@section('page-header')

        {{ trans('labels.backend.access.permissions.management') }}
        <small>{{ trans('labels.backend.access.permissions.create') }}</small>

@endsection

@section('content-new')
    <div class="box-tools text-right" style="margin-bottom: -34px;">
        @include('backend.access.includes.partials.permission-header-buttons')
    </div><!--box-tools pull-right-->
    {{ Form::open(['route' => 'admin.access.permission.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-permission']) }}

        <div class="card">

            <div class="box-body">

                {{-- Including Form --}}
                <div class="row">
                    @include("backend.access.permissions.form")
                </div>

                <div class="edit-form-btn">
                    {{ link_to_route('admin.access.permission.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                    <div class="clearfix"></div>
                </div>
            </div><!-- /.box-body -->
        </div><!--box-->
    {{ Form::close() }}
@endsection
