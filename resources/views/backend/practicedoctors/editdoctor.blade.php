<link rel="stylesheet" href="{{asset('libraries/phoneApi/css/intlTelInput.css')}}">
<link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

<div>
    <label class="required">Name:</label>

    {{ Form::text('name', !is_null($doctors)?$doctors->middle_name:'', ['maxlength'=>'50','class' => 'read-only-location','style'=>'width:100%', 'placeholder' => 'Name', 'required' => 'required','readonly' => 'true']) }}

    {{ Form::hidden('doctor_id',$doctor->id)  }}
</div>
<div class="mt-3" style="margin-bottom: -23px;">
    <label class="required">Phone No.</label>
    <input type="tel" class="form-control phone-form edit-provider-phone" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' name="phone" id="payer-phone" value="{{!is_null($doctors->phone)?$doctors->phone:null}}" data-inputmask="'alias': '999-999-9999'" >
<img class="phone-field-edit" src="{{ asset('img/images/us-flag.svg') }}" alt="">
    <span class="input-num-edit">+1</span>
    <!-- <div class="edit-provider-phone-fields error-position-1">
    </div> -->
</div>

<div class="mt-3">
    <label>Email</label>
    {{ Form::text('email', !is_null($doctors->email)?$doctors->email:null, [ 'maxlength'=>'65','class' => 'form-control', 'placeholder' => 'Enter Provider Email', 'required' => 'required']) }}
    
</div>
<div class="mt-3">
    <label class="required">Taxonomy Code</label>
{{ Form::text('taxonomy_code', !is_null($doctors->taxonomy_code)?$doctors->taxonomy_code:null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => 'Enter Provider Taxonomy Code', 'required' => 'required']) }}
{{--    <input type="tel" class="form-control phone-form" name="taxonomy_code" id="payer-phone" data-inputmask="'alias': '999-999-9999'" >--}}
</div>
<div class="mt-3">
    <label class="required">NPI</label>
    <input type="text" maxlength="10" class="form-control edit-provider-phone" name="npi" value="{{!is_null($doctors->npi)?$doctors->npi:null}}" placeholder="Enter Provider NPI" required >

</div>
<script src="{{asset('libraries/phoneApi/js/intlTelInput.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('libraries/phoneApi/js/intlTelInput.min.js')}}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
{{ Html::script('vendors/inputmask/jquery.inputmask.bundle.js') }}
{{ Html::script('vendors/typeahead.js/typeahead.bundle.min.js') }}
{{ Html::script('js/template/js/inputmask.js') }}
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
