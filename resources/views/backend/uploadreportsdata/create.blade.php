@extends(!is_null(Auth::user()->roles()->where('name', 'Administrator')->first()) ? 'backend.layouts.backend' : 'backend.layouts.dashboard')

@section('after-styles')
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> -->
    <style>
        .progress {
            position: relative;
            width: 100%;
            border: 1px solid #7F98B2;
            padding: 1px;
            border-radius: 3px;
        }

        .bar {
            background-color: #B4F5B4;
            width: 0%;
            height: 25px;
            border-radius: 3px;
        }

        .percent {
            position: absolute;
            display: inline-block;
            top: 3px;
            left: 48%;
            color: #7F98B2;
        }
    </style>
@endsection
@section('content-new')
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card" style="border: none;">
                <div class="card-body">
                    <h4 class="card-title">Upload CSV</h4>
                    <form method="POST" action="{{ route('admin.upload-reports-data.store') }}"
                          enctype="multipart/form-data" class="csvForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                @if(isset($practices) && count($practices) > 0)

                                    @if(!is_null(Auth::user()->roles()->where('name', 'Administrator')->first()) || !is_null(Auth::user()->roles()->where('name', 'Billing Manager')->first()))
                                        <div class="form-group">

                                            {{ Form::label('name', 'Select Practice') }}

                                            {!! Form::select('practice', count($practices)?$practices->pluck('name', 'id'):'',null,['class' => 'form-control practice-val', 'required' => 'required']) !!}

                                        </div>
                                    @else
                                        <input type="hidden" name="practice"
                                               value="{{ !is_null(Auth::user()->practice_id) ? Auth::user()->practice_id: ''  }}">
                                    @endif
                                @endif
                            </div>
                            <div class="col-md-12">
                                <input name="file" type="file"
                                       accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel,text/comma-separated-values, text/csv, application/csv.csv"
                                       class="form-control csv-file" style="border: none;padding: 4px 8px;width: 35%;"><br/>

                                <button type="button" class="btn btn-primary"
                                        style="background-color: #f16857;border:1px solid #f16857" id="sample-csv"
                                        data-role="button"><i class="fa fa-download"></i> Sample CSV
                                </button>
                                <button type="submit" value="Submit" class="btn btn-danger upload_csv">Upload</button>
                                <p class="csv-rows-up"><span class="csv-rows-count"></span>/<span class="csv-rows-total"></span></p>
                                <div class="csv-rows-errors">
                                    
                                </div>
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
            
//             $('body').on('change','.csv-file', function() {
                
//   var file = this.files[0];
//   var reader = new FileReader();
//   var practice_id = $('.practice-val').val();
  
//   reader.onload = async function(event) {
//     var csv = event.target.result;
//     var rows = csv.split(/\r\n|\n/);
    
//     $('.csv-rows-count').html('0');
//     $('.csv-rows-total').html(rows.length);
//     var chunkSend = [];
//     for (var i = 0; i < 100; i++) {
//         if(i > 0){
//           var columns = rows[i].split(',');
//           var data = {
//             provider: columns[0],
//             Rendering_Provider: columns[1],
//             Service_Location: columns[2],
//             account_nbr : columns[3],
//             Patient_Name : columns[4],
//             dateofbirth : changeDateFormat(columns[5]),
//             Date_of_Service : changeDateFormat(columns[6]),
//             Claim_BillDate : changeDateFormat(columns[7]),
//             icd_1 : columns[8],
//             icd_2 : columns[9],
//             icd_3 : columns[10],
//             icd_4 : columns[11],
//             icd_5 : columns[12],
//             icd_6 : columns[13],
//             icd_7 : columns[14],
//             icd_8 : columns[15],
//             pos : columns[16],
//             cptcode : columns[17],
//             MODIFIER : columns[18],
//             units : columns[19],
//             Billed_Amount : columns[20],
//             Primary_Insurance_Name : columns[21],
//             Secondary_Insurance_Name : columns[22],
//             Primary_Insurance_Allowance : columns[23],
//             Primary_Insurance_Payment : columns[24],
//             Primary_Contractual_Adjustment : columns[25],
//             Primary_PaymentDate_CheckDate : changeDateFormat(columns[26]),
//             Primary_CheckNo_ReferenceNo : columns[27],
//             Secondary_Insurance_Payment : columns[28],
//             Secondary_Contractual_Adjustment : columns[29],
//             Secondary_PaymentDate : changeDateFormat(columns[30]),
//             Secondary_CheckNo : columns[31],
//             Patient_Payment : columns[32],
//             Patient_PaymentDate : changeDateFormat(columns[33]),
//             Insurance_Balance : columns[34],
//             Patient_Balance : columns[35],
//             Write_off : columns[36],
//             address : columns[37],
//             city : columns[38],
//             state : columns[39],
//             ZIPCode : columns[40],
//             phone : columns[41],
//             cptcode_description : columns[42],
//             work_RVU : columns[43],
//             practice_RVU : columns[44],
//             malpractice_RVU : columns[45],
//             total_RVU : columns[46],
//             practice_id : practice_id,
            
