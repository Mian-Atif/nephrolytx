@extends ('backend.layouts.dashboard')

@section ('title', trans('labels.backend.practiceusers.management') . ' | ' . trans('labels.backend.practiceusers.create'))


@section('page-header')
    {{ trans('labels.backend.practiceusers.management') }}
    <small>{{ trans('labels.backend.practiceusers.create') }}</small>
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
            box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
        }
        .location-model .card-header{
            border: none;
            border-radius:0;
            margin-bottom: 5px;
            color: #fff;

        }
        .location-model .card{
            background: transparent;
        }
    </style>

@endsection



@section('content-new')
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">Practice User</h4>
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
{{--
    @if(session()->has('error'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            </div>
        </div>

    @endif--}}



    {{ Form::open(['route' => 'admin.savepracticeusers', 'class' => 'form-horizontal addPracticeUser', 'role' => 'form', 'method' => 'post', 'id' => 'practice-user']) }}
    <div>
        <div class="location-model">
            <div class="row">

                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="required">First Name</label>
                        {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First  Name', 'required' => 'required']) }}
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="required">Last Name</label>
                        {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Last  Name', 'required' => 'required']) }}
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Middle Initial:</label>
                        {{ Form::text('middle_name', null, ['class' => 'form-control', 'placeholder' => 'Middle  Name']) }}
                    </div>
                </div>
                <div class="col-sm-6">
               {{-- <div class="form-group">
                <label for="phone">Phone</label>

                <input type="tel" name="phone" class="form-control phone-form" id="phone" data-inputmask="'alias': 'phone'">
                <img class="phone-field" src="{{ asset('img/images/us-flag.svg') }}" alt="">
                <span class="input-num" style="font-size: 13px;">+1</span>
            </div>--}}
                    <div class="form-group">
                        <label for="phone" class="required">Phone</label>
                        <input type="tel" name="phone" class="form-control phone-form phone" id="phone" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' data-inputmask="'alias': '999-999-9999'" required>

                        <img class="phone-field" src="{{ asset('img/images/us-flag.svg') }}" alt="">
                        <span class="input-num">+1</span>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="required">Email</label>
                        {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter  Email', 'required' => 'required']) }}
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group password-box">
                        <label class="required">Password</label>
                        {{ Form::password('password', ['class' => 'form-control field-height', 'placeholder' => 'Enter  Password', 'required' => 'required']) }}
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group password-box">
                        <label class="required">Confirm Password</label>
                        {{ Form::password('confirm_password',  ['class' => 'form-control field-height', 'placeholder' => 'Enter  confirm password', 'required' =>'required']) }}
                    </div>
                </div>

{{--               --}}

               {{-- <div class="col-sm-6">
                    <div class="form-group">
                        <label>Select Location <span class="loader-location"></span></label>

                        <select class="form-control location-multiple"  multiple="multiple">
                            @if($locations->count())
                                @foreach($locations as $location)
                                    <option data-url="{{ url('admin/get_practice_doctor_by_location/'.$location->id) }}" value="{{$location->id}}">{{ $location->location_name  }}</option>
                                @endforeach
                            @endif
                        </select>


                    </div>
                </div>--}}

            </div>

           {{-- <div class="row">
                <div class="col-sm-6">
                    <div class="card" >
                        <div class="card-header" style="color:#000;">
                            Available Doctors
                        </div>

                        <div class="avaiable_doctors"></div>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card" >
                        <div class="card-header" style="color:#000;">
                            Selected Doctors
                        </div>
                        <ul id="addusersortable2" class="list-group list-group-flush adduserconnectedSortable" style="width: 100%; height: 200px; overflow-x: hidden; overflow-y: scroll;">
                        </ul>
                    </div>
                </div>
            </div>--}}

        </div>
{{--        practiceusersmanagement--}}

        <div class="edit-form-btn">
            {{ link_to_route('admin.practiceusersmanagement', trans('buttons.general.cancel'), [], ['class' => 'btn btn-danger btn-md']) }}
            {{ Form::submit(trans('buttons.general.crud.create'), ['class' => 'btn btn-primary btn-md submitpracticeuser']) }}
            <div class="clearfix"></div>
        </div><!--edit-form-btn-->

    </div><!--box box-success-->
    {{ Form::close() }}
</div>
</div>
</div>

@endsection


@section('after-scripts')

    {{ Html::script('js/jquery-latest.min.js') }}
    {{ Html::script('js/jquery-ui.js') }}
    {{ Html::script('js/select2.min.js') }}
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

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
        $("#addusersortable1").sortable({
            connectWith: ".adduserconnectedSortable"
        }).disableSelection();

        $("#addusersortable2").sortable({
            connectWith: ".adduserconnectedSortable"
        }).disableSelection();

    /*    $(document).ready(function() {
            $('.location-multiple').select2();
        });

        $('.location-multiple').on('select2:select', function (e) {
            var id = e.params.data.id;
            var url = e.params.data.element.dataset.url;

            $.ajax({
                type:'GET',
                url:url,
                data:'_token = <?php echo csrf_token() ?>',
                beforeSend: function() {
                    $('.loader-location').html('<i class="fas fa-cog fa-spin" aria-hidden="true"></i>');
                },
                success:function(responce) {
                    if(responce.code == 1){
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

        $('form.addPracticeUser').submit(function(){
            $('.avaiable_doctors').html('');
        });*/

        </script>
        <script>
        $(document).ready(function() {

        $(document).on("submit", '#practice-user', function(e) {
            if ($('.phone').val().replace(/\D/g, '').length > 0 && $('.phone').val().replace(/\D/g, '').length < 10) {
                $('.phone').popover('show');
                $('.phone').focus();
                return false;
            }
        });
        });
        $('.phone').on('shown.bs.popover', function () {
   setTimeout(function () {
    $('.phone').popover('hide');
   }, 3000);
})
    </script>
@endsection

