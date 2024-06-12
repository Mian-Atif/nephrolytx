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

class SummaryOptimalStarts extends Controller
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
        
        $optimalStartsPercentY = $analysisController->optimalStartsPercent();
        $optimalStartsY = $analysisController->optimalStarts();
        $inCenterNoCatheterY = $analysisController->inCenterNoCatheter();
        $incidentHomeY = $analysisController->incidentHome();
        $totalNewStartsY = $analysisController->totalNewStarts();
        
        $optimalStarts12MonthPriorPercentM = $analysisController->optimalStarts12MonthPriorPercent();
        
       

            $optimalStarts12MonthPriorPercentCM =  isset($optimalStarts12MonthPriorPercentM[12]->vals) && !empty($optimalStarts12MonthPriorPercentM[12]->vals) ? $optimalStarts12MonthPriorPercentM[12]->vals : 0;

            $optimalStarts12MonthPriorPercentPM = isset($optimalStarts12MonthPriorPercentM[11]->vals) && !empty($optimalStarts12MonthPriorPercentM[11]->vals) ? $optimalStarts12MonthPriorPercentM[11]->vals : 0;
            
            $optimalStarts12MonthPriorPercentPY = isset($optimalStarts12MonthPriorPercentM[0]->vals) && !empty($optimalStarts12MonthPriorPercentM[0]->vals) ? $optimalStarts12MonthPriorPercentM[0]->vals : 0; 
        

            $optimalStarts12MonthPriorM = $analysisController->optimalStarts12MonthPrior();
            //dd($optimalStarts12MonthPriorM);

            $optimalStarts12MonthPriorCM = isset($optimalStarts12MonthPriorM[12]->vals) && !empty($optimalStarts12MonthPriorM[12]->vals) ? $optimalStarts12MonthPriorM[12]->vals : 0;


            $optimalStarts12MonthPriorPM = isset($optimalStarts12MonthPriorM[11]->vals) && !empty($optimalStarts12MonthPriorM[11]->vals) ? $optimalStarts12MonthPriorM[11]->vals : 0;

            $optimalStarts12MonthPriorPY = isset($optimalStarts12MonthPriorM[0]->vals) && !empty($optimalStarts12MonthPriorM[0]->vals) ? $optimalStarts12MonthPriorM[0]->vals : 0;

            $inCenterNoCatheter12MonthPriorM = $analysisController->inCenterNoCatheter12MonthPrior();
            //dd($inCenterNoCatheter12MonthPriorM);

            $inCenterNoCatheter12MonthPriorCM = isset($inCenterNoCatheter12MonthPriorM[12]->vls) && !empty($inCenterNoCatheter12MonthPriorM[12]->vls) ? $inCenterNoCatheter12MonthPriorM[12]->vls : 0;

            $inCenterNoCatheter12MonthPriorPM = isset($inCenterNoCatheter12MonthPriorM[11]->vls) && !empty($inCenterNoCatheter12MonthPriorM[11]->vls) ? $inCenterNoCatheter12MonthPriorM[11]->vls : 0;

            $inCenterNoCatheter12MonthPriorPY = isset($inCenterNoCatheter12MonthPriorM[0]->vls) && !empty($inCenterNoCatheter12MonthPriorM[0]->vls) ? $inCenterNoCatheter12MonthPriorM[0]->vls : 0;


            $incidentHome12MonthPriorM = $analysisController->incidentHome12MonthPrior();
            // dd($incidentHome12MonthPriorM);

            $incidentHome12MonthPriorCM = isset($incidentHome12MonthPriorM[12]->vals) && !empty($incidentHome12MonthPriorM[12]->vals) ? $incidentHome12MonthPriorM[12]->vals : 0;

            $incidentHome12MonthPriorPM = isset($incidentHome12MonthPriorM[11]->vals) && !empty($incidentHome12MonthPriorM[11]->vals) ? $incidentHome12MonthPriorM[11]->vals : 0;

            $incidentHome12MonthPriorPY = isset($incidentHome12MonthPriorM[0]->vals) && !empty($incidentHome12MonthPriorM[0]->vals) ? $incidentHome12MonthPriorM[0]->vals : 0;
        
            $totalNewStarts12MonthPriorM = $analysisController->totalNewStarts12MonthPrior();
            //dd($totalNewStarts12MonthPriorM);

            $totalNewStarts12MonthPriorCM = isset($totalNewStarts12MonthPriorM[12]->vals) && !empty($totalNewStarts12MonthPriorM[12]->vals) ? $totalNewStarts12MonthPriorM[12]->vals : 0;

           $totalNewStarts12MonthPriorPM = isset($totalNewStarts12MonthPriorM[11]->vals) && !empty($totalNewStarts12MonthPriorM[11]->vals) ? $totalNewStarts12MonthPriorM[11]->vals : 0;

            $totalNewStarts12MonthPriorPY = isset($totalNewStarts12MonthPriorM[0]->vals) && !empty($totalNewStarts12MonthPriorM[0]->vals) ? $totalNewStarts12MonthPriorM[0]->vals : 0;



        return view('backend.summary-optimal-starts',
        compact('activePatientPerPhysicians',
        'totalNewStarts12MonthPriorM',
        'totalNewStarts12MonthPriorCM',
        'totalNewStarts12MonthPriorPM',
        'totalNewStarts12MonthPriorPY',
        'incidentHome12MonthPriorM',
        'incidentHome12MonthPriorCM',
        'incidentHome12MonthPriorPM',
        'incidentHome12MonthPriorPY',
        'inCenterNoCatheter12MonthPriorM',
        'inCenterNoCatheter12MonthPriorCM',
        'inCenterNoCatheter12MonthPriorPM',
        'inCenterNoCatheter12MonthPriorPY',
        'optimalStarts12MonthPriorCM',
        'optimalStarts12MonthPriorPM',
        'optimalStarts12MonthPriorPY',
        'optimalStarts12MonthPriorM',
        'optimalStarts12MonthPriorPercentM',
        'optimalStarts12MonthPriorPercentCM',
        'optimalStarts12MonthPriorPercentPM',
        'optimalStarts12MonthPriorPercentPY',
                'analysisController',
                'incidentHomeY',
                'totalNewStartsY',
                'inCenterNoCatheterY',
                'optimalStartsY',
                'optimalStartsPercentY',
                'esrdPatientsPerPhysicians',
                'newPatientsPerPhysicians',
                'avgRevenuePerPhysiciansperDays',
                'newPatientsActualMonths',
                'activePatientsActualMonths'));
    }
    
}
