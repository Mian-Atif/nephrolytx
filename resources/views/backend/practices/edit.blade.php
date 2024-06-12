@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.practices.management') . ' | ' . trans('labels.backend.practices.create'))

@section('page-header')
{{ trans('labels.backend.practices.management') }}
<small>{{ trans('labels.backend.practices.edit') }}</small>
@endsection
@section('after-styles')
<link rel="stylesheet" href="{{asset('libraries/phoneApi/css/demo.css')}}">
<link rel="stylesheet" href="{{asset('libraries/phoneApi/css/intlTelInput.css')}}">
<link rel="stylesheet" href="build/css/intlTelInput.css">
<style>
    .alert{
        display: inline-block !important;
    }
    .location-model .list-group-item {
        color: #212529;
        background-color: #d4edda;
        border-color: #c3e6cb;
        margin-top: 5px;
        padding: 1px 10px;
        cursor: grab;
        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
    }

    .location-model .card-header {
        border: none;
        border-radius: 0;
        margin-bottom: 5px;
        color: #fff;

    }

    .location-model .card {
        background: transparent;
    }

    .model-loader {
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, .9);
        z-index: 9;
        color: #fff;
    }

    .model-loader h1 {
        top: 50%;
        position: relative;

    }

    .hide {
        display: none;
    }

    .error {
        color: red;
        margin-left: 5px;
    }

    label.error {
        display: inline;
    }

    .read-only-location {
        background-color: #161622 !important;
        border: 1px solid #161622;
        color: #918f8f !important;
    }
</style>

@endsection

@section('content-new')

<div class="row">
    <div class="col-md-12" style="margin-top: -50px">
        <a class="btn btn-info practice-btn ml-3" href="{{ url('admin/addPracticeUser/'.$practice->id) }}">Add Practice User <i class="fas fa-user-plus" aria-hidden="true"></i></a>
        <a style="color:#fff;" class="btn btn-info practice-btn add-billing-manager" title="Tooltip on top">Add Billing Manager <i class="fas fa-user-plus" aria-hidden="true"></i></a>
        {{--<button type="button"  class="btn btn-info practice-btn mr-3" data-toggle="tooltip" data-placement="top" title="Tooltip on top" data-toggle="modal" data-target="#userdetails"><i class="fa fa-user" aria-hidden="true"></i></button>--}}
        <a href="{{ url('admin/practiceusers/'.$practice->id) }}" title="User Management" class="btn btn-info practice-btn mr-3"><i class="fa fa-users" aria-hidden="true"></i></a>

    </div>
</div>

{{--@if ($errors->any())
<div class="row">
    <div class="col-12">
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
@endforeach
</ul>
</div>
</div>
</div>
@endif--}}

@if(session()->has('message'))
<div class="row">
    <div class="col-12">
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    </div>
</div>

@endif

