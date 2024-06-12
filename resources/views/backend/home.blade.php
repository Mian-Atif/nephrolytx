@extends('backend.layouts.dashboard')

@section('content-new')

@php 
    $averageRevenuePerMonthsJson = json_encode($averageRevenuePerMonths);
    $averageRevenuePerQuarterJson = json_encode($averageRevenuePerQuarter);
    $averageRevenuePerYearJson = json_encode($averageRevenuePerYear);

    $patientsSeenPerMonthsJson = json_encode($patientsSeenPerMonths);
    $patientsSeenPerQuarterJson = json_encode($patientsSeenPerQuarter);
    $patientsSeenPerYearJson = json_encode($patientsSeenPerYear);

    $newPatientsActualMonthsJson = json_encode($newPatientsActualMonths);
    $newPatientsActualQuarterJson = json_encode($newPatientsActualQuarter);
    $newPatientsActualYearJson = json_encode($newPatientsActualYear);
    
    $esrdStartsPerMonthsJson = json_encode($esrdStartsPerMonths);
    $esrdStartsPerQuarterJson = json_encode($esrdStartsPerQuarter);
    $esrdStartsPerYearJson = json_encode($esrdStartsPerYear);

    $activePatientsActualMonthsJson = json_encode($activePatientsActualMonths);
    $activePatientsActualQuarterJson = json_encode($activePatientsActualQuarter);
    $activePatientsActualYearJson = json_encode($activePatientsActualYear);
    
    $esrdPatientsActualMonthsJson = json_encode($esrdPatientsActualMonths);
    $esrdPatientsActualQuarterJson = json_encode($esrdPatientsActualQuarter);
    $esrdPatientsActualYearJson = json_encode($esrdPatientsActualYear);

    $earlyStageCkdPatientsActualMonthsJson = json_encode($earlyStageCkdPatientsActualMonths);
    $earlyStageCkdPatientsActualQuarterJson = json_encode($earlyStageCkdPatientsActualQuarter);
    $earlyStageCkdPatientsActualYearJson = json_encode($earlyStageCkdPatientsActualYear);

    $lateStageCkdPatientsActualMonthsJson = json_encode($lateStageCkdPatientsActualMonths);
    $lateStageCkdPatientsActualQuarterJson = json_encode($lateStageCkdPatientsActualQuarter);
    $lateStageCkdPatientsActualYearJson = json_encode($lateStageCkdPatientsActualYear);

    
@endphp



