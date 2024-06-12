<div class="box-body">
    <div class="row">
        <div class="form-group col-md-4">
            {{ Form::label('first_name', 'First Name', ['class' => 'col-lg-12 control-label required']) }}

            <div class="col-lg-12">
                {{ Form::text('first_name', null, ['class' => 'form-control box-size', 'placeholder' => 'First Name', 'required' => 'required']) }}
            </div>
            <!--col-lg-10-->
        </div>


        <div class="form-group col-md-4">
            {{ Form::label('last_name', 'Last Name', ['class' => 'col-lg-12 control-label required']) }}

            <div class="col-lg-12">
                {{ Form::text('last_name', null, ['class' => 'form-control box-size', 'placeholder' => 'Last Name', 'required' => 'required']) }}
            </div>
            <!--col-lg-10-->
        </div>

        <div class="form-group col-md-4">
            {{ Form::label('middle_name', 'Middle Initial', ['class' => 'col-lg-12 control-label required']) }}

            <div class="col-lg-12">
                {{ Form::text('middle_name', null, ['class' => 'form-control box-size', 'placeholder' => 'Middle Initial', 'required' => 'required']) }}
            </div>
            <!--col-lg-10-->
        </div>
        <!--form control-->

        <div class="form-group col-md-4">
            {{ Form::label('content', trans('validation.attributes.backend.person.email'), ['class' => 'col-lg-12 control-label required']) }}

            <div class="col-lg-12 mce-box">
                {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => trans('validation.attributes.backend.person.email'), 'required' => 'required']) }}
            </div>
            <!--col-lg-10-->
        </div>
        <!--form control-->
        <div class="form-group col-md-4">
            {{ Form::label('phone', trans('validation.attributes.backend.person.phone'), ['class' => 'col-lg-12 control-label required']) }}

            <div class="col-lg-12">
            <input type="tel" name="person-phone" class="form-control phone-form" id="phone" data-inputmask="'alias': 'phone'">
            <img class="phone-field-4" src="{{ asset('img/images/us-flag.svg') }}" alt="">
            <div class="input-num-4" style="font-size: 13px;
    color: darkgray;">+1</div>       
        </div>

            <!--col-lg-10-->
        </div>
        <!--form control-->

        <div class="form-group col-md-4">
            {{ Form::label('address1', trans('validation.attributes.backend.person.address1'), ['class' => 'col-lg-12 control-label required']) }}

            <div class="col-lg-12">
                {{ Form::text('address1', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.person.address1')]) }}
            </div>
            <!--col-lg-10-->
        </div>
        <!--form control-->

        <div class="form-group col-md-4">
            {{ Form::label('address2', trans('validation.attributes.backend.person.address2'), ['class' => 'col-lg-12 control-label required']) }}

            <div class="col-lg-12">
                {{ Form::text('address2', null, ['class' => 'form-control box-size', 'placeholder' => trans('validation.attributes.backend.person.address2')]) }}
            </div>
            <!--col-lg-10-->
        </div>
        <!--form control-->
    </div>
</div>

@section("after-scripts")
{{--<script src="https://code.jquery.com/jquery-latest.min.js"></script>--}}
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>
     $("#phone").inputmask({
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
</script>
@endsection