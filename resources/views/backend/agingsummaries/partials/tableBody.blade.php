<tbody class="table-body">

@if(count($agingSummaries) > 0)
    @foreach($agingSummaries as $agingSummary)
        <tr class="text-white">
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Grand Total</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(!is_null($agingSummary->prevAR)?$agingSummary->prevAR:0)}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPrice(!is_null($agingSummary->charges)?$agingSummary->charges:0)}}<br/>
                {{prettyPricePercent(!is_null($agingSummary->charges)?(truncate_number($agingSummary->charges/($grandTotal > 0 ? $grandTotal : 1)*100)):0)}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(!is_null($agingSummary->payments)?$agingSummary->payments:0)}}<br/>
                {{prettyPricePercent(!is_null($agingSummary->paymentPercentage)?$agingSummary->paymentPercentage:0)}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(!is_null($agingSummary->refunds)?$agingSummary->refunds:0)}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(!is_null($agingSummary->adjustment)?$agingSummary->adjustment:0)}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(!is_null($agingSummary->trans_out)?$agingSummary->trans_out:0)}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(!is_null($agingSummary->trnas_in)?$agingSummary->trnas_in:0)}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPrice(!is_null($agingSummary->newAR)?$agingSummary->newAR:0)}}</th>


        </tr>

    @endforeach
@endif
</tbody>