<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<div class="content-wrapper">
<div class="home-background">
   <h3 class="box-height h3-color-home"> Activity </h3>
    <div class="row">
        <div class="col-md-4 grid-margin  stretch-card ">
            <div class="home-design1">
                <h3 class="home-slide-head h3-color-home">
                Expected Revenue
                </h3>
                <div class="vertical-slider">
                    <div class="slide-item">
                        <div class="slide-item-inner slide-cursor" data-slideid="1" data-head="Expected Revenue" data-month="{{$averageRevenuePerMonthsJson}}" data-quarter="{{$averageRevenuePerQuarterJson}}" data-year="{{$averageRevenuePerYearJson}}">
                            <div class="si-top">Expected Revenue </div>
                            <div class="si-bottom">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="109" height="108" viewBox="0 0 109 108"> <defs> <clipPath id="clip-path-12"> <rect id="Rectangle_17666" data-name="Rectangle 17666" width="109" height="108" transform="translate(0 0.315)"/> </clipPath> </defs> <g id="Group_40931" data-name="Group 40931" transform="translate(0 -0.315)"> <g id="Group_40754" data-name="Group 40754" clip-path-12="url(#clip-path-12)"> <path id="Path_38116" data-name="Path 38116" d="M817.353,386.764c-.045-.19-.224-.158-.351-.2a6.739,6.739,0,0,1-5-6.64Q812,368.7,812,357.462q0-19.111,0-38.221a6.757,6.757,0,0,1,5.165-6.729,7.6,7.6,0,0,1,1.891-.194c2.088,0,4.177,0,6.265,0a6.77,6.77,0,0,1,6.911,5.094c.029.094.007.228.159.247v63.9a6.438,6.438,0,0,1-1.212,2.622,6.309,6.309,0,0,1-4.347,2.577Z" transform="translate(-723.394 -278.449)" fill="#32679b"/> <path id="Path_38117" data-name="Path 38117" d="M567.556,498.13c-.048-.189-.227-.156-.353-.193a6.729,6.729,0,0,1-5-6.636q-.014-9.883,0-19.767,0-13.7,0-27.4a6.756,6.756,0,0,1,5.186-6.713,7.719,7.719,0,0,1,1.838-.188c2.125,0,4.251-.006,6.376,0a6.75,6.75,0,0,1,7.03,7q.006,23.477,0,46.953a6.7,6.7,0,0,1-5.482,6.843c-.041.009-.072.065-.108.1Z" transform="translate(-500.845 -389.815)" fill="#32679b"/> <path id="Path_38118" data-name="Path 38118" d="M317.744,609.474c-.05-.187-.229-.154-.355-.19a6.732,6.732,0,0,1-5.014-6.628q-.016-11.047,0-22.094,0-5.686,0-11.372a6.765,6.765,0,0,1,7.126-7.072q3.106-.005,6.212,0a6.759,6.759,0,0,1,7.095,7.047q0,16.678,0,33.357a6.708,6.708,0,0,1-5.472,6.852c-.041.01-.071.065-.107.1Z" transform="translate(-278.282 -501.16)" fill="#32679b"/> <path id="Path_38119" data-name="Path 38119" d="M67.87,720.834c-.071-.2-.267-.16-.411-.2a6.744,6.744,0,0,1-4.968-6.39c-.031-1.226-.009-2.454-.009-3.681,0-5.54-.009-11.081,0-16.621A6.738,6.738,0,0,1,68.3,687.1a7.683,7.683,0,0,1,1.194-.07q3.214-.01,6.429,0a6.753,6.753,0,0,1,7,6.979q.008,9.935,0,19.869a6.715,6.715,0,0,1-5.462,6.86c-.041.01-.07.066-.105.1Z" transform="translate(-55.657 -612.52)" fill="#32679b"/> <path id="Path_38120" data-name="Path 38120" d="M51.086,6.233,88.6,0l-13.3,35.33c-.244-.05-.318-.253-.437-.4q-3.472-4.173-6.927-8.36c-.277-.338-.44-.316-.762-.081A190.741,190.741,0,0,1,42.515,41.944,130.233,130.233,0,0,1,18.972,51.5,99.474,99.474,0,0,1,7.956,54.081,6.814,6.814,0,0,1,.124,48.669a6.7,6.7,0,0,1,5.243-7.851A107.873,107.873,0,0,0,19.766,37a131.573,131.573,0,0,0,22.274-10.3A186.472,186.472,0,0,0,58.367,16.131c.569-.41.57-.409.137-.93L51.469,6.719c-.113-.136-.219-.278-.383-.486" transform="translate(0)" fill="#32679b"/> </g> </g></svg>
                                <span>
                                @if(count($averageRevenuePerMonths)>0) 
                                {{isset(end($averageRevenuePerMonths)->vals) ? "$".number_format(end($averageRevenuePerMonths)->vals) : 0}}   
                                @endif
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="slide-item ">
                        <div class="slide-item-inner slide-cursor ps-bg" data-slideid="2" data-head="Patients Seen"  data-month="{{$patientsSeenPerMonthsJson}}" data-quarter="{{$patientsSeenPerQuarterJson}}" data-year="{{$patientsSeenPerYearJson}}">
                            <div class="si-top">Patients Seen</div>
                                <div class="si-bottom">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="109" height="108" viewBox="0 0 109 108"> <defs> <clipPath id="clip-path-12"> <rect id="Rectangle_17666" data-name="Rectangle 17666" width="109" height="108" transform="translate(0 0.315)"/> </clipPath> </defs> <g id="Group_40931" data-name="Group 40931" transform="translate(0 -0.315)"> <g id="Group_40754" data-name="Group 40754" clip-path-12="url(#clip-path-12)"> <path id="Path_38116" data-name="Path 38116" d="M817.353,386.764c-.045-.19-.224-.158-.351-.2a6.739,6.739,0,0,1-5-6.64Q812,368.7,812,357.462q0-19.111,0-38.221a6.757,6.757,0,0,1,5.165-6.729,7.6,7.6,0,0,1,1.891-.194c2.088,0,4.177,0,6.265,0a6.77,6.77,0,0,1,6.911,5.094c.029.094.007.228.159.247v63.9a6.438,6.438,0,0,1-1.212,2.622,6.309,6.309,0,0,1-4.347,2.577Z" transform="translate(-723.394 -278.449)" fill="#32679b"/> <path id="Path_38117" data-name="Path 38117" d="M567.556,498.13c-.048-.189-.227-.156-.353-.193a6.729,6.729,0,0,1-5-6.636q-.014-9.883,0-19.767,0-13.7,0-27.4a6.756,6.756,0,0,1,5.186-6.713,7.719,7.719,0,0,1,1.838-.188c2.125,0,4.251-.006,6.376,0a6.75,6.75,0,0,1,7.03,7q.006,23.477,0,46.953a6.7,6.7,0,0,1-5.482,6.843c-.041.009-.072.065-.108.1Z" transform="translate(-500.845 -389.815)" fill="#32679b"/> <path id="Path_38118" data-name="Path 38118" d="M317.744,609.474c-.05-.187-.229-.154-.355-.19a6.732,6.732,0,0,1-5.014-6.628q-.016-11.047,0-22.094,0-5.686,0-11.372a6.765,6.765,0,0,1,7.126-7.072q3.106-.005,6.212,0a6.759,6.759,0,0,1,7.095,7.047q0,16.678,0,33.357a6.708,6.708,0,0,1-5.472,6.852c-.041.01-.071.065-.107.1Z" transform="translate(-278.282 -501.16)" fill="#32679b"/> <path id="Path_38119" data-name="Path 38119" d="M67.87,720.834c-.071-.2-.267-.16-.411-.2a6.744,6.744,0,0,1-4.968-6.39c-.031-1.226-.009-2.454-.009-3.681,0-5.54-.009-11.081,0-16.621A6.738,6.738,0,0,1,68.3,687.1a7.683,7.683,0,0,1,1.194-.07q3.214-.01,6.429,0a6.753,6.753,0,0,1,7,6.979q.008,9.935,0,19.869a6.715,6.715,0,0,1-5.462,6.86c-.041.01-.07.066-.105.1Z" transform="translate(-55.657 -612.52)" fill="#32679b"/> <path id="Path_38120" data-name="Path 38120" d="M51.086,6.233,88.6,0l-13.3,35.33c-.244-.05-.318-.253-.437-.4q-3.472-4.173-6.927-8.36c-.277-.338-.44-.316-.762-.081A190.741,190.741,0,0,1,42.515,41.944,130.233,130.233,0,0,1,18.972,51.5,99.474,99.474,0,0,1,7.956,54.081,6.814,6.814,0,0,1,.124,48.669a6.7,6.7,0,0,1,5.243-7.851A107.873,107.873,0,0,0,19.766,37a131.573,131.573,0,0,0,22.274-10.3A186.472,186.472,0,0,0,58.367,16.131c.569-.41.57-.409.137-.93L51.469,6.719c-.113-.136-.219-.278-.383-.486" transform="translate(0)" fill="#32679b"/> </g> </g></svg>
                                    <span>
                                    @if(count($patientsSeenPerMonths)>0)    
                                    {{ isset(end($patientsSeenPerMonths)->vals) ? end($patientsSeenPerMonths)->vals : 0}}
                                    @endif
                                    </span>
                                </div>
                        </div>
                    </div>
                    <div class="slide-item">
                        <div class="slide-item-inner slide-cursor np-bg" data-slideid="3" data-head="New Patients"  data-month="{{$newPatientsActualMonthsJson}}" data-quarter="{{$newPatientsActualQuarterJson}}" data-year="{{$newPatientsActualYearJson}}">
                            <div class="si-top">New Patients</div>
                            <div class="si-bottom">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="109" height="108" viewBox="0 0 109 108"> <defs> <clipPath id="clip-path-12"> <rect id="Rectangle_17666" data-name="Rectangle 17666" width="109" height="108" transform="translate(0 0.315)"/> </clipPath> </defs> <g id="Group_40931" data-name="Group 40931" transform="translate(0 -0.315)"> <g id="Group_40754" data-name="Group 40754" clip-path-12="url(#clip-path-12)"> <path id="Path_38116" data-name="Path 38116" d="M817.353,386.764c-.045-.19-.224-.158-.351-.2a6.739,6.739,0,0,1-5-6.64Q812,368.7,812,357.462q0-19.111,0-38.221a6.757,6.757,0,0,1,5.165-6.729,7.6,7.6,0,0,1,1.891-.194c2.088,0,4.177,0,6.265,0a6.77,6.77,0,0,1,6.911,5.094c.029.094.007.228.159.247v63.9a6.438,6.438,0,0,1-1.212,2.622,6.309,6.309,0,0,1-4.347,2.577Z" transform="translate(-723.394 -278.449)" fill="#32679b"/> <path id="Path_38117" data-name="Path 38117" d="M567.556,498.13c-.048-.189-.227-.156-.353-.193a6.729,6.729,0,0,1-5-6.636q-.014-9.883,0-19.767,0-13.7,0-27.4a6.756,6.756,0,0,1,5.186-6.713,7.719,7.719,0,0,1,1.838-.188c2.125,0,4.251-.006,6.376,0a6.75,6.75,0,0,1,7.03,7q.006,23.477,0,46.953a6.7,6.7,0,0,1-5.482,6.843c-.041.009-.072.065-.108.1Z" transform="translate(-500.845 -389.815)" fill="#32679b"/> <path id="Path_38118" data-name="Path 38118" d="M317.744,609.474c-.05-.187-.229-.154-.355-.19a6.732,6.732,0,0,1-5.014-6.628q-.016-11.047,0-22.094,0-5.686,0-11.372a6.765,6.765,0,0,1,7.126-7.072q3.106-.005,6.212,0a6.759,6.759,0,0,1,7.095,7.047q0,16.678,0,33.357a6.708,6.708,0,0,1-5.472,6.852c-.041.01-.071.065-.107.1Z" transform="translate(-278.282 -501.16)" fill="#32679b"/> <path id="Path_38119" data-name="Path 38119" d="M67.87,720.834c-.071-.2-.267-.16-.411-.2a6.744,6.744,0,0,1-4.968-6.39c-.031-1.226-.009-2.454-.009-3.681,0-5.54-.009-11.081,0-16.621A6.738,6.738,0,0,1,68.3,687.1a7.683,7.683,0,0,1,1.194-.07q3.214-.01,6.429,0a6.753,6.753,0,0,1,7,6.979q.008,9.935,0,19.869a6.715,6.715,0,0,1-5.462,6.86c-.041.01-.07.066-.105.1Z" transform="translate(-55.657 -612.52)" fill="#32679b"/> <path id="Path_38120" data-name="Path 38120" d="M51.086,6.233,88.6,0l-13.3,35.33c-.244-.05-.318-.253-.437-.4q-3.472-4.173-6.927-8.36c-.277-.338-.44-.316-.762-.081A190.741,190.741,0,0,1,42.515,41.944,130.233,130.233,0,0,1,18.972,51.5,99.474,99.474,0,0,1,7.956,54.081,6.814,6.814,0,0,1,.124,48.669a6.7,6.7,0,0,1,5.243-7.851A107.873,107.873,0,0,0,19.766,37a131.573,131.573,0,0,0,22.274-10.3A186.472,186.472,0,0,0,58.367,16.131c.569-.41.57-.409.137-.93L51.469,6.719c-.113-.136-.219-.278-.383-.486" transform="translate(0)" fill="#32679b"/> </g> </g></svg>
                                <span>
                                    @if(count($newPatientsActualMonths)>0)
                                        {{isset(end($newPatientsActualMonths)->vals) ? end($newPatientsActualMonths)->vals : 0}}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="slide-item">
                        <div class="slide-item-inner slide-cursor esrd-bg" data-slideid="4" data-head="ESRD Patients" data-month="{{$esrdStartsPerMonthsJson}}" data-quarter="{{$esrdStartsPerQuarterJson}}" data-year="{{$esrdStartsPerYearJson}}">
                            <div class="si-top">ESRD Starts</div>
                            <div class="si-bottom">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="109" height="108" viewBox="0 0 109 108"> <defs> <clipPath id="clip-path-12"> <rect id="Rectangle_17666" data-name="Rectangle 17666" width="109" height="108" transform="translate(0 0.315)"/> </clipPath> </defs> <g id="Group_40931" data-name="Group 40931" transform="translate(0 -0.315)"> <g id="Group_40754" data-name="Group 40754" clip-path-12="url(#clip-path-12)"> <path id="Path_38116" data-name="Path 38116" d="M817.353,386.764c-.045-.19-.224-.158-.351-.2a6.739,6.739,0,0,1-5-6.64Q812,368.7,812,357.462q0-19.111,0-38.221a6.757,6.757,0,0,1,5.165-6.729,7.6,7.6,0,0,1,1.891-.194c2.088,0,4.177,0,6.265,0a6.77,6.77,0,0,1,6.911,5.094c.029.094.007.228.159.247v63.9a6.438,6.438,0,0,1-1.212,2.622,6.309,6.309,0,0,1-4.347,2.577Z" transform="translate(-723.394 -278.449)" fill="#32679b"/> <path id="Path_38117" data-name="Path 38117" d="M567.556,498.13c-.048-.189-.227-.156-.353-.193a6.729,6.729,0,0,1-5-6.636q-.014-9.883,0-19.767,0-13.7,0-27.4a6.756,6.756,0,0,1,5.186-6.713,7.719,7.719,0,0,1,1.838-.188c2.125,0,4.251-.006,6.376,0a6.75,6.75,0,0,1,7.03,7q.006,23.477,0,46.953a6.7,6.7,0,0,1-5.482,6.843c-.041.009-.072.065-.108.1Z" transform="translate(-500.845 -389.815)" fill="#32679b"/> <path id="Path_38118" data-name="Path 38118" d="M317.744,609.474c-.05-.187-.229-.154-.355-.19a6.732,6.732,0,0,1-5.014-6.628q-.016-11.047,0-22.094,0-5.686,0-11.372a6.765,6.765,0,0,1,7.126-7.072q3.106-.005,6.212,0a6.759,6.759,0,0,1,7.095,7.047q0,16.678,0,33.357a6.708,6.708,0,0,1-5.472,6.852c-.041.01-.071.065-.107.1Z" transform="translate(-278.282 -501.16)" fill="#32679b"/> <path id="Path_38119" data-name="Path 38119" d="M67.87,720.834c-.071-.2-.267-.16-.411-.2a6.744,6.744,0,0,1-4.968-6.39c-.031-1.226-.009-2.454-.009-3.681,0-5.54-.009-11.081,0-16.621A6.738,6.738,0,0,1,68.3,687.1a7.683,7.683,0,0,1,1.194-.07q3.214-.01,6.429,0a6.753,6.753,0,0,1,7,6.979q.008,9.935,0,19.869a6.715,6.715,0,0,1-5.462,6.86c-.041.01-.07.066-.105.1Z" transform="translate(-55.657 -612.52)" fill="#32679b"/> <path id="Path_38120" data-name="Path 38120" d="M51.086,6.233,88.6,0l-13.3,35.33c-.244-.05-.318-.253-.437-.4q-3.472-4.173-6.927-8.36c-.277-.338-.44-.316-.762-.081A190.741,190.741,0,0,1,42.515,41.944,130.233,130.233,0,0,1,18.972,51.5,99.474,99.474,0,0,1,7.956,54.081,6.814,6.814,0,0,1,.124,48.669a6.7,6.7,0,0,1,5.243-7.851A107.873,107.873,0,0,0,19.766,37a131.573,131.573,0,0,0,22.274-10.3A186.472,186.472,0,0,0,58.367,16.131c.569-.41.57-.409.137-.93L51.469,6.719c-.113-.136-.219-.278-.383-.486" transform="translate(0)" fill="#32679b"/> </g> </g></svg>
                              
                                <span>{{isset(end($esrdStartsPerMonths)->vals) ? end($esrdStartsPerMonths)->vals : 0}}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-8 grid-margin stretch-card ">
            <div class="card card-shadow">
                    <h3 class="home-design1 or-clr1"  data-targetcanvas="myChart5">
                     <a href="#" class="btn btn-secondary active actual-trigger margin-right-btn ">Actual</a> 
                     or
                    <a href="#" class="btn btn-secondary change-trigger margin-left-btn">Change</a>
                        <span class="graph-right-filter"> 
                            <a href="#" data-targetCanvas="myChart5" data-type="month" data-chart_type="actual" data-actual_data ="{{$averageRevenuePerMonthsJson}}"   class="btn btn-secondary active activity-month">Months</a> 
                            <a href="#" data-targetCanvas="myChart5" data-type="quarter" data-chart_type="actual" data-actual_data="{{$averageRevenuePerQuarterJson}}" class="btn btn-secondary activity-quarter activity-direction">Quarters</a>
                            <a href="#" data-targetCanvas="myChart5" data-type="year" data-chart_type="actual" data-actual_data="{{$averageRevenuePerYearJson}}" class="btn btn-secondary activity-year">Years</a>
                        </span>
                    </h3>
                <div class="card-body" >
                    <div class="row">
                        <div class="col-md-12">
                            <canvas id="myChart5"></canvas>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
    </div>   
