@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.cptcodeinsuranceprices.management') . ' | ' . trans('labels.backend.cptcodeinsuranceprices.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.cptcodeinsuranceprices.management') }}
        <small>{{ trans('labels.backend.cptcodeinsuranceprices.edit') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::model($cptcodeinsuranceprices, ['route' => ['admin.cptcodeinsuranceprices.update', $cptcodeinsuranceprice], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-cptcodeinsuranceprice']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.cptcodeinsuranceprices.edit') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.cptcodeinsuranceprices.partials.cptcodeinsuranceprices-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!--box-header with-border-->

            <div class="box-body">
                <div class="form-group">
                    {{-- Including Form blade file --}}
                    @include("backend.cptcodeinsuranceprices.form")
                    <div class="edit-form-btn">
                        {{ link_to_route('admin.cptcode-insurance-prices.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
                        {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!--form-group-->
            </div><!--box-body-->
        </div><!--box box-success -->
    {{ Form::close() }}
@endsection
