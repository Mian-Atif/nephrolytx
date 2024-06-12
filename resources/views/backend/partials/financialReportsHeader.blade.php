@section('title', 'Charges Detail Report')
<div class="reports-header">
    <h3 class="table-color text-center" style="font-weight: 600;">{{$title}}</h3>
    <h3 class="table-color text-center" style="font-weight: 600;">{{!is_null(Auth::user()->practice)?Auth::user()->practice->name:''}}</h3>
    <h3 class="table-color text-center" style="font-weight: 600;">{{\Carbon\Carbon::parse($currentMonth)->format('m/d/Y')}}-
        {{\Carbon\Carbon::parse($currentDate)->format('m/d/Y')}}</h3>
</div>