</div>
    <div class="home-background">
        <h3 class="box-height h3-color-home"> Key Performance Indicators </h3>

        <div class="row">
        
            <div class="col-md-6 grid-margin stretch-card ">
                <div class="card card-shadow">
                        <h3 class="home-design1">
                            Active Patients/Physician
                            <span>12 Month Trend</span>
                        </h3>
                    <div class="card-body" >
                        <div class="row vertical-middle">
                            <div class="col-md-9">
                                <canvas id="myChart"></canvas>
                            </div>
                            <div class="col-md-3">
                                @php
                                $key = 'active_patients';
                                $finalVal = App\Http\Controllers\nepanalysis\AnalysisController::svgTrendValue($activePatientPerPhysicians,$key);
                                @endphp
                                <div class="resultbox svg-icon-dark-blue">
                                    @php 
                                    App\Http\Controllers\nepanalysis\AnalysisController::svgTrend($finalVal->direction);
                                    @endphp
                                </div>
                                <span class="resultbox1">
                                        @if(isset($finalVal->value) && !empty($finalVal->value))
                                             {{$finalVal->value}}
                                    @endif
                                </span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card card-shadow">
                            <h3 class="home-design1">
                                ESRD Patient/Physician
                                <span>12 Month Trend</span>
                            </h3>
                            <div class="card-body" >
                            <div class="row vertical-middle">
                                <div class="col-md-9">
                                    <canvas id="myChart2"></canvas>
                                </div>
                                <div class="col-md-3">
                                @php
                                $key = 'esrd_patients';
                                $finalVal = App\Http\Controllers\nepanalysis\AnalysisController::svgTrendValue($esrdPatientsPerPhysicians,$key);
                                @endphp
                                    <div class="resultbox svg-icon-orange">
                                        @php 
                                            App\Http\Controllers\nepanalysis\AnalysisController::svgTrend($finalVal->direction);
                                        @endphp
                                    </div>
                                    <span class="resultbox2">
                                    @if(isset($finalVal->value) && !empty($finalVal->value))
                                             {{$finalVal->value}}
                                    @endif
                                    </span>
                                </div>
                                
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card card-shadow">
                            <h3 class="home-design1">
                                New Patients/Physician
                                <span>12 Month Trend</span>
                            </h3>
                            <div class="card-body" >
                            <div class="row vertical-middle">
                                <div class="col-md-9">
                                    <canvas id="myChart3"></canvas>
                                </div>
                                <div class="col-md-3">
                                @php
                                $key = 'new_patient_count';
                                $finalVal = App\Http\Controllers\nepanalysis\AnalysisController::svgTrendValue($newPatientsPerPhysicians,$key);
                                @endphp
                                    <div class="resultbox svg-icon-sky-blue">
                                    @php 
                                        App\Http\Controllers\nepanalysis\AnalysisController::svgTrend($finalVal->direction);
                                     @endphp
                                    </div>
                                    <span class="resultbox3">
                                    @if(isset($finalVal->value) && !empty($finalVal->value))
                                             {{$finalVal->value}}
                                    @endif
                                        
                                    </span>

                                </div>
                            </div>
                        </div>
                </div>
            </div>
            
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card card-shadow">
                            <h3 class="home-design1">
                            Average Revenue/Physician/Day
                                <span>12 Month Trend</span>
                            </h3>
                        <div class="card-body" >
                            <div class="row vertical-middle">
                                <div class="col-md-9">
                                    <canvas id="myChart4"></canvas>
                                </div>
                                <div class="col-md-3">
                                @php
                                $key = 'avg_income';
                                $finalVal = App\Http\Controllers\nepanalysis\AnalysisController::svgTrendValue($avgRevenuePerPhysiciansperDays,$key);
                                @endphp 
                                    <div class="resultbox svg-icon-pink">
                                    @php 
                                        App\Http\Controllers\nepanalysis\AnalysisController::svgTrend($finalVal->direction);
                                     @endphp
                                    <span class="resultbox4"> 
                                    @if(isset($finalVal->value) && !empty($finalVal->value))
                                             {{"$".$finalVal->value}}
                                    @endif
                                    </span>
                                    
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="home-background">
        <h3 class="box-height h3-color-home"> Patients </h3>
        @php 
            
            // Year Growth
            if(!empty($activePatientsActualYear)){
                if(isset($activePatientsActualYear[2]) && !empty($activePatientsActualYear[2])){
                    $patientBalancePriorYear = round($activePatientsActualYear[2]->vals,2);
                }else{
                    $patientBalancePriorYear =1;
                }
            }
            //$patientBalancePriorYear = $activePatientsActualYear[2]->vals;

            if(!empty($activePatientsActualYear)){
                if(isset($activePatientsActualYear[3]) && !empty($activePatientsActualYear[3])){
                    $patientBalanceCrYear = round($activePatientsActualYear[3]->vals,2);
                }else{
                    $patientBalanceCrYear = 0;
                }
            }
            
           // $patientBalanceCrYear = $activePatientsActualYear[3]->vals;
           if(isset($patientBalancePriorYear) && isset($patientBalancePriorYear)){
            $patientBalanceYearPercentage = number_format((($patientBalancePriorYear-$patientBalanceCrYear) / $patientBalancePriorYear) * 100,3);
           }else{
            $patientBalanceYearPercentage = 0;
           }

            // Month Growth
            $patientBalancePriorMonth = array_slice($activePatientsActualMonths, -2, 1);

            $patientBalancePriorMonth = $patientBalancePriorMonth[0]->vals;
            $patientBalanceCrMonth = end($activePatientsActualMonths)->vals;

            if(isset($patientBalancePriorMonth) && isset($patientBalancePriorMonth)){
            $patientBalanceMonthPercentage = number_format((($patientBalancePriorMonth - $patientBalanceCrMonth) / $patientBalancePriorMonth) * 100,3);
            }else{
                $patientBalanceMonthPercentage = 0;
            }
        @endphp

        
        @php 

            // Year Growth
            // $esrdPatientBalancePriorYear = $esrdPatientsActualYear[2]->vals;
            // $esrdPatientBalanceCrYear = $esrdPatientsActualYear[3]->vals;


            if(!empty($esrdPatientsActualYear)){
                if(isset($esrdPatientsActualYear[2]) && !empty($esrdPatientsActualYear[2])){
                    $esrdPatientBalancePriorYear = $esrdPatientsActualYear[2]->vals;
                }else{
                    $esrdPatientBalancePriorYear = 0;
                }
            }

            if(!empty($esrdPatientsActualYear)){
                if(isset($esrdPatientsActualYear[3]) && !empty($esrdPatientsActualYear[3])){
                    $esrdPatientBalanceCrYear = $esrdPatientsActualYear[3]->vals;
                }else{
                    $esrdPatientBalanceCrYear = 0;
                }
            }

            
            if(isset($esrdPatientBalancePriorYear) && isset($esrdPatientBalancePriorYear)){
            $esrdPatientBalanceYearPercentage = number_format((($esrdPatientBalancePriorYear-$esrdPatientBalanceCrYear) / $esrdPatientBalancePriorYear) * 100,3);
            }else{
                $esrdPatientBalanceYearPercentage = 0;
            }

            // Month Growth
            $esrdPatientBalancePriorMonth = array_slice($esrdPatientsActualMonths, -2, 1);
            
            $esrdPatientBalancePriorMonth = $esrdPatientBalancePriorMonth[0]->vals;
            $esrdPatientBalanceCrMonth = end($esrdPatientsActualMonths)->vals;

            if(isset($esrdPatientBalancePriorMonth) && isset($esrdPatientBalancePriorMonth)){
            $esrdPatientBalanceMonthPercentage = number_format((($esrdPatientBalancePriorMonth-$esrdPatientBalanceCrMonth) / $esrdPatientBalancePriorMonth) * 100,3);
            }else{
                $esrdPatientBalanceMonthPercentage = 0;
            }
        @endphp
        
        @php 

            // Year Growth
            $earlyStageCkdPatientBalancePriorYear = isset($earlyStageCkdPatientsActualYear[2]->vals) && !empty($earlyStageCkdPatientsActualYear[2]->vals) ? $earlyStageCkdPatientsActualYear[2]->vals : 0;
            $earlyStageCkdPatientBalanceCrYear = isset($earlyStageCkdPatientsActualYear[3]->vals) && !empty($earlyStageCkdPatientsActualYear[3]->vals) ? $earlyStageCkdPatientsActualYear[3]->vals : 0;
            
            if(isset($earlyStageCkdPatientBalancePriorYear) && isset($earlyStageCkdPatientBalancePriorYear)){
            $earlyStageCkdPatientBalanceYearPercentage = number_format((($earlyStageCkdPatientBalancePriorYear-$earlyStageCkdPatientBalanceCrYear) / $earlyStageCkdPatientBalancePriorYear) * 100,3);
            }else{
                $earlyStageCkdPatientBalanceYearPercentage = 0;
            }
            
            // Month Growth

            $earlyStageCkdPatientsActualMonths11= array_slice($earlyStageCkdPatientsActualMonths, -2, 1);
            $earlyStageCkdPatientsActualMonths11= $earlyStageCkdPatientsActualMonths11[0]->vals;
            $earlyStageCkdPatientsActualMonths12 = end($earlyStageCkdPatientsActualMonths)->vals;

            //dd($earlyStageCkdPatientsActualMonths);
            $earlyStageCkdPatientBalancePriorMonth = isset($earlyStageCkdPatientsActualMonths11) && !empty($earlyStageCkdPatientsActualMonths11) ? $earlyStageCkdPatientsActualMonths11 : 0;
            $earlyStageCkdPatientBalanceCrMonth = isset($earlyStageCkdPatientsActualMonths12) && !empty($earlyStageCkdPatientsActualMonths12) ? $earlyStageCkdPatientsActualMonths12 : 0;

            
            if(isset($earlyStageCkdPatientBalancePriorMonth) && isset($earlyStageCkdPatientBalanceCrMonth)){
                $earlyStageCkdPatientBalanceMonthPercentage = number_format((($earlyStageCkdPatientBalancePriorMonth-$earlyStageCkdPatientBalanceCrMonth) / $earlyStageCkdPatientBalancePriorMonth) * 100,3);
            }else{
                $earlyStageCkdPatientBalanceMonthPercentage = 0;
            }
        @endphp
        
        @php 
 
            // Year Growth 
            $lateStageCkdPatientBalancePriorYear = $lateStageCkdPatientsActualYear[1]->vals;
            $lateStageCkdPatientBalanceCrYear = $lateStageCkdPatientsActualYear[2]->vals;

            if(isset($lateStageCkdPatientBalancePriorYear) && !empty($lateStageCkdPatientBalancePriorYear)){
            $lateStageCkdPatientBalanceYearPercentage = number_format((($lateStageCkdPatientBalancePriorYear-$lateStageCkdPatientBalanceCrYear) / $lateStageCkdPatientBalancePriorYear) * 100,3);
            }else{
                $lateStageCkdPatientBalanceYearPercentage=0;
            }
          
            
            // Month Growth
            // dd($lateStageCkdPatientsActualMonths);

            $lateStageCkdPatientsActualMonths11= array_slice($lateStageCkdPatientsActualMonths, -2, 1);

            $lateStageCkdPatientsActualMonths11= $lateStageCkdPatientsActualMonths11[0]->vals;
            $lateStageCkdPatientsActualMonths12 = end($lateStageCkdPatientsActualMonths)->vals;

            $lateStageCkdPatientBalancePriorMonth = isset($lateStageCkdPatientsActualMonths11) && !empty($lateStageCkdPatientsActualMonths11) ? $lateStageCkdPatientsActualMonths11 : 0; 
            $lateStageCkdPatientBalanceCrMonth = isset($lateStageCkdPatientsActualMonths12) && !empty($lateStageCkdPatientsActualMonths12) ? $lateStageCkdPatientsActualMonths12 : 0;


            if(isset($lateStageCkdPatientBalancePriorMonth) && !empty($lateStageCkdPatientBalancePriorMonth)){
                $lateStageCkdPatientBalanceMonthPercentage = number_format((($lateStageCkdPatientBalancePriorMonth-$lateStageCkdPatientBalanceCrMonth) / $lateStageCkdPatientBalancePriorMonth) * 100,3);
            }else{
                $lateStageCkdPatientBalanceMonthPercentage = 0;
            }
        @endphp


      
        <div class="row">
            <div class="col-md-4 grid-margin  stretch-card ">
                <div class="home-design1">
                    <h3 class="home-slide-head h3-color-home">
                        Active Patients
                    </h3>
                    <div class="patient-bal-slider">
                        <div class="patient-bal-item">
                            <div class="patient-bal-inner" data-slideid="5" data-head="Active Patients" data-month="{{$activePatientsActualMonthsJson}}" data-quarter="{{$activePatientsActualQuarterJson}}" data-year="{{$activePatientsActualYearJson}}">
                                <div class="pbi-top">
                                @php
                                $key = 'vals';
                                $percentage_year = App\Http\Controllers\nepanalysis\AnalysisController::calculatePercentage($activePatientsActualYear,$key);
                                $percentage_month = App\Http\Controllers\nepanalysis\AnalysisController::calculatePercentage($activePatientsActualMonths,$key);
                                $finalVal = App\Http\Controllers\nepanalysis\AnalysisController::svgTrendValue($activePatientsActualYear,$key);
                                @endphp
                                    <div class="pbi-box">
                                        <div class="">{{$percentage_year}}% From Last Year</div>
                                        <div class="">{{$percentage_month}}% From Last Month</div>
                                    </div>
                                    <div class="pbi-box">{{$patientBalanceCrMonth}}</div>
                                </div>
                                <div class="pbi-bottom">
                                    @php 
                                        App\Http\Controllers\nepanalysis\AnalysisController::svgTrend($finalVal->direction);
                                     @endphp
                                </div>
                            </div>
                        </div>
                        <div class="patient-bal-item">
                            <div class="patient-bal-inner" data-slideid="6" data-head="ESRD  Patients" data-month="{{$esrdPatientsActualMonthsJson}}" data-quarter="{{$esrdPatientsActualQuarterJson}}" data-year="{{$esrdPatientsActualYearJson}}">
                                <div class="pbi-top">
                                @php
                                $key = 'vals';
                                $percentage_year = App\Http\Controllers\nepanalysis\AnalysisController::calculatePercentage($esrdPatientsActualYear,$key);
                                $percentage_month = App\Http\Controllers\nepanalysis\AnalysisController::calculatePercentage($esrdPatientsActualMonths,$key);
                                $finalVal = App\Http\Controllers\nepanalysis\AnalysisController::svgTrendValue($esrdPatientsActualYear,$key);
                                @endphp
                                    <div class="pbi-box">
                                        <div class="">{{$percentage_year}}% From Last Year</div>
                                        <div class="">{{$percentage_month}}% From Last Month</div>
                                    </div>
                                    <div class="pbi-box">{{$esrdPatientBalanceCrMonth}}</div>
                                </div>
                                <div class="pbi-bottom">
                                    @php 
                                        App\Http\Controllers\nepanalysis\AnalysisController::svgTrend($finalVal->direction);
                                     @endphp
                                </div>
                            </div>
                        </div>
                        <div class="patient-bal-item">
                            <div class="patient-bal-inner" data-slideid="7" data-head="Early CKD  Patients" data-month="{{$earlyStageCkdPatientsActualMonthsJson}}" data-quarter="{{$earlyStageCkdPatientsActualQuarterJson}}" data-year="{{$earlyStageCkdPatientsActualYearJson}}">
                                <div class="pbi-top">
                                @php
                                $key = 'vals';
                                $percentage_year = App\Http\Controllers\nepanalysis\AnalysisController::calculatePercentage($earlyStageCkdPatientsActualYear,$key);
                                $percentage_month = App\Http\Controllers\nepanalysis\AnalysisController::calculatePercentage($earlyStageCkdPatientsActualMonths,$key);
                                $finalVal = App\Http\Controllers\nepanalysis\AnalysisController::svgTrendValue($earlyStageCkdPatientsActualYear,$key);
                                @endphp
                                    <div class="pbi-box">
                                        <div class="">{{$percentage_year}}% From Last Year</div>
                                        <div class="">{{$percentage_month}}% From Last Month</div>
                                    </div>
                                    <div class="pbi-box">{{isset($earlyStageCkdPatientBalanceCrMonth) ? $earlyStageCkdPatientBalanceCrMonth : 0}}</div>
                                </div>
                                <div class="pbi-bottom">
                                @php 
                                        App\Http\Controllers\nepanalysis\AnalysisController::svgTrend($finalVal->direction);
                                     @endphp
                                </div>
                            </div>
                        </div>
                        <div class="patient-bal-item">
                            <div class="patient-bal-inner" data-slideid="8" data-head="Late Stage  Patients" data-month="{{$lateStageCkdPatientsActualMonthsJson}}" data-quarter="{{$lateStageCkdPatientsActualQuarterJson}}" data-year="{{$lateStageCkdPatientsActualYearJson}}">
                                <div class="pbi-top">
                                @php
                                $key = 'vals';
                                $percentage_year = App\Http\Controllers\nepanalysis\AnalysisController::calculatePercentage($lateStageCkdPatientsActualYear,$key);
                                $percentage_month = App\Http\Controllers\nepanalysis\AnalysisController::calculatePercentage($lateStageCkdPatientsActualMonths,$key);
                                $finalVal = App\Http\Controllers\nepanalysis\AnalysisController::svgTrendValue($lateStageCkdPatientsActualYear,$key);
                                @endphp
                                    <div class="pbi-box">
                                        <div class="">{{$percentage_year}}% From Last Year</div>
                                        <div class="">{{$percentage_month}}% From Last Month</div>
                                    </div>
                                    <div class="pbi-box">{{isset($lateStageCkdPatientBalanceCrMonth) ? $lateStageCkdPatientBalanceCrMonth : 0}}</div>
                                </div>
                                <div class="pbi-bottom">
                                @php 
                                        App\Http\Controllers\nepanalysis\AnalysisController::svgTrend($finalVal->direction);
                                     @endphp
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 grid-margin stretch-card ">
                <div class="card card-shadow">
                    <h3 class="home-design1 or-clr1" data-targetcanvas="myChart6">
                     <a href="#" class="btn btn-secondary active actual-trigger margin-right-btn ">Actual</a> 
                     or
                    <a href="#" class="btn btn-secondary change-trigger margin-left-btn">Change</a>
                        <span class="graph-right-filter"> 
                            <a href="#" data-targetCanvas="myChart6" data-type="month" data-chart_type="actual" data-actual_data ="{{$activePatientsActualMonthsJson}}"   class="btn btn-secondary active activity-month">Months</a> 
                            <a href="#" data-targetCanvas="myChart6" data-type="quarter" data-chart_type="actual" data-actual_data="{{$activePatientsActualQuarterJson}}" class="btn btn-secondary activity-quarter activity-direction">Quarters</a>
                            <a href="#" data-targetCanvas="myChart6" data-type="year" data-chart_type="actual" data-actual_data="{{$activePatientsActualYearJson}}" class="btn btn-secondary activity-year">Years</a>
                        </span>
                    </h3>
                    <div class="card-body" >
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="myChart6"></canvas>
                            </div>
                        </div>
                    </div>
                </div>   
            </div>
         </div>   
    </div>