//           };
//           chunkSend.push(data);
          
//         }
//     } // End For Loop
    
    
//     try {
        
//         console.log(chunkSend);
    
//         var response = await $.ajax({
//             url: 'https://nephrolytix.tdemo.biz/admin/upload-reports-data/single-load',
//             method: 'POST',
//             data: {chunkSend},
//             success: function(response) {
//               console.log('Row ' + (i+1) + ' inserted successfully.');
//                 $('.csv-rows-count').html(i+1);
//             },
//             error: function(jqXHR, textStatus, errorThrown) {
//                 $('.csv-rows-errors').append('<p>Error inserting row ' + (i+1) + ': ' + errorThrown + '</p>');
//             }
//           });
      
//     } catch (error) {
//       $('.csv-rows-errors').append('<p>Error inserting row ' + (i+1) + ': ' + error + '</p>');
//     }
    
    
//   };

//   reader.readAsText(file);
// });
          
    function changeDateFormat (dateStr){
        var dateObj = $.datepicker.parseDate('mm/dd/yy', dateStr);
        var formattedDate = $.datepicker.formatDate('yy-mm-dd', dateObj);
        return formattedDate;
    }          
            
            
            //*******CPT Graph Date submission************
        //     $('.csvForm').submit(function (e) {
        //         e.preventDefault();
        //         var $f = $(this);
        //         if (!$f[0].file.value) {
        //             toastr.clear();
        //             toastr.error('File not found', 'Error', {timeOut: 5000})

        //             return false;
        //         }
        //         var $sb = $f.find('[type="submit"]');
        //         var oldBtnText = $sb.html();
        //         $.ajax({
        //             beforeSend: function () {
        //                 $sb.html(' Processing...').prop('disabled', true);
        //                 $sb.html('<i class="fa fa-spinner fa-pulse fa-1x fa-fw"></i> Processing').prop('disabled', true);

        //             },
        //             url: $f.attr('action'),
        //             method: "POST",
        //             data: new FormData(this),
        //             dataType: 'JSON',
        //             contentType: false,
        //             cache: false,
        //             processData: false,
        //             success: function (data) {
        //                 $sb.html(oldBtnText).prop('disabled', false);
        //                 if (data.status) {
        //                     toastr.clear();
        //                     toastr.success(data.message, 'Sucess', {timeOut: 5000})
        //                     $('.csvForm')[0].reset();

        //                 } else {
        //                     toastr.clear();
        //                     toastr.error(data.message, 'Error', {timeOut: 5000})
        //                 }
        //             },
        //             error: function (xhr) {
        //                 $sb.html(oldBtnText).prop('disabled', false);
        //                 loadRequestErrors(xhr);
        //             },
        //             timeout: 1023000
        //         });

        //     });
        // });

            $('.csvForm').submit(function (e) {
                e.preventDefault();
                var skip = 0;
                var practice_id = $('.practice-val').val();
                //console.log(practice_id);
                loadCSVChunks(skip,practice_id);
            });
        
    });
    function loadCSVChunks(skip = 0,practice_id = -1){
            
            $.ajax({
                url: 'https://nephrolytix.tdemo.biz/admin/upload-reports-data/single-load',
                method: 'POST',
                data: {skip:skip,practice_id:practice_id},
                success: function(response) {
                    
                    $('.csv-rows-count').html(response.skip);
                    $('.csv-rows-total').html(response.total);
                    if(response.total > response.skip){
                        loadCSVChunks(response.skip,practice_id);
                    }
                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   //$('.csv-rows-errors').append('<p>Error inserting row ' + (i+1) + ': ' + errorThrown + '</p>');
                }
            });
            
        }
        
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
                    url: '{{url('/sample.csv')}}',
                    method: 'GET',
                    responseType: 'blob',
                }).then((response) => {
                    var fileURL = window.URL.createObjectURL(new Blob([response.data]));
                    var fileLink = document.createElement('a');

                    fileLink.href = fileURL;
                    fileLink.setAttribute('download', 'sample.csv');
                    document.body.appendChild(fileLink);

                    fileLink.click();
                });
            });

        });
    </script>
@endsection