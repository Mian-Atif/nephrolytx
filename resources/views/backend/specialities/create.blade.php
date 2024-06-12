@extends(!is_null(Auth::user()->roles()->where('name', 'Administrator')->first()) ? 'backend.layouts.backend' : 'backend.layouts.dashboard')

@section('after-styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
        .progress { position:relative; width:100%; border: 1px solid #7F98B2; padding: 1px; border-radius: 3px; }
        .bar { background-color: #B4F5B4; width:0%; height:25px; border-radius: 3px; }
        .percent { position:absolute; display:inline-block; top:3px; left:48%; color: #7F98B2;}
    </style>
@endsection
@section('content-new')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card" style="border: none;">
                <div class="card-body">
                    <h4 class="card-title">Upload CPT Code Price CSV</h4>
                    <form method="POST" action="{{ route('spacialityStore') }}" enctype="multipart/form-data" class="csvForm">
                        @csrf
                        <div class="row">

                            <div class="col-md-12">
                                <input name="file" id="poster" type="file" class="form-control" style="border: none;padding: 4px 8px;width: 35%;"><br/>

                                <button type="button" class="btn btn-info"style="background-color: #f16857;border:1px solid #f16857;" id="sample-csv" data-role="button"><i class="fa fa-download"></i> Sample CSV</button>
                                <button type="submit" value="Submit"style="background-color: #f16857;border:1px solid #f16857;" class="btn btn-success upload_csv">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('after-scripts')
    {{ Html::script('js/jquery.js') }}
    {{ Html::script('js/jquery.form.js') }}


    <script type="text/javascript">

        function validate(formData, jqForm, options) {
            var form = jqForm[0];
            if (!form.file.value) {
                alert('File not found');
                return false;
            }
        }

        (function() {
            $('.progress').hide();

            $('.csvForm').ajaxForm({
                beforeSubmit: validate,
                beforeSend: function() {},
                uploadProgress: function(event, position, total, percentComplete) {
                    // $('.upload_csv').attr('disabled','disabled').html('Uploading <i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i>')
                },
                success: function() {},
                complete: function(xhr) {
                    $('.upload_csv').html('Uploaded!')
                    alert('Uploaded Successfully');
                    // window.location.reload();
                }
            });

        })();
    </script>

@endsection