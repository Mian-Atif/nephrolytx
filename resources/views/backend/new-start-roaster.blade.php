@extends('backend.layouts.dashboard')


@section('content-new')




<div class="content-wrapper">

    <div class="home-background esrd-card-box">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                        By the Office Provider
                    </h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="canvas-box-scroller1">
                                    <div class="subbox1">
                                        <canvas id="myChart1"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                        By Last Provider
                    </h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="canvas-box-scroller2">
                                    <div class="subbox2">
                                        <canvas id="myChart2"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                        By First Dialysis Location
                    </h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="canvas-box-scroller3">
                                    <div class="subbox3">
                                        <canvas id="myChart3"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                        By Last Dialysis Location
                    </h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="canvas-box-scroller4">
                                    <div class="subbox4">
                                        <canvas id="myChart4"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                        By Home Status
                    </h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="map-new-start">
                                    <div id="chart5"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                        By Access Type
                    </h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="map-new-start">
                                    <div id="chart6"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                        New Start Map By Optimal Start
                    </h3>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="map-container">
                                    <div id="map" class="newLateMap"></div>
                                </div>
                            </div>
                            <div id="inline-actions" style="display:none;">
                                <span>Max zoom level:
                                    <select id="zoom">
                                        <option value="-1">Default</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                    </select>

                                </span>
                                <span class="item">Cluster size:
                                    <select id="size">
                                        <option value="-1">Default</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                        <option value="70">70</option>
                                        <option value="80">80</option>
                                    </select>
                                </span>
                                <span class="item">Cluster style:
                                    <select id="style">
                                        <option value="-1">Default</option>
                                        <option value="0">People</option>
                                        <option value="1">Conversation</option>
                                        <option value="2">Heart</option>
                                        <option value="3">Pin</option>
                                    </select>
                                    <input id="refresh" type="button" value="Refresh Map" class="item" />
                                    <a href="#" id="clear">Clear</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card ">
            <div class="card card-shadow">
                <h3 class="home-design1">
                    New Start Roster
                </h3>
                <div class="card-body table-scroll">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-graph">
                                <thead class="th-color">
                                    <tr>
                                        <th>Patient Id</th>
                                        <th>Patient Name</th>
                                        <th>Date of Birth</th>
                                        <th>Office Provider</th>
                                        <th>Location</th>
                                        <th>Last office Location</th>
                                        <th>Day of First MCP</th>
                                        <th>First Access</th>
                                        <th>Home Status</th>
                                        <th>Optimal Start</th>
                                     
                                    </tr>
                                </thead>
                                        <tbody>
                                            @foreach($newStartRosterNSR as $newStartRosterNSRF)
                                                <tr>
                                                    <td>{{ $newStartRosterNSRF->patient_id }}</td>
                                                    <td>{{ $newStartRosterNSRF->patient_name }}</td>
                                                    <td>{{ $newStartRosterNSRF->dateofbirth }}</td>
                                                    <td>{{ $newStartRosterNSRF->provider }}</td>
                                                    <td>{{ $newStartRosterNSRF->location }}</td>
                                                    <td>{{ $newStartRosterNSRF->last_office_location }}</td>
                                                    <td>{{ $newStartRosterNSRF->Day_of_First_MCP }}</td>
                                                    <td>{{ $newStartRosterNSRF->first_access }}</td>
                                                    <td>{{ $newStartRosterNSRF->home_status }}</td>
                                                    <td>{{ $newStartRosterNSRF->optimal_start }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                </table>
                                {{ $newStartRosterNSR->links() }}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>







<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>

    // Chartjs start
    Chart.defaults.font.family = 'Quicksand';     
     
    // Data for the chart
    var data1 = {
        labels: [   @foreach($byFirstProviderNSR as $byFirstProviderNSR1)
                '{{$byFirstProviderNSR1->provider}}',
            @endforeach ],
        datasets: [{
            label: 'Data',
            data: [    @foreach($byFirstProviderNSR as $byFirstProviderNSR1)
                '{{$byFirstProviderNSR1->new_start_patients}}',
            @endforeach ], 
            backgroundColor: 'rgba(159, 82,	143)', // Bar color
            borderColor: 'rgba(159, 82,	143)', // Border color
            borderWidth: 1 // Border width
        }]
        };

    // Chart configuration
    
            const config1 = {
            type: 'bar',
            data:data1,
            options: {
                indexAxis: 'y',
                maintainAspectRatio: false,
                scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            
                            grid: {
                                    display: false
                                }
                        }
                    },
                plugins: {
                legend: {
                    display: false // set display property to false to hide labels
                }
                }
            }
            };

    // Create chart
    
        var myChart1 = new Chart(document.getElementById('myChart1'), config1);

        const subbox1 = document.querySelector('.subbox1');
        subbox1.style.height = '300px';
        if(myChart1.data.labels.length > 7){
            const newHeight1 = 300 + ((myChart1.data.labels.length - 7) * 20);
            subbox1.style.height  = `${newHeight1}px`;
            console.log(subbox1.style.height)
        }
        myChart1.update();

    // Chartjs end

    // // Apex chart START
    // var options = {
    //     series: [{
    //         data: [
    //             @foreach($byFirstProviderNSR as $byFirstProviderNSR1)
    //             '{{$byFirstProviderNSR1->new_start_patients}}',
    //         @endforeach
    //     ]
    //     }],
    //     chart: {
    //         type: 'bar',
    //         height: 250,
    //         toolbar: {
    //             show: false,
    //         }
    //     },
    //     plotOptions: {
    //         bar: {
    //             borderRadius: 0,
    //             horizontal: true,
    //         }
    //     },
    //     dataLabels: {
    //         enabled: false
    //     },
    //     xaxis: {
    //         categories: [
    //             @foreach($byFirstProviderNSR as $byFirstProviderNSR1)
    //             '{{$byFirstProviderNSR1->provider}}',
    //         @endforeach
    //         ],
    //     },
    //     fill: {
    //         opacity: 1,
    //         colors: ['#9F528F']
    //     }
    // };

    // var chart = new ApexCharts(document.querySelector("#chart1"), options);
    // chart.render();

    // Apex chart END

    // Chartjs start
       
    // Data for the chart
    var data2 = {
        labels: [@foreach($byLastProviderNSR as $byLastProviderNSR1)
                '{{$byLastProviderNSR1->provider}}',
            @endforeach],
        datasets: [{
            label: 'Data',
            data: [@foreach($byLastProviderNSR as $byLastProviderNSR1)
                '{{$byLastProviderNSR1->new_start_patients}}',
            @endforeach], 
            backgroundColor: 'rgba(159, 82,	143)', // Bar color
            borderColor: 'rgba(159, 82,	143)', // Border color
            borderWidth: 1 // Border width
        }]
        };

    // Chart configuration
            const config2 = {
            type: 'bar',
            data:data2,
            options: {
                indexAxis: 'y',
                maintainAspectRatio: false,
                scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            
                            grid: {
                                    display: false
                                }
                        }
                    },
                plugins: {
                legend: {
                    display: false // set display property to false to hide labels
                }
                }
            }
            };

    // Create chart
    
        var myChart2 = new Chart(document.getElementById('myChart2'), config2);

        const subbox2 = document.querySelector('.subbox2');
        subbox2.style.height = '300px';
        if(myChart2.data.labels.length > 7){
            const newHeight2 = 300 + ((myChart2.data.labels.length - 7) * 20);
            subbox2.style.height  = `${newHeight2}px`;
            console.log(subbox2.style.height)
        }
        myChart2.update();
        
    // Chartjs end

    // // Apex chart START
    // var options = {
    //     series: [{
    //         data: [ @foreach($byLastProviderNSR as $byLastProviderNSR1)
    //             '{{$byLastProviderNSR1->new_start_patients}}',
    //         @endforeach]
    //     }],
    //     chart: {
    //         type: 'bar',
    //         height: 250,
    //         toolbar: {
    //             show: false,
    //         }
    //     },
    //     plotOptions: {
    //         bar: {
    //             borderRadius: 0,
    //             horizontal: true,
    //         }
    //     },
    //     dataLabels: {
    //         enabled: false
    //     },
    //     xaxis: {
    //         categories: [ @foreach($byLastProviderNSR as $byLastProviderNSR1)
    //             '{{$byLastProviderNSR1->provider}}',
    //         @endforeach
    //         ],
    //     },
    //     fill: {
    //         opacity: 1,
    //         colors: ['#9F528F']
    //     }
    // };

    // var chart = new ApexCharts(document.querySelector("#chart2"), options);
    // chart.render();

    // // Apex chart END

    // Chartjs start

       
    // Data for the chart
    var data3 = {
        labels: [@foreach($byFirstDialysisLocationNSR as $byFirstDialysisLocationNSR1)
                '{{$byFirstDialysisLocationNSR1->service_location}}',
            @endforeach],
        datasets: [{
            label: 'Data',
            data: [@foreach($byFirstDialysisLocationNSR as $byFirstDialysisLocationNSR1)
                '{{$byFirstDialysisLocationNSR1->new_start_patients}}',
            @endforeach], 
            backgroundColor: 'rgba(159, 82,	143)', // Bar color
            borderColor: 'rgba(159, 82,	143)', // Border color
            borderWidth: 1 // Border width
        }]
        };

    // Chart configuration
            const config3 = {
            type: 'bar',
            data:data3,
            options: {
                indexAxis: 'y',
                maintainAspectRatio: false,
                scales: {
                        y: {
                            beginAtZero: true
                        },
                        x: {
                            
                            grid: {
                                    display: false
                                }
                        }
                    },
                plugins: {
                legend: {
                    display: false // set display property to false to hide labels
                }
                }
            }
            };

    // Create chart
    
        var myChart3 = new Chart(document.getElementById('myChart3'), config3);

        const subbox3 = document.querySelector('.subbox3');
        subbox3.style.height = '300px';
        if(myChart3.data.labels.length > 7){
            const newHeight3 = 300 + ((myChart3.data.labels.length - 7) * 20);
            subbox3.style.height  = `${newHeight3}px`;
            console.log(subbox3.style.height)
        }
        myChart3.update();
        
    // chartjs end

    // // Apex chart START
    // var options = {
    //     series: [{
    //         data: [@foreach($byFirstDialysisLocationNSR as $byFirstDialysisLocationNSR1)
    //             '{{$byFirstDialysisLocationNSR1->new_start_patients}}',
    //         @endforeach]
    //     }],
    //     chart: {
    //         type: 'bar',
    //         height: 250,
    //         toolbar: {
    //             show: false,
    //         }
    //     },
    //     plotOptions: {
    //         bar: {
    //             borderRadius: 0,
    //             horizontal: true,
    //         }
    //     },
    //     dataLabels: {
    //         enabled: false
    //     },
    //     xaxis: {
    //         categories: [@foreach($byFirstDialysisLocationNSR as $byFirstDialysisLocationNSR1)
    //             '{{$byFirstDialysisLocationNSR1->service_location}}',
    //         @endforeach],
    //     },
    //     fill: {
    //         opacity: 1,
    //         colors: ['#9F528F']
    //     }
    // };

    // var chart = new ApexCharts(document.querySelector("#chart3"), options);
    // chart.render();

    // // Apex chart END

    // Chartjs start

       
    // Data for the chart
    var data4 = {
        labels: [@foreach($bylastDialysisLocationNSR as $bylastDialysisLocationNSR1)
                '{{$bylastDialysisLocationNSR1->service_location}}',
            @endforeach],
        datasets: [{
            label: 'Data',
            data: [ @foreach($bylastDialysisLocationNSR as $bylastDialysisLocationNSR1)
                '{{$bylastDialysisLocationNSR1->new_start_patients}}',
            @endforeach], 
            backgroundColor: 'rgba(159, 82,	143)', // Bar color
            borderColor: 'rgba(159, 82,	143)', // Border color
            borderWidth: 1 // Border width
        }]
        };

    // Chart configuration
            const config4 = {
            type: 'bar',
            data:data4,
            options: {
                indexAxis: 'y',
                maintainAspectRatio: false,
                scales: {
                        y: {
                            beginAtZero: true,
                        },
                        x: {
                            
                            grid: {
                                    display: false
                                }
                        }
                    },
                plugins: {
                legend: {
                    display: false // set display property to false to hide labels
                }
                }
            }
            };

    // Create chart
    
        var myChart4 = new Chart(document.getElementById('myChart4'), config4);

        const subbox4 = document.querySelector('.subbox4');
        subbox4.style.height = '300px';
        if(myChart4.data.labels.length > 7){
            const newHeight4 = 300 + ((myChart4.data.labels.length - 7) * 20);
            subbox4.style.height  = `${newHeight4}px`;
            console.log(subbox4.style.height)
        }
        myChart4.update();
        
    // chartjs end

    // // Apex chart START
    // var options = {
    //     series: [{
    //         data: [
    //             @foreach($bylastDialysisLocationNSR as $bylastDialysisLocationNSR1)
    //             '{{$bylastDialysisLocationNSR1->new_start_patients}}',
    //         @endforeach
    //     ]
    //     }],
    //     chart: {
    //         type: 'bar',
    //         height: 250,
    //         toolbar: {
    //             show: false,
    //         }
    //     },
    //     plotOptions: {
    //         bar: {
    //             borderRadius: 0,
    //             horizontal: true,
    //         }
    //     },
    //     dataLabels: {
    //         enabled: false
    //     },
    //     xaxis: {
    //         categories: [@foreach($bylastDialysisLocationNSR as $bylastDialysisLocationNSR1)
    //             '{{$bylastDialysisLocationNSR1->service_location}}',
    //         @endforeach],
    //     },
    //     fill: {
    //         opacity: 1,
    //         colors: ['#9F528F']
    //     }
    // };

    // var chart = new ApexCharts(document.querySelector("#chart4"), options);
    // chart.render();

    // // Apex chart END

    // Apex Donut Chart START

    var Appointmentoptions = {
        width: '450px',
        height: '100%',
        series: [{{$byHomeStatusNSR1}}, {{$byHomeStatusNSR2}},{{$byHomeStatusNSR3}}],
        colors: ['#842D72', '#776ACF','#257ED8'],
        chart: {
            type: 'donut',
            fontFamily: 'Quicksand'
        },
        labels: ["Incident Home", "Home Status","New Dialysis"],

        legend: {
            show: true,
            position: 'bottom'
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                }
            }
        }]
    };

    var Appointmentchart = new ApexCharts(document.querySelector("#chart5"), Appointmentoptions);
    Appointmentchart.render();

    // Apex chart END

    // Apex Donut Chart START
    var seriesVal = [{{$byAccessTypeNSRF1}}, {{$byAccessTypeNSRF2}}, {{$byAccessTypeNSRF3}}];
    var seriesLabel = ["PDCATH", "None", "CVCATH"];
    var Appointmentoptions = {
        width: '450px',
        height: '100%',
        series: seriesVal,
        colors: ['#2D3684', '#A325D8', '#257ED8'],
        chart: {
            type: 'donut',
            fontFamily: 'Quicksand'
        },
        labels: seriesLabel,

        legend: {
            show: true,
            position: 'bottom'
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                }
            }
        }]
    };

    var Appointmentchart = new ApexCharts(document.querySelector("#chart6"), Appointmentoptions);
    Appointmentchart.render();

    // Apex chart END
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWJ2bfcc9vb4aP1sw9b_xg4faVAovgh6U"></script>
<script>
    var data = <?php echo json_encode($mapofPatientsPR); ?>;
    console.log(data.photos.length);
