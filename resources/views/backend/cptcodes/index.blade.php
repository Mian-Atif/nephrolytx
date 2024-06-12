@extends(!is_null(Auth::user()->roles()->where('name', 'Administrator')->first()) ? 'backend.layouts.backend' : 'backend.layouts.dashboard')

@section('before-styles')
<style>
#cptCode label{
    color: #fff;
}
</style>
@endsection
@section('content-new')

<div class="content-wrapper">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Cpt Code</h4>
            <div class="row">
                <div class="col-md-12 text-right" style="margin-top: -50px">
                    <button type="button" class="btn btn-primary practice-btn commit-button">Add Cpt Code <i class="fas fa-user-plus" aria-hidden="true"></i></button>

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
                    <div class="col-md-6">
{{--                        @dd($practices)--}}
                        @if(isset($practices) && count($practices) > 0)
                        @if(!is_null(Auth::user()->roles()->where('name', 'Administrator')->first()) || !is_null(Auth::user()->roles()->where('name', 'Billing Manager')->first()))
                            <div class="form-group">
                                {{ Form::label('name', 'Select Practice') }}
                                {{-- {!! Form::select('practice', count($practices)?$practices->pluck('name', 'code'):'',null,['class' => 'form-control', 'required' => 'required']) !!}--}}
                                {!! Form::select('practice', count($practices)?$practices->pluck('name', 'id'):'',null,['class' => 'form-control', 'required' => 'required']) !!}

                            </div>
                        @else

                            <input type="hidden" name="practice" value="{{ !is_null(Auth::user()->practice_id) ? Auth::user()->practice_id: ''  }}">
                        @endif
                            @endif
                    </div>
                    <div class="table-responsive tableFixHead">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr class="table-color">
                                    <th><strong> #</strong></th>
                                    <th class="table-height"><strong>CPT Code</strong> </th>
                                    <th class="table-height1"><strong> Amount($)</strong></th>
                                    <th><strong> State</strong></th>
                                    <th class="text-center"><strong> Action</strong></th>

                                </tr>

                            </thead>
                            <tbody class="cptcode-table">
                                @if(isset($cptCodes) && !is_null($cptCodes))
                                @foreach($cptCodes as $cptCode)
                                <tr class="text-white billingindex{{ !is_null($cptCode->id) ? $cptCode->id : '' }}">

                                    <td>{{ $loop->iteration }}</td>
                                    <td class="table-border-left">{{ !is_null($cptCode->cpt_code)? $cptCode->cpt_code : ''   }}</td>
                                    <td ><span class="editable" data-id="{{ !is_null($cptCode->id) ? $cptCode->id : '' }}" data-cptId="{{ !is_null($cptCode->id) ? $cptCode->id : '' }}"> {{ !is_null($cptCode->par_amount)? $cptCode->par_amount : ''   }}</span></td>

                                    <td>{{ !is_null($cptCode->state)? $cptCode->state : ''   }}</td>
                                    <td class="text-center"><a style="cursor: pointer;color:#FE0957;" class="DeleteCpt  DeleteCpt{{ !is_null($cptCode->id) ? $cptCode->id : '' }}" data-id="{{ !is_null($cptCode->id) ? $cptCode->id : '' }}"><i class="fas fa-trash-alt"></i></a></td>
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

<div class="modal fade cpt-popup" id="useradd" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content pop-up">
        <div class="modal-header">
            <h4 class="pt-3"><strong>CPT Code</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                </button>
            </div>

            <div class="modal-body" style="padding: 0px;">

            </div>

        </div>
    </div>
</div>



@endsection

