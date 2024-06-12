<script>

    var canvas = document.getElementById("payer-bar-chart");
    var ctx = canvas.getContext('2d');

    var data = {
        labels: [
            @if(count($patientMonth)>0)
                    @foreach($patientMonth as $patient)
                '{{$patient}}',
            @endforeach
                    @else
                '',
            @endif
        ],
        datasets: [
            {
                label: "No. Of Patients",
                backgroundColor: "#842d72",
                data: [

                    @if(count($patientCount)>0)
                            @foreach($patientCount as $patient)
                        '{{number_format($patient, 0, ".", "")}}',
                    @endforeach
                            @else
                        '10000, 18940, 36000, 44000, 38000, 39000, 40000',
                    @endif
                ],
            }
        ]
    };

    var options = {
        legend: {
            display: true,
        },
        tooltips: {
            enabled: true,
        },
        scales: {
            xAxes: [{
                display: true,
                ticks: {
                    beginAtZero: true
                },
                barThickness: 40,
            }],
            yAxes: [{
                display: true,
                ticks: {
                    beginAtZero: true,
                    fontColor: "#296a81",
                    min: 0,
                    max: {{$patientMax}},

                },
            }]
        },
        annotation: {
            annotations: [{
                type: 'line',
                mode: 'horizontal',
                scaleID: 'y-axis-0',
                value: '{{$averagePatient}}',
                borderColor: 'tomato',
                borderWidth: 2
            },
            ],

            tooltips: {
                enabled: true
            },
            drawTime: "afterDraw" // (default)
        }
    };

    // Chart declaration:
    var multiLineChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });

    $('.payer-bar-chart').bind('mouseover', function (e) {
        var x = e.originalEvent.x,
            y = e.originalEvent.y;

        chart.annotationTooltip ? chart.annotationTooltip.destroy() : null;
        chart.annotationTooltip = chart.renderer.label('Some text', x, y, 'callout')
            .css({
                color: '#FFFFFF'
            })
            .attr({
                fill: 'rgba(66, 0, 33, 0.75)',
                padding: 5,
                zIndex: 10,
                r: 5
            })
            .add();
    });
</script>


