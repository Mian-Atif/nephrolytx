<tbody class="table-body">

@if(count($performanceReports) > 0)
    @foreach($performanceReports as $key=> $subPerformanceReport)

        <tr class="text-white">
{{--            <td>Billing Provider: Provider 1</td>--}}
            <th class="text-white">{{ $key }}</th>
            <th class="text-white"></th>
            <th class="text-white"> </th>
            <th class="text-white"></th>
            <th class="text-white"> </th>
            <th class="text-white"> </th>
        </tr>
        @foreach($subPerformanceReport as $performanceReport)

            <tr class="text-white">
                <td></td>
                <td>{{!is_null($performanceReport->Service_Location)?$performanceReport->Service_Location:''}}</td>
                <td>{{!is_null($performanceReport->patientVisit)?$performanceReport->patientVisit:'-- -- --'}}</td>
                <td>{{!is_null($performanceReport->Units)?standardPrettyFormat($performanceReport->Units):'-- -- --'}}</td>
                <td>{{!is_null($performanceReport->charges)?prettyPrice($performanceReport->charges):'-- -- --'}}</td>
                <td>{{!is_null($performanceReport->workRVU)?standardPrettyFormat($performanceReport->workRVU):'-- -- --'}}</td>
{{--                <td></td>--}}
            </tr>
        @endforeach
        <tr class="text-white">
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{$key}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{$subPerformanceReport->sum('patientVisit')}} </th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{standardPrettyFormat($subPerformanceReport->sum('Units'))}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice($subPerformanceReport->sum('charges'))}}</th>
            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{standardPrettyFormat($subPerformanceReport->sum('workRVU'))}}</th>
{{--            <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>--}}
        </tr>
    @endforeach

    <tr class="text-white">
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">Grand Totals:</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{collect($performance)->sum('patientVisit')}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{standardPrettyFormat(collect($performance)->sum('Units'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{prettyPrice(collect($performance)->sum('charges'))}}</th>
        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;">{{standardPrettyFormat(collect($performance)->sum('workRVU'))}}</th>
{{--        <th style="border-bottom: 1px solid grey; border-top: 1px solid grey;"></th>--}}
    </tr>
@endif
</tbody>
