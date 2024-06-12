<tbody class="table-body">
@if(count($chequeReconciliationDetails) > 0)
    <tr class="text-white">
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>{{prettyPrice(array_sum(array_column($chequeReconciliationDetails, 'chequeAmount')))}}</th>
        <th>{{prettyPrice(array_sum(array_column($chequeReconciliationDetails, 'postedAmount')))}}</th>
        <th></th>
{{--        <th></th>--}}
    </tr>

    @foreach($chequeReconciliationDetails as $chequeReconciliationDetail)
        <tr class="text-white">
            <td>{{$loop->iteration}}</td>
            <td>
                {{!is_null($chequeReconciliationDetail->insurance)?$chequeReconciliationDetail->insurance:'-- -- --'}}
            </td>
            <td>
                {{!is_null($chequeReconciliationDetail->chequeNo)?$chequeReconciliationDetail->chequeNo:'-- -- --'}}
            </td>
            <td>
                {{!is_null($chequeReconciliationDetail->chequeDate)?$chequeReconciliationDetail->chequeDate:'-- -- --'}}
            </td>
            <td>
                {{!is_null($chequeReconciliationDetail->chequeAmount)?prettyPrice($chequeReconciliationDetail->chequeAmount):'-- -- --'}}
            </td>
            <td>
                {{!is_null($chequeReconciliationDetail->postedAmount)?prettyPrice($chequeReconciliationDetail->postedAmount):'-- -- --'}}

            </td>
            <td>
                {{!is_null($chequeReconciliationDetail->Remarks)?$chequeReconciliationDetail->Remarks:'-- -- --'}}
            </td>

        </tr>

    @endforeach
@endif
</tbody>
