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
