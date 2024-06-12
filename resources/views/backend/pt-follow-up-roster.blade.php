@extends('backend.layouts.dashboard')
@section('after-styles')
<style>
    #map-container {
        padding: 6px;
        border-width: 1px;
        border-style: solid;
        border-color: #ccc #ccc #999 #ccc;
        -webkit-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
        -moz-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
        box-shadow: rgba(64, 64, 64, 0.1) 0 2px 5px;
        width: 100%;
    }

    #map {
        width: 100%;
        height: 200px;
    }
</style>
@endsection

@section('content-new')



<div class="content-wrapper">
    <div class="bg-white-wrap">
        <div class="row">

            <div class="col-md-5 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                        Patients By Stage
                    </h3>
                    <div class="card-body canvasheight">
                        <div class="row">
                            <div class="col-md-12 backgroundimage">
                                <div class="map-new-start" id="patientByStage"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1">
                        Map of Patients
                    </h3>
                    <div class="card-body canvasheight">
                        <div class="row">
                            <div class="col-md-12 backgroundMap">

                                <div id="map-container">
                                    <div id="map"></div>
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
            <div class="col-md-12">
                <div class="table-card">
                    <div class="card-header-2">
                        <h4> Patient Roster Last Day seen </h4>
                    </div>
                    <table id="dtBasicExample" class="table table-bordered table-responsive nephro-table">
                        <thead>
                            <tr>
                                <th>Stage Name</th>
                                <th>Patient Name</th>
                                <th>Primary Phone</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Late Date of Service</th>
                                <th>Last Seen Provider</th>
                                <th>Office location</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patientRosterLastDaySeen1 as $ptRost)
                            <tr>
                                <td>{{ $ptRost->Stage_name }}</td>
                                <td>{{ $ptRost->Patient_Name }}</td>
                                <td>{{ $ptRost->primary_phone }}</td>
                                <td>{{ $ptRost->Address }}</td>
                                <td>{{ $ptRost->City }}</td>
                                <td>{{ $ptRost->Last_date_of_service }}</td>
                                <td>{{ $ptRost->last_seen_provider }}</td>
                                <td>{{ $ptRost->Office_Location }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $patientRosterLastDaySeen1->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>
    var patientOption = {
        width: '250px',
        series: [{{$patientsByStagePF1}},{{$patientsByStagePF2}},{{$patientsByStagePF3}},{{$patientsByStagePF4}},{{$patientsByStagePF5}}],
        colors: ['#776acf', '#163888', '#6acfc8', '#88cf6a', '#842d72'],
        labels: ["Early CKD","Stage-4 CKD","Stage-5 CKD", "ESRD", "Non-CKD"],
        chart: {
            fontFamily: 'Quicksand',
            type: 'donut',
        },
        legend: {
            show: true,
            markers: {
                fillColors: ['#776acf', '#163888', '#6acfc8', '#88cf6a', '#842d72'],
                radius: 12,
            },
        },
        dataLabels: {
            formatter: function(val) {
                const percent = (val / 1);
                return percent.toFixed(0)
            },
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

    var PatientChart = new ApexCharts(document.querySelector("#patientByStage"), patientOption);
    PatientChart.render();
</script>


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


    <!-- <script>
        $(document).ready(function () {
    $('#dtBasicExample').DataTable();
    $('.dataTables_length').addClass('bs-select');
    });
    </script> -->


@endsection

@section('after-scripts')