@extends ('backend.layouts.dashboard')
@section('title', 'Analysis by Provider')
@section('content-new')

<div class="content-wrapper">
    @include('backend.partials.stats')
    {{ Form::open(['route' => 'admin.collection-analysis.store', 'class' => 'form', 'role' => 'form', 'method' => 'post', 'id'=>'searchFilter']) }}
    @include('widgets.search_filter')

    {{ Form::close() }}
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Analysis by Provider</h4>
            <div class="row">
                <div class="col-12">
                    @include('backend.partials.exportReportDropdown')

                    <div class="table-responsive tableFixHead">
                        <div id="buttons"></div>

                        <table id="order-listing" class="table table-body">

                        @if(isset($esrdPatientBalance))
                            @foreach($esrdPatientBalance as $l => $esrd)


                                @if($loop->iteration == 1)
                                <thead>
                                    <tr class="table-color">
                                        <th></th>
                                        @for($m = 1; $m <= 13; $m++)
                                            <th class="text-center">
                                              <strong>  {{ $esrd->{'monthNme'.$m} }}</strong>
                                            </th>
                                            <th></th>
                                            <th></th>
                                        @endfor
                                    </tr>
                                    </thead>
                                    <thead>
                                    <tr class="table-color">
                                        <th><strong>Provider</strong> </th>

                                        @for($m = 1; $m <= 13; $m++)
                                            <th class="table-height table-header2"><strong>No of Encounters</strong> </th>
                                            <th class="table-height1 table-header2"><strong>Collections</strong> </th>
                                            <th class="table-header2"><strong> Collection/Encounter</strong></th>
                                        @endfor

                                    </tr>
                                    </thead>
                                @endif

                                <tr class="text-white">
                                    <td>{{  $esrd->provider }}</td>
                                    @for($m = 1; $m <= 13; $m++)

                                        <td class="table-border-left">  {{ $esrd->{'NoofPts'.$m} ?standardPrettyFormat($esrd->{'NoofPts'.$m}) : '-- -- --' }}</td>
                                        <td>  {{ $esrd->{'collection'.$m} ? prettyPrice($esrd->{'collection'.$m}) : '-- -- --' }}</td>
                                        <td> {{ $esrd->{'avgCollectionPerPts'.$m} ? prettyPrice($esrd->{'avgCollectionPerPts'.$m}) : '-- -- --' }}</td>
                                    @endfor
                                </tr>

                                @if($loop->iteration == count($esrdPatientBalance))
                                    <tr class="text-white font-bold">
                                        <th>Total</th>
                                        @for($m = 1; $m <= 13; $m++)
                                            <td class="table-border-left">{{standardPrettyFormat(collect($esrdPatientBalance)->sum('NoofPts'.$m)) }}</td>
                                            <td>{{ prettyPrice(collect($esrdPatientBalance)->sum('collection'.$m)) }}</td>
                                            <td>{{ prettyPrice(collect($esrdPatientBalance)->sum('avgCollectionPerPts'.$m))}}</td>
                                        @endfor
                                    </tr>
                                @endif
                            @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection