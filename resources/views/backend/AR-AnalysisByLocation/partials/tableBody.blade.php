<tbody class="table-body">
@if(count($analysisLocations)>0)
    @foreach($analysisLocations as $analysisLocation )
        <tr class="text-white">
            <td>
                {{!is_null($analysisLocation->locationName)?$analysisLocation->locationName:'-- -- --'}}</td>
            <td>{{prettyPrice(!is_null($analysisLocation->prevAR)?$analysisLocation->prevAR:0)}}</td>
            <td>{{prettyPrice(!is_null($analysisLocation->charges)?$analysisLocation->charges:0)}}
                <br>
                {{prettyPricePercent(!is_null($analysisLocation->charges)?(truncate_number($analysisLocation->charges/($chargeTotal > 0 ? $chargeTotal : 1)*100)):0)}}
            </td>
            <td>{{prettyPrice(!is_null($analysisLocation->payments)?$analysisLocation->payments:0)}}
                <br>
                {{prettyPricePercent(!is_null($analysisLocation->payments)?(truncate_number($analysisLocation->payments/($paymentTotal > 0 ? $paymentTotal : 1)*100)):0)}}
            </td>
            <td>{{prettyPrice(!is_null($analysisLocation->refund)?$analysisLocation->refund:0)}}</td>
            <td>{{prettyPrice(!is_null($analysisLocation->adjustment)?$analysisLocation->adjustment:0)}}</td>
            <td>{{prettyPrice(!is_null($analysisLocation->trans_out)?$analysisLocation->trans_out:0)}}</td>
            <td>{{prettyPrice(!is_null($analysisLocation->trnas_in)?$analysisLocation->trnas_in:0)}}</td>
            <td>{{prettyPrice(!is_null($analysisLocation->newAR)?$analysisLocation->newAR:0)}}</td>
        </tr>
    @endforeach
    <tr class="text-white">
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Grand Total</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisLocations)->sum('prevAR'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPrice(collect($analysisLocations)->sum('charges'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisLocations)->sum('payments'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisLocations)->sum('refund'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisLocations)->sum('adjustment'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisLocations)->sum('trans_out'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisLocations)->sum('trnas_in'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisLocations)->sum('newAR'))}}</th>

    </tr>
@endif
</tbody>
