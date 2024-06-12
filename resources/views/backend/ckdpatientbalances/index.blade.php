@extends ('backend.layouts.dashboard')
@section('content-new')

<div class="content-wrapper">
    @include('backend.partials.stats')


    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Payer Details</h4>
            <div class="row">
                <div class="col-12">
                    <div class="daterange-picker-input">
                        <input type="text" class="daterange form-control " /> <i class="fa fa-calendar" style="position: absolute;
                        right: 10px;
                        bottom: 10px;" aria-hidden="true"></i>
                    </div>
                    <div class="table-responsive tableFixHead">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr class="table-color">
                                    <th>Patient Type</th>
                                    <th>Active Patient</th>
                                    <th class="table-height">No of Claims</th>
                                    <th class="table-height1">Paid Claims</th>
                                    <th>Claims Open</th>
                                    <th>Charge Amount (Paid Claims)</th>
                                    <th>Collections</th>
                                    <th>Bench Mark</th>
                                    <th>Variance</th>
                                    <th>Collection %age</th>
                                    <th>Avg Collection/Claim</th>
                                    <th>Open Balance</th>
                                </tr>
                            </thead>

                            <tbody>
                            @if(count($payers))
                            @foreach($payers as  $keys => $payer)
                                <tr class="table-color">
                                    <th style="text-align:center; font-size:18px;" colspan="12">
                                        <strong>{{!is_null($payer->first()->Primary_Insurance_Name)?ucfirst($payer->first()->Primary_Insurance_Name):''}}
                                             </strong>
                                    </th>
                                </tr>
                                @foreach($payer as $keys => $payerList)
                                <tr class="text-white">
                                    <td>{{!is_null($payerList->pType)?$payerList->pType:'-- -- --'}}</td>
                                    <td>{{!is_null($payerList->activePatient)?$payerList->activePatient:'-- -- --'}}</td>
                                    <td>{{!is_null($payerList->noofclaim)?$payerList->noofclaim:'-- -- --'}} </td>
                                    <td>{{!is_null($payerList->claimProcessed)?$payerList->claimProcessed:'-- -- --'}}</td>
                                    <td>{{!is_null($payerList->claimOpen)?$payerList->claimOpen:'-- -- --'}}</td>
                                    <td>{{!is_null($payerList->chargeAmountProcessed)?prettyPrice($payerList->chargeAmountProcessed):'-- -- --'}}</td>
                                    <td>{{!is_null($payerList->Collection)?prettyPrice($payerList->Collection):'-- -- --'}}</td>
                                    <td>{{!is_null($payerList->benchmarks)?prettyPrice($payerList->benchmarks):'-- -- --'}}</td>
                                    <td>{{!is_null($payerList->varience)?prettyPrice($payerList->varience):'-- -- --'}}</td>
                                    <td>{{!is_null($payerList->collectionPercentage)?truncate_number($payerList->collectionPercentage):'-- -- --'}}</td>
                                    <td>{{!is_null($payerList->perUnitAvgCollection)?prettyPrice($payerList->perUnitAvgCollection):'-- -- --'}}</td>
                                    <td>{{!is_null($payerList->openBalance)?prettyPrice($payerList->openBalance):'-- -- --'}}</td>
                                </tr>
                                @endforeach
                                <tr class="text-white">
                                    <th>TOTAL </th>
                                    <th>{{$payer->sum('activePatient')}}</th>
                                    <th>{{$payer->sum('noofclaim')}}</th>
                                    <th>{{$payer->sum('claimProcessed')}}</th>
                                    <th>{{$payer->sum('claimOpen')}}</th>
                                    <th>{{prettyPrice($payer->sum('chargeAmountProcessed'))}}</th>
                                    <th>{{prettyPrice($payer->sum('Collection'))}}</th>
                                    <th>{{prettyPrice($payer->sum('benchmarks'))}}</th>
                                    <th>{{prettyPrice($payer->sum('varience'))}}</th>
                                    <th>{{truncate_number($payer->sum('collectionPercentage'))}}</th>
                                    <th>{{prettyPrice($payer->sum('perUnitAvgCollection'))}}</th>
                                    <th>{{prettyPrice($payer->sum('openBalance'))}}</th>
                                </tr>

                                @endforeach
                            @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection