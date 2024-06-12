<link rel="stylesheet" href="{{asset('libraries/phoneApi/css/intlTelInput.css')}}">

{{ Form::open(['route' => 'admin.saveBillingManager', 'class' => 'form billing-manager', 'role' => 'form', 'method' => 'post', 'files' => true]) }}
{{ Form::hidden('practice_id',!is_null($practice->detail)?$practice->detail->id:'') }}
<div>
    {{ Form::label('name', 'First Name',['class'=>'required']) }}
    {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'Enter First Name', 'required' => 'required']) }}

</div>

<div class="mt-3">
    {{ Form::label('name', 'Last Name',['class'=>'required']) }}

    {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Last Name', 'required' => 'required']) }}

</div>

<div class="mt-3">
    <label>Middle Initial:</label>

    {{ Form::text('middle_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Middle Initial', 'required' => 'required']) }}

</div>
<div class="mt-3 billing-manager-margin">

    {{ Form::label('name', 'Phone No.',['class'=>'required']) }}


    <input type="tel" name="phone" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' class="form-control phone-form billing-phone" id="phone" data-inputmask="'alias': '999-999-9999'" required>

    <img class="phone-field" src="{{ asset('img/images/us-flag.svg') }}" alt="">
    <span class="input-num">+1</span>
</div>

<div>
    <label class="required-1">Email</label>
    {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter  Email', 'required' => 'required']) }}

</div>

{{-- <div class="mt-3">
    <label>Address 1</label>
    {{ Form::text('address1', null, ['class' => 'form-control', 'placeholder' => 'Enter  Address', 'required' => 'required']) }}

</div>

<div class="mt-3">
    <label>Address 2</label>
    {{ Form::text('address2', null, ['class' => 'form-control', 'placeholder' => 'Enter  Address 2', 'required' => 'required']) }}

</div>--}}


<div class="modal-footer">


    <button type="submit" class="btn btn-info">Save</button>
</div>
{{ Form::close() }}


<script src="{{asset('libraries/phoneApi/js/intlTelInput.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('libraries/phoneApi/js/intlTelInput.min.js')}}"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
{{ Html::script('vendors/inputmask/jquery.inputmask.bundle.js') }}
{{ Html::script('vendors/typeahead.js/typeahead.bundle.min.js') }}
{{ Html::script('js/template/js/inputmask.js') }}
<script>
    $('.create-location-phone').on('shown.bs.popover', function() {
        setTimeout(function() {
            $('.edit-provider-phone').popover('hide');
        }, 3000);
    })
</script>