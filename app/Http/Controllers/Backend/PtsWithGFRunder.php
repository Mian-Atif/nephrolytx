<?php

namespace App\Http\Controllers\Backend;

use App\AnalyticData;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Person\Person;
use App\Models\Access\User\User;
use App\Models\Practice\Practice;
use App\Models\Provider\Provider;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Responses\ViewResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\nepanalysis\AnalysisController;

class PtsWithGFRunder extends Controller
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

        $ptsWithGfrUnder60M =  DB::select('CALL pts_with_gfr_under_60_months(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        // dd($ptsWithGfrUnder60M);
        $ptsWithGfrUnder60Pct =  DB::select('CALL pts_with_gfr_under_60_months_pct(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        // dd($ptsWithGfrUnder60Pct);
        
        $analysisController = new AnalysisController();

        $ptsWithGfrUnder60F = $analysisController->ptsWithGfrUnder60();
           //dd($ptsWithGfrUnder60F);

        return view('backend.pts-with-gf-under',compact('activePatientPerPhysicians',
        'analysisController',
        'ptsWithGfrUnder60F',
        'ptsWithGfrUnder60M',
        'ptsWithGfrUnder60Pct',
        'esrdPatientsPerPhysicians',
        'newPatientsPerPhysicians',
        'avgRevenuePerPhysiciansperDays',
        'newPatientsActualMonths',
        'activePatientsActualMonths'));
    }
    
}
