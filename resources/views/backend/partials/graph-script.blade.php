<script>
    var ctx = document.getElementById("Chart1");
    var myChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: ["Non ESRD", "ESRD", "Total"],
            datasets: [{
                label: 'Collectables $',
                data: [{{$accountReceivablesCollectablesNonEsrd[0]}},{{$accountReceivablesCollectablesEsrd[0]}},{{$accountReceivablesCollectablesTotal[0]}}],
                backgroundColor: "#842d72",
                hoverBackgroundColor: "#842d72",
                borderWidth:1,
                barPercentage: 0.5
            },{
                label: 'Open Balance $',
                data: [{{$accountReceivablesOpenBalancesNonEsrd[0]}},{{$accountReceivablesOpenBalancesEsrd[0]}},{{$accountReceivablesOpenBalancesTotal[0]}}],
                backgroundColor: "#86B420",
                hoverBackgroundColor: "#86B420",
                borderWidth:1,
                barPercentage: 0.5
            }]
        },
        options:{
            scales: {
            xAxes: [{
                ticks: {
                    beginAtZero:true,
                }
            }]
        },
            responsive: true,
            maintainAspectRatio: false
        }
    });

    var barOptions_stacked = {
        tooltips: {
            display: true
        },
        hover :{
            animationDuration:0
        },
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            xAxes: [{
                ticks: {
                    beginAtZero:true,
                    fontFamily: "'Open Sans Bold', sans-serif",
                    fontSize:11,
                    fontColor: "#296a81"

                },
                scaleLabel:{
                    display:false
                },
                gridLines: {
                    display:false
                },
                stacked: true
            }],
            yAxes: [{
                barThickness : 15,
                gridLines: {
                    display:false,
                    color: "#fff",
                    zeroLineColor: "#fff",
                    zeroLineWidth: 0
                },
                ticks: {
                    fontFamily: "'Open Sans Bold', sans-serif",
                    fontSize:11,
                    fontColor:'#296a81'
                },
                stacked: true
            }]
        },
        legend:{
            display:true,
            labels: {
                fontColor: "#04151b",
            }
        },

        // animation: {
        //     onComplete: function () {
        //         var chartInstance = this.chart;
        //         var ctx = chartInstance.ctx;
        //         ctx.textAlign = "left";
        //         ctx.font = "9px Open Sans";
        //         ctx.fillStyle = "#fff";
        //
        //         Chart.helpers.each(this.data.datasets.forEach(function (dataset, i) {
        //             var meta = chartInstance.controller.getDatasetMeta(i);
        //             Chart.helpers.each(meta.data.forEach(function (bar, index) {
        //                 data = dataset.data[index];
        //                 if(i==0){
        //                     ctx.fillText(data, 50, bar._model.y+4);
        //                 } else {
        //                     ctx.fillText(data, bar._model.x-25, bar._model.y+4);
        //                 }
        //             }),this)
        //         }),this);
        //     }
        // },
        pointLabelFontFamily : "Quadon Extra Bold",
        scaleFontFamily : "Quadon Extra Bold",
    };

</script>

