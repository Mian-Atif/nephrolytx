@extends ('backend.layouts.backend')

@section ('title', trans('labels.backend.practices.management') . ' | ' . trans('labels.backend.practices.create'))

@section('page-header')
{{ trans('labels.backend.practices.management') }}
<small>{{ trans('labels.backend.practices.create') }}</small>
@endsection
@section('after-styles')
<link rel="stylesheet" href="{{asset('libraries/phoneApi/css/demo.css')}}">
<link rel="stylesheet" href="{{asset('libraries/phoneApi/css/intlTelInput.css')}}">
<link rel="stylesheet" href="build/css/intlTelInput.css">
<style>
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
</style>

@endsection
@section('content-new')
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
</div>--}}
{{ Form::open(['route' => 'admin.practices.store', 'class' => 'forms-sample practiceCreate', 'role' => 'form', 'method' => 'post', 'id' => 'create-practice']) }}
@csrf
<div class="container pt-4 pb-3 practice-card">
    <div class="row">



        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('name', 'Practice Name', ['class' => 'required']) }}
                {{ Form::text('name', null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => "Practice Name", 'name'=>"practice_name", 'required' => 'required']) }}
            </div>
        </div>


        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('name', 'Practice Type', ['class' => 'required']) }}
                <select class="form-control " name="practice_type" required>
                    @foreach($paraciteTypes as $key=> $paraciteType)
                    <option value="{{$paraciteType}}">{{$paraciteType}}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('name', 'Speciality', ['class' => 'required']) }}
                {!! Form::select('speciality[]', $specialities->pluck('name', 'id'),null,['class' => 'form-control js-example-basic-multiple', 'multiple'=>"multiple", 'required' => 'required']) !!}
            </div>
        </div>



        <div class="col-md-2">
            <div class="form-group">
                {{ Form::label('name', 'NPI', ['class' => 'required']) }}

                {{ Form::tel('npi', null, ['class' => 'form-control npi npi-field','id'=>'npi','data-trigger'=>'manual','data-placement'=>'bottom','data-html'=>'true','data-content'=>'<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits', 'placeholder' => "NPI",'maxlength'=>"10" , 'required' => 'required']) }}



            </div>
        </div>


        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('name', 'Tax ID', ['class' => 'required']) }}
                {{ Form::tel('tax_id', null, ['class' => 'form-control taxId tax-field','data-inputmask-alias'=>'999-999-999','data-trigger'=>'manual','data-placement'=>'bottom','data-html'=>'true','data-content'=>'<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 9 Digits', 'placeholder' => "Tax ID",'maxlength'=>"12", 'required' => 'required' ]) }}


            </div>
        </div>


        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('name', 'Email', ['class' => 'required']) }}
                {{ Form::text('email', null, ['maxlength'=>'65','class' => 'form-control', 'placeholder' => "Email",'name'=>"email" , 'required' => 'required']) }}
            </div>
        </div>



        <div class="col-md-3">
            <div class="form-group">
                <label for="phone" class="required">Phone</label>

                <input name="phone" class="form-control phone-form phone-fields" id="phone" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' data-inputmask="'alias': '999-999-9999'" required>
                <img class="phone-field" src="{{ asset('img/images/us-flag.svg') }}" alt="">
                <span class="input-num">+1</span>
            </div>
        </div>


        <div class="col-md-3">
            <div class="form-group">
                {{ Form::label('name', 'Fax') }}
                <input class="form-control phone-form fax-field faxs-field" id="phone" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' data-inputmask="'alias': '999-999-9999'" name="fax">
                <img class="phone-field" src="{{ asset('img/images/us-flag.svg') }}" alt="">
                <span class="input-num">+1</span>
            </div>
        </div>
    </div>
    <div class="row">



        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('name', 'Website') }}
                {{ Form::text('text', null, ['maxlength'=>'65','class' => 'form-control', 'placeholder' => "Website",'name'=>"website"]) }}
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
                {{ Form::text('text', null, ['maxlength'=>'150','class' => 'form-control', 'placeholder' => "Address 1",'name'=>"address_1", 'required' => 'required']) }}
            </div>
        </div>


        <div class="col-md-12">
            <div class="form-group">
                {{ Form::label('name', 'Address 2', ['class' => 'required']) }}
                {{ Form::text('text', null, ['maxlength'=>'150','class' => 'form-control', 'placeholder' => "Address 2",'name'=>"address_2" , 'required' => 'required']) }}
            </div>
        </div>
    </div>


    <div class="row">

        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('name', 'City', ['class' => 'required']) }}
                {{ Form::text('text', null, ['maxlength'=>'35','class' => 'form-control', 'placeholder' => "City", 'required' => 'required','name'=>"city", 'required' => 'required']) }}
            </div>
        </div>


        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('name', 'State', ['class' => 'required']) }}
                <div id="the-basics">

                    <select name="state" class="form-control" required>
                        <option value="">Select State</option>
                        @if($states->count())
                        @foreach($states as $state)
                        <option value="{{ $state->name  }}" style="text-transform: capitalize;">{{ $state->name  }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('name', 'Zip', ['class' => 'required']) }}
                {{ Form::text('text', null, ['maxlength'=>'15','class' => 'form-control', 'placeholder' => "Zip", 'required' => 'required','name'=>"zip"]) }}

            </div>
        </div>


    </div>

