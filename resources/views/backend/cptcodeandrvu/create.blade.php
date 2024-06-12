@extends(!is_null(Auth::user()->roles()->where('name', 'Administrator')->first()) ? 'backend.layouts.backend' : 'backend.layouts.dashboard')

@section('after-styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
        .progress { position:relative; width:100%; border: 1px solid #7F98B2; padding: 1px; border-radius: 3px; }
        .bar { background-color: #B4F5B4; width:0%; height:25px; border-radius: 3px; }
        .percent { position:absolute; display:inline-block; top:3px; left:48%; color: #7F98B2;}
        .dropdown-menu-right{background: #000 !important;}
        .dropdown-menu-right a{color:#fff !important;}
        .dropdown-menu-right a i{color: #f16857 !important;}
    </style>
@endsection
@section('content-new')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card" style="border: none;">
                <div class="card-body">
                    <h4 class="card-title">Upload CPT Code RUV</h4>
                    <form method="POST" action="{{ route('admin.cptcodervu.store') }}" enctype="multipart/form-data" class="csvForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                @if(isset($practices) && count($practices) > 0)

                                    @if(!is_null(Auth::user()->roles()->where('name', 'Administrator')->first()) || !is_null(Auth::user()->roles()->where('name', 'Billing Manager')->first()))
                                        <div class="form-group">
                                            {{ Form::label('name', 'Select Practice') }}
                                            {{--                                        {!! Form::select('practice', count($practices)?$practices->pluck('name', 'code'):'',null,['class' => 'form-control super', 'required ' => 'required']) !!}--}}

                                            {!! Form::select('practice', count($practices)?$practices->pluck('name', 'id'):'',null,['class' => 'form-control super', 'required ' => 'required']) !!}

                                        </div>
                                    @else

                                        <input type="hidden" name="practice" value="{{ !is_null(Auth::user()->practice_id) ? Auth::user()->practice_id: ''  }}">
                                    @endif
                                @endif

                            </div>
                            <div class="col-md-12">
                                <input name="file" id="poster" type="file" class="form-control" style="border: none;padding: 4px 8px;width: 35%;"><br/>

                                <button type="button" class="btn btn-info"style="background-color: #f16857;border:1px solid #f16857;" id="sample-csv" data-role="button"><i class="fa fa-download"></i> Sample CSV</button>
                                <button type="submit" value="Submit" style="background-color: #d24571;border: 1px solid #d24571;" class="btn btn-danger upload_csv">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('after-scripts')
    <!-- Use as a jQuery plugin -->

    <script src="https://code.jquery.com/jquery-latest.min.js"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>


    <script type="text/javascript">
        $(document).ready(function () {
            //*******CPT Graph Date submission************
            $('.csvForm').submit(function (e) {
                e.preventDefault();
                var $f = $(this);
                if (!$f[0].file.value) {
                    toastr.clear();
                    toastr.error('File not found', 'Error', {timeOut: 5000})

                    return false;
                }
                var $sb = $f.find('[type="submit"]');
                var oldBtnText = $sb.html();
                $.ajax({
                    beforeSend: function () {
                        $sb.html(' Processing...').prop('disabled', true);
                        $sb.html('<i class="fas fa-spinner fa-spin"></i> Processing').prop('disabled', true);

                    },
                    url: $f.attr('action'),
                    method: "POST",
                    data: new FormData(this),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        $sb.html(oldBtnText).prop('disabled', false);
                        if (data.status) {
                            toastr.success(data.message, 'Success', {timeOut: 5000})
                            $('.csvForm')[0].reset();

                        } else {
                            toastr.clear();
                            toastr.error(data.message, 'Error', {timeOut: 5000})
                        }
                    },
                    error: function (xhr) {
                        $sb.html(oldBtnText).prop('disabled', false);
                        loadRequestErrors(xhr);
                    }
                });

            });
        });

        function loadRequestErrors(xhr) {
            if (xhr.responseJSON.errors) {
                $.each(xhr.responseJSON.errors, function (key, item) {
                    toastr.clear();
                    toastr.error(item, 'Error', {timeOut: 5000});
                });
            } else if (xhr.responseJSON.message) {
                toastr.clear();
                toastr.error(xhr.responseJSON.message, 'Error', {timeOut: 5000});
            }
        }

    </script>

    <script>
        $(document).ready(function () {
            $("#sample-csv").click(function () {
                axios({
                    url: '{{url('/cptcodeandrvu.csv')}}',
                    method: 'GET',
                    responseType: 'blob',
                }).then((response) => {
                    var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                    var fileLink = document.createElement('a');

                    fileLink.href = fileURL;
                    fileLink.setAttribute('download', 'cptcodeandrvu.csv');
                    document.body.appendChild(fileLink);

                    fileLink.click();
                });
            });

        });
    </script>
@endsection