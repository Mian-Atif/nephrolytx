<tbody class="table-body">
@if(count($analysisInsurances)>0)
    @foreach($analysisInsurances as $analysisInsurance)
        <tr class="text-white">
            <td>{{!is_null($analysisInsurance->insuranceName)?$analysisInsurance->insuranceName:'-- -- --'}}</td>
            <td>{{prettyPrice(!is_null($analysisInsurance->prevAR)?$analysisInsurance->prevAR:0)}}</td>
            <td>{{prettyPrice(!is_null($analysisInsurance->charges)?$analysisInsurance->charges:0)}}
                <br>
                {{prettyPricePercent(!is_null($analysisInsurance->charges)?(truncate_number($analysisInsurance->charges/($chargeTotal > 0 ? $chargeTotal : 1)*100)):0)}}
            </td>
            <td>{{prettyPrice(!is_null($analysisInsurance->payments)?$analysisInsurance->payments:0)}}
                <br>
                {{prettyPricePercent(!is_null($analysisInsurance->payments)?(truncate_number($analysisInsurance->payments/($paymentTotal > 0 ? $paymentTotal : 1)*100)):0)}}
            </td>
            <td>{{prettyPrice(!is_null($analysisInsurance->refund)?$analysisInsurance->refund:0)}}</td>
            <td>{{prettyPrice(!is_null($analysisInsurance->adjustment)?$analysisInsurance->adjustment:0)}}</td>
            <td>{{prettyPrice(!is_null($analysisInsurance->trans_out)?$analysisInsurance->trans_out:0)}}</td>
            <td>{{prettyPrice(!is_null($analysisInsurance->trnas_in)?$analysisInsurance->trnas_in:0)}}</td>
            <td>{{prettyPrice(!is_null($analysisInsurance->newAR)?$analysisInsurance->newAR:0)}}</td>
        </tr>
    @endforeach

    <tr class="text-white">
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Grand Total</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisInsurances)->sum('prevAR'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(!is_null($chargeTotal)?$chargeTotal:0)}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(!is_null($paymentTotal)?$paymentTotal:0)}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisInsurances)->sum('refund'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisInsurances)->sum('adjustment'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisInsurances)->sum('trans_out'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisInsurances)->sum('trnas_in'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($analysisInsurances)->sum('newAR'))}}</th>
    </tr>
@endif
</tbody>