</div>
<div class="container pt-4 pb-3 mt-3 practice-card">
    <h2>Owner</h2>
    <div class="row">


        <div class="col-md-2">
            <div class="form-group">
                {{ Form::label('name', 'First Name', ['class' => 'required']) }}
                {{ Form::text('practice_owner_first_name', null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => "First Name", 'required' => 'required']) }}
            </div>
        </div>



        <div class="col-md-2">
            <div class="form-group">
                {{ Form::label('name', 'Last Name', ['class' => 'required']) }}
                {{ Form::text('practice_owner_last_name', null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => "Last Name", 'required' => 'required']) }}
            </div>
        </div>


        <div class="col-md-2">
            <div class="form-group">
                {{ Form::label('name', 'Middle Initial') }}
                {{ Form::text('practice_owner_middle_name', null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => "Middle Initial"]) }}
            </div>
        </div>


        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('name', 'Email',['class'=>'required']) }}
                {{ Form::email('practice_owner_email', null, ['maxlength'=>'65','class' => 'form-control ', 'placeholder' => "Owner Email", 'required' => 'required']) }}
            </div>
        </div>
        <div class="col-md-6">

            <div class="form-group">
                {{ Form::label('name', 'Phone') }}

                <input class="form-control phone-form owner-phone-field" name="practice_owner_phone" id="phone" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' data-inputmask="'alias': '999-999-9999'">
                <img class="phone-field" src="{{ asset('img/images/us-flag.svg') }}" alt="">
                <span class="input-num ">+1</span>
            </div>


        </div>

    </div>

</div>
<div class="pt-3">
    {{ link_to_route('admin.practices.index', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger mr-2']) }}
    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-gradient-primary']) }}
    {{ Form::close() }}

</div>


@endsection
@section('after-scripts')
{{-- <script src="{{asset('libraries/phoneApi/js/intlTelInput.js')}}"></script>--}}
<!-- Use as a Vanilla JS plugin -->

<script src="{{asset('libraries/phoneApi/js/intlTelInput.min.js')}}"></script>
<!-- Use as a jQuery plugin -->

{{--<script src="https://code.jquery.com/jquery-latest.min.js"></script>--}}

{{--<script src="build/js/intlTelInput-jquery.min.js"></script>--}}
{{--<script src="https://code.jquery.com/jquery-latest.min.js"></script>--}}
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });

    $(document).on("submit", ".practiceCreate", function (e) {
        $(".error").remove();
        if ($('.npi-field').val().length < 10) {
            $('#npi').popover('show');
            $('#npi').focus();
            return false;
        } else if ($('.tax-field').val().replace(/\D/g, '').length < 9) {
            $('.tax-field').popover('show')
            $('.tax-field').focus();
            return false;
        } else if ($('.phone-fields').val().replace(/\D/g, '').length < 10) {
            $('.phone-fields').popover('show')
            $('.phone-fields').focus();
            return false;
        } else if ($('.owner-phone-field').val().replace(/\D/g, '').length>0 && $('.owner-phone-field').val().replace(/\D/g, '').length<10) {
            $('.owner-phone-field').popover('show')
            $('.owner-phone-field').focus();
            return false;
        } else if ($('.fax-field').val().replace(/\D/g, '').length>0 && $('.fax-field').val().replace(/\D/g, '').length<10) {
            $('.fax-field').popover('show')
            $('.faxs-field').focus();
            return false;
        }

    });

    $('#npi').on('shown.bs.popover', function () {
   setTimeout(function () {
    $('#npi').popover('hide');
   }, 3000);
})
$('.tax-field').on('shown.bs.popover', function () {
   setTimeout(function () {
    $('.tax-field').popover('hide');
   }, 3000);
})
$('.phone-fields').on('shown.bs.popover', function () {
   setTimeout(function () {
    $('.phone-fields').popover('hide');
   }, 3000);
})
$('.owner-phone-field').on('shown.bs.popover', function () {
   setTimeout(function () {
    $('.owner-phone-field').popover('hide');
   }, 3000);
})
$('.faxs-field').on('shown.bs.popover', function () {
   setTimeout(function () {
    $('.faxs-field').popover('hide');
   }, 3000);
})



    $(document).on("change keyup", '.npi-field', function(e) {
        if (/\D/g.test(this.value)) {
            // Filter non-digits from input value.
            this.value = this.value.replace(/\D/g, '');
            toastr.error('please enter numbers only', 'Error', {
                timeOut: 2000
            });

        }
    });
</script>
@endsection