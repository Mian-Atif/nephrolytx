<!doctype html>
<html class="no-js" lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('img/favicon_icon/nephro-fav.png')}}">
    <title>@yield('title', app_name())</title>
    <!-- Meta -->
    <meta name="description" content="@yield('meta_description', 'Default Description')">
    <meta name="author" content="@yield('meta_author', 'Viral Solani')">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Quicksand&display=swap" rel="stylesheet"> -->

    @yield('meta')
<!-- Styles -->

<!-- Check if the language is set to RTL, so apply the RTL layouts -->
    <!-- Otherwise apply the normal LTR layouts -->
    {{--<link rel="stylesheet" href="vendors/ti-icons/css/themify-icons.css">--}}
    {{--<link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">--}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.4.1/css/all.min.css">
    {{ Html::style(asset('css/ti-icons/css/themify-icons.css')) }}
    {{ Html::style('css/vendor.bundle.base.css') }}
    {{ Html::style('vendors/select2/select2.min.css') }}
    {{ Html::style('vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}
    {{ Html::style('vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}
    {{ Html::style('vendors/jquery-asColorPicker/css/asColorPicker.min.css') }}
    {{ Html::style('vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}
    {{ Html::style('vendors/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.min.css') }}
    {{ Html::style('vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}
    {{ Html::style('css/style.css') }}

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    @yield('after-styles')
        <!--[endif]-->

        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([ 'csrfToken' => csrf_token() ]) !!};
        </script>
        <?php
        if (!empty($google_analytics)) {
            echo $google_analytics;
        }
        ?>
    <style>
        .twitter-typeahead { display:block !important; }
        .raphael-group-152-background rect, .raphael-group-226-background rect, .raphael-group-thkhLZUh text{ fill: #f7fdff !important;}
        .raphael-group-17-caption text, .raphael-group-92-caption text,
        .raphael-group-54-dataset-top-label text, .raphael-group-90-datalabel text,
        .raphael-group-129-dataset-top-label text, .raphael-group-15-datalabel text{fill:#000 !important;}
        .profile-wrap {list-style:none;}
        .profile-wrap li {
            margin-bottom: 8px;
        }
        .profile-wrap li div.profile-title {
            width: 150px;
            margin-right: 20px;
            text-transform: capitalize;
            color: #000;
            display: inline-block;
        }
        .profile-wrap li .profile-desc {
            display: inline-block;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: solid black 1px;
            outline: 0;
            background: none !important;
            height: 40px !important;
            overflow-y: scroll !important;
        }
        .select2-container--default .select2-selection--multiple{
            background:none !important;
            height: 40px !important;
            border: 1px solid #bce0ea !important;
        }
        .dropdown-menu-right li{padding: 0 5px;color:#fff;font-size: 13px;}
        .dropdown-menu-right li a{color:#fff;}
        .dropdown-menu-right li a i{margin-right: 5px;}

        body .table-condensed  th, body .table-condensed  td{
            padding: 7px 8px !important;
        }
        .dt-buttons {
            display: none;
        }
        .export-btn-group {
            position: relative;
            left: 80%;
            padding-bottom: 10px;
        }
    </style>
    <script src="https://kit.fontawesome.com/7d58bb2b22.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="loading" style="display:none"></div>
@include('includes.partials.logged-in-as')
<div class="container-scroller">
    <!-- partial:partials/_sidebar.html -->
@include('backend.includes.sidebar-new')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        @include('backend.includes.header-nav')
        <div class="main-panel">

            @yield('content-new')
            {{--@include('includes.partials.messages')--}}
            {{--<div class="content-wrapper">--}}
                {{--<div class="row">--}}
                    {{--<div class="col-12 grid-margin stretch-card">--}}
                        {{--<div class="card">--}}
                            {{--<div class="card-body">--}}
                                {{--<h4 class="card-title">@yield('page-header')</h4>--}}
                                {{--@include('includes.partials.messages')--}}
                                {{--@yield('content-new')--}}

                                {{--                           //form--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
            @include('backend.includes.footer')
        </div>
        <!-- content-wrapper ends -->

    </div>
    <!-- main-panel ends -->
</div>
<!-- JavaScripts -->
@yield('before-scripts')

{{ Html::script('vendors/js/vendor.bundle.base.js') }}
{{ Html::script('js/template/js/tooltips.js') }}

{{ Html::script('vendors/flot/jquery.flot.js') }}
{{ Html::script('vendors/flot/jquery.flot.resize.js') }}
{{ Html::script('vendors/chart.js/Chart.min.js') }}
<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/fusioncharts.js"></script>
<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>
<script type="text/javascript" src="https://unpkg.com/jquery-fusioncharts@1.1.0/dist/fusioncharts.jqueryplugin.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

{{ Html::script('js/template/js/off-canvas.js') }}
{{ Html::script('js/template/js/hoverable-collapse.js') }}
{{ Html::script('js/template/js/template.js') }}
{{--{{ Html::script('js/template/js/dashboard2.js') }}--}}
{{ Html::script('vendors/inputmask/jquery.inputmask.bundle.js') }}
{{ Html::script('vendors/typeahead.js/typeahead.bundle.min.js') }}
{{ Html::script('js/template/js/inputmask.js') }}
{{ Html::script('vendors/select2/select2.min.js') }}
{{ Html::script('js/template/js/typeahead.js') }}
{{ Html::script('js/template/js/select2.js') }}
{{ Html::script('vendors/jquery-asColor/jquery-asColor.min.js') }}
{{ Html::script('vendors/jquery-asGradient/jquery-asGradient.min.js') }}
{{ Html::script('vendors/jquery-asColorPicker/jquery-asColorPicker.min.js') }}
{{ Html::script('vendors/moment/moment.min.js') }}
{{ Html::script('vendors/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.js') }}
{{ Html::script('vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}

{{ Html::script('js/template/js/formpickers.js') }}

{{ Html::script('vendors/datatables.net/jquery.dataTables.js') }}
{{ Html::script('vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}
{{--{{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js') }}--}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>
<link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css'/>


{{ Html::script('datatables/dataTables.buttons.min.js') }}
{{ Html::script('datatables/buttons.bootstrap.min.js') }}
{{ Html::script('datatables/jszip.min.js') }}
{{ Html::script('datatables/buttons.html5.min.js') }}
{{ Html::script('datatables/jszip.min.js') }}
{{ Html::script('datatables/pdfmake.min.js') }}
{{ Html::script('datatables/buttons.print.min.js') }}
{{ Html::script('datatables/vfs_font.js') }}
{{--{{ Html::script(('js/template/js/data-table.js')) }}--}}

<script type="text/javascript">
    $('.daterange').daterangepicker();

</script>
<!-- End plugin js for this page -->
<!-- Custom js for this page-->
<script type="text/javascript">


    var filenameMenu = $('title').text();
    var fileTitle = filenameMenu;
  function initFilterDataTable() {

      var table =   $('#order-listing').DataTable(
          { "bSort": false}
      );
      var buttons = new $.fn.dataTable.Buttons(table, {
          buttons:
              [
                  {extend: 'copy', className: 'copyButton',title: fileTitle},
                  {extend: 'csv', className: 'csvButton',title: fileTitle},
                  {extend: 'excel', className: 'excelButton',title: fileTitle},
                  {extend: 'pdf', className: 'pdfButton',title: fileTitle},
                  {extend: 'print', className: 'printButton',title: fileTitle}
              ]
      
      }).container().appendTo($('#buttons'));
          //Copy button
          $('#copyButton').click(function (e) {
              e.preventDefault();
              $('.copyButton').trigger('click');
          });
          //Download csv
          $('#csvButton').click(function (e) {
              e.preventDefault();
              $('.csvButton').trigger('click');
          });
          //Download excelButton
          $('#excelButton').click(function (e) {
              e.preventDefault();
              $('.excelButton').trigger('click');
          });
          //Download pdf
          $('#pdfButton').click(function (e) {
              e.preventDefault();
              $('.pdfButton').trigger('click');
          });
          //Download printButton
          $('#printButton').click(function (e) {
              e.preventDefault();
              $('.printButton').trigger('click');
          });

  }
  initFilterDataTable();

jQuery(document).ready(function ($) {
    $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        $('input[name="dateStartfilter"]').val(picker.startDate.format('MM/DD/YYYY') );
        $('input[name="dateEndfilter"]').val(picker.endDate.format('MM/DD/YYYY') );
        // $('#formDatePicker').submit();
        var $f = $('#formDatePicker');
        var interval = setInterval(function() { NProgress.inc(); }, 1000);

        $.ajax({
            beforeSend: function () {
                NProgress.set(0.4);
            },
            url: $f.attr('action'),
            type: $f.attr('method'),
            data: $f.serialize(),
            dataType: 'JSON',
            success: function (data) {
                if (data.status) {
                    $('.table-body').replaceWith(data.view);
                    NProgress.done();
                    clearInterval(interval);
                } /*else {

                        $sb.html(oldBtnText).prop('disabled', false);
                        new Noty({
                            type: 'error',
                            text: data.message
                        }).show();
                    }*/
            },
            error: function (xhr) {
                loadRequestErrors(xhr);
            }
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

           /* new Noty({
                type: 'error',
                text: xhr.responseJSON.message
            }).show();*/
        }
    }
    //******search filter for Analytics*******
    $('#searchFilter').submit(function (e) {
        e.preventDefault();
        var $f = $(this);
        var $sb = $f.find('[type="submit"]');
        var oldBtnText = $sb.html();
        var interval = setInterval(function() { NProgress.inc(); }, 1000);

        $("#order-listing").DataTable().destroy();
        $('#copyButton').unbind('click');
        $('#csvButton').unbind('click');
        $('#excelButton').unbind('click');
        $('#pdfButton').unbind('click');
        $('#printButton').unbind('click');

        $.ajax({
            beforeSend: function () {
                $sb.html('Processing...').prop('disabled', true);
                NProgress.set(0.4);
            },
            url: $f.attr('action'),
            type: $f.attr('method'),
            data: $f.serialize(),
            dataType: 'JSON',
            success: function (data) {
                $sb.html(oldBtnText).prop('disabled', false);
                if (data.status) {
                    $('.table-body').replaceWith(data.view);
                    $('.patient-stats').replaceWith(data.stat);

                    NProgress.done();
                    clearInterval(interval);
                    initFilterDataTable();
                } else {
                    clearInterval(interval);

                    // $sb.html(oldBtnText).prop('disabled', false);
                    toastr.clear();
                    toastr.error(data.message, 'Error', {timeOut: 5000});

                }
            },
            error: function (xhr) {
                $sb.html(oldBtnText).prop('disabled', false);
                loadRequestErrors(xhr);
            }
        });


    });

    $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
    });

});

</script>
<script>
    $(function() {
        console.log($.now());
        $('.date').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'), 10),
            maxDate: new Date()
        });

        //*******Financial Reports Date submission************
        $('.formDatePickers').submit(function (e) {
            e.preventDefault();
            var startDate = $('.startDate').val();
            var endDate = $('.endDate').val();
            if (startDate == '') {
                toastr.clear();
                toastr.warning('Please enter Start Date!!', 'Error', {timeOut: 5000})
                return false;
            } else if (endDate == '') {
                toastr.clear();
                toastr.warning('Please enter End Date!!', 'Error', {timeOut: 5000})
                return false;
            }
            var endDateFormat = new Date($('.endDate').val());
            var startDateFormat = new Date($('.startDate').val());
            if (startDateFormat > endDateFormat) {
                toastr.clear();
                toastr.warning('Start Date should be greater than to End Date.', 'Error', {timeOut: 5000})
                return false;
            }

            var $f = $(this);
            var $sb = $f.find('[type="submit"]');
            var oldBtnText = $sb.html();

            var interval = setInterval(function () {
                NProgress.inc();
            }, 1000);

            $("#order-listing").DataTable().destroy();
            $('#copyButton').unbind('click');
            $('#csvButton').unbind('click');
            $('#excelButton').unbind('click');
            $('#pdfButton').unbind('click');
            $('#printButton').unbind('click');

            $.ajax({
                beforeSend: function () {
                    $sb.html(' Processing...').prop('disabled', true);
                    NProgress.set(0.4);

                },
                url: $f.attr('action'),
                type: $f.attr('method'),
                data: $f.serialize(),
                dataType: 'JSON',
                success: function (data) {
                    $sb.html(oldBtnText).prop('disabled', false);
                    if (data.status) {
                        $('.table-body').replaceWith(data.view);
                        $('.reports-header').html(data.header);
                        NProgress.done();
                        clearInterval(interval);
                        initFilterDataTable();
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

    });


</script>
<script>
     $(document).ready(function () {
              $('#profileDropdown').on('click', function () {
                  
                  if ($('.dropdown-menu').hasClass('show')) {
                      $('.dropdown-menu').removeClass('show');
                  }
                  else {
                      $('.dropdown-menu').addClass('show');
                  }
              });
          });
          function closeMenu(){
            if ($('.dropdown-menu').hasClass('show')) {
                      $('.dropdown-menu').removeClass('show');
                  } 
}

$(document.body).click( function(e) {
     closeMenu();
});



$('body').on('click', '.menu-level-33', function(e){
    //e.preventDefault();
    var thUp = $(this).closest('.nav-item');
    thUp.find('.nav').slideToggle();
});

$('body').on('click', '.navbar-toggler', function(e){
    e.preventDefault();
    $('body').toggleClass('sidebar-icon-only');
});

    $('body').on('click','.feedback-btn', function(e){
        e.preventDefault();
        var x = validateForm();
        const email = document.getElementById("email").value;
        const comment = document.getElementById("exampleFormControlTextarea1").value;
        var y = checkComment(comment)
        console.log(email);
        if(isEmail(email) && x == 1 && y == 1 ){
        $("#namecheck").hide();
        $("#emailvalid").hide();
        $("#form-comment").hide();
        $(".email-check").removeClass('input-focus');

        jQuery.ajax({
            url:"{{route('admin.formsubmit')}}",   
            data: jQuery('#form-dialog').serialize(),
            type:'post',
            success: function (reasult) {
                console.log(reasult);
                $('.feedback-form')[0].reset();
                $('.feedback-msg').show();
                setTimeout(()=> {
                        $('#exampleModal').modal('hide');
                        $("#namecheck").hide();
                        $("#emailvalid").hide();
                        $('.feedback-msg').hide();
            }
            ,1000);
            }
    
        });

     
        // $('.modal-backdrop').removeClass('show');
        // $('body').removeClass('modal-open');
        // $('#exampleModal').removeClass('show');
        }
    } 
    );

function validateForm() {
  let x = document.forms["validate-my-Form"]["name"].value;
  let y = document.forms["validate-my-Form"]["email"].value;
  let comment = document.forms["validate-my-Form"]["comment"].value;
  if (x == "" || y == "" || comment == "" ||comment == "" ) {
    if((x == "" && y == "" && comment == "" )){
        $("#namecheck").show();
        $(".first-user-name").addClass('input-focus');
        $("#namecheck").html("Name is required"); 
        $("#emailvalid").show();
        $(".email-check").addClass('input-focus');
        $("#emailvalid").html("Email is required");
        $("#form-comment").show();
        $(".form-suggestion").addClass('input-focus');
        $("#form-comment").html("Suggestion is required");
        
    return 0;
    }else
    {
        $("#namecheck").hide();
        $(".first-user-name").removeClass('input-focus');
        $("#emailvalid").hide();
        $(".email-check").removeClass('input-focus');
        $("#form-comment").hide();
        $(".form-suggestion").removeClass('input-focus');

    }
    if(x == "" ){
        $("#namecheck").show();
        $(".first-user-name").addClass('input-focus');
        $("#namecheck").html("Name is required");    
        return 0;
    }else {
    $("#namecheck").hide();
    $(".first-user-name").removeClass('input-focus');
    }

    if(y == ""){
        $("#emailvalid").show();
        $(".email-check").addClass('input-focus');
        $("#emailvalid").html("Email is required");
        return 0;
    }else {
        $("#emailvalid").hide();
        $(".email-check").removeClass('input-focus');
    }
    if(comment == ""){
        $("#form-comment").show();
        $(".form-suggestion").addClass('input-focus');
        $("#form-comment").html("Suggestion is required");
        return 0;
    }else {
        $("#form-comment").hide();
        $(".form-suggestion").removeClass('input-focus');
    }

  }
  else
  return 1;
};

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  var is_valid = regex.test(email)
  if(is_valid == true)
  return regex.test(email);
  else{
    if(email != ''){
    $("#emailvalid").show();    
    $(".email-check").addClass('input-focus');    
    $("#emailvalid").html("Email is invalid");
    }
  }

}

function checkComment(comment) {
    if(comment == ""){
        $("#form-comment").show();
        $(".form-suggestion").addClass('input-focus');
        $("#form-comment").html("Suggestion is required");
        return 0;
    }
    else{
        $("#form-comment").hide();
        $(".form-suggestion").removeClass('input-focus');
        return 1;
    }

}

$(document).ready(function(){
    $('.modalheader-activepatient li').on('click', function(e){
        e.preventDefault();
        var liHead = $(this).text();
        var liContent = $(this).data('content');

        $('.modalheader-esrd h3').html(liHead);
        $('.modalheader-esrd p').html(liContent);

    });    
});


jQuery(document).ready(function(){
		jQuery("#exampleFormControlInput1").keyup(function(){

			// Retrieve the input field text and reset the count to zero
			var filter = jQuery(this).val(), count = 0;
			if(!filter){
				jQuery(".modalheader-activepatient li").show();
				return;
			}else{
				// $(".modalheader-esrd").hide();
			}
			var regex = new RegExp(filter, "i");
			// Loop through the comment list
			jQuery(".modalheader-activepatient li").each(function(){

				// If the list item does not contain the text phrase fade it out
				if (jQuery(this).text().search(regex) < 0) {
					jQuery(this).hide();

				// Show the list item if the phrase matches and increase the count by 1
				} else {
                    
					jQuery(this).show();
					count++;
				}
			});
		});
   });

   jQuery('.list-group-horizontal li').on('click', function(){
        var liVal = $(this).text();
        var count = 0;
        jQuery(".modalheader-activepatient li").hide();
        jQuery(".modalheader-activepatient li").each(function(){
            if ($(this).text().toLowerCase().indexOf(liVal.toLowerCase()) === 0) {

                // Add and Remove active class
            $('.modalheader-activepatient li').click(function(){
                $('.modalheader-activepatient li').removeClass('active')
                $(this).addClass('active')
            })


					if(count == 0){
                        console.log('Hello World');   
                        var liHead = $(this).text();
                        var liContent = $(this).data('content');

                        $('.modalheader-esrd h3').html(liHead);
                        $('.modalheader-esrd p').html(liContent);

                        
                        
                    }
            $(this).show();
            count++;
            }else{
               
            }

        });

         
                          
    });




</script>

@yield('after-scripts')
</body>
</html>