@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.billingmanagers.management') . ' | ' . trans('labels.backend.billingmanagers.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.billingmanagers.management') }}
        <small>{{ trans('labels.backend.billingmanagers.edit') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($billingmanagers, ['route' => ['admin.billingmanagers.update', $billingmanager], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-billingmanager']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.billingmanagers.edit') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.billingmanagers.partials.billingmanagers-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!--box-header with-border-->

            <div class="box-body">
                <div class="form-group">
                    {{-- Including Form blade file --}}
                    @include("backend.billingmanagers.form")
                    <div class="edit-form-btn">
                        {{ link_to_route('admin.billingmanagers.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!--form-group-->
            </div><!--box-body-->
        </div><!--box box-success -->
    {{ Form::close() }}
@endsection