<script>
    // Clinical Dashboard Graph
    new Chart(document.getElementById("bar-chart-grouped-new"), {
        type: 'bar',
        data: {
            labels: [
                @if(count($newPatientAnalysisLabeles)>0)
                        @foreach($newPatientAnalysisLabeles as $projectedMonthLable)
                    '{{$projectedMonthLable}}',
                @endforeach
                        @else
                    'Sep-2019", "Feb-2019", "Mar-2019", "Apr-2019", "May-2019", "June-2019',
                @endif


                // "1900", "1950", "1999", "2050"
            ],
            datasets: [
                {
                    label: "This Year",
                    backgroundColor: "#842d72",
                    data: [
                        @if(count($newPatientAnalysisTargets)>0)
                                @foreach($newPatientAnalysisTargets as $newPatientAnalysisTarget)
                            '{{number_format($newPatientAnalysisTarget, 0, ".", "")}}',
                        @endforeach
                                @else
                            '10000, 18940, 36000, 44000, 38000, 39000, 40000',
                        @endif
                    ]
                },
                {
                    label: "Prior Year",
                    backgroundColor: "#86B420",
                    data: [
                        @if(count($newPatientAnalysisAchieves)>0)
                                @foreach($newPatientAnalysisAchieves as $newPatientAnalysisAchieve)
                            '{{number_format($newPatientAnalysisAchieve, 0, ".", "")}}',
                        @endforeach
                                @else
                            '20000, 18000, 17230, 26000, 22000, 10000',
                        @endif

                    ]
                }
            ]
        },
        options: {
            title: {
                display: true,
                text: ''
            },
            onClick:
                function (evt, item) {
                    var activePoint = this.getElementAtEvent(evt)[0];
                    var data = activePoint._chart.data;
                    var datasetIndex = activePoint._datasetIndex;
                    var label = data.datasets[datasetIndex].label;
                    var value = data.datasets[datasetIndex].data[activePoint._index];
                    var monthYear = this.data.labels[activePoint._index];
                    var provider = $('#provider').val();
                    var location = $('#location').val();
                    var payer = $('#payer').val();
                    let url = "/admin/monthly-patient-analysis?monthYear=" + monthYear + "&provider=" + provider + "&location=" + location + "&payer=" + payer;
                    // window.location.replace(url);
                    window.location.href = url;
                },

            scales: {
                yAxes: [
                    {
                        ticks: {
                            fontColor: "#296a81",
                            // min: 0,
                            beginAtZero: true,
                            max: {{$maxPatientAnalysis}},


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
<script>

    new Chart(document.getElementById("bar-chart-grouped"), {
        type: 'bar',
        data: {
            labels: [
                @if(count($newPatientAnalysisLabeles)>0)
                        @foreach($newPatientAnalysisLabeles as $projectedMonthLable)
                    '{{$projectedMonthLable}}',
                @endforeach
                        @else
                    'Sep-2019", "Feb-2019", "Mar-2019", "Apr-2019", "May-2019", "June-2019',
                @endif


                // "1900", "1950", "1999", "2050"
            ],
            datasets: [
                {
                    label: "Target",
                    backgroundColor: "#842d72",
                    data: [
                        @if(count($newPatientAnalysisTargets)>0)
                                @foreach($newPatientAnalysisTargets as $newPatientAnalysisTarget)
                            '{{number_format($newPatientAnalysisTarget, 0, ".", "")}}',
                        @endforeach
                                @else
                            '10000, 18940, 36000, 44000, 38000, 39000, 40000',
                        @endif
                    ]
                },
                {
                    label: "Achieve",
                    backgroundColor: "#86B420",
                    data: [
                        @if(count($newPatientAnalysisAchieves)>0)
                                @foreach($newPatientAnalysisAchieves as $newPatientAnalysisAchieve)
                            '{{number_format($newPatientAnalysisAchieve, 0, ".", "")}}',
                        @endforeach
                                @else
                            '20000, 18000, 17230, 26000, 22000, 10000',
                        @endif

                    ]
                }
            ]
        },
        options: {
            title: {
                display: true,
                text: 'Patient Analysis'
            },
            onClick:
                function (evt, item) {
                    var activePoint = this.getElementAtEvent(evt)[0];
                    var data = activePoint._chart.data;
                    var datasetIndex = activePoint._datasetIndex;
                    var label = data.datasets[datasetIndex].label;
                    var value = data.datasets[datasetIndex].data[activePoint._index];
                    var monthYear = this.data.labels[activePoint._index];
                    var provider = $('#provider').val();
                    var location = $('#location').val();
                    var payer = $('#payer').val();
                    let url = "/admin/monthly-patient-analysis?monthYear=" + monthYear + "&provider=" + provider + "&location=" + location + "&payer=" + payer;
                    // window.location.replace(url);
                    window.location.href = url;
                },

            scales: {
                yAxes: [
                    {
                        ticks: {
                            fontColor: "#296a81",
                            // min: 0,
                            beginAtZero: true,
                            max: {{$maxPatientAnalysis}},


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
                    backgroundColor: "#842d72",
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

<script>
    new Chart(document.getElementById("payer-bar-charts"), {
        type: 'bar',
        data: {
            labels: [
                @if(count($payerLabels)>0)
                        @foreach($payerLabels as $payerLabel)
                    '{{$payerLabel}}',
                @endforeach
                        @else
                    '',
                @endif

            ],
            datasets: [
                {
                    label: "Charge Amount $",
                    backgroundColor: "#842d72",
                    data: [
                        @if(count($payercharges)>0)
                                @foreach($payercharges as $payercharge)
                            '{{number_format($payercharge, 0, ".", "")}}',
                        @endforeach
                                @else
                            '0',
                        @endif
                    ]
                },
                {
                    label: "Collection Amount $",
                    backgroundColor: "#86B420",
                    data: [
                        @if(count($payerCollections)>0)
                                @foreach($payerCollections as $payerCollection)
                            '{{number_format($payerCollection, 0, ".", "")}}',
                        @endforeach
                                @else
                            '',
                        @endif

                    ]
                }
            ]
        },
        options: {
            title: {
                display: true,
                text: 'Charges & Payment by Payer by Month'
            },
            scales: {
                yAxes: [
                    {
                        ticks: {
                            fontColor: "#296a81",
                            min: 0,
                        },
                        gridLines: {
                            drawBorder: false,
                            color: "rgba(101, 103, 119, 0.21)"
                        }
                    },
                ],
               /* annotation: {
                    annotations: [{
                        type: 'line',
                        mode: 'horizontal',
                        scaleID: 'y-axis-0',
                        value: '26',
                        borderColor: 'tomato',
                        borderWidth: 1
                    }],
                    drawTime: "afterDraw" // (default)
                }*/


            },
            annotation: {
                annotations: [{
                    type: 'line',
                    mode: 'horizontal',
                    scaleID: 'y-axis-0',
                    value: '{{$averagePayerCharges}}',
                    borderColor: '#842d72',//'Chartreuse',
                    borderWidth: 2
                },
                    {
                        type: 'line',
                        mode: 'horizontal',
                        scaleID: 'y-axis-0',
                        value: '{{$averagePayerCollections}}',
                        borderColor: '#86B420',//'tomato',
                        borderWidth: 2
                    },
                ],

                tooltips: {
                    enabled: true
                },
                drawTime: "afterDraw" // (default)
            },

        },

    });
</script>
<script>

    $('.date').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        minYear: 1901,
        maxYear: parseInt(moment().format('YYYY'), 10)
    });
</script>

<script>
    //*******CPT Graph Date submission************
    $('.cptDatePickers').submit(function (e) {
        e.preventDefault();
        var startDate = $('.startDate').val();
        var endDate = $('.endDate').val();
        var provider = $('#provider').val();
        var location = $('#location').val();
        var payer = $('#payer').val();
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
        // return true;

        var $f = $(this);
        var $sb = $f.find('[type="submit"]');
        if(!$sb.hasClass('re-await')){
            var oldBtnText = $sb.html();
            var interval = setInterval(function () {
                NProgress.inc();
            }, 1000);
            console.log('sending');
            $.ajax({
                beforeSend: function () {
                    $sb.html(' Processing...').prop('disabled', true);
                    NProgress.set(0.4);
                    $sb.addClass('re-await');
            console.log('sent');
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
                    $sb.removeClass('re-await');
            console.log('completed');
                },
                error: function (xhr) {
                    $sb.html(oldBtnText).prop('disabled', false);
                    loadRequestErrors(xhr);
                }
            });
        }

    });

    //*******location filter submission************

    $('#locationFilter').submit(function (e) {
        e.preventDefault();
        var $f = $(this);
        var $sb = $f.find('[type="submit"]');
        var oldBtnText = $sb.html();
        var interval = setInterval(function() { NProgress.inc(); }, 1000);

        $.ajax({
            beforeSend: function () {
                $sb.html('Processing...').prop('disabled', true);
                NProgress.set(0.4);
            },
            url: $f.attr('action'),
            type: $f.attr('method'),
            data: $('#locationFilter, .cptDatePickers').serialize(),
            dataType: 'JSON',
            success: function (data) {
                // $sb.html(oldBtnText).prop('disabled', false);
                $sb.html('submit').prop('disabled', false);
                if (data.status) {
                    $('.table-body').replaceWith(data.view);
                    $('.patient-stats').replaceWith(data.stat);

                    NProgress.done();
                    clearInterval(interval);

                    $sb.html('submit').html('<i class="fas fa-search"></i> Search');

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