{{ Form::model($practice, ['route' => ['admin.practices.update', $practice], 'class' => 'form-horizontal practiceEdit', 'role' => 'form', 'method' => 'PATCH', 'id' => 'edit-role', 'files' => true]) }}
@csrf
<div class="container pt-4 pb-3  practice-card">
    <div class="row">



        <div class="col-md-3">
            <div class="form-group" >
                {{ Form::label('name', 'Practice Name', ['class' => 'required']) }}
                {{ Form::text('name', null, ['class' => 'form-control','maxlength'=>'50', 'placeholder' => "Practice Name", 'required' => 'required','name'=>"practice_name"]) }}
            </div>
        </div>


        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('name', 'Paracite Type', ['class' => 'required']) }}

                <select class="form-control " name="practice_type" required>
                    @foreach($paraciteTypes as $key=> $paraciteType)
                    <?php if ($paraciteType == $practice->type) : ?>
                        <option selected value="{{$paraciteType}}">{{$paraciteType}}</option>
                    <?php else : ?>
                        <option value="{{$paraciteType}}">{{$paraciteType}}</option>
                    <?php endif; ?>
                    @endforeach
                </select>


            </div>
        </div>


        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('name', 'Speciality', ['class' => 'required']) }}

                {!! Form::select('speciality[]', $specialities->pluck('name', 'id'),$practice->specialities,['class' => 'form-control content-overflow js-example-basic-multiple', 'multiple'=>"multiple", 'required' => 'required']) !!}

            </div>
        </div>


        <div class="col-md-2">
            {{-- <div class="form-group">
                {{ Form::label('name', 'NPI', ['class' => 'required']) }}
            --}}{{-- {{ Form::tel('npi',  !is_null($practice->detail)?$practice->detail->npi:null, ['class' => 'form-control npi','id'=>'npi', 'placeholder' => "NPI",'maxlength'=>"10" , 'required' => 'required']) }}--}}{{--
            <input type="tel" value="{{!is_null($practice->detail)?$practice->detail->npi:null}}" class="form-control npi" id="npi" placeholder="NPI" required="required" max="2">

        </div>--}}
        <div class="form-group">

            {{ Form::label('name', 'NPI', ['class' => 'required']) }}
            {{ Form::tel('npi', !is_null($practice->detail)?$practice->detail->npi:null, ['id'=>'npi','data-trigger'=>'manual','data-placement'=>'bottom','data-html'=>'true','data-content'=>'<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits','class' => 'form-control npi-field', 'placeholder' => "NPI" ,'maxlength'=>"10" , 'required' => 'required']) }}

        </div>
    </div>



    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('name', 'Tax ID', ['class' => 'required']) }}
            {{ Form::tel('tax_id',  !is_null($practice->tax_id)?$practice->tax_id:null, ['class' => 'form-control tax-field taxId','data-trigger'=>'manual','data-placement'=>'bottom','data-html'=>'true','data-content'=>'<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 9 Digits','data-inputmask-alias'=>'999-999-999', 'placeholder' => "Tax ID" , 'required' => 'required']) }}
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('name', 'Email', ['class' => 'required']) }}
            {{ Form::text('email', null, ['maxlength'=>'65','class' => 'form-control', 'placeholder' => "Email", 'required' => 'required','name'=>"email"]) }}
        </div>
    </div>


    <div class="col-md-3 margin-btm">
        <div class="form-group">
            {{ Form::label('name', 'Phone', ['class' => 'required']) }}
            <input class="form-control phone-form phone-fields" id="phone" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' data-inputmask="'alias': '999-999-9999'" name="phone" value="{{!is_null($practice->detail)?$practice->detail->phone:''}}" required>

            <img class="phone-field" src="{{ asset('img/images/us-flag.svg') }}" alt="">
            <span class="input-num">+1</span>
            {{-- {{ Form::text('text', !is_null($practice->detail)?$practice->detail->phone:'', ['id'=>'phone','data-inputmask-alias'=>'999-999-9999','class' => 'form-control', 'placeholder' => "Phone",'name'=>"phone", 'type'=>"tel" , 'required' => 'required']) }}--}}

        </div>

    </div>


    <div class="col-md-3 margin-btm">
        <div class="form-group">
            {{ Form::label('name', 'Fax') }}
            {{-- {{ Form::text('text',  !is_null($practice->detail)?$practice->detail->fax:'', ['class' => 'form-control', 'placeholder' => "Fax", 'required' => 'required','name'=>"fax"]) }}--}}

            <input class="form-control phone-form fax-field faxs-field" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' id="phone" data-inputmask="'alias': '999-999-9999'" name="fax" value="{{!is_null($practice->detail)?$practice->detail->fax:''}}">
            <img class="phone-field" src="{{ asset('img/images/us-flag.svg') }}" alt="">
            <span class="input-num">+1</span>
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('name', 'Website') }}
            {{ Form::text('text',  !is_null($practice->detail)?$practice->detail->website:'', ['maxlength'=>'65','class' => 'form-control', 'placeholder' => "Website", 'required' => 'required','name'=>"website"]) }}
        </div>
    </div>


</div>

</div>

<div class="container mt-3 pt-4 practice-card">
    <h2>Address</h2>
    <div class="row">


        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('name', 'Address 1', ['class' => 'required']) }}
                {{ Form::text('address_1', !is_null($practice->detail)?$practice->detail->address_1:'', ['maxlength'=>'150','class' => 'form-control', 'placeholder' => "Address 1", 'required' => 'required']) }}
            </div>
        </div>


        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('name', 'Address 2', ['class' => 'required']) }}
                {{ Form::text('address_2', !is_null($practice->detail)?$practice->detail->address_2:'', ['maxlength'=>'150','class' => 'form-control', 'placeholder' => "Address 2", 'required' => 'required']) }}
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('name', 'City', ['class' => 'required']) }}

                {{ Form::text('city', !is_null($practice->detail)?$practice->detail->city:'', ['maxlength'=>'35','class' => 'form-control', 'placeholder' => "City", 'required' => 'required']) }}
            </div>
        </div>



        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('name', 'State', ['class' => 'required']) }}
                <select name="state" class="form-control" required>
                    <option value="">Select State</option>
                    @if(count($states) > 0)
                    @foreach($states as $state)
                    @if(!is_null($practice->detail->state))

                    <option value="{{!is_null($state)? $state->name : ''   }}" {{($practice->detail->state == $state->name)? 'selected' : ''   }}>{{ $state->name  }}</option>
                    @else
                    <option value="{{!is_null($state)? $state->name : ''   }}">{{ $state->name  }}</option>
                    @endif
                    @endforeach

                    @endif
                </select>

            </div>
        </div>



        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('name', 'Zip', ['class' => 'required']) }}
                {{ Form::text('zip', !is_null($practice->detail)?$practice->detail->zip_code:'', ['maxlength'=>'15','class' => 'form-control', 'placeholder' => "Zip", 'required' => 'required']) }}

            </div>
        </div>


    </div>
</div>


