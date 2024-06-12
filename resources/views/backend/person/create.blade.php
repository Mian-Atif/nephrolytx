@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.person.management') . ' | ' . trans('labels.backend.person.create'))

@section('page-header')
{{ trans('labels.backend.person.management') }}
<small>{{ trans('labels.backend.person.create') }}</small>
@endsection



@section('content-new')
{{ Form::open(['route' => 'admin.person.store', 'class' => 'form', 'role' => 'form', 'method' => 'post', 'id' => 'create-permission', 'files' => true]) }}

<div class="row">
    <div class="card">
        <div class="card-body">
            <div class="col-md-12">


                <div>
                    <div class="alert alert-danger">
                        <strong>Danger!</strong> This alert box could indicate a dangerous or potentially negative action.
                    </div>
                </div>

                
                <div class="form-group">
                    @include("backend.person.form")
                </div>
            </div>


            <div class="col-md-12">
                {{ link_to_route('admin.person.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md mr-2']) }}
                {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md']) }}
            </div>
        </div>
    </div>
</div>

{{ Form::close() }}
@endsection