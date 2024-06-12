@php
    use App\Models\Practice\Practice;use Illuminate\Support\Facades\Auth;use Illuminate\Support\Facades\DB;
    $user = Auth::user();
    $practice_id = $user->practice_id;
    $payers=DB::table('practice_payers')
    ->where('practice_id',$practice_id)
    ->get();


    if ($user->roles()->first()->name == 'Practice User') {
       /* $person = $user->person;
        $providers = $person->doctors;
        $locations = $person->locations;*/
        $practice = Practice::find($practice_id);
        $providers = $practice->getDotorsdata;
        $locations = $practice->getLocationdata;
    } else {
        $practice = Practice::find($practice_id);
        $providers = $practice->getDotorsdata;
        $locations = $practice->getLocationdata;
    }
@endphp


<div class="row">
    <div class="col-md-3">
        <select name="provider" id="provider" class="form-control">
            <option value="">All Providers</option>
            @if($providers->count())
                @foreach($providers as $provider)
                    <option value="{{ $provider->person->middle_name  }}">{{ $provider->person->middle_name  }}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="col-md-3">
        <select name="location" id="location" class="form-control">
            <option value="">All Locations</option>
            @if($locations->count())
                @foreach($locations as $location)
                    <option value="{{ $location->location_name  }}">{{ $location->location_name  }}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="col-md-3">
        <select name="payer" id="payer" class="form-control">
            <option value="">All Insurances</option>
            @if($payers->count())
                @foreach($payers as $payer)
                    <option value="{{ $payer->payer_name  }}">{{ $payer->payer_name  }}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="col-md-3">
    <button type="submit" class="btn btn-block btn-primary" disabled ><i class="fas fa-search" aria-hidden="true"></i>Search</button>
    </div>
</div>
<br>
