<tbody class="table-body">

@if(count($patientDeductables) > 0)
    <tr class="text-white">
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>{{prettyPrice(array_sum(array_column($patientDeductables, 'deductibleAmount')))}}</th>
{{--        <th></th>--}}

    </tr>

    @foreach($patientDeductables as $patientPayment)
        <tr class="text-white">
            <td>{{$loop->iteration}}</td>
            <td>
                {{!is_null($patientPayment->Primary_Insurance_Name)?$patientPayment->Primary_Insurance_Name:'-- -- --'}}
            </td>
            <td>
                {{!is_null($patientPayment->Primary_CheckNo_ReferenceNo)?$patientPayment->Primary_CheckNo_ReferenceNo:'-- -- --'}}
            </td>
            <td>
                {{!is_null($patientPayment->dateofservice)?$patientPayment->dateofservice:'-- -- --'}}
            </td>
            <td>
                {{!is_null($patientPayment->Patient_Name)?$patientPayment->Patient_Name:'-- -- --'}}
            </td>
            <td>
                {{!is_null($patientPayment->deductibleAmount)?prettyPrice($patientPayment->deductibleAmount):'-- -- --'}}
            </td>
        </tr>

    @endforeach
@endif
</tbody>
