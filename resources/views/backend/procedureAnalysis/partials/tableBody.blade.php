<tbody class="table-body">
@if(count($procedureAnalysis)>0)
    @foreach($procedureAnalysis as $key => $procedures)
        @if($key)
            <tr>
                <th class="text-white">{{ $key }}</th>
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
        @foreach($procedures as $row)
            <tr class="text-white">
                <td>
                    Totals for Procedure Code
                    {{!is_null($row->cptcode)?$row->cptcode:0}}
                    <br>
                    Description: {{!is_null($row->cptcode_description)?$row->cptcode_description:'-- -- --'}}
                </td>
                <td>
                    {{normalPrettyPrice2(!is_null($row->units)?$row->units:0)}}
                </td>
                <td>
                    {{prettyPricePercent(!is_null($row->units)?(truncate_number($row->units/($unitTotal > 0 ? $unitTotal : 1)*100)):0)}}

                </td>
                <td>
                    {{normalPrettyPrice2(!is_null($row->workRVUs)?$row->workRVUs:0)}}

                </td>
                <td>
                    {{normalPrettyPrice2(!is_null($row->pracRVUs)?$row->pracRVUs:0)}}
                </td>
                <td>
                    {{normalPrettyPrice2(!is_null($row->malpractRVUs)?$row->malpractRVUs:0)}}

                </td>
                <td>
                    {{normalPrettyPrice2(!is_null($row->totalRVUs)?$row->totalRVUs:0)}}

                </td>
                <td>
                    {{prettyPrice(!is_null($row->charges)?$row->charges:0)}}

                </td>
                <td>
                    {{prettyPricePercent(!is_null($row->charges)?(truncate_number($row->charges/($chargeTotal > 0 ? $chargeTotal : 1)*100)):0)}}

                </td>

            </tr>


        @endforeach

        <tr class="text-white">
            @if($key)
                <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">
                    Total for {{ $key }}</th>
            @endif
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($procedures)->sum('units'))}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{prettyPricePercent((truncate_number(collect($procedures)->sum('units')/($unitTotal > 0 ? $unitTotal : 1)*100)))}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($procedures)->sum('workRVUs'))}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($procedures)->sum('pracRVUs'))}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($procedures)->sum('malpractRVUs'))}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{normalPrettyPrice2(collect($procedures)->sum('totalRVUs'))}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($procedures)->sum('charges'))}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPricePercent(truncate_number($chargeTotal/($chargeTotal > 0 ? $chargeTotal : 1)*100))}}</th>
        </tr>
    @endforeach
    <tr class="text-white">
        @if($key)
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Grand
                Total
            </th>
        @endif
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($frProcedures)->sum('units'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">-- --
            --
        </th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($frProcedures)->sum('workRVUs'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($frProcedures)->sum('pracRVUs'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"> {{normalPrettyPrice2(collect($frProcedures)->sum('malpractRVUs'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{normalPrettyPrice2(collect($frProcedures)->sum('totalRVUs'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($frProcedures)->sum('charges'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">-- --
            --
        </th>

    </tr>
@endif

</tbody>
