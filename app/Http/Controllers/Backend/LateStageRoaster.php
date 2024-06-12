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

class LateStageRoaster extends Controller
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
        
        $mileFromOffice2 = array();
        $mileFromOffice = DB::select("CALL miles_from_office($practice_id,'','','')");
        $mileFromOffice2['count'] = 10785236;
        $mileFromOffice2['photos'] = $mileFromOffice;
        $mileFromOffice = $mileFromOffice2;


        $analysisController = new AnalysisController();
        //dd($analysisController);

        $byProviderLSR = $analysisController->byProvider();
        //dd($byProviderLSR);

        $byFirstLocationLSR = $analysisController->byFirstLocation();

        $byInsuranceLSR = $analysisController->byInsurance();

        $lastOfficeLocationLSR = $analysisController->lastOfficeLocation();

       $lateStageCKDRosterLSR  = $analysisController->lateStageCKDRoster();

        $byStageLSR = $analysisController->byStage();
        // dd($byStageLSR);
        $byStageLSR1 = isset($byStageLSR[0]->last_stage_patients) && !empty($byStageLSR[0]->last_stage_patients) ? $byStageLSR[0]->last_stage_patients : 0;
        $byStageLSR2 = isset($byStageLSR[1]->last_stage_patients) && !empty($byStageLSR[1]->last_stage_patients) ? $byStageLSR[1]->last_stage_patients : 0;
        $byStageLSR3 = isset($byStageLSR[2]->last_stage_patients) && !empty($byStageLSR[2]->last_stage_patients) ? $byStageLSR[2]->last_stage_patients : 0;

        
        //$lateStagePatientMapLSR = $analysisController->lateStagePatientMap();
        
         //dd($lateStagePatientMapLSR);
        
         $mapofPatientsPR = $analysisController->lateStagePatientMap();
           //dd($mapofPatientsPR);
         $mapofPatientsPR2['count'] = 10785236;
         $mapofPatientsPR2['photos'] = $mapofPatientsPR;
         $mapofPatientsPR = $mapofPatientsPR2;
         
         
         return view('backend.late-stage-roaster',compact('activePatientPerPhysicians',
        'esrdPatientsPerPhysicians',
        'lateStageCKDRosterLSR',
        'byStageLSR',
        'byStageLSR1',
        'byStageLSR2',
        'byStageLSR3',
        'lastOfficeLocationLSR',
        'byInsuranceLSR',
        'byFirstLocationLSR',
        'analysisController',
        'byProviderLSR',
        'newPatientsPerPhysicians',
        'avgRevenuePerPhysiciansperDays',
        'newPatientsActualMonths',
        'activePatientsActualMonths', 
        'mapofPatientsPR',
        'mileFromOffice'));
    }
    
}
