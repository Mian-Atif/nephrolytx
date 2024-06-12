@extends ('backend.layouts.dashboard')
@section('content-new')

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Billing Manager</h4>
            <div class="row">
                <div class="col-md-12 text-right" style="margin-top: -50px">
                    <button type="button" class="btn btn-primary practice-btn " title="Tooltip on top" data-toggle="modal" data-target="#useradd">Add Billing Manager <i class="fas fa-user-plus" aria-hidden="true"></i></button>

                </div>
            </div>

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

                    <div class="table-responsive tableFixHead">
                        <table id="#" class="table">
                            <thead>
                                <tr class="table-color">
                                    <th><strong>#</strong> </th>
                                    <th class="table-height"><strong> Name</strong></th>
                                    <th class="table-height1"><strong> Email</strong></th>
                                  {{--  <th><strong> Address 1</strong></th>
                                    <th><strong> Address 2</strong></th>--}}

                                    <th class="table-height"><strong> Cell No.</strong></th>
                                    <th class="text-center"><strong>Action</strong> </th>

                                </tr>

                            </thead>
                            <tbody>
                                @if($billingManagers->count())
                                @foreach($billingManagers as $billingManager)
                                <tr class="text-white billingindex{{ !is_null($billingManager->person) ? $billingManager->person->id : '' }}">

                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ !is_null($billingManager->person)? $billingManager->person->first_name.' '. $billingManager->person->last_name : ''   }}</td>
                                    <td> {{ !is_null($billingManager->person)? $billingManager->person->email : ''   }}</td>
                                   {{-- <td>{{ !is_null($billingManager->person)? $billingManager->person->address1 : ''   }}</td>
                                    <td>{{ !is_null($billingManager->person)? $billingManager->person->address2 : ''   }}</td>--}}
                                    <td> {{ !is_null($billingManager->person)? $billingManager->person->phone : ''   }}</td>
                                    <td class="text-center"><a style="cursor: pointer;color:#FE0957;" class="DeleteBilling  DeleteBilling{{ !is_null($billingManager->person) ? $billingManager->person->id : '' }}" data-id="{{ !is_null($billingManager->person) ? $billingManager->person->id : '' }}"><i class="fas fa-trash-alt"></i></a></td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">No data found!</td>
                                </tr>
                                @endif


                            </tbody>

                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="useradd" role="dialog">
    <div class="modal-dialog">


        <div class="modal-content pop-up">
        <div class="modal-header">
            <h4 class="pt-3"><strong>Billing Manager</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                </button>
            </div>

            <div class="modal-body">
                {{ Form::open(['route' => 'admin.addBillingManager', 'id' => 'billing-manager', 'class' => 'form', 'role' => 'form', 'method' => 'post', 'files' => true]) }}
                <div class="mt-3">
                    {{ Form::label('name', 'First Name',['class'=>'required']) }}

                    {{ Form::text('first_name', null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => 'Enter First Name', 'required' => 'required']) }}
                </div>

                <div class="mt-3">
                    {{ Form::label('name', 'Last Name',['class'=>'required']) }}

                    {{ Form::text('last_name', null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => 'Enter Last Name', 'required' => 'required']) }}
                </div>

                <div class="mt-3">
                    <label>Middle Initial:</label>
                    {{ Form::text('middle_name', null, ['maxlength'=>'50','class' => 'form-control', 'placeholder' => 'Enter Middle Initial', 'required' => 'required']) }}
                </div>
                <div class="mt-3" style="margin-bottom: -23px;">
                    {{ Form::label('name', 'Phone No.',['class'=>'required']) }}
                    <input type="tel" name="phone" class="form-control phone-form phone" data-html="true" data-placement="bottom" data-trigger="manual" data-content='<i class="fa fa-exclamation" aria-hidden="true"></i> Please Enter 10 Digits' id="phone" data-inputmask="'alias': '999-999-999'">
                    <img class="phone-field-bm phone-field" src="{{ asset('img/images/us-flag.svg') }}" alt="">
                    <span class="input-num-bm" style="font-size: 13px;">+1</span>
                    <div class="phone-fields error-position-1">
                </div>



                <div>
                    <label>Email</label>
                    {{ Form::text('email', null, ['maxlength'=>'65','class' => 'form-control', 'placeholder' => 'Enter  Email', 'required' => 'required']) }}

                </div>

                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                {{ Form::close() }}
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
    $(document).on("click", ".DeleteBilling", function() {
        if (confirm('Are you sure you want to delete?')) {
            // var url = $(this).data('url');
            var id = $(this).data('id');
            var url = '{!! url('admin/deleteBillingmanager')!!}'+"/"+id;
            $.ajax({
                type: 'GET',
                url: url,
                data: '_token = <?php echo csrf_token() ?>',
                beforeSend: function() {
                    $('.DeleteBilling' + id).html('<i class="fas fa-cog fa-spin" aria-hidden="true"></i>');
                },
                success: function(responce) {
                    if (responce.code == 1) {
                        $('.billingindex' + id).remove();
                    }
                },
                complete: function() {
                    $('.DeleteBilling' + id).html('<i class="fas fa-trash-alt" aria-hidden="true"></i>');
                }
            });
        }
    });
    $('.phone').on('shown.bs.popover', function () {
   setTimeout(function () {
    $('.phone').popover('hide');
   }, 3000);
})
    $(document).on("submit","#billing-manager",function (e)  {
        e.preventDefault();

        if ($('.phone').val().replace(/\D/g, '').length > 0 && $('.phone').val().replace(/\D/g, '').length < 10) {
            $('.phone').popover('show')
            $('.phone').focus();
            return false;
        }
        var $f = $(this);
        var $sb = $f.find('[type="submit"]');
        var oldBtnText = $sb.html();

        $.ajax({
            beforeSend: function () {
                $sb.html('<i class="fa fa-spinner fa-spin"></i>Processing').prop('disabled', true);
            },
            url: $f.attr('action'),
            type: $(this).attr('method'),
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {

                $sb.html(oldBtnText).prop('disabled', false);
                if (data.status == true) {
                    toastr.clear();

                    toastr.success(data.message, 'Success', {timeOut: 5000});
                    location.reload(true);
                }
                else {
                    toastr.clear();
                    loadRequestErrors(data);

                    // toastr.error(data.message, 'Error', {timeOut: 5000});
                }
            },
            error: function (xhr) {
                $sb.html(oldBtnText).prop('disabled', false);
                loadRequestErrors(xhr);
            }
        });
    });

     function loadRequestErrors(xhr) {
         if (xhr.message) {
             $.each(xhr.message, function (key, item) {
                 toastr.clear();
                 toastr.error(item, 'Error', {timeOut: 5000});
             });
         } else if (xhr.responseJSON.message) {
             toastr.clear();
             toastr.error(xhr.responseJSON.message, 'Error', {timeOut: 5000});
         }
     }</script>
@endsection