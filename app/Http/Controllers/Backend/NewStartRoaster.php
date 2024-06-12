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

class NewStartRoaster extends Controller
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
       
        // $mileFromOffice2 = array();
        // $mileFromOffice = DB::select("CALL miles_from_office($practice_id,'','','')");
        // $mileFromOffice2['count'] = 10785236;
        // $mileFromOffice2['photos'] = $mileFromOffice;
        // $mileFromOffice = $mileFromOffice2;

            $analysisController = new AnalysisController();
             //dd($analysisController);

             $mapofPatientsPR = $analysisController->newstartPatientMap();
             $mapofPatientsPR2['count'] = 10785236;
             $mapofPatientsPR2['photos'] = $mapofPatientsPR;
             $mapofPatientsPR = $mapofPatientsPR2;

            $byFirstProviderNSR = $analysisController->byFirstProvider();
            
            $byLastProviderNSR = $analysisController->byLastProvider();
   
            $byFirstDialysisLocationNSR = $analysisController->byFirstDialysisLocation();
            
            $bylastDialysisLocationNSR = $analysisController->bylastDialysisLocation();

            $byHomeStatusNSR = $analysisController->byHomeStatus();
            //dd($byHomeStatusNSR);

            $byHomeStatusNSR1 = $byHomeStatusNSR[0]->incident_home_pct;
            $byHomeStatusNSR2 = $byHomeStatusNSR[0]->home_status_pct;
            $byHomeStatusNSR3 = $byHomeStatusNSR[0]->new_pct;

            $byAccessTypeNSR = $analysisController->byAccessType();
             //dd($byAccessTypeNSR);
            $byAccessTypeNSRF1 = $byAccessTypeNSR[0]->pdcath_pct;
            $byAccessTypeNSRF2 = $byAccessTypeNSR[0]->none_pct;
            $byAccessTypeNSRF3 = $byAccessTypeNSR[0]->cvcath_pct;

            $newStartRosterNSR = $analysisController->newStartRoster();
            //dd($newStartRosterNSR);
              
        return view('backend.new-start-roaster',compact('activePatientPerPhysicians',
        'analysisController',
        'byHomeStatusNSR',
        'mapofPatientsPR',
        'byHomeStatusNSR1',
        'byHomeStatusNSR2',
        'byHomeStatusNSR3',
        'newStartRosterNSR',
        'byAccessTypeNSR',
        'byAccessTypeNSRF1',
        'byAccessTypeNSRF2',
        'byAccessTypeNSRF3',
        'byFirstDialysisLocationNSR',
        'bylastDialysisLocationNSR',
        'byLastProviderNSR',
        'byFirstProviderNSR',
        'esrdPatientsPerPhysicians',
        'newPatientsPerPhysicians',
        'avgRevenuePerPhysiciansperDays',
        'newPatientsActualMonths',
        'activePatientsActualMonths'));
    }
    
}
