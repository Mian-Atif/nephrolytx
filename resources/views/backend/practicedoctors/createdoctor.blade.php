
<link rel="stylesheet" href="{{asset('libraries/phoneApi/css/intlTelInput.css')}}">
{{ Form::open(['route' => 'admin.saveDoctors', 'class' => 'form provider-create', 'role' => 'form', 'method' => 'POST']) }}
{{ Form::hidden('practice_id',!is_null($practice->detail)?$practice->detail->id:'') }}
<div>
    <label class="required">Provider Name:</label>
    {{ Form::text('name',null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => 'Enter Provider Name', 'required' => 'required']) }}
</div>

<div class="mt-3" style="margin-bottom: -24px;">


<label class="required">Phone:</label>
    <input type="tel" class="form-control phone-form provider-phone" name="phone" id="phone" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' data-inputmask="'alias': '999-999-9999'" required>
    <img class="phone-field-doctor" src="{{ asset('img/images/us-flag.svg') }}" alt="">
    <span class="input-num-doctor ">+1</span>
    <div class="provider-phone-fields error-position-1" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits'>
    </div>
</div>


<div class="mt-3">
    <label>Provider Email</label>
    {{ Form::text('email', null, ['maxlength'=>'65','class' => 'form-control', 'placeholder' => 'Enter Provider Email', 'required' => 'required']) }}

</div>

<div class="mt-3">
    <label class="required">Taxonomy Code</label>
    {{ Form::text('taxonomy_code',null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => 'Enter Provider Taxonomy Code', 'required' => 'required']) }}
    {{-- <input type="tel" class="form-control phone-form" name="taxonomy_code" id="payer-phone" data-inputmask="'alias': '999-999-9999'" >--}}
</div>
<div class="mt-3">
    <label class="required">NPI</label>
    {{ Form::text('npi',null, ['class' => 'form-control create-provider-npi','data-trigger'=>'manual','data-placement'=>'bottom','data-html'=>'true','data-content'=>'<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits', 'placeholder' => 'Enter Provider NPI', 'required' => 'required','maxlength'=>"10"]) }}
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
{{--<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>Location Title</label>
            {{ Form::text('location_map', null, ['class' => 'form-control', 'placeholder' => 'Title', 'required' => 'required']) }}
            {{ Form::hidden('practice_id',!is_null($practice->detail)?$practice->detail->id:'') }}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label>Location Name</label>
            {{ Form::text('location_name', null, ['class' => 'form-control', 'placeholder' => 'Name', 'required' => 'required']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">

            <label>Email</label>
            {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Location Email', 'required' => 'required']) }}

            --}}{{-- {!! Form::select('location_map', $locations->pluck('location_name'),['class' => 'form-control js-example-basic-multiple', 'required' => 'required']) !!}--}}{{--
            --}}{{-- <select name="location_map" id="location" class="form-control" required>
                 <option value="">Select Location</option>
                 @if($locations->count())
                 @foreach($locations as $location)
                 <option value="{{ $location->location_name  }}">{{ $location->location_name  }}</option>
                 @endforeach
                 @endif
             </select>--}}{{--
            --}}{{-- {{ Form::text('location_map', null, ['class' => 'form-control', 'placeholder' => 'Location Map', 'required' => 'required']) }}--}}{{--
        </div>
    </div>
    <div class="col-sm-6" style="margin-bottom: -22px;">
        <div class="form-group">
            <label for="">Phone</label>
            <input type="tel" class="form-control phone-form location-phone phone-fields owner-phone-field create-location-phone" name="phone" id="phone" data-inputmask="'alias': '999-999-9999'" required>
            <img class="phone-field-location" src="{{ asset('img/images/us-flag.svg') }}" alt="">
            <div class="input-num-location">+1</div>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label>Address 1</label>
            {{ Form::text('address1', null, ['class' => 'form-control', 'placeholder' => 'Address 1', 'required' => 'required']) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label>Address 2</label>
            {{ Form::text('address2', null, ['class' => 'form-control', 'placeholder' => 'Address 2', 'required' => 'required']) }}
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>City</label>
            {{ Form::text('city', null, ['class' => 'form-control', 'placeholder' => 'City', 'required' => 'required']) }}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>State</label>
            <select name="state" class="form-control" required>
                <option value="">Select State</option>
                @if(count($states) > 0)
                    @foreach($states as $state)
                        <option value="{{!is_null($state)? $state->name : ''   }}">{{ $state->name  }}</option>
                    @endforeach
                @endif
            </select>
            --}}{{-- {{ Form::text('state', null, ['class' => 'form-control', 'placeholder' => 'State', 'required' => 'required']) }}--}}{{--
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label>Zip code</label>
            {{ Form::text('zip', null, ['class' => 'form-control', 'placeholder' => 'Zip Code', 'required' => 'required']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6" style="margin-bottom: -22px;">
        <div class="form-group">
            --}}{{-- <label for="">Phone</label>
             <input class="form-control phone-form location-phone owner-phone-field" name="practice_owner_phone" id="phone" data-inputmask="'alias': '999-999-9999'" value="{{!is_null($practice->person)?$practice->person->phone:''}}" required>
             <img class="phone-field-location" src="{{ asset('img/images/us-flag.svg') }}" alt="">
             <div class="input-num-location">+1</div>
             <div class="location-phone-fields error-position-1">
             </div>--}}{{--
            <label>NPI</label>
            {{ Form::text('npi',null, ['class' => 'form-control location-npi-field','data-trigger'=>'manual','data-placement'=>'bottom','data-html'=>'true','data-content'=>'<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits', 'placeholder' => 'Enter Provider NPI', 'required' => 'required','maxlength'=>"10"]) }}

        </div>
    </div>
</div>--}}
<script src="{{asset('libraries/phoneApi/js/intlTelInput.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('libraries/phoneApi/js/intlTelInput.min.js')}}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
{{ Html::script('vendors/inputmask/jquery.inputmask.bundle.js') }}
{{ Html::script('vendors/typeahead.js/typeahead.bundle.min.js') }}
{{ Html::script('js/template/js/inputmask.js') }}