<script>
    $("#chart-container").insertFusionCharts({
        type: "angulargauge",
        width: "100%",
        height: "150",
        dataFormat: "json",
        dataSource: {
            chart: {
                // caption:"Year to Date",
                subcaption: "",
                lowerlimit: "0",
                upperlimit: "100",
                showvalue: "1",
                numbersuffix: "",
                numberprefix: "$",
                theme: "fusion"
            },
            colorrange: {
                color: [
                    {
                        minvalue: "0",
                        maxvalue: "50",
                        code: "#F2726F"
                    },
                    {
                        minvalue: "50",
                        maxvalue: "75",
                        code: "#FFC533"
                    },
                    {
                        minvalue: "75",
                        maxvalue: "100",
                        code: "#62B58F"
                    }
                ]
            },
            dials: {
                dial: [
                    {
                        value: "{{truncate_number(count($collectionAndTargetCurrentMonth)>0?$collectionAndTargetCurrentMonth[0]->Collection:0)}}",
                        tooltext: "${{truncate_number(count($collectionAndTargetCurrentMonth)>0?$collectionAndTargetCurrentMonth[0]->Collection:0)}}",
                    }
                ]
            },
            trendpoints: {
                point: [
                    {
                        startvalue: "{{truncate_number(count($collectionAndTargetCurrentMonth)>0?$collectionAndTargetCurrentMonth[0]->targetAmount:0)}}",
                        displayvalue: "Target",
                        thickness: "2",
                        color: "#E15A26",
                        usemarker: "1",
                        markerbordercolor: "#E15A26",
                        markertooltext: " ${{truncate_number(count($collectionAndTargetCurrentMonth)>0?$collectionAndTargetCurrentMonth[0]->targetAmount:0)}}"
                    }
                ]
            }
        }
    });
    $("#chart-container-yearly").insertFusionCharts({
        type: "angulargauge",
        width: "100%",
        height: "150",
        dataFormat: "json",
        dataSource: {
            chart: {
                // caption: "Month To Date",
                subcaption: "",
                lowerlimit: "0",
                upperlimit: "100",
                showvalue: "1",
                numbersuffix: "",
                numberprefix: "$",
                theme: "fusion"
            },
            colorrange: {
                color: [
                    {
                        minvalue: "0",
                        maxvalue: "50",
                        code: "#3add99"
                    },
                    {
                        minvalue: "50",
                        maxvalue: "75",
                        code: "#ddf2f8"
                    },
                    {
                        minvalue: "75",
                        maxvalue: "100",
                        code: "#04b4f0"
                    }
                ]
            },
            dials: {
                dial: [
                    {
                        value: "{{$collectionAndTargetCurrentYear[0]->Collection}}",
                        tooltext: "${{number_format((float)(count($collectionAndTargetCurrentYear)>0)?$collectionAndTargetCurrentYear[0]->Collection:0, 2, '.', '')}}"
                    }
                ]
            },
            trendpoints: {
                point: [
                    {
                        startvalue: "{{number_format((float)(count($collectionAndTargetCurrentYear)>0)?$collectionAndTargetCurrentYear[0]->targetAmount:0, 2, '.', '')}}",
                        displayvalue: "Target",
                        thickness: "2",
                        color: "#E15A26",
                        usemarker: "1",
                        markerbordercolor: "#E15A26",
                        markertooltext: "${{number_format((float)(count($collectionAndTargetCurrentYear)>0)?$collectionAndTargetCurrentYear[0]->targetAmount:0, 2, '.', '')}}"
                    }
                ]
            }
        }
    });
</script>