</div>

    

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
      Chart.defaults.font.family = 'Quicksand';    

    const grideHide = {
            responsive: true,
            maintainAspectRatio: false,
            scales:{
                y:{
                    beginAtZero: true,
                    grid:{
                        display: false
                    }
                }
            },
            plugins: { legend: { display: false }, }
    };

    /* active_patients_count_per_physician Start */
    const labels1 = [
        @foreach($activePatientPerPhysicians as $activePatientPerPhysician)
                '{{$activePatientPerPhysician->month_year}}',
            @endforeach
    ];

    const data1 = {
        labels: labels1,
        datasets: [{
        label: '',
        backgroundColor: 'rgb(132 45 114)',
        borderColor: 'rgb(50, 103, 155)',
        data: [
            @if(count($activePatientPerPhysicians)>0)
                @foreach($activePatientPerPhysicians as $activePatientPerPhysician)
                    {{$activePatientPerPhysician->active_patients}},
                @endforeach
            @else
                0, 10, 5, 2, 20, 30, 45, 5, 2, 20, 30, 45
            @endif
            ],
        }]
    };

    const config1 = {
        type: 'line',
        data: data1,
        options: grideHide
    };

    const myChart = new Chart(
        document.getElementById('myChart'),
        config1
    );
    /* active_patients_count_per_physician End */


    /* ESRD_patients_count_per_physician Start */
    const labels2 = [
        @foreach($esrdPatientsPerPhysicians as $esrdPatientsPerPhysician)
                '{{$esrdPatientsPerPhysician->month_year}}',
            @endforeach
    ];

    const data2 = {
        labels: labels2,
        datasets: [{
        label: '',
        backgroundColor: 'rgb(132 45 114)',
        borderColor: 'rgb(255, 131, 102)',
        data: [
            @if(count($esrdPatientsPerPhysicians)>0)
                @foreach($esrdPatientsPerPhysicians as $esrdPatientsPerPhysician)
                    {{$esrdPatientsPerPhysician->esrd_patients}},
                @endforeach
            @else
                0, 10, 5, 2, 20, 30, 45, 5, 2, 20, 30, 45
            @endif
            ],
        }]
    };

    const config2 = {
        type: 'line',
        data: data2,
        options: grideHide
    };

    const myChart2 = new Chart(
        document.getElementById('myChart2'),
        config2
    );
    /* ESRD_patients_count_per_physician End */


    /* new_patients_count_per_physician Start */
    const labels3 = [
        @foreach($newPatientsPerPhysicians as $newPatientsPerPhysician)
                '{{$newPatientsPerPhysician->month_year}}',
            @endforeach
    ];

    const data3 = {
        labels: labels3,
        datasets: [{
        label: '',
        backgroundColor: 'rgb(132 45 114)',
        borderColor: 'rgb(112, 194, 190)',
        data: [
            @if(count($newPatientsPerPhysicians)>0)
                @foreach($newPatientsPerPhysicians as $newPatientsPerPhysician)
                    {{$newPatientsPerPhysician->new_patient_count}},
                @endforeach
            @else
                0, 10, 5, 2, 20, 30, 45, 5, 2, 20, 30, 45
            @endif
            ],
        }]
    };

    const config3 = {
        type: 'line',
        data: data3,
        options: grideHide
    };

    const myChart3 = new Chart(
        document.getElementById('myChart3'),
        config3
    );
    /* new_patients_count_per_physician End */

    /* average_revenue_per_physician_per_day Start */
    const labels4 = [
        @foreach($avgRevenuePerPhysiciansperDays as $avgRevenuePerPhysiciansperDay)
                '{{$avgRevenuePerPhysiciansperDay->month_year}}',
            @endforeach
    ];

    const data4 = {
        labels: labels4,
        datasets: [{
        label: '$',
        backgroundColor: 'rgb(132 45 114)',
        borderColor: 'rgb(227, 149, 196)',
        data: [
            @if(count($avgRevenuePerPhysiciansperDays)>0)
                @foreach($avgRevenuePerPhysiciansperDays as $avgRevenuePerPhysiciansperDay)
                    {{$avgRevenuePerPhysiciansperDay->avg_income}},
                @endforeach
            @else
                0, 10, 5, 2, 20, 30, 45, 5, 2, 20, 30, 45
            @endif
            ],
        }]
    };

    const config4 = {
        type: 'line',
        data: data4,
        options: grideHide
    };

    const myChart4 = new Chart(
    document.getElementById('myChart4'),
    config4
    );
    /* average_revenue_per_physician_per_day End */


    /* average_revenue_per_visit_actual_month Start */
    const labels5 = [
        @foreach($averageRevenuePerMonths as $k => $averageRevenuePerMonth)
            @if($k>0)
                '{{$averageRevenuePerMonth->kys}}',
                @endif
            @endforeach
    ];

    const data5 = {
        labels: labels5,
        datasets: [{
            label: '$',
            backgroundColor: 'rgb(132 45 114)',
            borderColor: 'rgb(132 45 114)',
            data: [
                @if(count($averageRevenuePerMonths)>0)
                    @foreach($averageRevenuePerMonths as $k => $averageRevenuePerMonth)
                    @if($k>0)
                        {{$averageRevenuePerMonth->vals}},
                        @endif
                    @endforeach
                @else
                    0, 10, 5, 2, 20, 30, 45, 5, 2, 20, 30, 45
                @endif
                ],

        }]
    };

    const config5 = {
        type: 'line',
        data: data5,
        options: grideHide
    };

    const myChart5 = new Chart(
        document.getElementById('myChart5'),
        config5
    );
    
    /* average_revenue_per_visit_actual_month End */


    /* active_patients_count_actual_month Start */
    const labels6 = [
        @foreach($activePatientsActualMonths as $k => $activePatientsActualMonth)
            @if($k>0)
                '{{$activePatientsActualMonth->kys}}',
                @endif
            @endforeach
    ];

    const data6 = {
        labels: labels6,
        datasets: [{
        label: '',
        fill: true  ,
        tension:0.5,
        pointBackgroundColor: "#842D72",
        backgroundColor: 'rgba(227, 149, 196,0.5)',
        borderColor: 'rgb(227, 149, 196)',
        data: [
            @if(count($activePatientsActualMonths)>0)
                @foreach($activePatientsActualMonths as $k => $activePatientsActualMonth)
                @if($k>0)
                    {{$activePatientsActualMonth->vals}},
                    @endif
                @endforeach
            @else
                0, 10, 5, 2, 20, 30, 45, 5, 2, 20, 30, 45
            @endif
            ],
        }]
    };

    const config6 = {
        type: 'line',
        data: data6,
        options: {
                responsive: true,
                maintainAspectRatio: false,
                scales:{
                    x:{
                        beginAtZero: true,
                        grid:{
                            display: false
                        }
                    }
                },
                plugins: { legend: { display: false }, }
        }
    };

    const myChart6 = new Chart(
        document.getElementById('myChart6'),
        config6
    );
    
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>


