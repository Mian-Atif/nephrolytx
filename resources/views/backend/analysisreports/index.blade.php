@extends ('backend.layouts.dashboard')
@section('title', 'Analysis of Major Services')
@section('content-new')
    <div class="content-wrapper">
        @include('backend.partials.stats')
        {{Form::open(['route' => 'admin.analysis-of-major-services.store', 'class' => 'form', 'role' => 'form', 'method' => 'post','id'=>'searchFilter'])}}
        @include('widgets.search_filter')
        {{Form::close()}}
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Analysis of Major Services</h4>
                <div class="row">
                    <div class="col-12">
                        {{--<div class="daterange-picker-input1">
                            <input type="text"class="daterange form-control " /> <i class="fa fa-calendar calnedar-icon"  aria-hidden="true"></i>
                        </div>--}}
                        @include('backend.partials.exportReportDropdown')

                        <div class="table-responsive tableFixHead">
                            <div id="buttons"></div>
                            <table id="order-listing" class="table table-body">
                                @if(count($cptLists))
{{--                                    @dd($cptLists)--}}

                                @foreach($cptLists as $cptList)
                                    @if($loop->iteration  == 1)
                                        @php
                                            $monthName = array_keys(collect($cptList)->toArray());
                                        @endphp
                                            <thead>

                                        <tr class="table-color">
                                            <th class="font-bold">CPT Code</th>
                                            @foreach($monthName as $month)
                                                @if($loop->iteration > 1)
                                                    <th class="font-bold"> {{ $month }}</th>
                                                @endif
                                            @endforeach
                                        </tr>
                                            </thead>
                                            <tbody>
                                        @endif

                                    @php
                                        $cptList = collect($cptList)->toArray();
                                    @endphp


                                        @if($loop->iteration > 0)
                                            <tr class="text-white">
                                                @foreach($monthName as $month)
                                                    <td> {{ $cptList[$month] }}</td>

                                                @endforeach

                                            </tr>
                                            @endif



                                   @if($loop->iteration == count($cptLists) )
                                        <tr class="text-white font-bold">
                                            <th >Total</th>
                                            @if($loop->iteration > 1)
                                                @foreach($monthName as $month)
                                                    @if($loop->iteration > 1)
                                                        <td> {{ array_sum(array_column($cptLists, $month)) }}</td>
                                                    @endif
                                                @endforeach
                                            @endif

                                        </tr>
                                    @endif

                                    @endforeach
                                </tbody>
                                @endif



                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection