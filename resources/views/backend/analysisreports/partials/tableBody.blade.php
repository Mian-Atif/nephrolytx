<table id="order-listing" class="table table-body">

    {{-- <tr class="table-color">
         <th></th>
         <th colspan="13" style="text-align:center; font-size:18px;"> <strong> No. Of Units/Month</strong></th>
     </tr>--}}


    @if(count($cptLists))
        @foreach($cptLists as $cptList)
            @if($loop->iteration == 1)
                <thead>
                @php
                    $monthName = array_keys(collect($cptList)->toArray());
                @endphp

                <tr class="table-color">
                    <th class="font-bold">CPT Code</th>
                    @foreach($monthName as $month)
                        @if($loop->iteration > 1)
                            <th class="font-bold"> {{ $month }}</th>
                        @endif
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @endif

                @php
                    $cptList = collect($cptList)->toArray();
                @endphp


                @if($loop->iteration > 1)
                    <tr class="text-white">
                        @foreach($monthName as $month)
                            <td> {{ $cptList[$month] }}</td>

                        @endforeach

                    </tr>
                @endif



                @if($loop->iteration == count($cptLists) )
                    <tr class="text-white font-bold">
                        <th >Total</th>
                        @if($loop->iteration > 1)
                            @foreach($monthName as $month)
                                @if($loop->iteration > 1)
                                    <td> {{ array_sum(array_column($cptLists, $month)) }}</td>
                                @endif
                            @endforeach
                        @endif

                    </tr>
                @endif

                @endforeach
                </tbody>
            @endif



</table>
