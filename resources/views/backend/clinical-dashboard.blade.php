@if($ajaxRequest == 'load')
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
        height:450px;
      }
      #actions {
        list-style: none;
        padding: 0;
      }
      #inline-actions {
        padding-top: 10px;
      }
      .item {
        margin-left: 20px;
      }

        #chart-container, #chart-container-yearly {
            position: relative;
        }
 
        #chart-container::after, #chart-container-yearly::after {
            position: absolute;
            content: '';
            background-color: #fff;
            height: 15px;
            width: 200px;
            bottom: 0;
            left: 0;

        }

        /* Tooltip container */
        /*  .tooltip {
              position: relative;
              display: inline-block;
              border-bottom: 1px dotted black; !* If you want dots under the hoverable text *!
          }*/

        /* Tooltip text */
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: black;
            color: #fff;
            text-align: center;
            padding: 5px 0;
            border-radius: 6px;

            /* Position the tooltip text - see examples below! */
            position: absolute;
            z-index: 1;
        }

        /* Show the tooltip text when you mouse over the tooltip container */
        .tooltip:hover .tooltiptext {
            visibility: visible;
        }
    </style>
@endsection

@section('content-new')
@endif
    <div class="content-wrapper" data-load="{{$ajaxRequest}}">
        @include('backend.partials.clinical-stats')
        {{ Form::open(['route' => 'admin.clinical-search', 'class' => 'form', 'role' => 'form', 'method' => 'post','id'=>'']) }}
        @include('widgets.search_clinical_filter')
        {{ Form::close() }}
        <br>
        <div class="table-body"> 
        <div class="row row-grids">
                    <div class="col-md-3 card-box-mr border-color-1">
                        <div class="card border-radius-25">
                            <div class="card-body ckd-box  pad-space-0">
                                <h5 class="card-title">Late Stage CKD Visit Interval</h5>
                                <div class="ckd-box-row ckd-box-row-pad">
                                    <strong>{{$lateStageCKDVisitInterval->analysis_year_value}}</strong><br/>
                                    Prior Year {{$lateStageCKDVisitInterval->prior_year_value}}
                                </div>
                                <div class="ckd-box-row ckd-box-col">
                                    <span>{{$lateStageCKDVisitInterval->yearly_change}}</span>
                                    <span>{{$lateStageCKDVisitInterval->trend_percent}}% 
                                        @if($lateStageCKDVisitInterval->direction == 'up')
                                        <i class="fa-solid fa-circle-arrow-up"></i>
                                        @else
                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <a href="{{ route('admin.interval-detail') }}" class="stretched-link"></a>
                        </div>
                    </div>

                    <div class="col-md-3 card-box-mr border-color-2">
                        <div class="card border-radius-25">
                            <div class="card-body ckd-box  pad-space-0">
                                <h5 class="card-title">Late Stage CKD Wait Time</h5>
                                <div class="ckd-box-row ckd-box-row-pad">
                                    <strong>{{$lateStageCKDWaitTime->analysis_year_value}}</strong><br/>
                                    Prior Year {{$lateStageCKDWaitTime->prior_year_value}}
                                </div>
                                <div class="ckd-box-row ckd-box-col">
                                    <span>{{$lateStageCKDWaitTime->yearly_change}}</span>
                                    <span> {{$lateStageCKDWaitTime->trend_percent}}%
                                        @if($lateStageCKDWaitTime->direction == 'up')
                                        <i class="fa-solid fa-circle-arrow-up"></i>
                                        @else
                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
                           
                        </div>
                    </div>

                    <div class="col-md-3 card-box-mr border-color-3">
                        <div class="card border-radius-25">
                            <div class="card-body ckd-box  pad-space-0">
                                <h5 class="card-title">Hospital To Office Follow Up</h5>
                                <div class="ckd-box-row ckd-box-row-pad">
                                    <strong>{{$hospitalToOfficeFollowUp->analysis_year_value}}%</strong><br/>
                                    Prior Year {{$hospitalToOfficeFollowUp->prior_year_value}}%
                                </div>
                                <div class="ckd-box-row ckd-box-col">
                                    <span>{{$hospitalToOfficeFollowUp->yearly_change}}%</span>
                                    <span>{{$hospitalToOfficeFollowUp->trend_percent}}% 
                                        @if($hospitalToOfficeFollowUp->direction == 'up')
                                        <i class="fa-solid fa-circle-arrow-up"></i>
                                        @else
                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
        
                        </div>
                    </div>

                    <div class="col-md-3 card-box-mr border-color-4">
                        <div class="card border-radius-25">
                            <div class="card-body ckd-box  pad-space-0">
                                <h5 class="card-title">Pts with Albumin under 2.0</h5>
                                <div class="ckd-box-row ckd-box-row-pad">
                                    <strong>{{$ptsWithAlbuminUnder2->analysis_year_value}}%</strong><br/>
                                    {{$ptsWithAlbuminUnder2->count_fraction}}<br/>
                                    Prior Year {{$ptsWithAlbuminUnder2->prior_year_value}}%
                                </div>
                                <div class="ckd-box-row ckd-box-col">
                                    <span>{{$ptsWithAlbuminUnder2->yearly_change}}%</span>
                                    <span>{{$ptsWithAlbuminUnder2->trend_percent}}% 
                                        @if($ptsWithAlbuminUnder2->direction == 'up')
                                        <i class="fa-solid fa-circle-arrow-up"></i>
                                        @else
                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 card-box-mr border-color-4">
                        <div class="card border-radius-25">
                            <div class="card-body ckd-box  pad-space-0">
                                <h5 class="card-title">Pts with GFR under 60</h5>
                                <div class="ckd-box-row ckd-box-row-pad">
                                    <strong>{{$ptsWithGFRUnder60->analysis_year_value}}%</strong><br/>
                                    {{$ptsWithGFRUnder60->count_fraction}}<br/>
                                    Prior Year {{$ptsWithGFRUnder60->prior_year_value}}%
                                </div>
                                <div class="ckd-box-row ckd-box-col">
                                    <span>{{$ptsWithGFRUnder60->yearly_change}}%</span>
                                    <span>{{$ptsWithGFRUnder60->trend_percent}}% 
                                        @if($ptsWithGFRUnder60->direction == 'up')
                                        <i class="fa-solid fa-circle-arrow-up"></i>
                                        @else
                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
    
                        </div>
                    </div>

                    <div class="col-md-3 card-box-mr  border-color-3">
                        <div class="card border-radius-25">
                            <div class="card-body ckd-box  pad-space-0">
                                <h5 class="card-title">New Start with Hosp. 30 Days Prior	</h5>
                                <div class="ckd-box-row ckd-box-row-pad">
                                    <strong>{{$newStartHosp30Prior->analysis_year_value}}%</strong><br/>
                                    Prior Year {{$newStartHosp30Prior->prior_year_value}}%
                                </div>
                                <div class="ckd-box-row ckd-box-col">
                                    <span>{{$newStartHosp30Prior->yearly_change}}%</span>
                                    <span>{{$newStartHosp30Prior->trend_percent}}% 
                                        @if($newStartHosp30Prior->direction == 'up')
                                        <i class="fa-solid fa-circle-arrow-up"></i>
                                        @else
                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
                    
                        </div>
                    </div>

                    <div class="col-md-3 card-box-mr border-color-2">
                        <div class="card border-radius-25">
                            <div class="card-body ckd-box  pad-space-0">
                                <h5 class="card-title">Timely Referral</h5>
                                <div class="ckd-box-row ckd-box-row-pad">
                                    <strong>{{$timeReferral->analysis_year_value}}%</strong><br/>
                                    Prior Year {{$timeReferral->prior_year_value}}%
                                </div>
                                <div class="ckd-box-row ckd-box-col">
                                    <span>{{$timeReferral->yearly_change}}%</span>
                                    <span>{{$timeReferral->trend_percent}}% 
                                        @if($timeReferral->direction == 'up')
                                        <i class="fa-solid fa-circle-arrow-up"></i>
                                        @else
                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        
                        </div>
                    </div>

                    <div class="col-md-3 card-box-mr border-color-1">
                        <div class="card border-radius-25">
                            <div class="card-body ckd-box  pad-space-0">
                                <h5 class="card-title">Patients Conversion to Late Stage CKD</h5>
                                <div class="ckd-box-row ckd-box-row-pad">
                                    <strong>{{$ptsConversionLateStageCKD->analysis_year_value}}%</strong><br/>
                                    Prior Year {{$ptsConversionLateStageCKD->prior_year_value}}%
                                </div>
                                <div class="ckd-box-row ckd-box-col">
                                    <span>{{$ptsConversionLateStageCKD->yearly_change}}%</span>
                                    <span>{{$ptsConversionLateStageCKD->trend_percent}}% 
                                        @if($ptsConversionLateStageCKD->direction == 'up')
                                        <i class="fa-solid fa-circle-arrow-up"></i>
                                        @else
                                        <i class="fa-solid fa-circle-arrow-down"></i>
                                        @endif
                                    </span>
                                </div>
                            </div>
                           
                        </div>
                    </div>

                </div>

            <div class="row">
                
                <div class="col-md-6 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">CKD Patients Comparison</h4>
                            <!--<canvas id="orders-chart-azure"></canvas>-->
           
                            <canvas id="bar-chart-grouped-new" width="800" height="450"></canvas>

                        </div>
                    </div>
                </div>
                

                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">CKD Patient/BMI</h4>

                            <div class="d-md-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title mb-2 mb-md-3"></h5>
                                </div>
                            </div>
                            <div class=" mt-12">
                                <div class="chart1c-container">
                                    <canvas id="Chart1C" width="800" height="450"></canvas>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
  


            </div>
            <div class="row">
                <div class="col-md-12">

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
       <input id="refresh" type="button" value="Refresh Map" class="item"/>
       <a href="#" id="clear">Clear</a>
    </div>

                </div>
            </div>

        </div>
    </div>


    @if($ajaxRequest == 'load')