</script>
{{ Html::script(asset('js/markerclusterer.js')) }}
<script>
    var styles = [
        [{
            url: "{{ asset('img/images/map/people35.png') }}",
            height: 35,
            width: 35,
            anchor: [16, 0],
            textColor: '#ff00ff',
            textSize: 10,
            fontFamily: 'Arial,sans-serif',
            fontWeight: 'bold',
        }, {
            url: "{{ asset('img/images/map/people45.png') }}",
            height: 45,
            width: 45,
            anchor: [24, 0],
            textColor: '#ff0000',
            textSize: 11
        }, {
            url: "{{ asset('img/images/map/people55.png') }}",
            height: 55,
            width: 55,
            anchor: [32, 0],
            textColor: '#ffffff',
            textSize: 12
        }],
        [{
            url: "{{ asset('img/images/map/conv30.png') }}",
            height: 27,
            width: 30,
            anchor: [3, 0],
            textColor: '#ff00ff',
            textSize: 10
        }, {
            url: "{{ asset('img/images/map/conv40.png') }}",
            height: 36,
            width: 40,
            anchor: [6, 0],
            textColor: '#ff0000',
            textSize: 11
        }, {
            url: "{{ asset('img/images/map/conv50.png') }}",
            width: 50,
            height: 45,
            anchor: [8, 0],
            textSize: 12
        }],
        [{
            url: "{{ asset('img/images/map/heart30.png') }}",
            height: 26,
            width: 30,
            anchor: [4, 0],
            textColor: '#ff00ff',
            textSize: 10
        }, {
            url: "{{ asset('img/images/map/heart40.png') }}",
            height: 35,
            width: 40,
            anchor: [8, 0],
            textColor: '#ff0000',
            textSize: 11
        }, {
            url: "{{ asset('img/images/map/heart50.png') }}",
            width: 50,
            height: 44,
            anchor: [12, 0],
            textSize: 12
        }],
        [{
            url: "{{ asset('img/images/map/pin.png') }}",
            height: 48,
            width: 30,
            anchor: [-18, 0],
            textColor: '#ffffff',
            textSize: 10,
            iconAnchor: [15, 48]
        }]
    ];

    var markerClusterer = null;
    var map = null;
    var imageUrl = "{{ asset('img/images/gpin.png') }}";

    function refreshMap(data = []) {
        if (markerClusterer) {
            markerClusterer.clearMarkers();
        }

        var markers = [];

        var markerImage = new google.maps.MarkerImage(imageUrl,
            new google.maps.Size(24, 32));
        for (var i = 0; i < data.photos.length; ++i) {
            var latLng = new google.maps.LatLng(data.photos[i].latitude,
                data.photos[i].longitude)
            var marker = new google.maps.Marker({
                position: latLng,
                draggable: true,
                icon: markerImage
            });
            markers.push(marker);
        }

        var zoom = parseInt(document.getElementById('zoom').value, 10);
        var size = parseInt(document.getElementById('size').value, 10);
        var style = parseInt(document.getElementById('style').value, 10);
        zoom = zoom === -1 ? null : zoom;
        size = size === -1 ? null : size;
        style = style === -1 ? null : style;

        markerClusterer = new MarkerClusterer(map, markers, {
            maxZoom: 10,
            gridSize: 80,
            styles: styles[style],
            imagePath: "{{ asset('img/images/map/m') }}"
        });
    }

    function initialize(data = []) {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6,
            center: new google.maps.LatLng(43.887080000182465, -116.19761388046881),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var refresh = document.getElementById('refresh');
        google.maps.event.addDomListener(refresh, 'click', refreshMap);

        var clear = document.getElementById('clear');
        google.maps.event.addDomListener(clear, 'click', clearClusters);

        refreshMap(data);
    }

    function clearClusters(e) {
        e.preventDefault();
        e.stopPropagation();
        markerClusterer.clearMarkers();
    }

    google.maps.event.addDomListener(window, 'load', initialize(data));