$('.vertical-slider').slick({
    vertical: true,
    verticalSwiping: true,
    slidesToShow: 2,
    slidesToScroll: 1,
    prevArrow:'<button type="button" class="slick-prev pull-left"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"> <g id="Icon_feather-arrow-left-circle" data-name="Icon feather-arrow-left-circle" transform="translate(1 24) rotate(-90)"> <path id="Path_38122" data-name="Path 38122" d="M23,11.5A11.5,11.5,0,1,0,11.5,23,11.5,11.5,0,0,0,23,11.5Z" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/> <path id="Path_38123" data-name="Path 38123" d="M4.6,9.2,0,4.6,4.6,0" transform="translate(6.9 6.9)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/> <path id="Path_38124" data-name="Path 38124" d="M9.2,0H0" transform="translate(6.9 11.5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/> </g></svg></button>',
    nextArrow:'<button type="button" class="slick-next pull-right"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"> <g id="Icon_feather-arrow-left-circle" data-name="Icon feather-arrow-left-circle" transform="translate(1 24) rotate(-90)"> <path id="Path_38122" data-name="Path 38122" d="M0,11.5A11.5,11.5,0,1,1,11.5,23,11.5,11.5,0,0,1,0,11.5Z" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/> <path id="Path_38123" data-name="Path 38123" d="M0,9.2,4.6,4.6,0,0" transform="translate(11.5 6.9)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/> <path id="Path_38124" data-name="Path 38124" d="M0,0H9.2" transform="translate(6.9 11.5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/> </g></svg></button>'
});
$(".vertical-slider").on("afterChange", function (){
    console.log('Changing');

    var th = jQuery(this).find('.slide-item.slick-active .slide-item-inner');
    //filterActiveBtn(th); // Active Button Filter
    var ths = jQuery('.graph-right-filter a.active');
    // var ths = jQuery(this).closest('.home-background').find('.graph-right-filter a.active');

    
    var type = ths.attr('data-type');
    var canvas_Data = th.data(type);
    var gHead = th.data('head');
    jQuery(this).closest('.home-design1').find('.home-slide-head').html(gHead);
    console.log(canvas_Data)
    var chart_type = ths.attr('data-chart_type');
    var slide_id = th.attr('data-slideid');
    console.log(slide_id)

    updateCanvasChart(myChart5,canvas_Data,type,chart_type,'myChart5',slide_id);

});

