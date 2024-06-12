<tbody class="table-body">
@if(count($transactionAnalyses) > 0)
    @foreach($transactionAnalyses as $m => $service)
        @if(count($service) > 0)
            @php
                $insuranceGroup=$service->groupBy('Insurance_Adjustment');
            @endphp
            @if($m)
                <tr>
                    <th class="text-white" >{{ $m }}</th>
                    <th class="text-white" ></th>
                    <th class="text-white" ></th>
                    <th class="text-white" ></th>

                </tr>
            @endif
            @foreach($insuranceGroup as $ks => $rows)

                @foreach($rows as $k => $row)
                    <tr class="text-white">

                        <td></td>
                        <td>{{!is_null($row->Primary_Insurance_Name)?$row->Primary_Insurance_Name:'-- -- --'}}</td>
                        <td>{{!is_null($row->Insurance_Adjustment)?$row->Insurance_Adjustment:'-- -- --'}}</td>
                        <td>{{!is_null($row->amount)?prettyPrice($row->amount):'-- -- --'}}</td>

                    </tr>
                @endforeach
                @if($k == count($rows) - 1)
                    <tr class="text-white">
                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>
                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{$ks}}</th>
                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>
                        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice($rows->sum('amount'))}}</th>
                    </tr>
                @endif
            @endforeach
            <tr class="text-white">
                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>
                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">
                    Total for Billing Provider : {{$m}}</th>
                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>
                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice($service->sum('amount'))}}</th>
            </tr>
        @endif

    @endforeach
@endif

</tbody>