<div class="container pt-4 pb-3 mt-3 practice-card">
    <h2>Owner</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('name', ' First Name', ['class' => 'required']) }}
                {{ Form::text('practice_owner_first_name', !is_null($practice->person)?$practice->person->first_name:null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => "First Name", 'required' => 'required']) }}
            </div>
        </div>



        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('name', ' Last Name', ['class' => 'required']) }}
                {{ Form::text('practice_owner_last_name', !is_null($practice->person)?$practice->person->last_name:null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => "Last Name", 'required' => 'required']) }}
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('name', ' Middle Initial') }}
                {{ Form::text('practice_owner_middle_name', !is_null($practice->person)?$practice->person->middle_name:null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => "Middle Initial"]) }}
            </div>
        </div>




        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('name', 'Email',['class'=>'required']) }}
                {{ Form::email('practice_owner_email',!is_null($practice->person)?$practice->person->email:null, ['maxlength'=>'65','class' => 'form-control read-only-location', 'placeholder' => "Email", 'required' => 'required','readonly' => true]) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">

                {{ Form::label('name', 'Phone') }}
                <input class="form-control phone-form owner-phone-field" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' name="practice_owner_phone" id="phone" data-inputmask="'alias': '999-999-9999'" value="{{!is_null($practice->person)?$practice->person->phone:''}}">
                <img class="phone-field" src="{{ asset('img/images/us-flag.svg') }}" alt="">
                <span class="input-num ">+1</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="mt-3">
                <button type="button" class="btn btn-info practice-btn createProvider">ADD PROVIDER</button>
                <button type="button" class="btn btn-info practice-btn mr-3 createLocation" >ADD LOCATION</button>
            </div>

        </div>

    </div>
    <div class="container">
        <div class="row mt-3 mb-3">
            <div class="col-md-12 ">
                <div class="table-responsive pop-up-table-border">
                    <table class="table">
                        <thead>
                            <tr class="table-color">
                                <th colspan="7" style="text-align:center; font-size: 15px;"> <strong> Locations</strong></th>
                            </tr>
                        </thead>
                        <thead>
                            <tr class="table-color">
                                <th>#</th>
                                <th style=" font-size: 15px;">Location Title</th>
                                <th style=" font-size: 15px;">Address 1</th>
                                <th style=" font-size: 15px;">City</th>
                                <th style=" font-size: 15px;">State</th>
                                <th style=" font-size: 15px;">Zip</th>

                                <th class="text-center">Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @if(isset($locations) && count($locations) > 0)
                            @foreach($locations as $location)
                            <tr class="text-white">
                                <td>{{ $loop->iteration  }}</td>
                                <td class="table-border-left">{{ $location->location_name  }}</td>
                                <td class="table-border-left">{{ !is_null($location->address) ? $location->address->address1 : '-- -- --'  }}</td>
                                <td class="table-border-left">{{ !is_null($location->address) ? $location->address->city : '-- -- --'  }}</td>
                                <td class="table-border-left">{{ !is_null($location->address) ? $location->address->state : '-- -- --'  }}</td>
                                <td class="table-border-left">{{ !is_null($location->address) ? $location->address->zip : '-- -- --'  }}</td>
                                <td class="text-center"><a style="color: #fff;" onclick="return confirm('Are you sure you want to delete')" href="{{url('admin/deleteLocation/'.$location->id)}}"><i class="fas fa-trash-alt"></i></a> | <a style="color: #fff; cursor: pointer;" data-url="{{url('admin/editLocation/'.$location->id)}}" data-id="{{ $location->id }}" class="editLocation editLocation{{ $location->id }}"><i class="fa fa-edit"></i></a></td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="7" class="text-center"> No data found!</td>
                            </tr>

                            @endif
                        </tbody>

                    </table>
                </div>
            </div>




        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
                <br>
                <div class="table-responsive pop-up-table-border">
                    <table class="table">
                        <thead>
                            <tr class="table-color">
                                <th colspan="6" style="text-align:center; font-size: 15px;"> <strong> Providers</strong></th>
                            </tr>
                        </thead>
                        <thead>
                            <tr class="table-color">
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>


                        <tbody>
                            @if(isset($doctors) && count($doctors) > 0)
                            @foreach($doctors as $doctor)
                            <tr class="text-white">
                                <td>{{ $loop->iteration  }}</td>
                                <td>{{ !is_null($doctor->person)? $doctor->person->middle_name : ''   }}</td>
                                <td class="table-border-left">{{ !is_null($doctor->person)? $doctor->person->email : ''   }}</td>
                                <td>{{ !is_null($doctor->person)? $doctor->person->phone : ''   }}</td>
                                <td class="text-center"><a onclick="return confirm('Are you sure you want to delete')" href="{{url('admin/deleteDoctor/'.$doctor->id)}}" style="color: #fff;"><i class="fas fa-trash-alt"></i></a> | <a style="color: #fff; cursor: pointer;" data-url="{{url('admin/editDoctor/'.$doctor->id)}}" data-id="{{ $doctor->id }}" class="editDoctor editDoctor{{ $doctor->id }}"><i class="fa fa-edit"></i></a></td>

                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="5" class="text-center">No data found!</td>
                            </tr>
                            @endif
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="edit-btn">
    {{ link_to_route('admin.practices.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger mr-2']) }}
    {{ Form::submit(trans('buttons.general.crud.update'), ['class' => 'btn btn-primary edit-btn-update']) }}
</div>
{{ Form::close() }}


<!--pop-up modal for user-button-->
<div class="modal fade " id="userdetails" role="dialog">
    <div class="modal-dialog model-width">

        <div class="modal-content pop-up">

            <div class="modal-body">
                <div class="table-responsive">

                    <table id="#" class="table">
                        <thead>
                            <tr class="table-color">
                                <th>No#</th>
                                <th class="table-height">Name</th>
                                <th class="table-height1">Email</th>
                                <th>Address 1</th>
                                <th>Address 2</th>

                                <th class="table-height">Cell No.</th>

                            </tr>

                        </thead>
                        <tbody>
                            @if(isset($billingManagers) && count($billingManagers) > 0)
                            @foreach($billingManagers as $billingManager)
                            @php $i = 1 @endphp
                            <tr class="text-white">

                                <td>{{ $i }}</td>
                                <td class="table-border-left">{{ !is_null($billingManager->person)? $billingManager->person->middle_name : ''   }}</td>
                                <td> {{ !is_null($billingManager->person)? $billingManager->person->email : ''   }}</td>
                                <td>{{ !is_null($billingManager->person)? $billingManager->person->address1 : ''   }}</td>
                                <td>{{ !is_null($billingManager->person)? $billingManager->person->address2 : ''   }}</td>
                                <td class="table-border-left"> {{ !is_null($billingManager->person)? $billingManager->person->phone : ''   }}</td>
                            </tr>
                            @php $i++ @endphp
                            @endforeach
                            @else
                            <tr>
                                <td colspan="6" class="text-center">No data found!</td>
                            </tr>
                            @endif


                        </tbody>

                    </table>
                </div>
            </div>

        </div>

    </div>
</div>



<!--pop-up modal for location-->
<div class="modal fade location-model" role="dialog">
    <div class="modal-dialog modal-md" style="max-width: 600px;">
        <div class="modal-content pop-up">
            <div class="modal-header">
            <h4 class="pt-3"><strong>Add Location</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="model-loader text-center hide">
                <h1>
                    <i class="fas fa-cog fa-spin" aria-hidden="true"></i>
                </h1>
            </div>
            <form class="addLocationForm" action="{{ url('admin/saveLocations') }}" method="POST">
                @csrf
                <div class="modal-body">
</div>
<div class="modal-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                </div>
            </form>
        </div>
</div>
</div>

<!--pop-up modal for doctor-->
<div class="modal fade provider-model" id="doctor" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content pop-up">
            <div class="modal-header">
                <h4 class="pt-3"><strong> Add Provider</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="modal-body pt-2">
                {{ Form::open(['route' => 'admin.saveDoctors', 'class' => 'form provider-create', 'role' => 'form', 'method' => 'post', 'files' => true]) }}
                {{ Form::hidden('practice_id',!is_null($practice->detail)?$practice->detail->id:'') }}
                <div>
                    <label>Provider Name:</label>

                    <select name="name" id="location" class="form-control" required>
                        <option value="">Select Provider</option>
                        @if(count($providersLocation) > 0)
                        @foreach($providersLocation as $doctor)
                        <option value="{{!is_null($doctor->person)?$doctor->person->middle_name:'' }}">{{ $doctor->person->middle_name  }}</option>
                        @endforeach
                        @endif
                    </select>

                </div>

                <div class="mt-3" style="margin-bottom: -24px;">


                    {{ Form::label('name', 'Phone') }}
                    <input type="tel" class="form-control phone-form provider-phone" name="phone" id="phone" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' data-inputmask="'alias': '999-999-9999'" required>
                    <img class="phone-field-doctor" src="{{ asset('img/images/us-flag.svg') }}" alt="">
                    <span class="input-num-doctor ">+1</span>
                    <div class="provider-phone-fields error-position-1" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits'>
                    </div>
                </div>


                <div class="mt-3">
                    <label>Provider Email</label>
                    {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Provider Email', 'required' => 'required']) }}

                </div>

                <div class="mt-3">
                    <label>Taxonomy Code</label>
                    {{ Form::text('taxonomy_code',null, ['class' => 'form-control', 'placeholder' => 'Enter Provider Taxonomy Code', 'required' => 'required']) }}
                    {{-- <input type="tel" class="form-control phone-form" name="taxonomy_code" id="payer-phone" data-inputmask="'alias': '999-999-9999'" >--}}
                </div>
                <div class="mt-3">
                    <label>NPI</label>
                    {{ Form::text('npi',null, ['class' => 'form-control npi-field', 'placeholder' => 'Enter Provider NPI', 'required' => 'required','maxlength'=>"10"]) }}
                </div>

                {{--<div class="row">
                       <div class="col-sm-12 mt-3">
                           <label>Provider Locations</label>
                           <div style="width:100%; height: 200px; overflow-x: hidden; overflow-y: scroll;">

                               @if(isset($locations) && count($locations) > 0)
                                   @foreach($locations as $location)
                               <div class="form-control">
                                   <label>
                                       <input type="checkbox" name="location_id[]" value="{{ $location->id }}" style="width:auto;height: auto;"> {{ $location->location_name }}
                </label>
            </div>
            @endforeach
            @endif


        </div>
    </div>
</div>--}}

<div class="modal-footer">

    <button type="submit" class="btn btn-info">Save</button>
</div>
{{ Form::close() }}
</div>

</div>
</div>
</div>



<!--pop-up modal for user add-->
<div class="modal fade billing-model" id="useradd" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content pop-up">
            <div class="modal-header">
                <h4 class="pt-3"><strong>Billing Manager</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                </button>
            </div>
            <div class="modal-body">
        </div>
    </div>
</div>
</div>


<!--pop-up modal for location-->
<div class="modal fade edit-location-model" id="edit-location" role="dialog">
    <div class="modal-dialog modal-md" style="max-width: 600px;">
        <div class="modal-content pop-up">
            <div class="modal-header">
                <h4 class="pt-3"><strong>Location</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                </button>
            </div>

            <div class="model-loader text-center hide">
                <h1>
                    <i class="fas fa-cog fa-spin" aria-hidden="true"></i>
                </h1>
            </div>
            <form class="practice-create" action="{{ url('admin/updateLocation') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="location_return_view"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>




<!--pop-up modal for doctor-->
<div class="modal fade" id="edit-doctor" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content pop-up">
        <div class="modal-header pb-0">
            <h4 class="pt-3"><strong>Edit Provider</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                </button>
            </div>
            {{ Form::open(['route' => 'admin.updateDoctors', 'class' => 'form provider-edit', 'role' => 'form', 'method' => 'post', 'files' => true]) }}
            <div class="modal-body">
                {{ Form::hidden('practice_id',!is_null($practice->detail)?$practice->detail->id:'') }}
                <div class="doctor_return_view"></div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Save</button>
            </div>
            {{ Form::close() }}
        </div>

    </div>
</div>



@endsection

@section('after-scripts')
<!-- Use as a Vanilla JS plugin -->
<script src="{{asset('libraries/phoneApi/js/intlTelInput.min.js')}}"></script>
{{-- <script src="{{asset('libraries/phoneApi/js/intlTelInput.min.js')}}"></script>--}}

<!-- Use as a jQuery plugin -->

<script src="https://code.jquery.com/jquery-latest.min.js"></script>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>--}}

