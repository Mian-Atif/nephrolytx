@extends ('backend.layouts.dashboard')

@section('content-new')
<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Practice Management</h4>
            @if ($errors->any())
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
            @endif

            @if(session()->has('message'))
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                </div>
            </div>

            @endif
            <div class="row">
                <div class="col-12">
                    {{ Form::open(['route' => 'admin.updateuserpractice', 'class' => 'form-horizontal addPracticeUser', 'role' => 'form', 'method' => 'post', 'id' => 'create-practiceuser']) }}

                    <div>

                        <div class="container pt-4 pb-3  practice-card">
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Practice Name', ['class' => 'required']) }}
                                        {{ Form::text('name', $practice->name, ['class' => 'form-control', 'placeholder' => "Practice Name", 'required' => 'required','name'=>"practice_name"]) }}
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
                                        {{ Form::label('name', 'Specialty', ['class' => 'required']) }}
                                        {!! Form::select('speciality[]', $specialities->pluck('name', 'id'),$practice->specialities,['class' => 'form-control js-example-basic-multiple', 'multiple'=>"multiple", 'required' => 'required']) !!}
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">

                                        {{ Form::label('name', 'NPI', ['class' => 'required']) }}
                                        {{ Form::tel('npi', !is_null($practice->detail)?$practice->detail->npi:null, ['id'=>'npi','class' => 'form-control npi-field','data-trigger'=>'manual','data-placement'=>'bottom','data-html'=>'true','data-content'=>'<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits', 'placeholder' => "NPI" ,'maxlength'=>"10" , 'required' => 'required']) }}

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Tax ID', ['class' => 'required']) }}
                                        {{ Form::tel('tax_id',  !is_null($practice->tax_id)?$practice->tax_id:null, ['class' => 'form-control tax-field taxId','data-inputmask-alias'=>'999-999-999','data-trigger'=>'manual','data-placement'=>'bottom','data-html'=>'true','data-content'=>'<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 9 Digits', 'placeholder' => "Tax ID",'maxlength'=>"12" , 'required' => 'required']) }}
                                    </div>
                                </div>
                            
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Email', ['class' => 'required']) }}
                                        {{ Form::text('email', $practice->email, ['class' => 'form-control', 'placeholder' => "Email", 'required' => 'required','name'=>"email", 'readonly' => true ]) }}
                                    </div>
                                </div>

                                <div class="col-md-3">
                                  {{--  <div class="form-group">
                                        <label for="phone" class="required">Phone</label>


                                        <input type="tel" name="practice-phone" class="form-control phone-form" id="phone"  data-inputmask="'alias': '999-999-9999'">

                                        <img class="phone-field" src="{{ asset('img/images/us-flag.svg') }}" alt="">
                                        <span class="input-num" style="font-size: 13px;">+1</span>
                                    </div>--}}

                                    <div class="form-group">
                                        {{ Form::label('name', 'Phone', ['class' => 'required']) }}
                                        <input class="form-control phone-form phone-fields" id="phone" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' data-inputmask="'alias': '999-999-9999'" name="phone" value="{{!is_null($practice->detail)?$practice->detail->phone:''}}" required>
                                        <img class="phone-field" src="{{ asset('img/images/us-flag.svg') }}" alt="">
                                        <span class="input-num" style="font-size: 13px;">+1</span>
                                        {{-- {{ Form::text('text', !is_null($practice->detail)?$practice->detail->phone:'', ['id'=>'phone','data-inputmask-alias'=>'999-999-9999','class' => 'form-control', 'placeholder' => "Phone",'name'=>"phone", 'type'=>"tel" , 'required' => 'required']) }}--}}

                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Fax') }}
                                        <input class="form-control phone-form fax-field faxs-field" id="phone" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' data-inputmask="'alias': '999-999-9999'" name="fax" value="{{ !is_null($practice->detail)?$practice->detail->fax:''}}">
                                        <img class="phone-field" src="{{ asset('img/images/us-flag.svg') }}" alt="">
                                        <span class="input-num" style="font-size: 13px;">+1</span>
                                    </div>
                                    <div class="fax-field error-position-1">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Website') }}
                                        {{ Form::text('text',  !is_null($practice->detail)?$practice->detail->website:'', ['class' => 'form-control', 'placeholder' => "Website", 'required' => 'required','name'=>"website"]) }}
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
                                        {{ Form::text('text', !is_null($practice->detail)?$practice->detail->address_1:'', ['class' => 'form-control', 'placeholder' => "Address 1", 'required' => 'required','name'=>"address_1"]) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Address 2', ['class' => 'required']) }}
                                        {{ Form::text('text', !is_null($practice->detail)?$practice->detail->address_2:'', ['class' => 'form-control', 'placeholder' => "Address 2", 'required' => 'required','name'=>"address_2"]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('name', 'City', ['class' => 'required']) }}
                                        {{-- {!! Form::select('state', $cities->pluck('name', 'id'),[ 'placeholder' => "City",'name'=>"city",'class' => 'typeahead form-control']) !!}--}}

                                        {{ Form::text('text', !is_null($practice->detail)?$practice->detail->city:'', ['class' => 'form-control', 'placeholder' => "City", 'required' => 'required','name'=>"city"]) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('name', 'State', ['class' => 'required']) }}
                                        <div id="the-basics">
{{--                                            {{ Form::text('text', !is_null($practice->detail)?$practice->detail->state:'', ['class' => 'typeahead form-control', 'placeholder' => "State", 'required' => 'required','name'=>"state"]) }}--}}

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
                                            {{-- {!! Form::select('state', $states->pluck('name', 'id'),[ 'placeholder' => "State",'name'=>"state",'class' => 'typeahead form-control']) !!}--}}

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Zip', ['class' => 'required']) }}
                                        {{ Form::text('text', !is_null($practice->detail)?$practice->detail->zip_code:'', ['class' => 'form-control', 'placeholder' => "Zip", 'required' => 'required','name'=>"zip"]) }}

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
                                        {{ Form::text('practice_owner_first_name', !is_null($practice->person)?$practice->person->first_name:null, ['class' => 'form-control', 'placeholder' => "First Name", 'required' => 'required']) }}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('name', ' Last Name', ['class' => 'required']) }}
                                        {{ Form::text('practice_owner_last_name', !is_null($practice->person)?$practice->person->last_name:null, ['class' => 'form-control', 'placeholder' => "Last Name", 'required' => 'required']) }}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        {{ Form::label('name', ' Middle Initial') }}
                                        {{ Form::text('practice_owner_middle_name', !is_null($practice->person)?$practice->person->middle_name:null, ['class' => 'form-control', 'placeholder' => "Middle Initial"]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('name', 'Email', ['class' => 'required']) }}
                                        {{ Form::email('practice_owner_email',!is_null($practice->person)?$practice->person->email:'', ['class' => 'form-control', 'placeholder' => "Owner Email", 'required' => 'required', 'readonly' => true]) }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        {{ Form::label('name', 'Phone') }}
                                        <input class="form-control phone-form owner-phone-field" name="practice_owner_phone" id="phone" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' data-inputmask="'alias': '999-999-9999'" value="{{!is_null($practice->person)?$practice->person->phone:''}}">
                                        <img class="phone-field" src="{{ asset('img/images/us-flag.svg') }}" alt="">
                                        <span class="input-num" style="font-size: 13px;">+1</span>
                                    </div>
                                    <div class="owner-phone-field error-position">
                                    </div>
                                </div>

                            </div>

                        </div>







                        {{ Form::submit('Update', ['class' => 'btn ml-3 btn-primary']) }}
                        {{ Form::close() }}















                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('after-scripts')
<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
 <script>
     $("#phone").inputmask({

        mask: '999 999 9999',
        placeholder: ' ',
        showMaskOnHover: false,
        showMaskOnFocus: false,
        onBeforePaste: function(pastedValue, opts) {
            var processedValue = pastedValue;

            //do something with it

            return processedValue;
        }
    });

    $("#phone-1").inputmask({
        mask: '999-999-9999',
        placeholder: ' ',
        showMaskOnHover: false,
        showMaskOnFocus: false,
        onBeforePaste: function(pastedValue, opts) {
            var processedValue = pastedValue;

            //do something with it

            return processedValue;
        }
    });

     $(document).on("change keyup", '.npi-field', function(e) {
         if (/\D/g.test(this.value)) {
             // Filter non-digits from input value.
             this.value = this.value.replace(/\D/g, '');
             toastr.error('please enter numbers only', 'Error', {
                 timeOut: 2000
             });

         }
     });
   



     $(document).on("submit", '#create-practiceuser', function(e) {

         $(".error").remove();
         if ($('.npi-field').val().length < 10) {
             $('#npi').popover('show')
             $('#npi').focus();
             return false;
         } else if ($('.tax-field').val().replace(/\D/g, '').length < 9) {
             $('.tax-field').popover('show');
             $('.tax-field').focus();
             return false;

         } else if ($('.phone-fields').val().replace(/\D/g, '').length < 10) {
         $('.phone-fields').popover('show');
         $('.phone-fields').focus();
         return false;
     }else if ($('.owner-phone-field').val().replace(/\D/g, '').length < 10) {
             $('.owner-phone-field').popover('show');
             $('.owner-phone-field').focus();
             return false;
         } else if ($('.fax-field').val().replace(/\D/g, '').length>0 && $('.fax-field').val().replace(/\D/g, '').length<10) {
             $('.fax-field').popover('show');
             $('.faxs-field').focus();
             return false;
         }
         
     });
     $('.owner-phone-field').on('shown.bs.popover', function () {
   setTimeout(function () {
    $('.owner-phone-field').popover('hide');
   }, 3000);
})
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
$('.fax-field').on('shown.bs.popover', function () {
   setTimeout(function () {
    $('.fax-field').popover('hide');
   }, 3000);
})
 </script>
@endsection