<script>

    //Chart Sales
    if ($("#chart-sales").length) {
        var chartSalesCanvas = $("#chart-sales").get(0).getContext("2d");

        var areaData = {
            labels: [
                @if(count($projectedMonthLables)>0)
                        @foreach($projectedMonthLables as $projectedMonthLable)
                    '{{$projectedMonthLable}}',
                @endforeach
                        @else
                    '0',
                @endif

            ],
            datasets: [{
                data: [
                    // 10000, 18940, 36000, 44000, 38000, 39000, 40000  ],
                    @if(count($projectedCollections)>0)
                            @foreach($projectedCollections as $projectedCollection)
                        '{{number_format($projectedCollection, 0, ".", "")}}',
                    @endforeach
                            @else
                        '10000, 18940, 36000, 44000, 38000, 39000, 40000',
                    @endif
                ],

                backgroundColor: "#E881B7",
                borderColor: [
                    '#842d72'
                ],
                borderWidth: 2,
                pointBorderColor: "#E881B7",
                pointBorderWidth: 4,
                pointRadius: 1,
                fill: '#842d72',
                label: "Projected Collection $"
            },
                {
                    data: [
                        // 20000, 18000, 17230, 26000, 22000, 10000,
                        @if(count($actualCollections)>0)
                                @foreach($actualCollections as $actualCollection)
                            '{{number_format($actualCollection, 0, ".", "")}}',
                        @endforeach
                                @else
                            '20000, 18000, 17230, 26000, 22000, 10000',
                        @endif

                    ],
                    backgroundColor: "#86B420",
                    borderColor: [
                        '#86B420'

                    ],
                    borderWidth: 2,
                    pointBorderColor: "#86B420",
                    pointBorderWidth: 4,
                    pointRadius: 1,
                    fill: '#86B420',
                    label: "Actual Collection $"
                }
            ]
        };
        var areaOptions = {
            responsive: true,
            onClick:
                function (evt, item) {
                    var activePoint=this.getElementAtEvent(evt)[0];
                    var data = activePoint._chart.data;
                    // console.log(data);

                    var datasetIndex = activePoint._datasetIndex;
                    var label = data.datasets[datasetIndex].label;
                    var value = data.datasets[datasetIndex].data[activePoint._index];
                    var monthYear=this.data.labels[activePoint._index];
                    var provider=$('#provider').val();
                    var location=$('#location').val();
                    var payer=$('#payer').val();
                    if(label == 'Projected Collection $')
                    {
                        let url = "/admin/open-cases?monthYear=" + monthYear+"&provider="+provider+"&location="+location+"&payer=" + payer;
                        window.location.href = url;
                    }
                    else{
                        let url = "/admin/under-paid-cases?monthYear=" + monthYear+"&provider="+provider+"&location="+location+"&payer=" + payer;
                        window.location.href = url;
                    }

                },
            maintainAspectRatio: true,
            plugins: {
                filler: {
                    propagate: false
                }
            },
            scales: {
                /* xAxes: [{
                   ticks: {
                     fontColor: "#fff"
                   },
                   gridLines: {
                     display: false,
                     color: "rgba(101, 103, 119, 0.21)"
                   }
                 }],*/
                yAxes: [{
                    ticks: {
                        // format the y-axis labels here
                        callback: function(value, index, values) {
                            return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); // format as currency
                        },
                        fontColor: "#296a81",
//                        stepSize: 50000,//10000
                        min: 0,
                        max: {{$actualCollectionMax}},//50000  $actualCollectionMax
                    },
                    gridLines: {
                        drawBorder: false,
                        color: "rgba(101, 103, 119, 0.21)"
                    }
                }]

            },
            legend: {
                display: true,
                labels: {
                    fontColor: "#04151b",

                }
            },
            legendCallback : function(chart) {
                var text = [];
                text.push(' <div class="d-flex justify-content-between justify-content-lg-start flex-wrap">');
                text.push('<div class="mr-5 mb-2">');
                text.push('<div class="d-flex">');
                text.push('<i class="ti-briefcase" style="color: ' + chart.data.datasets[0].borderColor[0] +' "></i>');
                text.push('<h3 class="text-white ml-3">'+ chart.data.datasets[0].data[1] + '</h3>');
                text.push('</div>');
                text.push('<h6 class="font-weight-normal mb-0">Online sales</h6>');
                text.push('</div>');
                text.push('<div class="mb-2">');
                text.push('<div class="d-flex">');
                text.push('<i class="ti-apple" style="color: ' + chart.data.datasets[1].borderColor[0] +' "></i>');
                text.push('<h3 class="text-white ml-3">'+ chart.data.datasets[1].data[2] + '</h3>');
                text.push('</div>');
                text.push('<h6 class="font-weight-normal mb-0">Sales in store</h6>');
                text.push('</div>');
                text.push('</div>');
                return text.join('');
            },
            tooltips: {
                enabled: true
            }
        }
        var salesChartCanvas = $("#chart-sales").get(0).getContext("2d");
        var salesChart = new Chart(salesChartCanvas, {
            type: 'line',
            data: areaData,
            options: areaOptions
        });
        //document.getElementById('sales-legend').innerHTML = salesChart.generateLegend();
    }
