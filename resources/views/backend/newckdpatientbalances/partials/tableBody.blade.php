<table id="order-listing" class="table table-body">
    {{--  <thead>
      <tr class="table-color">
          <th colspan="12" style="text-align:center; font-size: 15px;"> <strong> Collection Analysis/Services Location</strong></th>
      </tr>
      </thead>--}}
    @php
        $locationsWiseByLocation = collect($locationsWise)->groupBy('Service_Location');
    @endphp

    @foreach($locationsWiseByLocation as $l => $location)


        @if($loop->iteration == 1)
            <thead>
            <tr class="table-color">
                <th></th>
                @for($m = 1; $m <= 13; $m++)
                    <th class="text-center ">
                        <strong>   {{ $location[0]->{'monthNme'.$m} }}</strong></th>
                    <th></th>
                    <th></th>
                @endfor
            </tr>

            <tr class="table-color ">
                <th><strong> Location</strong></th>

                @for($m = 1; $m <= 13; $m++)
                    <th class="table-height table-header2"><strong> No of Encounters</strong></th>
                    <th class="table-height1 table-header2"><strong> Collections</strong></th>
                    <th class="table-header2"><strong> Collection/Encounter</strong></th>
                @endfor

            </tr>
            </thead>
        @endif

        <tr class="text-white">
            <td>{{ $l }}</td>
            @for($m = 1; $m <= 13; $m++)
                <td class="table-border-left"> {{ $location[0]->{'NoofPts'.$m} ? standardPrettyFormat($location[0]->{'NoofPts'.$m}) : '-- -- --' }}</td>
                <td>{{ $location[0]->{'collection'.$m} ? prettyPrice($location[0]->{'collection'.$m}) : '-- -- --' }}</td>
                <td>{{ $location[0]->{'avgCollectionPerPts'.$m} ? prettyPrice($location[0]->{'avgCollectionPerPts'.$m}) : '-- -- --' }}</td>
            @endfor

        </tr>


        @if($loop->iteration == count($locationsWiseByLocation))
            <tr class="text-white font-bold">
                <th>Total</th>
                @for($m = 1; $m <= 13; $m++)
                    <td class="table-border-left">{{standardPrettyFormat(collect($locationsWise)->sum('NoofPts'.$m)) }}</td>
                    <td>{{ prettyPrice(collect($locationsWise)->sum('collection'.$m)) }}</td>
                    <td>{{ prettyPrice(collect($locationsWise)->sum('avgCollectionPerPts'.$m))}}</td>
                @endfor
            </tr>
        @endif
    @endforeach

    {{--@php--}}
    {{--dd($locationsWise);--}}
    {{--@endphp--}}


</table>
