<tbody class="table-body">

@if(count($chargeDetails) > 0)
    @foreach($chargeDetails as $chargeDetail)
        <tr class="text-white">
            <td>{{$loop->iteration}}</td>
            <td>
                {{!is_null($chargeDetail->Patient_Name)?$chargeDetail->Patient_Name:'-- -- --'}}
            </td>
            <td>
                {{!is_null($chargeDetail->Date_of_Service)?(\Carbon\Carbon::parse($chargeDetail->Date_of_Service)->format('m/d/Y')):'-- -- --'}}
            </td>
            <td>
                {{!is_null($chargeDetail->Service_Location)?$chargeDetail->Service_Location:'-- -- --'}}
            </td>
            <td>
                {{!is_null($chargeDetail->serviceName)?$chargeDetail->serviceName:'-- -- --'}}
            </td>
            <td>
              {{ !is_null($chargeDetail->Rendering_Provider)?$chargeDetail->Rendering_Provider:'-- -- --'}}

            </td>
            <td>
                {{!is_null($chargeDetail->Primary_Insurance_Name)?$chargeDetail->Primary_Insurance_Name:'-- -- --'}}
            </td>
            <td>
                {{!is_null($chargeDetail->ClaimID)?$chargeDetail->ClaimID:'-- -- --'}}
            </td>
            <td>
                {{!is_null($chargeDetail->cptcode)?$chargeDetail->cptcode:'-- -- --'}}
            </td>
            <td>
                {{!is_null($chargeDetail->Billed_Amount)?prettyPrice($chargeDetail->Billed_Amount):'-- -- --'}}
            </td>
        </tr>

    @endforeach
    <tr class="text-white">
        <th>Total</th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th> {{ prettyPrice(array_sum(array_column($chargeDetails, 'Billed_Amount'))) }}</th>
    </tr>
@endif
</tbody>