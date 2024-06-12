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

class SummaryRevenueCycle extends Controller
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
           
        $cashPostedMonthGraph1 = $analysisController->cashPostedMonthGraph();
        
           $cashPostedCyS1 = $analysisController->cashPostedCy();
           $cashPostedCyS1F = $cashPostedCyS1;
           $cashPostedP1yS = $analysisController->cashPostedP1y();
           $cashPostedP1ySF = $cashPostedP1yS;
           $cashPostedTrendS = $analysisController->cashPostedTrend();
            
        $encounterMonthGraphS = $analysisController->encounterMonthGraph();
       
             
            $encounterCyS = $analysisController->encounterCy();
            $encounterCySF = $encounterCyS;
            $encounterP1yS = $analysisController->encounterP1y();
            $encounterP1ySF = $encounterP1yS;
            $encountersTrendS = $analysisController->encountersTrend();
        
        $patientsSeenMonthGraphS = $analysisController->patientsSeenMonthGraph();
             
            $patientsSeenCyS = $analysisController->patientsSeenCy();
            $patientsSeenCyS1 = $patientsSeenCyS;
            $patientsSeenP1yS = $analysisController->patientsSeenP1y();
            $patientsSeenP1ySF = $patientsSeenP1yS;
            
            $patientsSeenTrendS = $analysisController->patientsSeenTrend();
            
         
         
        $newPatientsMonthGraphS = $analysisController->newPatientsMonthGraph();
           

           $newPatientsCyS = $analysisController->newPatientsCy();
           $newPatientsCySF = $newPatientsCyS;
           $newPatientsP1yS = $analysisController->newPatientsP1y();   
           $newPatientsP1ySF = $newPatientsP1yS;
           $newPatientsTrendS = $analysisController->newPatientsTrend();
          
        $totalPaymentEarlyStageS = $analysisController->totalPaymentEarlyStage();  
        
           $totalPaymentEarlyStageSCY1 = $totalPaymentEarlyStageS[0]->total_payment_early_stage_cy;
           $totalPaymentEarlyStageSCPY1 = $totalPaymentEarlyStageS[0]->total_payment_early_stage_p1y;

        $totalPaymentStage4ckdS = $analysisController->totalPaymentStage4ckd();  
           
           $totalPaymentStage4ckdSCY1 = $totalPaymentStage4ckdS[0]->total_payment_ckd4_cy;
           $totalPaymentStage4ckdSPY1 = $totalPaymentStage4ckdS[0]->total_payment_ckd4_p1y;

        $totalPaymentStage5ckdS = $analysisController->totalPaymentStage5ckd();  
         
           $totalPaymentStage5ckdSCY1 = $totalPaymentStage5ckdS[0]->total_payment_ckd5_cy;
           $totalPaymentStage5ckdSPY1 = $totalPaymentStage5ckdS[0]->total_payment_ckd5_p1y;

        $totalPaymentEsrdS = $analysisController->totalPaymentEsrd();  
        
           $totalPaymentEsrdSCY1 = $totalPaymentEsrdS[0]->total_payment_esrd_cy;
           $totalPaymentEsrdSPY1 = $totalPaymentEsrdS[0]->total_payment_esrd_p1y;

        $totalPaymentNonCkdS = $analysisController->totalPaymentNonCkd(); 
      //   dd($totalPaymentNonCkdS); 
         
           $totalPaymentNonCkdSCY1 = $totalPaymentNonCkdS[0]->total_payment_non_ckd_cy;
           $totalPaymentNonCkdSPY1 = $totalPaymentNonCkdS[0]->total_payment_non_ckd_p1y;

        $cashPerPatientS = $analysisController->cashPerPatient();  
       
        $totalPaymentsS = $analysisController->totalPayments(); 
      
        $cashPerEncountersS = $analysisController->cashPerEncounters();
        $totalEncountersS = $analysisController->totalEncounters();
        $encounterPerPatientS = $analysisController->encounterPerPatient();
          // dd($encounterPerPatientS);
        $totalPatientsS = $analysisController->totalPatients();
        $totalNewPatientsS = $analysisController->totalNewPatients();
         // dd($totalNewPatientsS);


        return view('backend.summary-revenue-cycle',compact('activePatientPerPhysicians',
        'esrdPatientsPerPhysicians',
        'totalNewPatientsS',
        'totalPatientsS',
        'encounterPerPatientS',
        'totalEncountersS',
        'cashPerEncountersS',
        'totalPaymentsS',
        'cashPerPatientS',
        'totalPaymentNonCkdS',
        'totalPaymentNonCkdSCY1',
        'totalPaymentNonCkdSPY1',
        'totalPaymentEsrdS',
        'totalPaymentEsrdSCY1',
        'totalPaymentEsrdSPY1',
        'totalPaymentStage5ckdS',
        'totalPaymentStage5ckdSCY1',
        'totalPaymentStage5ckdSPY1',
        'totalPaymentStage4ckdSCY1',
        'totalPaymentStage4ckdSPY1',
        'totalPaymentStage4ckdS',
        'totalPaymentEarlyStageS',
        'totalPaymentEarlyStageSCY1',
        'totalPaymentEarlyStageSCPY1',
        'newPatientsTrendS',
        'newPatientsP1yS',
        'newPatientsP1ySF',
        'newPatientsCyS',
        'newPatientsCySF',
        'newPatientsMonthGraphS',
        'patientsSeenTrendS',
       'patientsSeenP1yS',
       'patientsSeenP1ySF',
        'patientsSeenCyS',
        'patientsSeenCyS1',
        'patientsSeenMonthGraphS',
        'encountersTrendS',
        'encounterCySF',
        'encounterP1yS',
        'encounterP1ySF',
        'encounterMonthGraphS',
        'encounterCyS',
        'cashPostedP1yS',
        'cashPostedP1ySF',
        'cashPostedTrendS',
        'cashPostedCyS1',
        'cashPostedCyS1F',
        'cashPostedMonthGraph1',
        'analysisController',
        'newPatientsPerPhysicians',
        'avgRevenuePerPhysiciansperDays',
        'newPatientsActualMonths',
        'activePatientsActualMonths'));
    }
    
}
