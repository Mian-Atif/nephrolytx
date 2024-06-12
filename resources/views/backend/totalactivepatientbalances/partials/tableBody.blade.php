<tbody class="table-body">
@php
    $totalCount= count($analysisReports);
    $clamsTotal = 0;
    $totalChargeAmount = 0;
    $actualCollection = 0;
    $projectCollection= 0;
    $totalVarience = 0;
    $collectionPercentage = 0;
    $totalContractualAdj = 0;
@endphp
@if(count($analysisReports) > 0)
    @foreach($analysisReports as $analysisReport)
        @php
            $clamsTotal += !is_null($analysisReport->No_Of_Claims)?truncate_number($analysisReport->No_Of_Claims):0.00;
            $totalChargeAmount += !is_null($analysisReport->Total_Charges_Amount)?truncate_number($analysisReport->Total_Charges_Amount):0.00;
            $actualCollection += !is_null($analysisReport->Actual_Collection)?truncate_number($analysisReport->Actual_Collection):0.00;
            $projectCollection+= !is_null($analysisReport->Projected_Collection)?truncate_number($analysisReport->Projected_Collection):0.00;
            $totalVarience += !is_null($analysisReport->Varience)?truncate_number($analysisReport->Varience):0.00;
            $collectionPercentage += !is_null($analysisReport->Collection_age)?truncate_number($analysisReport->Collection_age):0.00;
            $totalContractualAdj += !is_null($analysisReport->Contractual_Adj)?truncate_number($analysisReport->Contractual_Adj):0.00;
        @endphp
        <tr class="text-white">

            <td>
                {{!is_null($analysisReport->MONTH)?$analysisReport->MONTH:'-- -- --'}}
            </td>
            <td>
                {{!is_null($analysisReport->No_Of_Claims)?truncate_number($analysisReport->No_Of_Claims):0.00}}

            </td>
            <td>
                {{!is_null($analysisReport->Total_Charges_Amount)?prettyPrice($analysisReport->Total_Charges_Amount):0.00}}
            </td>
            <td>
                {{!is_null($analysisReport->Actual_Collection)?prettyPrice($analysisReport->Actual_Collection):0.00}}
            </td>
            <td>
                {{!is_null($analysisReport->Projected_Collection)?prettyPrice($analysisReport->Projected_Collection):0.00}}

            </td>
            <td>
                {{!is_null($analysisReport->Varience)?prettyPrice($analysisReport->Varience):0.00}}
            </td>
            <td>
                {{!is_null($analysisReport->Collection_age)?truncate_number($analysisReport->Collection_age):0.00}}
            </td>
            <td>
                {{!is_null($analysisReport->Contractual_Adj)?prettyPrice($analysisReport->Contractual_Adj):0.00}}
            </td>
        </tr>

    @endforeach
    <tr class="text-white" style="font-weight: bold;">
        <td>
            Total
        </td>
        <td>
            {{$clamsTotal}}

        </td>
        <td>
            {{prettyPrice($totalChargeAmount)}}
        </td>
        <td>
            {{prettyPrice($actualCollection)}}

        </td>
        <td>
            {{prettyPrice($projectCollection)}}
        </td>
        <td>
            {{prettyPrice($totalVarience)}}
        </td>
        <td>
            -- -- --
        </td>

        <td>
            {{prettyPrice($totalContractualAdj)}}
        </td>
    </tr>
    <tr class="text-white" style="font-weight: bold;">
        <td>
            Average
        </td>
        <td>
            {{truncate_number($clamsTotal/ $totalCount)}}

        </td>
        <td>
            {{prettyPrice($totalChargeAmount/$totalCount)}}
        </td>
        <td>
            {{prettyPrice($actualCollection/$totalCount)}}

        </td>
        <td>
            {{prettyPrice($projectCollection/$totalCount)}}
        </td>
        <td>
            {{prettyPrice($totalVarience/$totalCount)}}
        </td>
        <td>
            {{truncate_number($collectionPercentage/$totalCount)}}
        </td>

        <td>
            {{prettyPrice($totalContractualAdj/$totalCount)}}
        </td>

    </tr>
@endif
</tbody>