@section('after-scripts')

    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<script>
    $(window).scroll(function() {
        if ($(window).scrollTop() >= 100) {
            $('.sticky_bar').addClass('fixed-nav');
        } else {
            $('.sticky_bar').removeClass('fixed-nav');
        }
    });
    $(document).on("click", ".DeleteCpt", function() {
        if (confirm('Are you sure you want to delete?')) {
            var id = $(this).data('id');
            var url = '{!! url('admin/cptcodes')!!}'+"/"+id;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data: {
                    id: id,
                    _method: 'DELETE'
                },
                beforeSend: function() {
                    $('.DeleteCpt' + id).html('<i class="fas fa-cog fa-spin" aria-hidden="true"></i>');
                },
                success: function(response) {
                    if (response.status) {
                        $('.billingindex' + id).remove();
                    }
                },
                complete: function() {
                    $('.DeleteCpt' + id).html('<i class="fas fa-trash-alt" aria-hidden="true"></i>');
                }
            });
        }
    });
    $(document).on("click", ".editable", function(e) {
        e.stopPropagation();
        var id = $(this).data('id');
        var value = $(this).text();
        updateVal(this, value, id);
    });
    function updateVal(currentEle, value, cptId) {
        let val = value.trim();
        $(currentEle).html('<input class="thVal" type="number" min="1" data-cptId="' + cptId + '" value="' + val + '" />');
        $(".thVal", currentEle).focus().keyup(function(event) {
            if (event.keyCode == 13) {
                $(currentEle).html($(".thVal").val().trim());
            }
        }).click(function(e) {
            e.stopPropagation();
        });

        $(document).click(function() {
            let attr = $(".thVal").attr('data-cptId');
            if (this.value == '') {
                return false;
            }
            $(".thVal").replaceWith(function() {
                let cptId = ($(".thVal").attr('data-cptId'));
                $.ajax({
                    type: 'GET',
                    url: "{{ url( 'admin/cptcodes') }}/" + cptId + '/' + this.value,
                    headers: {
                        'X-CSRF-Token': "{{csrf_token()}}"
                    },
                    success: function(response) {
                        toastr.clear();
                        toastr.success('Amount Updated!!', 'Sucess', {
                            timeOut: 2000
                        })
                    },
                });

                return this.value;
            });

        });
    }

    $(document).on("click", ".commit-button", function() {
        var oldBtnText = $(this).html();
        $.ajax({
            beforeSend: function() {
                $('.commit-button').html('Add Cpt Code <i class="fas fa-cog fa-spin" aria-hidden="true"></i>');
            },
            type: 'GET',
            url: "{{ url('admin/get-cptcodePrice-modal') }}",
            headers: {
                'X-CSRF-Token': "{{csrf_token()}}"
            },
            success: function(response) {
                $('.commit-button').html(oldBtnText).prop('disabled', false);

                if (response.status == true) {
                    $('.cpt-popup .modal-body').html(response.data);
                    $('.cpt-popup').modal('show');
                } else {
                    $('.cpt-popup .modal-body').html('');
                    toastr.clear();
                    toastr.error(response.message, 'Error', {
                        timeOut: 5000
                    });
                }
            },
        });
    });
    $(document).on("submit","#cptCode",function (e) {
        e.preventDefault();
        var $f = $(this);
        var $sb = $f.find('[type="submit"]');
        var oldBtnText = $sb.html();

        $.ajax({
            beforeSend: function () {
                $sb.html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>Processing').prop('disabled', true);
            },
            url: $f.attr('action'),
            type: $(this).attr('method'),
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {

                $sb.html(oldBtnText).prop('disabled', false);
                if (data.status) {
                    toastr.clear();

                    toastr.success(data.message, 'Success', {timeOut: 5000});
                    location.reload(true);
                }
                else {
                    toastr.clear();
                    toastr.error(data.message, 'Error', {timeOut: 5000});
                    loadRequestErrors(data);

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
            $.each(xhr.message, function(key, item) {
                toastr.clear();
                toastr.error(item, 'Error', {
                    timeOut: 5000
                });
            });
        } else if (xhr.responseJSON.message) {
            toastr.clear();
            toastr.error(xhr.responseJSON.message, 'Error', {
                timeOut: 5000
            });
        }
    }
    $("select[name='practice']").on('change', function(e) {
        e.preventDefault();
        var practice_id = $('option:selected', this).val();
        var url = '{!! url('admin/cptCodeFilter')!!}';

        var interval = setInterval(function () {
            NProgress.inc();
        }, 1000);

        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': "{{csrf_token()}}"
            }
        });
        $.ajax({
            beforeSend: function () {
                NProgress.set(0.4);
            },
            type:'POST',
            url: url,
            data:{practice:practice_id},
            success:function(response){
                if(response.status){
                    $('.cptcode-table').replaceWith(response.view);
                    NProgress.done();
                    clearInterval(interval);
                }else{
                    toastr.clear();
                    toastr.error(response.message, 'Error', {timeOut: 5000});
                }
            },
            error: function(xhr, status, error) {
                $.each(xhr.responseJSON.errors, function (key, item) {
                    toastr.error(item);
                });
            }

        });
    });

</script>

@endsection