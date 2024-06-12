@extends('backend.layouts.dashboard')


@section('content-new')



<div class="content-wrapper">
    <div class="home-background esrd-card-box">

        <div class="row">
            <div class="col-md-12">
                <div class="table-card">
                    <div class="card-header-2">
                        <h4>List of Pt with Albumin under 2.0</h4>
                    </div>
                    <table class="table table-bordered nephro-table">
                            <thead>
                                <tr>
                                    <th>Patient Id</th>
                                    <th>Last Name</th>
                                    <th>DOB</th>
                                    <th>Office Location</th>
                                    <th>Physician Name</th>
                                    <th>Insurance Type</th>
                                </tr>
                            </thead>
                                <tbody>
                                        @foreach($listOfPtWithAlbuminUnder2Point0F as $listOfPtWithAlbuminUnder2Point0FF)
                                            <tr>
                                                <td>{{ $listOfPtWithAlbuminUnder2Point0FF->account_nbr }}</td>
                                                <td>{{ $listOfPtWithAlbuminUnder2Point0FF->Patient_Name }}</td>
                                                <td>{{ $listOfPtWithAlbuminUnder2Point0FF->DOB }}</td>
                                                <td>{{ $listOfPtWithAlbuminUnder2Point0FF->Location }}</td>
                                                <td>{{ $listOfPtWithAlbuminUnder2Point0FF->provider }}</td>
                                                <td>{{ $listOfPtWithAlbuminUnder2Point0FF->Insurance }}</td>
                                            </tr>
                                            @endforeach
                                </tbody>
                    </table>
                                {{ $listOfPtWithAlbuminUnder2Point0F->links() }}
                   
                </div>
            </div> 
            <div class="col-md-6 grid-margin  stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                    Percentage of Pts with Albumin Under 2.0 (Month Wise)
                    </h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="topTenDiagnosis"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                        Count of Pts with Albumin Under 2.0 (Month Wise)
                    </h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="topTenDiagnosis2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    // By the Office Provider Chart
    var topTenDiagnosisOptions = {
        series: [{
            name: 'Percentage Of Patients',
            data: [@foreach($ptswithalbuminunder2monthspct as $ptswithalbuminunder2monthspctt)
                    '{{$ptswithalbuminunder2monthspctt->vals}}',
            @endforeach]
        }, ],
        chart: {
            fontFamily: 'Quicksand',
            type: 'area',
            height: 400,
            stacked: true,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 2,
                dataLabels: {
                    total: {
                        enabled: true,
                        style: {
                            fontSize: '0',
                            fontWeight: 100
                        }
                    }
                }
            },
        },
        stroke: {
            width: [2, 2],
            colors: ['#02bc77']
        },
        grid: {
            borderColor: '#e9e9e9',
            strokeDashArray: 8,
        },
        markers: {
            size: 4,
            colors: ['#ffffff'],
            shape: "circle",
            radius: 12,
            strokeColors: '#02bc77',
            strokeWidth: 3,
        },
        dataLabels: {
            enabled: false,
            style: {
                colors: ['#02bc77']
            }
        },
        xaxis: {
            categories: [
                @foreach($ptswithalbuminunder2monthspct as $ptswithalbuminunder2monthspctt)
                    '{{$ptswithalbuminunder2monthspctt->kys}}',
            @endforeach
            ]
        },
        // legend: {
        //     showForSingleSeries: true,
        //     position: 'top',
        //     horizontalAlign: 'right',
        //     markers: {
        //         fillColors: ['#9F528F'],
        //         radius: 12,
        //     },
        // },
        fill: {
            type: "gradient",
            gradient: {
                shade: 'light',
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [40, 100, 100],
                colorStops: [{
                        offset: 0,
                        color: "#02bc77",
                        opacity: 0.18
                    },
                    {
                        offset: 100,
                        color: "#02bc77",
                        opacity: 0.05
                    }
                ]
            }
        }
    };

    var topTenDiagnosisChart = new ApexCharts(document.querySelector("#topTenDiagnosis"), topTenDiagnosisOptions);
    topTenDiagnosisChart.render();


    // Count of Pts with Albumin Under 2.0 (Month Wise) Chart
    var topTenDiagnosisOptions = {
        series: [{
            name: 'No. Of Patients',
            data: [ @foreach($ptswithalbuminunder2months as $ptswithalbuminunder2monthsS)
                    '{{$ptswithalbuminunder2monthsS->vals}}',
            @endforeach]
        }, ],
        chart: {
            fontFamily: 'Quicksand',
            type: 'area',
            height: 400,
            stacked: true,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                legend: {
                    position: 'bottom',
                    offsetX: -10,
                    offsetY: 0
                }
            }
        }],
        plotOptions: {
            bar: {
                horizontal: false,
                borderRadius: 2,
                dataLabels: {
                    total: {
                        enabled: true,
                        style: {
                            fontSize: '0',
                            fontWeight: 100
                        }
                    }
                }
            },
        },
        stroke: {
            width: [2, 2],
            colors: ['#0289BC']
        },
        grid: {
            borderColor: '#e9e9e9',
            strokeDashArray: 8,
        },
        markers: {
            size: 4,
            colors: ['#ffffff'],
            shape: "circle",
            radius: 12,
            strokeColors: '#0289BC',
            strokeWidth: 3,
        },
        dataLabels: {
            enabled: false,
            style: {
                colors: ['#0289BC']
            }
        },
        xaxis: {
            categories: [
                @foreach($ptswithalbuminunder2months as $ptswithalbuminunder2monthsS)
                    '{{$ptswithalbuminunder2monthsS->kys}}',
            @endforeach
            ]
        },
        fill: {
            type: "gradient",
            gradient: {
                shade: 'light',
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [40, 100, 100],
                colorStops: [{
                        offset: 0,
                        color: "#0289BC",
                        opacity: 0.18
                    },
                    {
                        offset: 100,
                        color: "#0289BC",
                        opacity: 0.05
                    }
                ]
            }
        }
    };

    var topTenDiagnosisChart = new ApexCharts(document.querySelector("#topTenDiagnosis2"), topTenDiagnosisOptions);
    topTenDiagnosisChart.render();
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>



@endsection

@section('after-scripts')
{{-- {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
{{ Html::script(asset('js/template/js/fusioncharts.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}