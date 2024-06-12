<tbody class="table-body">
@if(count($patientPayments) > 0)
    <tr class="text-white">
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>{{prettyPrice(array_sum(array_column($patientPayments, 'Patient_Payment')))}}</th>
        <th></th>
{{--        <th></th>--}}
    </tr>

    @foreach($patientPayments as $patientPayment)
        <tr class="text-white">
            <td>{{$loop->iteration}}</td>
            <td>
                {{!is_null($patientPayment->claimID)?$patientPayment->claimID:'-- -- --'}}
            </td>
            <td>
                {{!is_null($patientPayment->Patient_Name)?$patientPayment->Patient_Name:'-- -- --'}}
            </td>
            <td>
                {{!is_null($patientPayment->dateofservice)?$patientPayment->dateofservice:'-- -- --'}}
            </td>
            <td>
                {{!is_null($patientPayment->reference)?$patientPayment->reference:'-- -- --'}}
            </td>
            <td>
                {{!is_null($patientPayment->category)?$patientPayment->category:'-- -- --'}}
            </td>
            <td>
                {{!is_null($patientPayment->postingDate)?$patientPayment->postingDate:'-- -- --'}}
            </td>
            <td>
                {{!is_null($patientPayment->paymentDate)?$patientPayment->paymentDate:'-- -- --'}}
            </td>
            <td>
                {{!is_null($patientPayment->Patient_Payment)?prettyPrice($patientPayment->Patient_Payment):'-- -- --'}}

            </td>
            <td>
                {{isset($patientPayment->Remarks)?$patientPayment->Remarks:'-- -- --'}}
            </td>

        </tr>

    @endforeach
@endif
</tbody>
