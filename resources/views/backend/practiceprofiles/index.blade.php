@extends ('backend.layouts.dashboard')
@section('after-styles')
    <link rel="stylesheet" href="{{asset('libraries/phoneApi/css/demo.css')}}">
    <link rel="stylesheet" href="{{asset('libraries/phoneApi/css/intlTelInput.css')}}">
    <!-- <link rel="stylesheet" href="build/css/intlTelInput.css"> -->

@endsection
@section('content-new')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Profile</h4>

                @if(!session()->has('passwordStatus'))
                    @if(session()->has('message'))
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            </div>
                        </div>

                    @endif
                @endif
                <div class="row">
                    <div class="col-12">
                        {{ Form::open(['route' => 'admin.updatepracticeprofile', 'id' => 'practice-profile', 'class' => 'form', 'role' => 'form', 'method' => 'post', 'files' => true]) }}


                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                    {{ Form::label('name', ' First Name', ['class' => 'required']) }}
                                    {{ Form::text('first_name', !is_null($user->person)?$user->person->first_name:null, ['class' => 'form-control ael', 'placeholder' => "First Name", 'required' => 'required', 'maxlength' => '30']) }}
                                    @if ($errors->has('first_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    {{ Form::label('name', ' Last Name', ['class' => 'required']) }}
                                    {{ Form::text('last_name', !is_null($user->person)?$user->person->last_name:null, ['class' => 'form-control ael ', 'placeholder' => "Last Name", 'required' => 'required', 'maxlength' => '30']) }}
                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {{ Form::label('name', ' Middle Initial') }}
                                    {{ Form::text('middle_name', !is_null($user->person)?$user->person->middle_name:null, ['class' => 'form-control  ael', 'placeholder' => "Middle Initial"]) }}
                                </div>
                            </div>
                            {{--   <div class="col-sm-6">
                                   <div class="form-group">
                                       <label>Name</label>
                                       {{ Form::text('name', !is_null($user->person)?$user->person->name:'', ['class' => 'form-control', 'placeholder ael' => 'Name', 'required' => 'required', 'maxlength' => '30']) }}
                                   </div>
                               </div>--}}
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="required">Email</label>
                                    {{ Form::email('email', !is_null($user->person)?$user->person->email:'', ['class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required', 'readonly' => 'readonly','disabled' => true ]) }}

                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone" class="required">Phone</label>
                                    <input type="tel" name="phone" data-html="true" data-placement="bottom"
                                           data-trigger="manual"
                                           data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits'
                                           class="form-control phone-form phone" id="phone"
                                           data-inputmask="'alias': '999-999-9999'"
                                           value="{{!is_null($user->person)?$user->person->phone:null}}" required>

                                    <img class="phone-field" src="{{ asset('img/images/us-flag.svg') }}" alt="">
                                    <span class="input-num">+1</span>
                                </div>
                            </div>
                        </div>
                        <div class="profile-btn">
                            {{ Form::submit(trans('Update'), ['class' => 'btn btn-primary btn-md']) }}
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
    <div class="content-wrapper mt-5">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Change Password</h4>

                @if(session()->has('passwordStatus'))
                    @if(session()->has('message'))
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-success">
                                    {{ session()->get('message') }}
                                </div>
                            </div>
                        </div>

                    @endif
                @endif
                <div class="row">
                    <div class="col-12">
                        {{ Form::open(['route' => 'admin.updateprofilepassword','class' => 'form', 'role' => 'form', 'method' => 'post']) }}
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group password-box{{ $errors->has('current_password') ? ' has-error' : '' }}">
                                    <label class="required">Current Password</label>
                                    {{ Form::password('current_password',  ['class' => 'form-control', 'placeholder' => 'Password','required'=>'required']) }}
                                    @if ($errors->has('current_password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('current_password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group password-box{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="required">New Password</label>
                                    {{ Form::password('password',  ['class' => 'form-control', 'placeholder' => 'Password','required'=>'required']) }}
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group password-box{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
                                    <label class="required">Confirm Password</label>
                                    {{ Form::password('confirm_password',  ['class' => 'form-control', 'placeholder' => 'Confirm Password','required'=>'required']) }}
                                    @if ($errors->has('confirm_password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('confirm_password') }}</strong>
                                    </span>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="profile-btn">
                            {{ Form::submit(trans('Update'), ['class' => 'btn btn-primary btn-md']) }}
                        </div>

                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>

        {{--</div>--}}
    </div>
@endsection

@section('after-scripts')
    {{-- <script src="{{asset('libraries/phoneApi/js/intlTelInput.js')}}"></script>--}}
    <!-- Use as a Vanilla JS plugin -->

    <script src="{{asset('libraries/phoneApi/js/intlTelInput.min.js')}}"></script>


    <!-- Use as a jQuery plugin -->

    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script type='text/javascript'
            src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>



    {{--<script src="build/js/intlTelInput-jquery.min.js"></script>--}}

    <script>
        $("#phone").inputmask({
            mask: '999 999 9999',
            placeholder: ' ',
            showMaskOnHover: false,
            showMaskOnFocus: false,
            onBeforePaste: function (pastedValue, opts) {
                var processedValue = pastedValue;

                //do something with it

                return processedValue;
            }
        });
    </script>


    <script>
        $('.phone').on('shown.bs.popover', function () {
            setTimeout(function () {
                $('.phone').popover('hide');
            }, 3000);
        })
        $(document).ready(function () {

            $('.js-example-basic-single').select2();
        });
        $(document).on("submit", '#practice-profile', function (e) {
            if ($('.phone').val().replace(/\D/g, '').length > 0 && $('.phone').val().replace(/\D/g, '').length < 10) {
                $('.phone').popover('show');
                $('.phone').focus();
                return false;
            }
        });

        $(document).on("keypress",".ael", function(event) {

            // Disallow anything not matching the regex pattern (A to Z uppercase, a to z lowercase and white space)
            // For more on JavaScript Regular Expressions, look here: https://developer.mozilla.org/en-US/docs/JavaScript/Guide/Regular_Expressions
            var englishAlphabetAndWhiteSpace = /[A-Za-z ]/g;

            // Retrieving the key from the char code passed in event.which
            // For more info on even.which, look here: http://stackoverflow.com/q/3050984/114029
            var key = String.fromCharCode(event.which);

            //alert(event.keyCode);

            // For the keyCodes, look here: http://stackoverflow.com/a/3781360/114029
            // keyCode == 8  is backspace
            // keyCode == 37 is left arrow
            // keyCode == 39 is right arrow
            // englishAlphabetAndWhiteSpace.test(key) does the matching, that is, test the key just typed against the regex pattern
            if (event.keyCode == 8 || event.keyCode == 37 || event.keyCode == 39 || englishAlphabetAndWhiteSpace.test(key)) {
                return true;
            }




            // If we got this far, just return false because a disallowed key was typed.
            return false;
            });
            $('body').on('keyup','.ael', function(){

                var eventVal = $(this).val();
                console.log(eventVal);
                if(eventVal.length > 13){
                    return false;
                }

            });
            $('#mytextbox').on("paste",function(e)
            {
            e.preventDefault();
            });


    </script>
@endsection