</script>
{{ Html::script(asset('js/markerclusterer.js')) }}
<script>
    var styles = [
        [{
            url: "{{ asset('img/images/map/people35.png') }}",
            height: 35,
            width: 35,
            anchor: [16, 0],
            textColor: '#ff00ff',
            textSize: 10,
            fontFamily: 'Arial,sans-serif',
            fontWeight: 'bold',
        }, {
            url: "{{ asset('img/images/map/people45.png') }}",
            height: 45,
            width: 45,
            anchor: [24, 0],
            textColor: '#ff0000',
            textSize: 11
        }, {
            url: "{{ asset('img/images/map/people55.png') }}",
            height: 55,
            width: 55,
            anchor: [32, 0],
            textColor: '#ffffff',
            textSize: 12
        }],
        [{
            url: "{{ asset('img/images/map/conv30.png') }}",
            height: 27,
            width: 30,
            anchor: [3, 0],
            textColor: '#ff00ff',
            textSize: 10
        }, {
            url: "{{ asset('img/images/map/conv40.png') }}",
            height: 36,
            width: 40,
            anchor: [6, 0],
            textColor: '#ff0000',
            textSize: 11
        }, {
            url: "{{ asset('img/images/map/conv50.png') }}",
            width: 50,
            height: 45,
            anchor: [8, 0],
            textSize: 12
        }],
        [{
            url: "{{ asset('img/images/map/heart30.png') }}",
            height: 26,
            width: 30,
            anchor: [4, 0],
            textColor: '#ff00ff',
            textSize: 10
        }, {
            url: "{{ asset('img/images/map/heart40.png') }}",
            height: 35,
            width: 40,
            anchor: [8, 0],
            textColor: '#ff0000',
            textSize: 11
        }, {
            url: "{{ asset('img/images/map/heart50.png') }}",
            width: 50,
            height: 44,
            anchor: [12, 0],
            textSize: 12
        }],
        [{
            url: "{{ asset('img/images/map/pin.png') }}",
            height: 48,
            width: 30,
            anchor: [-18, 0],
            textColor: '#ffffff',
            textSize: 10,
            iconAnchor: [15, 48]
        }]
    ];

    var markerClusterer = null;
    var map = null;
    var imageUrl = "{{ asset('img/images/gpin.png') }}";

    function refreshMap(data = []) {
        if (markerClusterer) {
            markerClusterer.clearMarkers();
        }

        var markers = [];

        var markerImage = new google.maps.MarkerImage(imageUrl,
            new google.maps.Size(24, 32));
        for (var i = 0; i < data.photos.length; ++i) {
            var latLng = new google.maps.LatLng(data.photos[i].latitude,
                data.photos[i].longitude)
            var marker = new google.maps.Marker({
                position: latLng,
                draggable: true,
                icon: markerImage
            });
            markers.push(marker);
        }

        var zoom = parseInt(document.getElementById('zoom').value, 10);
        var size = parseInt(document.getElementById('size').value, 10);
        var style = parseInt(document.getElementById('style').value, 10);
        zoom = zoom === -1 ? null : zoom;
        size = size === -1 ? null : size;
        style = style === -1 ? null : style;

        markerClusterer = new MarkerClusterer(map, markers, {
            maxZoom: 10,
            gridSize: 80,
            styles: styles[style],
            imagePath: "{{ asset('img/images/map/m') }}"
        });
    }

    function initialize(data = []) {
        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 6,
            center: new google.maps.LatLng(43.887080000182465, -116.19761388046881),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var refresh = document.getElementById('refresh');
        google.maps.event.addDomListener(refresh, 'click', refreshMap);

        var clear = document.getElementById('clear');
        google.maps.event.addDomListener(clear, 'click', clearClusters);

        refreshMap(data);
    }

    function clearClusters(e) {
        e.preventDefault();
        e.stopPropagation();
        markerClusterer.clearMarkers();
    }

    google.maps.event.addDomListener(window, 'load', initialize(data));
</script>

@endsection

@section('after-scripts')
{{-- {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
{{ Html::script(asset('js/template/js/fusioncharts.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
{{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}