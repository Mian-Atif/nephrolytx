@extends(!is_null(Auth::user()->roles()->where('name', 'Administrator')->first()) ? 'backend.layouts.backend' : 'backend.layouts.dashboard')


@section ('title', trans('labels.backend.cptcodeinsuranceprices.management') . ' | ' . trans('labels.backend.cptcodeinsuranceprices.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.cptcodeinsuranceprices.management') }}
        <small>{{ trans('labels.backend.cptcodeinsuranceprices.create') }}</small>
    </h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin.cptcode-insurance-prices.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-cptcodeinsuranceprice']) }}

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.cptcodeinsuranceprices.create') }}</h3>

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
                        {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
                        <div class="clearfix"></div>
                    </div><!--edit-form-btn-->
                </div><!-- form-group -->
            </div><!--box-body-->
        </div><!--box box-success-->
    {{ Form::close() }}
@endsection
