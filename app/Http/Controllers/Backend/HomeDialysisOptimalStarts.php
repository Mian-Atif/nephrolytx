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

class HomeDialysisOptimalStarts extends Controller
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
        

        $analysisController = new AnalysisController();
             //dd($analysisController);

        $homePatientsHD = $analysisController->homePatients();
            // dd($homePatientsHD);
        $newHomePatientsHD = $analysisController->newHomePatients();
           
        $homeCountPerFteHD = $analysisController->homeCountPerFte();
           //dd($homeCountPerFteHD);
        $newHomePerFteHD = $analysisController->newHomePerFte();
          //dd($newHomePerFteHD);

        $incidentHomePerFteHD = $analysisController->incidentHomePerFte();
          //dd($incidentHomePerFteHD);

        $homePercentHD = $analysisController->homePercent();
         //dd($homePercentHD);
        
        return view('backend.home-dialysis-optimal-starts',compact('activePatientPerPhysicians',
        'esrdPatientsPerPhysicians',
        'homePercentHD',
        'incidentHomePerFteHD',
        'homePatientsHD',
        'newHomePerFteHD',
        'homeCountPerFteHD',
        'newHomePatientsHD',
        'analysisController',
        'newPatientsPerPhysicians',
        'avgRevenuePerPhysiciansperDays',
        'newPatientsActualMonths',
        'activePatientsActualMonths'));
    }
    
}
