<tbody class="table-body">
@if(count($productivityAnalysis)>0)
    @foreach($productivityAnalysis as $key=> $productivity)
        @if($key)
            <tr>
          <th class="text-white"></th>
           <th class="text-white">{{ $key }}</th>
           <th class="text-white"></th>
           <th class="text-white"></th>
           <th class="text-white"></th>
           <th class="text-white"></th>
           <th class="text-white"></th>
           <th class="text-white"></th>
           <th class="text-white"></th>
           <th class="text-white"></th>
           <th class="text-white"></th>
           <th class="text-white"></th>
            </tr>
        @endif
        @foreach($productivity as $row)
            <tr class="text-white">
                <td>
                    {{!is_null($row->Service_Location)?$row->Service_Location:'-- -- --'}}
                </td>
                <td>
                    {{normalPrettyPrice2(!is_null($row->units)?$row->units:0)}}
                </td>
                <td>
                    {{normalPrettyPrice2(!is_null($row->rvus)?$row->rvus:0)}}
                </td>
                <td>
                    {{prettyPrice(!is_null($row->charges)?$row->charges:0)}}
                </td>
                <td>
                    {{prettyPricePercent(!is_null($row->charges)?(truncate_number($row->charges/($chargeTotal > 0 ? $chargeTotal : 1)*100)):0)}}
                </td>
                <td>
                    {{prettyPrice(!is_null($row->payments)?$row->payments:0)}}
                </td>
                <td>
                    {{prettyPricePercent(!is_null($row->payments)?(truncate_number($row->payments/($paymentTotal > 0 ? $paymentTotal : 1)*100)):0)}}</td>
                <td>
                    {{prettyPrice(!is_null($row->refunds)?$row->refunds:0)}}
                </td>
                <td>
                    {{prettyPrice(!is_null($row->adjustment)?$row->adjustment:0)}}
                </td>
                <td>
                    {{prettyPrice(!is_null($row->transOouIn)?$row->transOouIn:0)}}
                </td>
                <td>
                    {{prettyPrice(!is_null($row->net)?$row->net:0)}}
                </td>
            </tr>
            <tr class="text-white">
                {{--            @if($key)--}}
                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Total For {{ $key }}</th>
                {{--            @endif--}}
                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{normalPrettyPrice2($productivity->sum('units'))}}</th>
                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2($productivity->sum('rvus'))}}</th>
                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPrice($productivity->sum('charges'))}}</th>
                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPricePercent(truncate_number($productivity->sum('charges')/($chargeTotal > 0 ? $chargeTotal : 1)*100))}}</th>
                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPrice($productivity->sum('payments'))}}</th>
                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPricePercent(truncate_number($productivity->sum('payments')/($paymentTotal > 0 ? $paymentTotal : 1)*100))}}</th>
                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">  {{prettyPrice($productivity->sum('refunds'))}}</th>
                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">  {{prettyPrice($productivity->sum('adjustment'))}}</th>
                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">  {{prettyPrice($productivity->sum('transOouIn'))}}</th>
                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">  {{prettyPrice($productivity->sum('net'))}}</th>
            </tr>
        @endforeach

    @endforeach
    <tr class="text-white">
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Grand Total</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{normalPrettyPrice2(collect($productivities)->sum('units'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($productivities)->sum('rvus'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPrice(collect($productivities)->sum('charges'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPricePercent(truncate_number(collect($productivities)->sum('charges')/($chargeTotal > 0 ? $chargeTotal : 1)*100))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPrice(collect($productivities)->sum('payments'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPricePercent(truncate_number(collect($productivities)->sum('payments')/($paymentTotal > 0 ? $paymentTotal : 1)*100))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">  {{prettyPrice(collect($productivities)->sum('refunds'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">  {{prettyPrice(collect($productivities)->sum('adjustment'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">  {{prettyPrice(collect($productivities)->sum('transOouIn'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">  {{prettyPrice(collect($productivities)->sum('net'))}}</th>
    </tr>
@endif
</tbody>