$('.patient-bal-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    prevArrow:'<button type="button" class="slick-prev pull-left"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"> <g id="Icon_feather-arrow-left-circle" data-name="Icon feather-arrow-left-circle" transform="translate(-2 -2)"> <g id="Group_41075" data-name="Group 41075"> <path id="Path_38122" data-name="Path 38122" d="M26,14.5A11.5,11.5,0,1,1,14.5,3,11.5,11.5,0,0,1,26,14.5Z" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/> <g id="Group_41074" data-name="Group 41074"> <path id="Path_38123" data-name="Path 38123" d="M16.6,12,12,16.6l4.6,4.6" transform="translate(-2.1 -2.1)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/> <path id="Path_38124" data-name="Path 38124" d="M21.2,18H12" transform="translate(-2.1 -3.5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/> </g> </g> </g></svg></button>',
    nextArrow:'<button type="button" class="slick-next pull-right"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 25 25"> <g id="Group_41073" data-name="Group 41073" transform="translate(-642 -1150)"> <path id="Path_38122" data-name="Path 38122" d="M3,14.5A11.5,11.5,0,1,0,14.5,3,11.5,11.5,0,0,0,3,14.5Z" transform="translate(640 1148)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/> <g id="Group_41072" data-name="Group 41072"> <path id="Path_38123" data-name="Path 38123" d="M12,12l4.6,4.6L12,21.2" transform="translate(642.5 1145.9)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/> <path id="Path_38124" data-name="Path 38124" d="M12,18h9.2" transform="translate(637.9 1144.5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/> </g> </g></svg></button>'
});

