<tbody class="table-body">
@if(count($chargeCollectionSummaries) > 0)
    @foreach($chargeCollectionSummaries as $chargeCollectionSummary)
        <tr class="text-white">
            <td>
                {{!is_null($chargeCollectionSummary->provider)?$chargeCollectionSummary->provider:'-- -- --'}}
            </td>
            <td>
                {{!is_null($chargeCollectionSummary->totalCharges)?prettyPrice($chargeCollectionSummary->totalCharges):'-- -- --'}}
            </td>
            <td>
                {{!is_null($chargeCollectionSummary->totalCollection)?prettyPrice($chargeCollectionSummary->totalCollection):'-- -- --'}}
            </td>
            <td>
                {{!is_null($chargeCollectionSummary->InsuranceCollection)?prettyPrice($chargeCollectionSummary->InsuranceCollection):'-- -- --'}}
            </td>
            <td>
                {{!is_null($chargeCollectionSummary->patientCollection)?prettyPrice($chargeCollectionSummary->patientCollection):'-- -- --'}}

            </td>
            <td>
                {{!is_null($chargeCollectionSummary->Adjustments)?prettyPrice($chargeCollectionSummary->Adjustments):'-- -- --'}}
            </td>
            <td>
                {{!is_null($chargeCollectionSummary->patientInsuranceAging)?prettyPrice($chargeCollectionSummary->patientInsuranceAging):'-- -- --'}}
            </td>
        </tr>
    @endforeach
    <tr class="text-white">
        <th>Total</th>
        <th>{{prettyPrice(array_sum(array_column($chargeCollectionSummaries, 'totalCharges')))}}</th>
        <th>{{prettyPrice(array_sum(array_column($chargeCollectionSummaries, 'totalCollection')))}}</th>
        <th>{{prettyPrice(array_sum(array_column($chargeCollectionSummaries, 'InsuranceCollection')))}}</th>
        <th>{{prettyPrice(array_sum(array_column($chargeCollectionSummaries, 'patientCollection')))}}</th>
        <th>{{prettyPrice(array_sum(array_column($chargeCollectionSummaries, 'Adjustments')))}}</th>
        <th>{{prettyPrice(array_sum(array_column($chargeCollectionSummaries, 'patientInsuranceAging')))}}</th>
    </tr>
@endif
</tbody>
