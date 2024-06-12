<div class="card-body chart-cptcode">
    <!--<canvas id="orders-chart-azure"></canvas>-->
    <canvas id="bar-chart-cptcode" width="800" height="450"></canvas>

</div>


{{--{{ Html::script('vendors/js/vendor.bundle.base.js') }}--}}
{{ Html::script('js/template/js/tooltips.js') }}
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
{{ Html::script(asset('js/template/js/fusioncharts.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}
<script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/0.5.7/chartjs-plugin-annotation.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css'/>

<script>

    $('.date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'), 10)
    });
</script>
<script>
    //*******Financial Reports Date submission************
    $('.cptDatePickers').submit(function (e) {
        e.preventDefault();
        var startDate = $('.startDate').val();
        var endDate = $('.endDate').val();
        var provider = $('#provider').val();
        var location = $('#location').val();
        var payer = $('#payer').val();
        if (startDate == '') {
            toastr.warning('Please enter Start Date!!', 'Error', {timeOut: 5000})
            return false;
        } else if (endDate == '') {
            toastr.warning('Please enter End Date!!', 'Error', {timeOut: 5000})
            return false;
        }
        var endDateFormat = new Date($('.endDate').val());
        var startDateFormat = new Date($('.startDate').val());
        if (startDateFormat > endDateFormat) {
            toastr.warning('Start Date should be greater than to End Date.', 'Error', {timeOut: 5000})
            return false;
        }
        // return true;

        var $f = $(this);
        var $sb = $f.find('[type="submit"]');
        var oldBtnText = $sb.html();
        var interval = setInterval(function () {
            NProgress.inc();
        }, 1000);

        $.ajax({
            beforeSend: function () {
                $sb.html(' Processing...').prop('disabled', true);
                NProgress.set(0.4);

            },
            url: $f.attr('action'),
            type: $f.attr('method'),
            data: $('#searchFilter, .cptDatePickers').serialize(),///$f.serialize(),
            dataType: 'JSON',
            success: function (data) {
                $sb.html(oldBtnText).prop('disabled', false);
                if (data.status) {
                    $('.chart-cptcode').replaceWith(data.view);
                    NProgress.done();
                    clearInterval(interval);
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
            toastr.error(xhr.responseJSON.message, 'Error', {timeOut: 5000});
        }
    }


</script>

<script>

    new Chart(document.getElementById("bar-chart-cptcode"), {
        type: 'bar',
        data: {
            labels: [
                @if(count($cptCodeLabeles)>0)
                        @foreach($cptCodeLabeles as $cptCodeLabel)
                    '{{$cptCodeLabel}}',
                @endforeach
                        @else
                    '',
                @endif
            ],
            datasets: [
                {
                    label: "Unit",
                    backgroundColor: "#00A4DB",
                    data: [
                        @if(count($cptCodeUnits)>0)
                                @foreach($cptCodeUnits as $cptCodeUnit)
                            '{{number_format($cptCodeUnit, 0, ".", "")}}',
                        @endforeach
                                @else
                            '10000, 18940, 36000, 44000, 38000, 39000, 40000',
                        @endif
                    ]
                },
            ]
        },
        options: {
            title: {
                display: true,
                text: 'Top 10 Services'
            },


            scales: {
                yAxes: [
                    {
                        ticks: {
                            fontColor: "#296a81",
                            beginAtZero: true,

                        },
                        gridLines: {
                            drawBorder: false,
                            color: "rgba(101, 103, 119, 0.21)"
                        }
                    }]
            },
        },

    });

</script>
