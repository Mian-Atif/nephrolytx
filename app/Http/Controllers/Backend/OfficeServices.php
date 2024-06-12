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

class OfficeServices extends Controller
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
     
        $cashPostedOfficeMonthGraphOS = $analysisController->cashPostedOfficeMonthGraph();
      
        $cashPostedOfficeCyOS = $analysisController->cashPostedOfficeCy();
        $cashPostedOfficeCyOS1 = $cashPostedOfficeCyOS;
        $cashPostedOfficeP1y = $analysisController->cashPostedOfficeP1y(); 
        $cashPostedOfficeP1OS = $cashPostedOfficeP1y;
        $cashPostedOfficeTrendOS = $analysisController->cashPostedOfficeTrend(); 
      

        $encounterOfficeMonthGraphOS = $analysisController->encounterOfficeMonthGraph();    
       
        $encounterOfficeCy = $analysisController->encounterOfficeCy();
        $encounterOfficeCyOS = $encounterOfficeCy;
        $encounterOfficeP1y = $analysisController->encounterOfficeP1y();
        $encounterOfficeP1yOS = $encounterOfficeP1y;
        $encountersOfficeTrendOS = $analysisController->encountersOfficeTrend(); 

        $patientsSeenOfficeMonthGraphOS = $analysisController->patientsSeenOfficeMonthGraph();
            
        $patientsSeenOfficeCy = $analysisController->patientsSeenOfficeCy();
        $patientsSeenOfficeCyOS = $patientsSeenOfficeCy;
        $patientsSeenOfficeP1y = $analysisController->patientsSeenOfficeP1y();   
        $patientsSeenOfficeP1yOS = $patientsSeenOfficeP1y;
        $patientsSeenOfficeTrend = $analysisController->patientsSeenOfficeTrend(); 
      
        
        $newPatientsOfficeMonthGraphOS = $analysisController->newPatientsOfficeMonthGraph();
        
       
        $newPatientsOfficeCy = $analysisController->newPatientsOfficeCy();
        $newPatientsOfficeCyOS = $newPatientsOfficeCy;
        $newPatientsOfficeP1y = $analysisController->newPatientsOfficeP1y();
        $newPatientsOfficeP1yOS = $newPatientsOfficeP1y;
        $newPatientsOfficeTrendOS = $analysisController->newPatientsOfficeTrend(); 
      

        $totalPaymentEarlyStageOfficeOS = $analysisController->totalPaymentEarlyStageOffice();
        $totalpaymentearlystagecyOS = $totalPaymentEarlyStageOfficeOS[0]->total_payment_early_stage_cy;
        $totalpaymentearlystagep1yOS = $totalPaymentEarlyStageOfficeOS[0]->total_payment_early_stage_p1y;

        $totalPaymentStage4ckdOfficeOS = $analysisController->totalPaymentStage4ckdOffice();
        $totalpaymentckd4cyOS = $totalPaymentStage4ckdOfficeOS[0]->total_payment_ckd4_cy;
        $totalpaymentckd4p1yOS = $totalPaymentStage4ckdOfficeOS[0]->total_payment_ckd4_p1y;

        $totalPaymentStage5ckdOfficeOS = $analysisController->totalPaymentStage5ckdOffice();
        $totalpaymentckd5cyOS = $totalPaymentStage5ckdOfficeOS[0]->total_payment_ckd5_cy;
        $totalpaymentckd5p1yOS = $totalPaymentStage5ckdOfficeOS[0]->total_payment_ckd5_p1y;
        
        $totalPaymentEsrdOfficeOS = $analysisController->totalPaymentEsrdOffice();  
        $totalpaymentesrdcyOS = $totalPaymentEsrdOfficeOS[0]->total_payment_esrd_cy;
        $totalpaymentesrdp1yOS = $totalPaymentEsrdOfficeOS[0]->total_payment_esrd_p1y;
     
        $totalPaymentNonCkdOfficeOS = $analysisController->totalPaymentNonCkdOffice();
        $totalpaymentnonckdcyOS = $totalPaymentNonCkdOfficeOS[0]->total_payment_non_ckd_cy;
        $totalpaymentnonckdp1yOS = $totalPaymentNonCkdOfficeOS[0]->total_payment_non_ckd_p1y;
        
        $cashPerPatientOfficeOS = $analysisController->cashPerPatientOffice();
        $totalPaymentsOfficeOS = $analysisController->totalPaymentsOffice();
        $cashPerEncountersOfficeOS = $analysisController->cashPerEncountersOffice();
        $totalEncountersOfficeOS = $analysisController->totalEncountersOffice();
        $encounterPerPatientOfficeOS = $analysisController->encounterPerPatientOffice();
        $totalPatientsOfficeOS = $analysisController->totalPatientsOffice();
        $newPatientsOfficeOS = $analysisController->newPatientsOffice();
        //dd($newPatientsOfficeOS);

        return view('backend.summary-office-services',compact('activePatientPerPhysicians',
        'analysisController',
        'newPatientsOfficeOS',
        'totalPatientsOfficeOS',
        'encounterPerPatientOfficeOS',
        'totalEncountersOfficeOS',
        'cashPerEncountersOfficeOS',
        'totalPaymentsOfficeOS',
        'cashPerPatientOfficeOS',
        'totalpaymentnonckdcyOS',
        'totalpaymentnonckdp1yOS',
        'totalPaymentNonCkdOfficeOS',
        'totalpaymentesrdcyOS',
        'totalpaymentesrdp1yOS',
        'totalPaymentEsrdOfficeOS',
        'totalPaymentStage5ckdOfficeOS',
        'totalpaymentckd5cyOS',
        'totalpaymentckd5p1yOS',
        'totalPaymentStage4ckdOfficeOS',
        'totalpaymentckd4cyOS',
        'totalpaymentckd4p1yOS',
        'totalPaymentEarlyStageOfficeOS',
        'totalpaymentearlystagecyOS',
        'totalpaymentearlystagep1yOS',
        'newPatientsOfficeTrendOS',
        'newPatientsOfficeP1y',
        'newPatientsOfficeP1yOS',
        'newPatientsOfficeCy',
        'newPatientsOfficeCyOS',
        'newPatientsOfficeMonthGraphOS',
        'patientsSeenOfficeTrend',
        'patientsSeenOfficeMonthGraphOS',
        'patientsSeenOfficeP1y',
        'patientsSeenOfficeP1yOS',
        'patientsSeenOfficeCy',
        'patientsSeenOfficeCyOS',
        'encounterOfficeP1yOS',
        'encountersOfficeTrendOS',
        'encounterOfficeP1y',
        'encounterOfficeCyOS',
        'encounterOfficeCy',
        'encounterOfficeMonthGraphOS',
        'cashPostedOfficeTrendOS',
        'cashPostedOfficeP1y',
        'cashPostedOfficeP1OS',
        'cashPostedOfficeCyOS',
        'cashPostedOfficeCyOS1',
        'cashPostedOfficeMonthGraphOS',
        'esrdPatientsPerPhysicians',
        'newPatientsPerPhysicians',
        'avgRevenuePerPhysiciansperDays',
        'newPatientsActualMonths',
        'activePatientsActualMonths'));
    }
    
}
