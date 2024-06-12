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
LateStageCkdPatient extends Controller
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
        

        $activeLateStage =  DB::select('CALL active_late_stage_patients_balance_year_ends(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);

      
        $activeLateStagePB = isset($activeLateStage[0]) && !empty($activeLateStage[0]) ? $activeLateStage[0] : 0;
        $lateStageGLY = isset($activeLateStage[1]) && !empty($activeLateStage[1]) && !is_null($activeLateStage[1]) ? $activeLateStage[1] : 0;
        $lateStageRatioCE = isset($activeLateStage[2]) && !empty($activeLateStage[2]) ? $activeLateStage[2] : 0;
        $lateStageRatioTP = isset($activeLateStage[3]) && !empty($activeLateStage[3]) ? $activeLateStage[3] : 0;

        $activeLateStageMonths =  DB::select('CALL active_late_stage_patients_balance_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        
        $newLateStageCKDPatient =  DB::select('CALL new_late_stage_ckd_patients_year(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        //dd($newLateStageCKDPatient);
        $newLateStageCKDPatientNW = $newLateStageCKDPatient[0];
        $LateStageCKDPatientGLY = $newLateStageCKDPatient[1];
        $LateStageCKDPatientCE = $newLateStageCKDPatient[2];
        $LateStageCKDPatientTP = $newLateStageCKDPatient[3];

        $newactiveLateStageMonths =  DB::select('CALL new_late_stage_ckd_patients_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        
        $lateStageHospOfcFYMonths =  DB::select('CALL late_stage_hospitalization_office_followup_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        // dd($lateStageHospOfcFYMonths);

        $latestagehospitalizationofficefollowupyear =  DB::select('CALL late_stage_hospitalization_office_followup_year(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        //dd($latestagehospitalizationofficefollowupyear);
        $latestagehospitalizationOFY = $latestagehospitalizationofficefollowupyear[0];
        $latestagehospitalizationATF = $latestagehospitalizationofficefollowupyear[1];
        $latestagehospitalizationCKD = $latestagehospitalizationofficefollowupyear[2];
        $latestagehospitalizationLFU = $latestagehospitalizationofficefollowupyear[3];
       

        return view('backend.late-stage-ckd-patient',compact('activePatientPerPhysicians',
                    'LateStageCKDPatientGLY',
                    'latestagehospitalizationOFY',
                    'latestagehospitalizationATF',
                    'latestagehospitalizationCKD',
                    'latestagehospitalizationLFU',
                    'LateStageCKDPatientCE',
                    'lateStageHospOfcFYMonths',
                    'LateStageCKDPatientTP',
                    'newLateStageCKDPatientNW',
                    'activeLateStagePB',
                    'newLateStageCKDPatientNW',
                    'lateStageGLY',
                    'lateStageRatioCE',
                    'lateStageRatioTP',
                    'activeLateStageMonths',
                    'newactiveLateStageMonths',
                    'esrdPatientsPerPhysicians','newPatientsPerPhysicians','avgRevenuePerPhysiciansperDays','newPatientsActualMonths','activePatientsActualMonths'));
    }
    
}
