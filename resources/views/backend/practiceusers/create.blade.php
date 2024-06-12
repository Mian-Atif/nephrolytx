@extends ('backend.layouts.backend')


@section('page-header')
User Management
@endsection

@section('after-styles')
{{ Html::style('css/select2.min.css') }}

<style>
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
</style>

@endsection



@section('content-new')

@if(session()->has('message'))
<div class="row">
    <div class="col-12">
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    </div>
</div>

@endif


{{ Form::open(['route' => 'admin.savePracticeUser', 'class' => 'form-horizontal addPracticeUser', 'role' => 'form', 'method' => 'post', 'id' => 'create-practiceuser']) }}
<div class="card">
    <div class="location-model">
        <div class="row">


            <div class="col-md-4">
                <div class="form-group">
                    <label class="required">First Name</label>
                    {{ Form::text('first_name', null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => 'First  Name', 'required' => 'required']) }}
                    <input type="hidden" name="practice_id" value="{{ Request::segment(3) }}">
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group">
                    <label class="required">Last Name</label>
                    {{ Form::text('last_name', null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => 'Last  Name', 'required' => 'required']) }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Middle Initial</label>
                    {{ Form::text('middle_name', null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => 'Middle Initial']) }}
                </div>
            </div>

            <div class="col-sm-6">
                {{-- <div class="form-group">
                    <label>Phone No.</label>
                    <input class="form-control phone-form phone" id="phone-5" data-inputmask="'alias': 'phonebe'" name="phone">
                    <img class="phone-field-3" src="{{ asset('img/images/us-flag.svg') }}" alt="">
                <span class="input-num-3" style="font-size: 13px;
    color: darkgray;">+1</span>
            </div>--}}
            <div class="form-group" style="margin-bottom: 0px;">
                <label for="phone" class="required">Phone No.</label>
                <input type="tel" name="phone" class="form-control phone-form phone" id="phone-5" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' data-inputmask="'alias': '999-999-9999'" required>

                <img class="phone-field-3" src="{{ asset('img/images/us-flag.svg') }}" alt="">
                <span class="input-num-3">+1</span>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group">
                <label class="required">Email</label>
                {{ Form::text('email', null, ['maxlength'=>'65','class' => 'form-control', 'placeholder' => 'Enter  Email', 'required' => 'required']) }}
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label class="required">Password</label>
                {{--{{ Form::text('password', null, ['class' => 'form-control', 'placeholder' => 'Enter  Password', 'required' => 'required', 'type'=>'password']) }}--}}
                {{--<input id="password" type="password" class="form-control" name="password" required="" placeholder="Enter  Password">--}}

                <input id="password" type="password" maxlength="150" class="form-control" name="password" required="" placeholder='Enter  Password'>

                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                <label class="required">Confirm Password</label>
                {{-- {{ Form::text('confirm_password', null, ['class' => 'form-control', 'placeholder' => 'Enter  confirm password', 'required' => 'required','type'=>'password']) }}--}}
                <input id="password-confirm" type="password" maxlength="150" class="form-control" name="confirm_password" required="" placeholder='Enter Confirm Password'>
                @if ($errors->has('confirm_password'))
                <span class="help-block">
                    <strong>{{ $errors->first('confirm_password') }}</strong>
                </span>
                @endif


                {{--<input id="cofirm_password" type="password" class="form-control" name="cofirm_password" required="" placeholder="Enter Confirm Password">--}}

            </div>
        </div>

        {{-- <div class="col-sm-6">
                    <div class="form-group">
                        <label>Select Location <span class="loader-location"></span></label>

                        <select class="form-control location-multiple"  multiple="multiple">
                            @if($locations->count())
                                @foreach($locations as $location)
                                    <option data-url="{{ url('admin/get_doctor_by_location/'.$location->id) }}" value="{{$location->id}}">{{ $location->location_name  }}</option>
        @endforeach
        @endif
        </select>


    </div>
</div>--}}

</div>
{{--
            <div class="row">
                <div class="col-sm-6">
                    <div class="card" >
                        <div class="card-header">
                            Available Doctors
                        </div>

                       <div class="avaiable_doctors"></div>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card" >
                        <div class="card-header">
                            Selected Doctors
                        </div>
                        <ul id="addusersortable2" class="list-group list-group-flush adduserconnectedSortable" style="width: 100%; height: 200px; overflow-x: hidden; overflow-y: scroll;">
                        </ul>
                    </div>
                </div>
            </div>--}}

</div>


<div class="edit-form-btn">
    {{ link_to_route('admin.practices.edit',trans('buttons.general.cancel'), request()->id, ['class' => 'btn btn-danger btn-md']) }}

    {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md submitpracticeuser']) }}
    <div class="clearfix"></div>
</div>
<!--edit-form-btn-->

</div>
<!--box box-success-->
{{ Form::close() }}


@endsection


@section('after-scripts')
{{ Html::script('js/jquery-latest.min.js') }}
{{ Html::script('js/jquery-ui.js') }}
{{ Html::script('js/select2.min.js') }}
<script src="https://code.jquery.com/jquery-latest.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<script>
    $("#phone-5").inputmask({
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

    $("#addusersortable1").sortable({
        connectWith: ".adduserconnectedSortable"
    }).disableSelection();

    $("#addusersortable2").sortable({
        connectWith: ".adduserconnectedSortable"
    }).disableSelection();

    $(document).ready(function() {
        $('.location-multiple').select2();
    });

    $('.location-multiple').on('select2:select', function(e) {
        var id = e.params.data.id;
        var url = e.params.data.element.dataset.url;

        $.ajax({
            type: 'GET',
            url: url,
            data: '_token = <?php echo csrf_token() ?>',
            beforeSend: function() {
                $('.loader-location').html('<i class="fas fa-cog fa-spin" aria-hidden="true"></i>');
            },
            success: function(responce) {
                if (responce.code == 1) {
                    $('.avaiable_doctors').html(responce.html);
                    $('.loader-location').html('');
                    $("#addusersortable1").sortable({
                        connectWith: ".adduserconnectedSortable"
                    }).disableSelection();

                    $("#addusersortable2").sortable({
                        connectWith: ".adduserconnectedSortable"
                    }).disableSelection();

                }
            }
        });
    });

    /* $('form.addPracticeUser').submit(function() {
         $('.avaiable_doctors').html('');
     });*/
</script>
<script>
    $(document).ready(function() {
        $(document).on("submit", '.addPracticeUser', function(e) {
            if ($('.phone').val().replace(/\D/g, '').length > 0 && $('.phone').val().replace(/\D/g, '').length < 10) {
                $('.phone').popover('show');
                $('.phone').focus();
                return false;
            }
        });
    });
    $('.phone').on('shown.bs.popover', function() {
        setTimeout(function() {
            $('.phone').popover('hide');
        }, 3000);
    })
</script>
@endsection