</script>

<script>
    // Trafic Chart
    if ($("#traffic-chart").length) {
        var ctx = document.getElementById('traffic-chart').getContext("2d");

        var gradientStrokeGreen = ctx.createLinearGradient(0, 0, 0, 181);
        gradientStrokeGreen.addColorStop(0, '#86B420');
        gradientStrokeGreen.addColorStop(1, '#86B420');
        var gradientLegendGreen = '#86B420';

        var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 150);
        gradientStrokeBlue.addColorStop(0, '#842d72');
        gradientStrokeBlue.addColorStop(1, '#842d72');
        var gradientLegendBlue = '#842d72';

        var gradientStrokePurple = ctx.createLinearGradient(0, 0, 0, 181);
        gradientStrokePurple.addColorStop(0, '#744af4');
        gradientStrokePurple.addColorStop(1, '#744af4');
        var gradientLegendPurple = '#744af4';
        {{--let rev='{!! $revenues !!}';alert(rev);--}}
        // let arrayRev = '['+rev+ ']';
        var trafficChartData = {
            datasets: [{
                data: [
                    @if(count($revenues)>0)
                        '{{truncate_number($revenues[0]->in_patient_non_esrd)}}',
                        '{{truncate_number($revenues[0]->in_patient_esrd)}}',
                    @else
                        '0,0,0',
                    @endif
                ],
                data1: [
                    @if(count($revenues)>0)
                        '{{truncate_number($revenues[0]->in_patient_non_esrd)}}',
                        '{{truncate_number($revenues[0]->in_patient_esrd)}}',
                            @else
                        '0,0,0',
                    @endif
                ],
                backgroundColor: [
                    gradientStrokeGreen,
                    gradientStrokeBlue,
                    gradientStrokePurple
                ],
                hoverBackgroundColor: [
                    gradientStrokeGreen,
                    gradientStrokeBlue,
                    gradientStrokePurple
                ],
                borderColor: [
                    gradientStrokeGreen,
                    gradientStrokeBlue,
                    gradientStrokePurple
                ],
                legendColor: [
                    gradientLegendGreen,
                    gradientLegendBlue,
                    gradientLegendPurple
                ]
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: [
                'Non ESRD',
                'ESRD',
            ]
        };
        var trafficChartOptions = {
            responsive: true,
            animation: {
                animateScale: true,
                animateRotate: true
            },
            legend: false,

            legendCallback: function(chart) {
                var text = [];
                text.push('<ul>');
                for (var i = 0; i < trafficChartData.datasets[0].data1.length; i++) {
                    text.push('<li><h2 class="mb-2">'+trafficChartData.datasets[0].data1[i]+'</h2><div class="legend-content"><span class="legend-dots" style="background:' +
                        trafficChartData.datasets[0].legendColor[i] +
                        '"></span>'+trafficChartData.labels[i]+'</div>');
                    text.push('</li>');
                }
                text.push('</ul>');
                return text.join('');
            },
            cutoutPercentage: 0
        };
        var trafficChartPlugins = {
            beforeDraw: function(chart) {
                var width = chart.chart.width,
                    height = chart.chart.height,
                    ctx = chart.chart.ctx;

                ctx.restore();
                var fontSize = 1.2;
                ctx.font = fontSize + "em sans-serif";
                ctx.textBaseline = "middle";
                ctx.fillStyle = "#ffffff";
                // ctx.borderWidth= 4;

                var text = "1.2 M",
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    textY = height / 2;

                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }
        var trafficChartCanvas = $("#traffic-chart").get(0).getContext("2d");
        var trafficChart = new Chart(trafficChartCanvas, {
            type: 'doughnut',
            data: trafficChartData,
            options: trafficChartOptions,
            plugins: trafficChartPlugins
        });
        $("#traffic-chart-legend").html(trafficChart.generateLegend());
    }
    // Trafic Chart
    if ($("#traffic2-chart").length) {
        var ctx = document.getElementById('traffic2-chart').getContext("2d");

        var gradientStrokeGreen = ctx.createLinearGradient(0, 0, 0, 181);
        gradientStrokeGreen.addColorStop(0, '#86B420');
        gradientStrokeGreen.addColorStop(1, '#86B420');
        var gradientLegendGreen = '#86B420';

        var gradientStrokeBlue = ctx.createLinearGradient(0, 0, 0, 150);
        gradientStrokeBlue.addColorStop(0, '#842d72');
        gradientStrokeBlue.addColorStop(1, '#842d72');
        var gradientLegendBlue = '#842d72';

        var gradientStrokePurple = ctx.createLinearGradient(0, 0, 0, 181);
        gradientStrokePurple.addColorStop(0, '#744af4');
        gradientStrokePurple.addColorStop(1, '#744af4');
        var gradientLegendPurple = '#744af4';
        {{--let rev='{!! $revenues !!}';alert(rev);--}}
        // let arrayRev = '['+rev+ ']';
        var trafficChartData = {
            datasets: [{
                data: [
                    @if(count($revenues)>0)
                        '{{truncate_number($revenues[0]->out_patient_non_esrd)}}',
                        '{{truncate_number($revenues[0]->out_patient_esrd)}}',
                    @else
                        '0,0,0',
                    @endif
                ],
                data1: [
                    @if(count($revenues)>0)
                        '{{truncate_number($revenues[0]->out_patient_non_esrd)}}',
                        '{{truncate_number($revenues[0]->out_patient_esrd)}}',
                            @else
                        '0,0,0',
                    @endif
                ],
                backgroundColor: [
                    gradientStrokeGreen,
                    gradientStrokeBlue,
                    gradientStrokePurple
                ],
                hoverBackgroundColor: [
                    gradientStrokeGreen,
                    gradientStrokeBlue,
                    gradientStrokePurple
                ],
                borderColor: [
                    gradientStrokeGreen,
                    gradientStrokeBlue,
                    gradientStrokePurple
                ],
                legendColor: [
                    gradientLegendGreen,
                    gradientLegendBlue,
                    gradientLegendPurple
                ]
            }],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: [
                'Non ESRD',
                'ESRD',
            ]
        };
        var trafficChartOptions = {
            responsive: true,
            animation: {
                animateScale: true,
                animateRotate: true
            },
            legend: false,

            legendCallback: function(chart) {
                var text = [];
                text.push('<ul>');
                for (var i = 0; i < trafficChartData.datasets[0].data1.length; i++) {
                    text.push('<li><h2 class="mb-2">'+trafficChartData.datasets[0].data1[i]+'</h2><div class="legend-content"><span class="legend-dots" style="background:' +
                        trafficChartData.datasets[0].legendColor[i] +
                        '"></span>'+trafficChartData.labels[i]+'</div>');
                    text.push('</li>');
                }
                text.push('</ul>');
                return text.join('');
            },
            cutoutPercentage: 0
        };
        var trafficChartPlugins = {
            beforeDraw: function(chart) {
                var width = chart.chart.width,
                    height = chart.chart.height,
                    ctx = chart.chart.ctx;

                ctx.restore();
                var fontSize = 1.2;
                ctx.font = fontSize + "em sans-serif";
                ctx.textBaseline = "middle";
                ctx.fillStyle = "#ffffff";
                // ctx.borderWidth= 4;

                var text = "1.2 M",
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    textY = height / 2;

                ctx.fillText(text, textX, textY);
                ctx.save();
            }
        }
        var trafficChartCanvas = $("#traffic2-chart").get(0).getContext("2d");
        var trafficChart = new Chart(trafficChartCanvas, {
            type: 'doughnut',
            data: trafficChartData,
            options: trafficChartOptions,
            plugins: trafficChartPlugins
        });
        $("#traffic2-chart-legend").html(trafficChart.generateLegend());
    }
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
                    backgroundColor: "#00A4DB",
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
                    backgroundColor: "#00FF95",
                    data: [
                        @if(count($newPatientAnalysisAchieves)>0)
                                @foreach($newPatientAnalysisAchieves as $newPatientAnalysisAchieve)
                            '{{number_format($newPatientAnalysisAchieve, 0, ".", "")}}',
                        @endforeach
                                @else
                            '20000, 18000, 17230, 26000, 22000, 10000',
                        @endif


                        // 408,547,675,734

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
                    // console.log(activePoint._datasetIndex);

                    var data = activePoint._chart.data;
                    var datasetIndex = activePoint._datasetIndex;
                    var label = data.datasets[datasetIndex].label;

                    var value = data.datasets[datasetIndex].data[activePoint._index];

                    var monthYear = this.data.labels[activePoint._index];
                    var provider = $('#provider').val();
                    var location = $('#location').val();
                    var payer = $('#payer').val();
                    /*  if(label == 'Projected Collection $')
                      {*/
                    let url = "/admin/monthly-patient-analysis?monthYear=" + monthYear + "&provider=" + provider + "&location=" + location + "&payer=" + payer;
                    // window.location.replace(url);
                    window.location.href = url;
                    /* }
                   else{
                        let url = "/admin/under-paid-cases?monthYear=" + monthYear+"&provider="+provider+"&location="+location+"&payer=" + payer;
                        window.location.replace(url);
                    }*/

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
                }]
            },
        },

    })
    ;
