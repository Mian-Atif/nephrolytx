<?php

namespace App\Http\Controllers\Backend;

use App\AnalyticData;
use App\Http\Controllers\Controller;
use App\Http\Responses\ViewResponse;
use App\Models\Access\User\User;
use App\Models\Person\Person;
use App\Models\Practice\Practice;
use App\Models\Provider\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class
QuickSummaryQuicktools extends Controller
{

    public function index()
    {
            
        
        $user = Auth::user();
        $practice_id = $user->practice_id;
        

        $provider = '';
        $location = '';
        $insurance = '';

        $activePatientPerPhysicians =  DB::select('CALL active_patients_count_per_physician(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        $esrdPatientsPerPhysicians =  DB::select('CALL ESRD_patients_count_per_physician(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        $newPatientsPerPhysicians =  DB::select('CALL new_patients_count_per_physician(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        $avgRevenuePerPhysiciansperDays =  DB::select('CALL average_revenue_per_physician_per_day(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        //dd($avgRevenuePerPhysiciansperDays);
        $newPatientsActualMonths =  DB::select('CALL new_patients_count_actual_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        $activePatientsActualMonths =  DB::select('CALL active_patients_count_actual_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
       
        return view('backend.quicksummary-quicktools',compact('activePatientPerPhysicians','esrdPatientsPerPhysicians','newPatientsPerPhysicians','avgRevenuePerPhysiciansperDays','newPatientsActualMonths','activePatientsActualMonths'));
    }
    
}
