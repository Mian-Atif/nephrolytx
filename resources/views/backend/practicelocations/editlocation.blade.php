<style>
    .edit-location-model .list-group-item {
        color: #212529;
        background-color: #d4edda;
        border-color: #c3e6cb;
        margin-top: 5px;
        padding: 1px 10px;
        cursor: grab;
        box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
    }
    .edit-location-model .card-header{
        border: none;
        border-radius:0;
        margin-bottom: 5px;
        color: #fff;

    }
    .edit-location-model .card{
        background: transparent;
    }
    
    .read-only-location {
        background-color: #161622 !important;
        border: 1px solid #161622;
        color: #918f8f !important;
    }
</style>

<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>Location Name</label>
            {{ Form::text('location_name', $location->location_name, ['maxlength'=>'50','class' => 'read-only-location', 'placeholder' => 'Title', 'required' => 'required','readonly' => 'true']) }}
            {{ Form::hidden('location_id',$location->id)  }}
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="required">Title </label>
            {{ Form::text('location_map', !is_null($location->location_map)?$location->location_map:null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => 'Location ', 'required' => 'required']) }}
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">

            <label>Email</label>
            {{ Form::text('email',  !is_null($location->email)?$location->email:null, ['maxlength'=>'65','class' => 'form-control', 'placeholder' => 'Location Email', 'required' => 'required']) }}

            {{-- {!! Form::select('location_map', $locations->pluck('location_name'),['class' => 'form-control js-example-basic-multiple', 'required' => 'required']) !!}--}}
            {{-- <select name="location_map" id="location" class="form-control" required>
                 <option value="">Select Location</option>
                 @if($locations->count())
                 @foreach($locations as $location)
                 <option value="{{ $location->location_name  }}">{{ $location->location_name  }}</option>
                 @endforeach
                 @endif
             </select>--}}
            {{-- {{ Form::text('location_map', null, ['class' => 'form-control', 'placeholder' => 'Location Map', 'required' => 'required']) }}--}}
        </div>
    </div>
    <div class="col-sm-6" style="margin-bottom: -22px;">
        <div class="form-group">
            <label for="" class="required">Phone</label>
            <input class="form-control phone-form location-phone owner-phone-field edit-location-phone" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' name="practice_owner_phone" id="phone" data-inputmask="'alias': '999-999-9999'" value="{{!is_null($location->phone)?$location->phone:''}}" required>
            <img class="phone-field-location" src="{{ asset('img/images/us-flag.svg') }}" alt="">
            <span class="input-num-location">+1</span>
          
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label class="required">Address 1</label>
            {{ Form::text('address1', !is_null($locationDetail)?$locationDetail->address1:null, ['maxlength'=>'150','class' => 'form-control', 'placeholder' => 'Address 1', 'required' => 'required']) }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label class="required">Address 2</label>
            {{ Form::text('address2', !is_null($locationDetail)?$locationDetail->address2:null, ['maxlength'=>'150','class' => 'form-control', 'placeholder' => 'Address 2', 'required' => 'required']) }}
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="required">City</label>
            {{ Form::text('city', !is_null($locationDetail)?$locationDetail->city:null, ['maxlength'=>'35','class' => 'form-control', 'placeholder' => 'City', 'required' => 'required']) }}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="required">State</label>

            <select name="state" class="form-control" required>
                <option value="">Select State</option>
                @if(count($states) > 0)
                    @foreach($states as $state)
                    @if(!is_null($locationDetail))
                        <option value="{{!is_null($state)? $state->name : ''   }}" {{($locationDetail->state == $state->name)? 'selected' : ''   }}>{{ $state->name  }}</option>
                        @else
                            <option value="{{!is_null($state)? $state->name : ''   }}" >{{ $state->name  }}</option>
                        @endif
                    @endforeach
                @endif
            </select>

{{--            {{ Form::text('state', !is_null($locationDetail)?$locationDetail->state:null, ['class' => 'form-control', 'placeholder' => 'State', 'required' => 'required']) }}--}}
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="required">Zip code</label>
            {{ Form::text('zip', !is_null($locationDetail)?$locationDetail->zip:null, ['maxlength'=>'15','class' => 'form-control', 'placeholder' => 'Zip Code', 'required' => 'required']) }}
        </div>
    </div>
</div>


{{--
<div class="row">
    <div class="col-sm-6">
        <div class="card" >
            <div class="card-header">
                Avaiable Doctor
            </div>
            <ul id="edit-sortable1" class="list-group list-group-flush edit-connectedSortable1" style="width: 100%; height: 200px; overflow-x: hidden; overflow-y: scroll;">

                @if(isset($doctors) && count($doctors) > 0)
                    @foreach($doctors as $doctor)
                        @if(!collect($location->doctors)->pluck('id')->contains($doctor->id))
                        <tr class="text-white">
                            <li class="list-group-item">
                                {{ !is_null($doctor->person)? $doctor->person->name : ''   }}
                                <input type="hidden" name="doctor_id[]" value="{{ $doctor->id }}">
                            </li>
                        </tr>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card" >
            <div class="card-header">
                Selected Doctor
            </div>
            <ul id="edit-sortable2" class="list-group list-group-flush edit-connectedSortable2" style="width: 100%; height: 200px; overflow-x: hidden; overflow-y: scroll;">

                    @foreach($location->doctors as $doctor)
                        <tr class="text-white">
                            <li class="list-group-item">
                                {{ !is_null($doctor->person)? $doctor->person->name : ''   }}
                                <input type="hidden" name="doctor_id[]" value="{{ $doctor->id }}">
                            </li>
                        </tr>
                    @endforeach

            </ul>
        </div>
    </div>
</div>
--}}

<div class="form-group">
    {{-- <label for="">Phone</label>
     <input class="form-control phone-form location-phone owner-phone-field" name="practice_owner_phone" id="phone" data-inputmask="'alias': '999-999-9999'" value="{{!is_null($practice->person)?$practice->person->phone:''}}" required>
     <img class="phone-field-location" src="{{ asset('img/images/us-flag.svg') }}" alt="">
     <div class="input-num-location">+1</div>
     <div class="location-phone-fields error-position-1">
     </div>--}}
    <label class="required">NPI</label>
    {{ Form::text('npi',  !is_null($location->npi)?$location->npi:null, ['class' => 'form-control location-npi-field edit-location-npi-field', 'placeholder' => 'Enter Provider NPI', 'required' => 'required','maxlength'=>"10"]) }}

</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
{{ Html::script('vendors/inputmask/jquery.inputmask.bundle.js') }}
{{ Html::script('vendors/typeahead.js/typeahead.bundle.min.js') }}
{{ Html::script('js/template/js/inputmask.js') }}