</script>
<script>
    $('#searchDashboardFilter').on('submit',function (e) {
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
            data: $f.serialize(),
            dataType: 'JSON',
            success: function (data) {
                $sb.html(oldBtnText).prop('disabled', false);
                if (data.status) {
                    $('.table-body').replaceWith(data.view);
                    $('.patient-stats').replaceWith(data.stat);

                    NProgress.done();
                    clearInterval(interval);
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

            /* new Noty({
                 type: 'error',
                 text: xhr.responseJSON.message
             }).show();*/
        }
    }


    
    new Chart(document.getElementById("payer-bar-charts"), {
            type: 'bar',
            data: {
                labels: [
                    @if(count($payerLabels) > 0)
                    @foreach($payerLabels as $payerLabel)
                    '{{$payerLabel}}',
                    @endforeach
                    @else '',
                    @endif

                ],
                datasets: [{
                        label: "Charge Amount $",
                        backgroundColor: "#842d72",
                        data: [
                            @if(count($payercharges) > 0)
                            @foreach($payercharges as $payercharge)
                            '{{number_format($payercharge, 0, ".", "")}}',
                            @endforeach
                            @else '0',
                            @endif
                        ]
                    },
                    {
                        label: "",
                        borderColor: "#842d72",
                        fill: false,
                        data: [
                            @if(count($payercharges) > 0)
                                @foreach($payercharges as $payercharge)
                                    '{{ $averagePayerCharges }}',
                                @endforeach
                            @else '0',
                            @endif
                        ],
                        type: 'line'
                    },
                    {
                        label: "Collection Amount $",
                        backgroundColor: "#86B420",
                        data: [
                            @if(count($payerCollections) > 0)
                            @foreach($payerCollections as $payerCollection)
                            '{{number_format($payerCollection, 0, ".", "")}}',
                            @endforeach
                            @else '',
                            @endif

                        ]
                    },
                    {
                        label: "",
                        borderColor: "#86B420",
                        fill: false,
                        data: [
                            @if(count($payerCollections) > 0)
                                @foreach($payerCollections as $payerCollection)
                                    '{{ $averagePayerCollections }}',
                                @endforeach
                            @else '',
                            @endif

                        ],
                        type: 'line'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: true,
                    text: 'Charges & Payment by Payer by Month'
                },
                legend: {
                            display: false //This will do the task
                        },
                scales: {
                    yAxes: [{
                        ticks: {
                             // format the y-axis labels here
                             beginAtZero:true,
                            callback: function(value, index, values) {
                            return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","); // format as currency
                        },
                        gridLines: {
                            drawBorder: false,
                            color: "rgba(101, 103, 119, 0.21)"
                        }
                    }
                }],
               
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
                            borderColor: '#00A4DB', //'Chartreuse',
                            borderWidth: 2
                        },
                        {
                            type: 'line',
                            mode: 'horizontal',
                            scaleID: 'y-axis-0',
                            value: '{{$averagePayerCollections}}',
                            borderColor: '#00FF95', //'tomato',
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

        new Chart(document.getElementById("bar-chart-cptcode"), {
            type: 'bar',
            data: {
                labels: [
                    @if(count($cptCodeLabeles) > 0)
                    @foreach($cptCodeLabeles as $cptCodeLabel)
                    '{{$cptCodeLabel}}',
                    @endforeach
                    @else 'Sep-2019", "Feb-2019", "Mar-2019", "Apr-2019", "May-2019", "June-2019',
                    @endif

                    // $cptCodeRevenueLabeles = Arr::pluck($cptCodeRevenue, 'cptcode');
                    // $cptCodeRevenueUnits = Arr::pluck($cptCodeRevenue, 'revenue');
                    // "1900", "1950", "1999", "2050"
            ],
                datasets: [{
                    label: "Unit",
                    backgroundColor: "#842d72",
                    data: [
                        @if(count($cptCodeUnits) > 0)
                        @foreach($cptCodeUnits as $cptCodeUnit)
                        '{{number_format($cptCodeUnit, 0, ".", "")}}',
                        @endforeach
                        @else '10000, 18940, 36000, 44000, 38000, 39000, 40000',
                        @endif
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: false,
                    text: 'Top 10 Services'
                },
               


                scales: {
                    yAxes: [{
                        ticks: {
                            fontColor: "#296a81",
                            min: 0,
                        },
                        gridLines: {
                            drawBorder: false,
                            color: "rgba(101, 103, 119, 0.21)"
                        }
                    }]
                },
            },

        });

        new Chart(document.getElementById("bar-chart-cptcode-revenue"), {
            type: 'bar',
            data: {
                labels: [
                    @if(count($cptCodeRevenueLabeles) > 0)
                    @foreach($cptCodeRevenueLabeles as $cptCodeRevenueLabele)
                    '{{$cptCodeRevenueLabele}}',
                    @endforeach
                    @else 'Sep-2019", "Feb-2019", "Mar-2019", "Apr-2019", "May-2019", "June-2019',
                    @endif

                    // $cptCodeRevenueLabeles = Arr::pluck($cptCodeRevenue, 'cptcode');
                    // $cptCodeRevenueUnits = Arr::pluck($cptCodeRevenue, 'revenue');
                    // "1900", "1950", "1999", "2050"
            ],
                datasets: [{
                    label: "Revenue",
                    backgroundColor: "#842d72",
                    data: [
                        @if(count($cptCodeRevenueUnits) > 0)
                        @foreach($cptCodeRevenueUnits as $cptCodeRevenueUnit)
                        '{{number_format($cptCodeRevenueUnit, 0, ".", "")}}',
                        @endforeach
                        @else '10000, 18940, 36000, 44000, 38000, 39000, 40000',
                        @endif
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: false,
                    text: 'Top 10 Services Revenue'
                },
               


                scales: {
                    yAxes: [{
                        ticks: {
                            fontColor: "#296a81",
                            min: 0,
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