$(".patient-bal-slider").on("afterChange", function (){
    console.log('Changing');

    var th = jQuery(this).find('.patient-bal-item.slick-active .patient-bal-inner');
    //filterActiveBtn(th); // Active Button Filter
    var ths = jQuery(this).closest('.home-background').find('.graph-right-filter a.active');
    
    var type = ths.attr('data-type');
    var canvas_Data = th.data(type);
    var gHead = th.data('head');
    jQuery(this).closest('.home-design1').find('.home-slide-head').html(gHead);
    console.log(canvas_Data)
    var chart_type = ths.attr('data-chart_type');
    var slide_id = th.attr('data-slideid');


    //var gHead = jQuery(this).data('head');
    //jQuery('.home-slide-head').html(gHead);
    //console.log(canvas_Data);
    //var chart_type = ths.attr('data-chart_type');

    updateCanvasChart(myChart6,canvas_Data,type,chart_type,'myChart6',slide_id);

});


// Activity Month
jQuery('body').on('click','.activity-month', function(e){
    e.preventDefault();
    var th = jQuery(this);
    filterActiveBtn(th);
    console.log(actual_month);
    var chart_type = jQuery(this).attr('data-chart_type');
    var targetCanvas = jQuery(this).attr('data-targetCanvas');
    var type = jQuery(this).attr('data-type');

    var slide_id = filterSlideId(th,targetCanvas);
   
    if(targetCanvas == 'myChart5'){
        var actual_month = jQuery('.slide-item.slick-current .slide-item-inner').data('month');
        updateCanvasChart(myChart5,actual_month,type,chart_type,targetCanvas,slide_id);
    }else if(targetCanvas == 'myChart6'){
        var actual_month = jQuery('.patient-bal-item.slick-active .patient-bal-inner').data('month');
        updateCanvasChart(myChart6,actual_month,type,chart_type,targetCanvas,slide_id);
    }
    

});

// Activity Quarter
jQuery('body').on('click','.activity-quarter', function(e){
    e.preventDefault();

    var th = jQuery(this);
    filterActiveBtn(th);
    var chart_type = jQuery(this).attr('data-chart_type');
    var targetCanvas = jQuery(this).attr('data-targetCanvas');
    var type = jQuery(this).attr('data-type');

    var slide_id = filterSlideId(th,targetCanvas);
  
    if(targetCanvas == 'myChart5'){
        var actual_quarter = jQuery('.slide-item.slick-current .slide-item-inner').data('quarter');
        updateCanvasChart(myChart5,actual_quarter,type,chart_type,targetCanvas,slide_id);
    }else if(targetCanvas == 'myChart6'){
        var actual_quarter = jQuery('.patient-bal-item.slick-active .patient-bal-inner').data('quarter');
        updateCanvasChart(myChart6,actual_quarter,type,chart_type,targetCanvas,slide_id);
    }

});

// Activity Year
jQuery('body').on('click','.activity-year', function(e){
    e.preventDefault();

    var th = jQuery(this);
    filterActiveBtn(th); // Active Button Filter

    
    var chart_type = jQuery(this).attr('data-chart_type');
    var targetCanvas = jQuery(this).attr('data-targetCanvas');
    var type = jQuery(this).attr('data-type');

    var slide_id = filterSlideId(th,targetCanvas);

    if(targetCanvas == 'myChart5'){
        var actual_year = jQuery('.slide-item.slick-current .slide-item-inner').data('year');
        updateCanvasChart(myChart5,actual_year,type,chart_type,targetCanvas,slide_id);
    }else if(targetCanvas == 'myChart6'){
        var actual_year = jQuery('.patient-bal-item.slick-active .patient-bal-inner').data('year');
        updateCanvasChart(myChart6,actual_year,type,chart_type,targetCanvas,slide_id);
    }

});


// Slider Item
jQuery('body').on('click','.slide-item-inner', function(e){
    e.preventDefault();

    var th = jQuery(this);
    var slickSlide = th.closest('.slick-slide');
    $('.slick-slide').removeClass('slick-current');
    slickSlide.addClass('slick-current');
    //filterActiveBtn(th); // Active Button Filter
    var ths = jQuery('.graph-right-filter a.active');

    
    var type = ths.attr('data-type');

    var canvas_Data = jQuery(this).data(type);
    // $('.activity-month').attr('data-actual_data',canvas_Data);
    // var canvas_Data_Quarter = jQuery(this).data('quarter');
    // $('.activity-quarter').attr('data-actual_data',canvas_Data_Quarter);
    // var canvas_Data_Year = jQuery(this).data('year');
    // $('.activity-year').attr('data-actual_data',canvas_Data_Year);
    var gHead = jQuery(this).data('head');
    jQuery('.home-slide-head').html(gHead);
    console.log(canvas_Data);
    var chart_type = ths.attr('data-chart_type');
    var slide_id = jQuery(this).attr('data-slideid');


    updateCanvasChart(myChart5,canvas_Data,type,chart_type,'myChart5',slide_id);


});


function filterActiveBtn(th){

    th.closest('.graph-right-filter').find('.btn').removeClass('active');
    th.addClass('active');

}

function filterSlideId(tha = '',targetCanvas = ''){

    if(targetCanvas== 'myChart5'){
        var th = jQuery(tha).closest('.home-background').find('.slide-item.slick-active .slide-item-inner');
        var slide_id = th.attr('data-slideid');
        return slide_id;
    }

    if(targetCanvas== 'myChart6'){
        var th = jQuery(tha).closest('.home-background').find('.patient-bal-item.slick-active .patient-bal-inner');
        var slide_id = th.attr('data-slideid');
        return slide_id;
    }

}