{{-- <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/jquery.validate.js"></script>--}}
{{-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>--}}

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    //********create billing manager Forms**********

    $(document).on("click", ".add-billing-manager", function() {
        let pracitce_id='{{$practice->id}}';
        $.ajax({
            beforeSend: function() {
                $('.add-billing-manager').html('Add Billing Manager <i class="fas fa-cog fa-spin" aria-hidden="true"></i>');
            },
            type: 'GET',
            url: '{!!url('admin/get-billing-modal')!!}'+"/"+pracitce_id,
            headers: {
                'X-CSRF-Token': "{{csrf_token()}}"
            },
            success: function(response) {
                $('.add-billing-manager' ).html('ADD Billing Manager <i class="fas fa-user-plus" aria-hidden="true"></i>');
                if (response.status == true) {
                    $('.billing-model .modal-body').html(response.data);
                    $('.billing-model').modal('show');
                } else {
                    $('.billing-model .modal-body').html('');
                    toastr.clear();
                    toastr.error(response.message, 'Error', {
                        timeOut: 5000
                    });
                }
            },
        });
    });
    //********add billing manager**********

    $(document).on("submit", ".billing-manager", function(e) {
        e.preventDefault();
        if ($('.billing-phone').val().replace(/\D/g, '').length > 0 && $('.billing-phone').val().replace(/\D/g, '').length < 10) {
            $('.billing-phone').popover('show');
            $('.billing-phone').focus();
            return false;
        }
        var $f = $(this);
        var $sb = $f.find('[type="submit"]');
        var oldBtnText = $sb.html();

        $.ajax({
            beforeSend: function() {
                $sb.html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>Processing').prop('disabled', true);
            },
            url: $f.attr('action'),
            type: $(this).attr('method'),
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            error: function(xhr, status, error) {
                $sb.html(oldBtnText).prop('disabled', false);
                loadRequestErrors(xhr, status, error);
            },
            success: function(data) {
                // $sb.html(oldBtnText).prop('disabled', false);
                if (data.status) {
                    toastr.clear();
                    toastr.success(data.message, 'Success', {
                        timeOut: 5000
                    });
                    location.reload(true);
                } else {
                    toastr.clear();
                    // toastr.error(data.message, 'Error', {timeOut: 5000});
                    $sb.html(oldBtnText).prop('disabled', false);
                    loadRequestErrors(data);

                }
            },

        });
    });

    //********add Location**********


    $('body').on("submit", "form.addLocationForm", function(e) {
        e.preventDefault();
        $(".error").remove();
        if ($('.location-npi-field').val().replace(/\D/g, '').length > 0 && $('.location-npi-field').val().replace(/\D/g, '').length < 10) {
            $('.location-npi-field').popover('show')
            $('.location-npi-field').focus();
            $('.location-npi-field').on('shown.bs.popover', function() {
        setTimeout(function() {
            $('.location-npi-field').popover('hide');
        }, 3000);
    })
            return false;
        }
        if ($('.location-phone').val().replace(/\D/g, '').length > 0 && $('.location-phone').val().replace(/\D/g, '').length < 10) {
            $('.location-phone').popover('show')
            $('.location-phone').focus();
            $('.location-phone').on('shown.bs.popover', function() {
        setTimeout(function() {
            $('.location-phone').popover('hide');
        }, 3000);
    })
            return false;
        }

       /* if ($('.edit-location-npi-field').val().replace(/\D/g, '').length > 0 && $('.edit-location-npi-field').val().replace(/\D/g, '').length < 10) {
            $('.edit-location-npi-field').after('<span class="error">Please Enter 10 Digits</span>');
            $('.edit-location-npi-field').focus();
            return false;
        }
        if ($('.edit-location-phone').val().replace(/\D/g, '').length > 0 && $('.edit-location-phone').val().replace(/\D/g, '').length < 10) {
            $('.edit-location-phone').popover('show')
            $('.edit-location-phone').focus();
            return false;
        }*/
        var $f = $(this);
        var $sb = $f.find('[type="submit"]');
        var oldBtnText = $sb.html();

        $.ajax({
            beforeSend: function() {
                $sb.html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>Processing').prop('disabled', true);
            },
            url: $f.attr('action'),
            type: $(this).attr('method'),
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            error: function(xhr, status, error) {
                $sb.html(oldBtnText).prop('disabled', false);
                loadRequestErrors(xhr, status, error);
            },
            success: function(data) {
                // $sb.html(oldBtnText).prop('disabled', false);
                if (data.status) {
                    toastr.clear();
                    toastr.success(data.message, 'Success', {
                        timeOut: 5000
                    });
                    location.reload(true);
                } else {
                    toastr.clear();
                    // toastr.error(data.message, 'Error', {timeOut: 5000});
                    $sb.html(oldBtnText).prop('disabled', false);
                    loadRequestErrors(data);

                }
            },

        });
    });


    //********add Provider Forms**********

    $(document).on("submit", ".provider-create", function(e) {
        e.preventDefault();
        $(".error").remove();
        if ($('.provider-phone').val().replace(/\D/g, '').length < 10) {
            $('.provider-phone').popover('show');
            $('.provider-phone').focus();
            $('.provider-phone').on('shown.bs.popover', function() {
        setTimeout(function() {
            $('.provider-phone').popover('hide');
        }, 3000);
    })
            return false;
        }
        if ($('.create-provider-npi').val().replace(/\D/g, '').length > 0 && $('.create-provider-npi').val().replace(/\D/g, '').length < 10) {
            $('.create-provider-npi').popover('show')
            $('.create-provider-npi').focus();
            $('.create-provider-npi').on('shown.bs.popover', function() {
        setTimeout(function() {
            $('.create-provider-npi').popover('hide');
        }, 3000);
    })
            return false;
        }

        var $f = $(this);
        var $sb = $f.find('[type="submit"]');
        var oldBtnText = $sb.html();

        $.ajax({
            beforeSend: function() {
                $sb.html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>Processing').prop('disabled', true);
            },
            url: $f.attr('action'),
            type: $(this).attr('method'),
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            error: function(xhr, status, error) {
                $sb.html(oldBtnText).prop('disabled', false);
                loadRequestErrors(xhr, status, error);
            },
            success: function(data) {
                // $sb.html(oldBtnText).prop('disabled', false);
                if (data.status) {
                    toastr.clear();
                    toastr.success(data.message, 'Success', {
                        timeOut: 5000
                    });
                    location.reload(true);
                } else {
                    toastr.clear();
                    // toastr.error(data.message, 'Error', {timeOut: 5000});
                    $sb.html(oldBtnText).prop('disabled', false);
                    loadRequestErrors(data);

                }
            },

        });
    });


    //******************
    $(document).on("submit", ".practice-create", function(e) {
        e.preventDefault();
        var $f = $(this);
        var $sb = $f.find('[type="submit"]');
        var oldBtnText = $sb.html();

        $.ajax({
            beforeSend: function() {
                $sb.html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>Processing').prop('disabled', true);
            },
            url: $f.attr('action'),
            type: $(this).attr('method'),
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            error: function(xhr, status, error) {
                $sb.html(oldBtnText).prop('disabled', false);
                loadRequestErrors(xhr, status, error);
            },
            success: function(data) {
                // $sb.html(oldBtnText).prop('disabled', false);
                if (data.status) {
                    toastr.clear();
                    toastr.success(data.message, 'Success', {
                        timeOut: 5000
                    });
                    location.reload(true);
                } else {
                    toastr.clear();
                    // toastr.error(data.message, 'Error', {timeOut: 5000});
                    $sb.html(oldBtnText).prop('disabled', false);
                    loadRequestErrors(data);

                }
            },

        });
    });

    //********add Provider Forms**********

    $(document).on("submit", ".provider-edit", function(e) {
        e.preventDefault();
        if ($('.edit-provider-phone').val().replace(/\D/g, '').length < 10) {
            $('.edit-provider-phone').popover('show');
            $('.edit-provider-phone').focus();
            return false;
        }
        if ($('.provider-npi-field').val().replace(/\D/g, '').length > 0 && $('.provider-npi-field').val().replace(/\D/g, '').length < 10) {
            $('.provider-npi-field').after('<span class="error">Please Enter 10 Digits</span>');
            $('.provider-npi-field').focus();
            return false;
        }
        var $f = $(this);

        var $sb = $f.find('[type="submit"]');
        var oldBtnText = $sb.html();

        $.ajax({
            beforeSend: function() {
                $sb.html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>Processing').prop('disabled', true);
            },
            url: $f.attr('action'),
            type: $(this).attr('method'),
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            error: function(xhr, status, error) {
                $sb.html(oldBtnText).prop('disabled', false);
                loadRequestErrors(xhr, status, error);
            },
            success: function(data) {
                // $sb.html(oldBtnText).prop('disabled', false);
                if (data.status) {
                    toastr.clear();
                    toastr.success(data.message, 'Success', {
                        timeOut: 5000
                    });
                    location.reload(true);
                } else {
                    toastr.clear();
                    // toastr.error(data.message, 'Error', {timeOut: 5000});
                    $sb.html(oldBtnText).prop('disabled', false);
                    loadRequestErrors(data);

                }
            },

        });
    });

    //********create location Forms**********

    $(document).on("click", ".createLocation", function() {
        let pracitce_id='{{$practice->id}}';
        $.ajax({
            beforeSend: function() {
                $('.createLocation').html('ADD LOCATION <i class="fas fa-cog fa-spin" aria-hidden="true"></i>');
            },
            type: 'GET',
            url: '{!!url('admin/get-location-modal')!!}'+"/"+pracitce_id,
            headers: {
                'X-CSRF-Token': "{{csrf_token()}}"
            },
            success: function(response) {
                $('.createLocation' ).html('ADD LOCATION');
                if (response.status == true) {
                    $('.location-model .modal-body').html(response.data);
                    $('.location-model').modal('show');
                } else {
                    $('.location-model .modal-body').html('');
                    toastr.clear();
                    toastr.error(response.message, 'Error', {
                        timeOut: 5000
                    });
                }
            },
        });
    });

    //********edit Location Forms**********

    $(document).on("click", ".editLocation", function() {
        $(".error").remove();

        $('.practice-create')[0].reset();
        var $sb = $('.practice-create').find('[type="submit"]');
        $sb.html('submit').prop('disabled', false);
        var url = $(this).data('url');
        var id = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: url,
            data: '_token = <?php echo csrf_token() ?>',
            beforeSend: function() {
                $('.editLocation' + id).html('<i class="fas fa-cog fa-spin" aria-hidden="true"></i>');
            },
            success: function(responce) {
                if (responce.code == 1) {
                    $('.location_return_view').html(responce.html);
                    $('#edit-location').modal('show');
                    $('.editLocation' + id).html('<i class="fa fa-edit"></i>');
                    $("#edit-sortable1").sortable({
                        connectWith: ".edit-connectedSortable2"
                    }).disableSelection();

                    $("#edit-sortable2").sortable({
                        connectWith: ".edit-connectedSortable1"
                    }).disableSelection();
                }
            }
        });
    });

    //********create provider Forms**********

    $(document).on("click", ".createProvider", function() {
        let pracitce_id='{{$practice->id}}';
        $.ajax({
            beforeSend: function() {
                $('.createProvider').html('ADD PROVIDER <i class="fas fa-cog fa-spin" aria-hidden="true"></i>');
            },
            type: 'GET',
            url: '{!!url('admin/get-provider-modal')!!}'+"/"+pracitce_id,
            headers: {
                'X-CSRF-Token': "{{csrf_token()}}"
            },
            success: function(response) {
                $('.createProvider' ).html('ADD PROVIDER');
                if (response.status == true) {
                    $('.provider-model .modal-body').html(response.data);
                    $('.provider-model').modal('show');
                } else {
                    $('.provider-model .modal-body').html('');
                    toastr.clear();
                    toastr.error(response.message, 'Error', {
                        timeOut: 5000
                    });
                }
            },
        });
    });

    //********edit Provider Forms**********

    $(document).on("click", ".editDoctor", function() {
        var url = $(this).data('url');
        var id = $(this).data('id');
        var $sb = $('.editDoctor').find('[type="submit"]');
        $sb.html('submit').prop('disabled', false);
        $.ajax({
            type: 'GET',
            url: url,
            data: '_token = <?php echo csrf_token() ?>',
            beforeSend: function() {
                $('.editDoctor' + id).html('<i class="fas fa-cog fa-spin" aria-hidden="true"></i>');
            },
            success: function(responce) {
                if (responce.code == 1) {
                    $('.doctor_return_view').html(responce.html);
                    $('#edit-doctor').modal('show');
                    $('.editDoctor' + id).html('<i class="fa fa-edit"></i>');
                }
            }
        });
    });

    $("#sortable1").sortable({
        connectWith: ".connectedSortable2"
    }).disableSelection();

    $("#sortable2").sortable({
        connectWith: ".connectedSortable1"
    }).disableSelection();
    $(document).on("change keyup", '.npi-field', function(e) {
        if (/\D/g.test(this.value)) {
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
            toastr.clear();
            toastr.error('please enter numbers only', 'Error', {
                timeOut: 2000
            });

        }
    });
    $(document).on("change keyup", '.create-provider-npi', function(e) {
        if (/\D/g.test(this.value)) {
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
            toastr.clear();
            toastr.error('please enter numbers only', 'Error', {
                timeOut: 2000
            });

        }
    });


    $(document).on("change keyup", '.location-npi-field', function(e) {
        if (/\D/g.test(this.value)) {
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
            toastr.clear();
            toastr.error('please enter numbers only', 'Error', {
                timeOut: 2000
            });

        }
    });

    /*  $(document).on("change keyup",'.tax-field' , function(e) {
          if (/\D/g.test(this.value))
          {
              // Filter non-digits from input value.
              this.value = this.value.replace(/\D/g, '');
              toastr.error('please enter numbers only', 'Error', {timeOut: 2000});
          }
      });*/
    /* $(document).on("change keyup",'.phone-fields' , function(e) {
         if (/\D/g.test(this.value))
         {
             // Filter non-digits from input value.
             this.value = this.value.replace(/\D/g, '');
             toastr.error('please enter numbers only', 'Error', {timeOut: 2000});
         }
     });*/

    //popover fadeout   
    $('.phone-fields').on('shown.bs.popover', function() {
        setTimeout(function() {
            $('.phone-fields').popover('hide');
        }, 3000);
    })
    $('.owner-phone-field').on('shown.bs.popover', function() {
        setTimeout(function() {
            $('.owner-phone-field').popover('hide');
        }, 3000);
    })
    $('.fax-field').on('shown.bs.popover', function() {
        setTimeout(function() {
            $('.fax-field').popover('hide');
        }, 3000);
    })
    $('.tax-field').on('shown.bs.popover', function() {
        setTimeout(function() {
            $('.tax-field').popover('hide');
        }, 3000);
    })
    $('#npi').on('shown.bs.popover', function() {
        setTimeout(function() {
            $('#npi').popover('hide');
        }, 3000);
    })
    $('.provider-phone').on('shown.bs.popover', function() {
        setTimeout(function() {
            $('.provider-phone').popover('hide');
        }, 3000);
    })
    
    $('.billing-phone').on('shown.bs.popover', function() {
        setTimeout(function() {
            $('.billing-phone').popover('hide');
        }, 3000);
    })

    // end fadeout

    $(document).on("submit", '.practiceEdit', function(e) {
        $(".error").remove();
        if ($('.npi-field').val().length < 10) {
            $('#npi').popover('show');
            $('#npi').focus();
            return false;
        } else if ($('.phone-fields').val().replace(/\D/g, '').length < 10) {
            $('.phone-fields').popover('show');
            $('.phone-fields').focus();
            return false;

        } else if ($('.tax-field').val().replace(/\D/g, '').length < 9) {
            $('.tax-field').popover('show');
            $('.tax-field').focus();
            return false;
        } else if ($('.owner-phone-field').val().replace(/\D/g, '').length > 0 && $('.owner-phone-field').val().replace(/\D/g, '').length < 10) {
            $('.owner-phone-field').popover('show');
            $('.owner-phone-field').focus();
            return false;
        } else if ($('.fax-field').val().replace(/\D/g, '').length > 0 && $('.fax-field').val().replace(/\D/g, '').length < 10) {
            $('.fax-field').popover('show');
            $('.faxs-field').focus();
            return false;
        }
    });
    function loadRequestErrors(xhr) {
        if (xhr.message) {
            $.each(xhr.message, function(key, item) {
                toastr.clear();
                toastr.error(item, 'Error', {
                    timeOut: 5000
                });
            });
        } else if (xhr.responseJSON.message) {
            toastr.clear();
            toastr.error(xhr.responseJSON.message, 'Error', {
                timeOut: 5000
            });
        }
    }
</script>



@endsection