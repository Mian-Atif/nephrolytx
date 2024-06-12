@extends ('backend.layouts.dashboard')
@section('title', 'Analysis By Service Type')
@section('content-new')
<div class="content-wrapper">
    @include('backend.partials.stats')
    {{Form::open(['route' => 'admin.analysis-by-service-type.store', 'class' => 'form', 'role' => 'form', 'method' => 'post','id'=>'searchFilter' ])}}
    @include('widgets.search_filter')

    {{Form::close()}}

                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Analysis by Service Type</h4>
                        <div class="row">
                            <div class="col-12">
                               {{-- <div class="daterange-picker-input1">
                                <input type="text"class="daterange form-control " /> <i class="fa fa-calendar calnedar-icon" aria-hidden="true"></i>
                            </div>--}}
                                @include('backend.partials.exportReportDropdown')

                                <div class="table-responsive tableFixHead">
                                    <div id="buttons"></div>

                                    <table id="order-listing" class="table">
{{--                                    <thead>--}}
                                  {{--  <tr class="table-color">
                                    <th></th>
                                    <th style="text-align:center; font-size:18px;"> <strong> Units Per Month</strong></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>

                                    </tr>--}}
{{--                                    </thead>--}}
                                        <thead>
                                        <tr class="table-color">
                                            <th><strong> Month</strong></th>
                                            <th><strong>Service Type</strong> </th>
                                            <th><strong> Billed Units</strong></th>
                                            <th><strong> Charge Amount</strong> </th>
                                            <th><strong> Paid Units</strong></th>
                                            <th><strong> Open Units </strong></th>
                                            <th><strong> Collection</strong></th>
                                            <th><strong> Open Balance</strong></th>
                                            <th><strong> Avg Collection/Unit</strong> </th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-body">
                                        @if(count($servicesAnalysis) > 0)
                                            @foreach($servicesAnalysis as $m => $service)
                                                    @if(count($service) > 0)
                                                        @foreach($service as $k => $row)
                                                            <tr class="text-white">
                                                            @if($k == 0)
                                                                <th >{{ $m }}</th>
                                                               @else
                                                            <td></td>
                                                                @endif
                                                            <td>{{$row->serviceName}}</td>
                                                            <td >{{normalPrettyPrice2($row->BilledUnits)}}</td>
                                                            <td >{{prettyPrice($row->chargeAmount)}}</td>
                                                            <td >{{normalPrettyPrice2($row->ProcessedUnits)}}</td>
                                                            <td >{{normalPrettyPrice2($row->openUnits)}}</td>
                                                            <td >{{prettyPrice($row->collection)}}</td>
                                                             <td >{{prettyPrice($row->openBalance)}}</td>
                                                            <td>{{prettyPrice($row->AvgCollectionPerUnit)}}</td>
                                                            </tr>

                                                            @if($k == count($service) - 1)
                                                            <tr class="text-white">
                                                                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>
                                                                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Total</th>
                                                                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{normalPrettyPrice2(collect($service)->sum('BilledUnits'))}}</th>
                                                                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;" >{{prettyPrice(collect($service)->sum('chargeAmount'))}}</th>
                                                                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;" >{{normalPrettyPrice2(collect($service)->sum('ProcessedUnits'))}}</th>
                                                                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;" >{{normalPrettyPrice2(collect($service)->sum('openUnits'))}}</th>
                                                                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;" >{{prettyPrice(collect($service)->sum('collection'))}}</th>
                                                                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;" >{{prettyPrice(collect($service)->sum('openBalance'))}}</th>
                                                                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;" >{{prettyPrice(collect($service)->sum('AvgCollectionPerUnit'))}}</th>
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                             @endforeach
                                            @endif

                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

@endsection