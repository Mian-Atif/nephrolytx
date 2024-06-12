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

class
PracticeRevenue extends Controller
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

        $revenueperfteyearOT =  DB::select('CALL revenue_per_fte_year(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        // dd($revenueperfteyearOT);
        
        $revenueperfteyearOTA =  isset($revenueperfteyearOT[0]) && !empty($revenueperfteyearOT[0]) ? $revenueperfteyearOT[0] : 0;
        $revenueperfteyearOTB =  isset($revenueperfteyearOT[1]) && !empty($revenueperfteyearOT[1]) ? $revenueperfteyearOT[1] : 0;
        $revenueperfteyearOTC =  isset($revenueperfteyearOT[2]) && !empty($revenueperfteyearOT[2]) ? $revenueperfteyearOT[2] : 0;
        $revenueperfteyearOTD =  isset($revenueperfteyearOT[3]) && !empty($revenueperfteyearOT[3]) ? $revenueperfteyearOT[3] : 0;
        $revenueperfteyearOTE =  isset($revenueperfteyearOT[4]) && !empty($revenueperfteyearOT[4]) ? $revenueperfteyearOT[4] : 0;


        $revenueperftemonthA =  DB::select('CALL revenue_per_fte_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        // dd($revenueperftemonthA);
        
        $analysisController = new AnalysisController();
        
        $officeNewPatientEncounterM = $analysisController->officeNewPatientEncounter();
        

            $officeNewPatientEncounterM1 = isset($officeNewPatientEncounterM[11]->vals) && !empty($officeNewPatientEncounterM[11]->vals) ? $officeNewPatientEncounterM[11]->vals : 0;

            $officeNewPatientEncounterM2 = isset($officeNewPatientEncounterM[10]->vals) && !empty($officeNewPatientEncounterM[10]->vals) ? $officeNewPatientEncounterM[10]->vals : 0;

            $officeNewPatientEncounterM3 = isset($officeNewPatientEncounterM[9]->vals) && !empty($officeNewPatientEncounterM[9]->vals) ? $officeNewPatientEncounterM[9]->vals : 0;

        
        
        $officeEstbdPatientEncounterM = $analysisController->officeEstbdPatientEncounter();
        //dd($officeEstbdPatientEncounterM);

        $officeEstbdPatientEncounterM1 = isset($officeEstbdPatientEncounterM[11]->vals) && !empty($officeEstbdPatientEncounterM[11]->vals) ? $officeEstbdPatientEncounterM[11]->vals : 0;
        $officeEstbdPatientEncounterM2 = isset($officeEstbdPatientEncounterM[10]->vals) && !empty($officeEstbdPatientEncounterM[10]->vals) ? $officeEstbdPatientEncounterM[10]->vals : 0;
        $officeEstbdPatientEncounterM3 = isset($officeEstbdPatientEncounterM[9]->vals) && !empty($officeEstbdPatientEncounterM[9]->vals) ? $officeEstbdPatientEncounterM[9]->vals : 0;

        $officeEstbdkys1 = isset($officeEstbdPatientEncounterM[11]->kys) && !empty($officeEstbdPatientEncounterM[11]->kys) ? $officeEstbdPatientEncounterM[11]->kys : 0;
        //dd($officeEstbdkys1);
        $officeEstbdkys2 = isset($officeEstbdPatientEncounterM[10]->kys) && !empty($officeEstbdPatientEncounterM[10]->kys) ? $officeEstbdPatientEncounterM[10]->kys : 0;
        $officeEstbdkys3 = isset($officeEstbdPatientEncounterM[9]->kys) && !empty($officeEstbdPatientEncounterM[9]->kys) ? $officeEstbdPatientEncounterM[9]->kys : 0;

        $officeNewPatientAvgCodeLevelM = $analysisController->officeNewPatientAvgCodeLevel();
        
            $officeNewPatientAvgCodeLevelM1 = isset($officeNewPatientAvgCodeLevelM[11]->vals) && !empty($officeNewPatientAvgCodeLevelM[11]->vals) ? $officeNewPatientAvgCodeLevelM[11]->vals : 0;
            $officeNewPatientAvgCodeLevelM2 = isset($officeNewPatientAvgCodeLevelM[10]->vals) && !empty($officeNewPatientAvgCodeLevelM[10]->vals) ? $officeNewPatientAvgCodeLevelM[10]->vals : 0;
            $officeNewPatientAvgCodeLevelM3 = isset($officeNewPatientAvgCodeLevelM[9]->vals) && !empty($officeNewPatientAvgCodeLevelM[9]->vals) ? $officeNewPatientAvgCodeLevelM[9]->vals : 0;
        
        $officeEstabPatientAvgCodeLevelM = $analysisController->officeEstabPatientAvgCodeLevel();
            
        $officeEstabPatientAvgCodeLevelM1 = isset($officeEstabPatientAvgCodeLevelM[11]->vals) && !empty($officeEstabPatientAvgCodeLevelM[11]->vals) ? $officeEstabPatientAvgCodeLevelM[11]->vals : 0;
        $officeEstabPatientAvgCodeLevelM2 = isset($officeEstabPatientAvgCodeLevelM[10]->vals) && !empty($officeEstabPatientAvgCodeLevelM[10]->vals) ? $officeEstabPatientAvgCodeLevelM[10]->vals : 0;
        $officeEstabPatientAvgCodeLevelM3 = isset($officeEstabPatientAvgCodeLevelM[9]->vals) && !empty($officeEstabPatientAvgCodeLevelM[9]->vals) ? $officeEstabPatientAvgCodeLevelM[9]->vals : 0;
        
        $hospitalNewPatientEncounterM = $analysisController->hospitalNewPatientEncounter();
         //dd($hospitalNewPatientEncounterM);
        $hospitalNewPatientEncounterM1 = isset($hospitalNewPatientEncounterM[11]->vals) && !empty($hospitalNewPatientEncounterM[11]->vals) ? $hospitalNewPatientEncounterM[11]->vals : 0;
        $hospitalNewPatientEncounterM2 = isset($hospitalNewPatientEncounterM[10]->vals) && !empty($hospitalNewPatientEncounterM[10]->vals) ? $hospitalNewPatientEncounterM[10]->vals : 0;
        $hospitalNewPatientEncounterM3 = isset($hospitalNewPatientEncounterM[9]->vals) && !empty($hospitalNewPatientEncounterM[9]->vals) ? $hospitalNewPatientEncounterM[9]->vals : 0;

        $hospitalNewPkys1 = isset($hospitalNewPatientEncounterM[11]->kys) && !empty($hospitalNewPatientEncounterM[11]->kys) ? $hospitalNewPatientEncounterM[11]->kys : 0;
        $hospitalNewPkys2 = isset($hospitalNewPatientEncounterM[10]->kys) && !empty($hospitalNewPatientEncounterM[10]->kys) ? $hospitalNewPatientEncounterM[10]->kys : 0;
        $hospitalNewPkys3 = isset($hospitalNewPatientEncounterM[9]->kys) && !empty($hospitalNewPatientEncounterM[9]->kys) ? $hospitalNewPatientEncounterM[9]->kys : 0;

        $hospitalEstbdPatientEncounterM = $analysisController->hospitalEstbdPatientEncounter();
        
        $hospitalEstbdPatientEncounterM1 = isset($hospitalEstbdPatientEncounterM[11]->vals) && !empty($hospitalEstbdPatientEncounterM[11]->vals) ? $hospitalEstbdPatientEncounterM[11]->vals : 0;
        $hospitalEstbdPatientEncounterM2 = isset($hospitalEstbdPatientEncounterM[10]->vals) && !empty($hospitalEstbdPatientEncounterM[10]->vals) ? $hospitalEstbdPatientEncounterM[10]->vals : 0;
        $hospitalEstbdPatientEncounterM3 = isset($hospitalEstbdPatientEncounterM[9]->vals) && !empty($hospitalEstbdPatientEncounterM[9]->vals) ? $hospitalEstbdPatientEncounterM[9]->vals : 0;


        $hospitalNewPatientAvgCodeLevelM = $analysisController->hospitalNewPatientAvgCodeLevel();
       
        $hospitalNewPatientAvgCodeLevelM1 = isset($hospitalNewPatientAvgCodeLevelM[11]->vals) && !empty($hospitalNewPatientAvgCodeLevelM[11]->vals) ? $hospitalNewPatientAvgCodeLevelM[11]->vals : 0;
        $hospitalNewPatientAvgCodeLevelM2 = isset($hospitalNewPatientAvgCodeLevelM[10]->vals) && !empty($hospitalNewPatientAvgCodeLevelM[10]->vals) ? $hospitalNewPatientAvgCodeLevelM[10]->vals : 0;
        $hospitalNewPatientAvgCodeLevelM3 = isset($hospitalNewPatientAvgCodeLevelM[9]->vals) && !empty($hospitalNewPatientAvgCodeLevelM[9]->vals) ? $hospitalNewPatientAvgCodeLevelM[9]->vals : 0;

        $hospitalEstabPatientAvgCodeLevelM = $analysisController->hospitalEstabPatientAvgCodeLevel();
        
        $hospitalEstabPatientAvgCodeLevelM1 = isset($hospitalEstabPatientAvgCodeLevelM[11]->vals) && !empty($hospitalEstabPatientAvgCodeLevelM[11]->vals) ? $hospitalEstabPatientAvgCodeLevelM[11]->vals : 0;
        $hospitalEstabPatientAvgCodeLevelM2 = isset($hospitalEstabPatientAvgCodeLevelM[10]->vals) && !empty($hospitalEstabPatientAvgCodeLevelM[10]->vals) ? $hospitalEstabPatientAvgCodeLevelM[10]->vals : 0;
        $hospitalEstabPatientAvgCodeLevelM3 = isset($hospitalEstabPatientAvgCodeLevelM[9]->vals) && !empty($hospitalEstabPatientAvgCodeLevelM[9]->vals) ? $hospitalEstabPatientAvgCodeLevelM[9]->vals : 0;
        
        $inCenterDialysisM = $analysisController->inCenterDialysis();
          //dd($inCenterDialysisM);
        
        $inCenterDialysisM1 = isset($inCenterDialysisM[11]->vals) && !empty($inCenterDialysisM[11]->vals) ? $inCenterDialysisM[11]->vals : 0;
        $inCenterDialysisM2 = isset($inCenterDialysisM[10]->vals) && !empty($inCenterDialysisM[10]->vals) ? $inCenterDialysisM[10]->vals : 0;
        $inCenterDialysisM3 = isset($inCenterDialysisM[9]->vals) && !empty($inCenterDialysisM[9]->vals) ? $inCenterDialysisM[9]->vals : 0;
        
        $inCenterkys1 = isset($inCenterDialysisM[11]->kys) && !empty($inCenterDialysisM[11]->kys) ? $inCenterDialysisM[11]->kys : 0;
        $inCenterkys2 = isset($inCenterDialysisM[10]->kys) && !empty($inCenterDialysisM[10]->kys) ? $inCenterDialysisM[10]->kys : 0;
        $inCenterkys3 = isset($inCenterDialysisM[9]->kys) && !empty($inCenterDialysisM[9]->kys) ? $inCenterDialysisM[9]->kys : 0;

        return view('backend.practice-revenue', compact(
            'activePatientPerPhysicians',
            'inCenterkys1',
            'inCenterkys2',
            'inCenterkys3',
            'inCenterDialysisM',
            'hospitalNewPkys1',
            'hospitalNewPkys2',
            'hospitalNewPkys3',
            'officeEstbdkys1',
            'officeEstbdkys2',
            'officeEstbdkys3',
            'inCenterDialysisM1',
            'inCenterDialysisM2',
            'inCenterDialysisM3',
            'hospitalEstabPatientAvgCodeLevelM',
            'hospitalEstabPatientAvgCodeLevelM1',
            'hospitalEstabPatientAvgCodeLevelM2',
            'hospitalEstabPatientAvgCodeLevelM3',
            'hospitalNewPatientAvgCodeLevelM',
            'hospitalNewPatientAvgCodeLevelM1',
            'hospitalNewPatientAvgCodeLevelM2',
            'hospitalNewPatientAvgCodeLevelM3',
            'hospitalEstbdPatientEncounterM',
            'hospitalEstbdPatientEncounterM1',
            'hospitalEstbdPatientEncounterM2',
            'hospitalEstbdPatientEncounterM3',
            'hospitalNewPatientEncounterM',
            'hospitalNewPatientEncounterM1',
            'hospitalNewPatientEncounterM2',
            'hospitalNewPatientEncounterM3',
            'officeEstabPatientAvgCodeLevelM',
            'officeEstabPatientAvgCodeLevelM1',
            'officeEstabPatientAvgCodeLevelM2',
            'officeEstabPatientAvgCodeLevelM3',
            'officeNewPatientAvgCodeLevelM',
            'officeNewPatientAvgCodeLevelM1',
            'officeNewPatientAvgCodeLevelM2',
            'officeNewPatientAvgCodeLevelM3',
            'officeNewPatientEncounterM',
            'officeNewPatientEncounterM1',
            'officeNewPatientEncounterM2',
            'officeNewPatientEncounterM3',
            'officeEstbdPatientEncounterM',
            'officeEstbdPatientEncounterM1',
            'officeEstbdPatientEncounterM2',
            'officeEstbdPatientEncounterM3',
            'revenueperfteyearOTA',
            'revenueperfteyearOTB',
            'revenueperfteyearOTC',
            'revenueperfteyearOTD',
            'revenueperfteyearOTE',
            'revenueperftemonthA',
            'esrdPatientsPerPhysicians',
            'newPatientsPerPhysicians',
            'avgRevenuePerPhysiciansperDays',
            'newPatientsActualMonths',
            'revenueperfteyearOT',
            'activePatientsActualMonths'

        ));
    }
}
