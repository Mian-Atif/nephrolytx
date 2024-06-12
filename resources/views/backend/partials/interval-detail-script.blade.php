<script>

    var canvas = document.getElementById("payer-bar-chart");
    var ctx = canvas.getContext('2d');

    var data = {
        labels: [
            @if(count($intervalStagePatientMonth)>0)
                    @foreach($intervalStagePatientMonth as $patient)
                '{{$patient}}',
            @endforeach
                    @else
                '',
            @endif
        ],
        datasets: [
            {
                label: "Visit Interval by month",
                backgroundColor: "#00A4DB",
                data: [

                    @if(count($intervalStagePatientCount)>0)
                            @foreach($intervalStagePatientCount as $patient)
                        '{{$patient}}',
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
                    max: {{$intervalStagePatientMax}},

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
                @if(count($intervalStageBoxthreeLabeles)>0)
                        @foreach($intervalStageBoxthreeLabeles as $projectedMonthLable)
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
                    backgroundColor: "#00A4DB",
                    data: [
                        @if(count($intervalStageBoxthreeTargets)>0)
                                @foreach($intervalStageBoxthreeTargets as $newPatientAnalysisTarget)
                            '{{number_format($newPatientAnalysisTarget, 0, ".", "")}}',
                        @endforeach
                                @else
                            '10000, 18940, 36000, 44000, 38000, 39000, 40000',
                        @endif
                    ]
                },
                {
                    label: "Prior Year",
                    backgroundColor: "#00FF95",
                    data: [
                        @if(count($intervalStageBoxthreeAchieves)>0)
                                @foreach($intervalStageBoxthreeAchieves as $newPatientAnalysisAchieve)
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
                            max: {{$maxintervalStageBoxthreeTargets}},


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

