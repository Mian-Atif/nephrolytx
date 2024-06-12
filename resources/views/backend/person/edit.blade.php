@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.person.management') . ' | ' . trans('labels.backend.person.edit'))

@section('page-header')
{{ trans('labels.backend.person.management') }}
<small>{{ trans('labels.backend.person.edit') }}</small>
@endsection


@section('content-new')

<div class="box-tools text-right">
    @include('backend.person.partials.person-header-buttons')
</div>
<!--box-tools pull-right-->

{{ Form::model($person, ['route' => ['admin.person.update', $person], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-role', 'files' => true]) }}

<div class="row">


    <div class="col-md-12">
       
        <div>
            <div class="mt-2 alert alert-danger">
                <strong>Danger!</strong> This alert box could indicate a dangerous or potentially negative action.
            </div>
        </div>

        

    </div>


    <div class="col-md-12">
        <div class="form-group">
            @include("backend.person.form")
        </div>
    </div>

</div>



<div class="col-md-12">
    {{ link_to_route('admin.person.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md mr-2']) }}
    {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary btn-md']) }}
</div>
{{ Form::close() }}

@endsection