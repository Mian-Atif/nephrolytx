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

class HomeDialysisRevenueCycle extends Controller
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
        
        $cashPostedHospitalMonthGraphOS = $analysisController->cashPostedHospitalMonthGraph();
           
        $cashPostedHospitalCy = $analysisController->cashPostedHospitalCy();
        $cashPostedHospitalCyHS = $cashPostedHospitalCy;
        $cashPostedHospitalP1y = $analysisController->cashPostedHospitalP1y();     
        $cashPostedHospitalP1yHS = $cashPostedHospitalP1y;
        $cashPostedHospitalTrendHS = $analysisController->cashPostedHospitalTrend();
        
        
        $encounterHospitalMonthGraphHS = $analysisController->encounterHospitalMonthGraph();
        
        $encounterHospitalCy = $analysisController->encounterHospitalCy();
        $encounterHospitalCyHS = $encounterHospitalCy;
        $encounterHospitalP1y = $analysisController->encounterHospitalP1y();
        $encounterHospitalP1yHS = $encounterHospitalP1y;
        $encountersHospitalTrendHS = $analysisController->encountersHospitalTrend();
         
        $patientsSeenHospitalMonthGraphHS = $analysisController->patientsSeenHospitalMonthGraph();
        $patientsSeenHospitalCy = $analysisController->patientsSeenHospitalCy();
        $patientsSeenHospitalCyHS = $patientsSeenHospitalCy;
        $patientsSeenHospitalP1y = $analysisController->patientsSeenHospitalP1y();
        $patientsSeenHospitalP1yHS = $patientsSeenHospitalP1y;
        $patientsSeenHospitalTrendHS = $analysisController->patientsSeenHospitalTrend();
        //dd($patientsSeenHospitalTrendHS);
        
        $newPatientsHospitalMonthGraphHS = $analysisController->newPatientsHospitalMonthGraph();
      
        $newPatientsHospitalCy = $analysisController->newPatientsHospitalCy();
        $newPatientsHospitalCyHS = $newPatientsHospitalCy;
        $newPatientsHospitalP1y = $analysisController->newPatientsHospitalP1y();
        $newPatientsHospitalP1yHS = $newPatientsHospitalP1y;
        $newPatientsHospitalTrendHS = $analysisController->newPatientsHospitalTrend();
         
        
        $totalPaymentEarlyStageHospitalHS = $analysisController->totalPaymentEarlyStageHospital();
        $totalPaymentEarlyStageHospitalCY = $totalPaymentEarlyStageHospitalHS[0]->total_payment_early_stage_cy;
        $totalPaymentEarlyStageHospitalPIY = $totalPaymentEarlyStageHospitalHS[0]->total_payment_early_stage_p1y;


        $totalPaymentStage4ckdHospitalHS = $analysisController->totalPaymentStage4ckdHospital();
        $totalPaymentStage4ckdHospitalHSCY = $totalPaymentStage4ckdHospitalHS[0]->total_payment_ckd4_cy;
        $totalPaymentStage4ckdHospitalHSPIY = $totalPaymentStage4ckdHospitalHS[0]->total_payment_ckd4_p1y;
       
        $totalPaymentStage5ckdHospitalHS = $analysisController->totalPaymentStage5ckdHospital();
        $totalPaymentStage5ckdHospitalHSCY = $totalPaymentStage5ckdHospitalHS[0]->total_payment_ckd5_cy;
        $totalPaymentStage5ckdHospitalHSP1Y = $totalPaymentStage5ckdHospitalHS[0]->total_payment_ckd5_p1y;

        $totalPaymentEsrdHospitalHS = $analysisController->totalPaymentEsrdHospital();
        $totalPaymentEsrdHospitalHSCY = $totalPaymentEsrdHospitalHS[0]->total_payment_esrd_cy;
        $totalPaymentEsrdHospitalHSP1Y =$totalPaymentEsrdHospitalHS[0]->total_payment_esrd_p1y;
       
        $totalPaymentNonCkdHospitalHS = $analysisController->totalPaymentNonCkdHospital();
        $totalPaymentNonCkdHospitalHSCY = $totalPaymentNonCkdHospitalHS[0]->total_payment_non_ckd_cy;
        $totalPaymentNonCkdHospitalHSP1Y =$totalPaymentNonCkdHospitalHS[0]->total_payment_non_ckd_p1y;
       
        $cashPerPatientHospitalHS = $analysisController->cashPerPatientHospital();
          //  dd($cashPerPatientHospitalHS);
        $totalPaymentsHospitalHS = $analysisController->totalPaymentsHospital();
        $cashPerEncountersHospitalHS = $analysisController->cashPerEncountersHospital();
        $totalEncountersHospitalHS = $analysisController->totalEncountersHospital();
        $encounterPerPatientHospitalHS = $analysisController->encounterPerPatientHospital();
        $totalPatientsHospitalHS = $analysisController->totalPatientsHospital();
        $newPatientHospitalHS = $analysisController->newPatientHospital();
          //  dd($cashPerEncountersHospitalHS,$totalEncountersHospitalHS);




        return view('backend.summary-hospital-services',compact('activePatientPerPhysicians',
        'esrdPatientsPerPhysicians',
        'totalPatientsHospitalHS',
        'newPatientHospitalHS',
        'encounterPerPatientHospitalHS',
        'cashPerEncountersHospitalHS',
        'totalEncountersHospitalHS',
        'totalPaymentsHospitalHS',
        'cashPerPatientHospitalHS',
        'totalPaymentNonCkdHospitalHS',
        'totalPaymentNonCkdHospitalHSCY',
        'totalPaymentNonCkdHospitalHSP1Y',
        'totalPaymentEsrdHospitalHS',
        'totalPaymentEsrdHospitalHSCY',
        'totalPaymentEsrdHospitalHSP1Y',
        'totalPaymentStage5ckdHospitalHS',
        'totalPaymentStage5ckdHospitalHSCY',
        'totalPaymentStage5ckdHospitalHSP1Y',
        'totalPaymentStage4ckdHospitalHS',
        'totalPaymentStage4ckdHospitalHSCY',
        'totalPaymentStage4ckdHospitalHSPIY',
        'totalPaymentEarlyStageHospitalHS',
        'totalPaymentEarlyStageHospitalCY',
        'totalPaymentEarlyStageHospitalPIY',
        'newPatientsHospitalTrendHS',
        'newPatientsHospitalP1y',
        'newPatientsHospitalP1yHS',
        'newPatientsHospitalCy',
        'newPatientsHospitalCyHS',
        'newPatientsHospitalMonthGraphHS',
        'patientsSeenHospitalTrendHS',
        'patientsSeenHospitalP1y',
        'patientsSeenHospitalP1yHS',
        'patientsSeenHospitalCy',
        'patientsSeenHospitalCyHS',
        'patientsSeenHospitalMonthGraphHS',
        'encountersHospitalTrendHS',
        'encounterHospitalP1y',
        'encounterHospitalP1yHS',
        'encounterHospitalCy',
        'encounterHospitalCyHS',
        'encounterHospitalMonthGraphHS',
        'cashPostedHospitalTrendHS',
        'cashPostedHospitalP1y',
        'cashPostedHospitalP1yHS',
        'cashPostedHospitalCy',
        'cashPostedHospitalCyHS',
        'cashPostedHospitalMonthGraphOS',
        'newPatientsPerPhysicians',
        'avgRevenuePerPhysiciansperDays',
        'newPatientsActualMonths',
        'activePatientsActualMonths'));
    }
    
}