@endsection


@section('after-scripts')
    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    {{ Html::script(asset('js/template/js/fusioncharts.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-annotation/0.5.7/chartjs-plugin-annotation.js"></script>
    @include('backend.partials.graph-clinical-dashboard-script')


    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBWJ2bfcc9vb4aP1sw9b_xg4faVAovgh6U"></script>
    <script>
      var data = {!! json_encode($mileFromOffice) !!};
        console.log(data.photos.length);
    </script>
    {{ Html::script(asset('js/markerclusterer.js')) }}
    <script>
      var styles = [[{
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
      }], [{
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
      }], [{
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
      }], [{
        url: "{{ asset('img/images/map/pin.png') }}",
        height: 48,
        width: 30,
        anchor: [-18, 0],
        textColor: '#ffffff',
        textSize: 10,
        iconAnchor: [15, 48]
      }]];

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
        style = style === -1 ? null: style;

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


      
    $("body").on("change","#provider,#location,#payer",function(){

    var provider = $("#provider").val();
    var location = $("#location").val();
    var payer = $("#payer").val();
    var token = $('input[name=_token]').val();


        $.ajax({   
            type: "POST",
            url: "{{ route('admin.clinical-filter') }}",
            data: {provider:provider,location:location,payer:payer,_token:token},
            beforeSend: function(){
                $('.fas.fa-search').addClass('fa-spin fa-spinner').removeClass('fa-search');
            },
            success: function(data){
                var data = JSON.parse(data);
                var html_1 = data.html_1;
                var html_2 = data.html_2;
                $('.patient-stats').html(html_1);
                $('.row-grids').html(html_2);

                console.log(data.canvas_html);
                
                BarChartGroupedNew.data.datasets=data.canvas_html;
                BarChartGroupedNew.update();

                myChart.data.datasets=data.canvas1c_html;
                myChart.update();

                refreshMap(data.mileFromOffice_html);
                
                $('.fas.fa-spinner').removeClass('fa-spin fa-spinner').addClass('fa-search');
            }
        });

    });

    </script>

@endsection

@endif