jQuery('.change-trigger').on('click', function(e){
    e.preventDefault();

    var graphHead = jQuery(this).closest('.home-design1');
    graphHead.find('.actual-trigger').removeClass('active');
    jQuery(this).addClass('active');
    var targetCanvas = graphHead.attr('data-targetCanvas');

    graphHead.find('.graph-right-filter a').attr('data-chart_type','change');

    //var ths = jQuery('.graph-right-filter a.active');

    var ths = jQuery(this).closest('.home-background').find('.graph-right-filter a.active');

    var slide_id = filterSlideId(jQuery(this),targetCanvas);
   
    var type = ths.attr('data-type');
    console.log(actual_data);
    var chart_type = ths.attr('data-chart_type');

    if(targetCanvas == 'myChart5'){
        var actual_data = $('.slide-item.slick-current .slide-item-inner').data(type);
        updateCanvasChart(myChart5,actual_data,type,chart_type,targetCanvas,slide_id);
    }else if(targetCanvas == 'myChart6'){
        var actual_data = $('.patient-bal-item.slick-active .patient-bal-inner').data(type);
        updateCanvasChart(myChart6,actual_data,type,chart_type,targetCanvas,slide_id);
    }

});

jQuery('.actual-trigger').on('click', function(e){
    e.preventDefault();

    var graphHead = jQuery(this).closest('.home-design1');
    jQuery(this).closest('.home-design1').find('.change-trigger').removeClass('active');
    jQuery(this).addClass('active');
    var targetCanvas = graphHead.attr('data-targetCanvas');

    graphHead.find('.graph-right-filter a').attr('data-chart_type','actual');

    //var ths = jQuery('.graph-right-filter a.active');

    var ths = jQuery(this).closest('.home-background').find('.graph-right-filter a.active');

    var slide_id = filterSlideId(jQuery(this),targetCanvas);
    
    var type = ths.attr('data-type');
    console.log(actual_data);
    var chart_type = ths.attr('data-chart_type');

    if(targetCanvas == 'myChart5'){
        var actual_data = $('.slide-item.slick-current .slide-item-inner').data(type);
        updateCanvasChart(myChart5,actual_data,type,chart_type,targetCanvas,slide_id);
    }else if(targetCanvas == 'myChart6'){
        var actual_data = $('.patient-bal-item.slick-active .patient-bal-inner').data(type);
        updateCanvasChart(myChart6,actual_data,type,chart_type,targetCanvas,slide_id);
    }
    
});


function updateCanvasChart(updateName,loop_data,loop_data_type,chart_type,targetCanvas = 'myChart5',slide_id = '0'){

    const dataVal = [];
    const labelSet = [];

    $cc = 0;
    $cc2 = 0;
    jQuery.each(loop_data, (index, item) => {

                if(loop_data_type == 'month'){
                    if(chart_type == 'change'){
                        if(index > 0){
                            var pmi = index - 1;
                            var prevMonth = loop_data[pmi].vals;
                            var curMonth = item.vals;
                                if(prevMonth !== 0){
                                var loopMonth = (curMonth - prevMonth) / prevMonth * 100;
                                }
                                else{
                                    loopMonth = 0;
                                }

                            dataVal[$cc2] = loopMonth.toString();
                            labelSet[$cc2] = item.kys.toString();
                $cc2++;    
                        }

                    }else{

                        if(index > 0){
                            dataVal[$cc2] = item.vals.toString();
                            labelSet[$cc2] = item.kys.toString();
                $cc2++;
                        }
                    }


                }else if(loop_data_type == 'quarter'){

                    if(chart_type == 'change'){
                        if(index > 0){

                            var pmi = index - 1;
                            var prevMonth = loop_data[pmi].vals;
                            var curMonth = item.vals;
                                if(prevMonth !== 0){
                                var loopMonth = (curMonth - prevMonth) / prevMonth * 100;
                                }
                                else{
                                    loopMonth = 0;
                                }

                            dataVal[$cc2] = loopMonth.toString();
                            labelSet[$cc2] = item.kys.toString();
                $cc2++;
                            
                        }

                    }else{
                        console.log(item.vals);
                        dataVal[$cc2] = item.vals.toString();
                        labelSet[$cc2] = item.kys.toString();
                $cc2++;
                    }

                }else if(loop_data_type == 'year'){

                    if(chart_type == 'change'){
                        if(index > 0){

                            var pmi = index - 1;
                            var prevMonth = loop_data[pmi].vals;
                            var curMonth = item.vals;
                                if(prevMonth !== 0){
                                var loopMonth = (curMonth - prevMonth) / prevMonth * 100;
                                }
                                else{
                                    loopMonth = 0;
                                }

                            dataVal[$cc2] = loopMonth.toString();
                            labelSet[$cc2] = item.kys.toString();
                $cc2++;
                            
                        }

                    }else{
                        console.log(item.vals);
                        dataVal[$cc2] = item.vals.toString();
                        labelSet[$cc2] = item.kys.toString();
                $cc2++;
                }

                }
                
            //}
        $cc++;
    });
    
    if(chart_type == 'change'){
        var llabel = '%';
    }else{
        var llabel = '';
    }

    //dataVal = dataVal.filter(Boolean);
    //console.log(dataVal,'hi',slide_id);
    
    if(targetCanvas == 'myChart5'){
        if(slide_id == '1'){
            if(chart_type == 'change'){
                var llabel = '%';
            }else{
                var llabel = '$';
            }

    var dataCanvas = [{
            label: '$',
            label: llabel,
            backgroundColor: 'rgb(132 45 114)',
            borderColor: 'rgb(132 45 114)',
            data: dataVal,
        }];
    }
    if(slide_id == '2'){
    var dataCanvas = [{
            label: llabel,
            backgroundColor: 'rgb(132 45 114)',
            borderColor: 'rgb(100, 124, 155)',
            data: dataVal,
        }];
    }
    if(slide_id == '3'){
    var dataCanvas = [{
            label: llabel,
            backgroundColor: 'rgb(132 45 114)',
            borderColor: 'rgb(129, 39, 76)',
            data: dataVal,
        }];
    }
    if(slide_id == '4'){
    var dataCanvas = [{
            label: llabel,
            backgroundColor: 'rgb(132 45 114)',
            borderColor: 'rgb(56, 151, 148)',
            data: dataVal,
        }];
    }
    }
    else if(targetCanvas == 'myChart6'){
    if(slide_id == '5'){
        var dataCanvas = [{
                label: llabel,
                fill: true  ,
                tension:0.5,
                pointBackgroundColor: "#842D72",
                backgroundColor: 'rgba(227, 149, 196,0.5)',
                borderColor: 'rgb(227, 149, 196)',
                data: dataVal,
            }];
    }
    if(slide_id == '6'){
    var dataCanvas = [{
            label: llabel,
            fill: true  ,
            tension:0.5,
            pointBackgroundColor: "#842D72",
            backgroundColor: 'rgba(132, 208, 202,0.5)',
            borderColor: 'rgb(132, 208, 202)',
            data: dataVal,
        }];
    }
    if(slide_id == '7'){
    var dataCanvas = [{
            label: llabel,
            fill: true  ,
            tension:0.5,
            pointBackgroundColor: "#842D72",
            backgroundColor: 'rgba(255, 131, 102,0.5)',
            borderColor: 'rgb(255, 131, 102)',
            data: dataVal,
        }];
    }
    if(slide_id == '8'){
    var dataCanvas = [{
            label: llabel,
            fill: true  ,
            tension:0.5,
            pointBackgroundColor: "#842D72",
            backgroundColor: 'rgba(132,45,114,0.5)',
            borderColor: 'rgb(132 45 114)',
            data: dataVal,
        }];
    }
    }

    updateName.data.labels = labelSet;
    updateName.data.datasets = dataCanvas;
    updateName.update();

}
</script>




@endsection

@section('after-scripts')
    {{--    {{ Html::script(asset('js/template/js/dashboard2.js')) }}--}}
    {{ Html::script(asset('js/template/js/fusioncharts.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.jqueryplugin.js')) }}
    {{ Html::script(asset('js/template/js/fusioncharts.theme.fusion.js')) }}
    @endsection