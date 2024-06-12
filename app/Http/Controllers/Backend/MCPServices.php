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

class MCPServices extends Controller
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
        

        $cashPostedMcpMonthGraphMCP = $analysisController->cashPostedMcpMonthGraph();

        $cashPostedMcpCy = $analysisController->cashPostedMcpCy(); 
        $cashPostedMcpCyMCP = $cashPostedMcpCy;
        $cashPostedMcpP1y = $analysisController->cashPostedMcpP1y();  
        $cashPostedMcpP1yMCP = $cashPostedMcpP1y;
        $cashPostedMcpTrendMCP = $analysisController->cashPostedMcpTrend();
         
       
        $encounterMcpMonthGraphMCP = $analysisController->encounterMcpMonthGraph();
        
        $encounterMcpCy = $analysisController->encounterMcpCy(); 
        $encounterMcpCyMCP = $encounterMcpCy;
        $encounterMcpP1y = $analysisController->encounterMcpP1y(); 
        $encounterMcpP1yMCP = $encounterMcpP1y;
        $encountersMcpTrendMCP = $analysisController->encountersMcpTrend();
      
       
        $patientsSeenMcpMonthGraphMCP = $analysisController->patientsSeenMcpMonthGraph();
        //dd($patientsSeenMcpMonthGraphMCP);
       
        $patientsSeenMcpCy = $analysisController->patientsSeenMcpCy(); 
        $patientsSeenMcpCyMCP = $patientsSeenMcpCy;
        $patientsSeenMcpP1y = $analysisController->patientsSeenMcpP1y(); 
        $patientsSeenMcpP1yMCP = $patientsSeenMcpP1y;
        $patientsSeenMcpTrendMCP = $analysisController->patientsSeenMcpTrend();
    
        $newPatientsMcpMonthGraphMCP = $analysisController->newPatientsMcpMonthGraph();
         // dd($newPatientsMcpMonthGraphMCP);
        
        $newPatientsMcpCy = $analysisController->newPatientsMcpCy(); 
        $newPatientsMcpCyMCP = $newPatientsMcpCy;
        $newPatientsMcpP1y = $analysisController->newPatientsMcpP1y();  
        $newPatientsMcpP1yMCP = $newPatientsMcpP1y;
        $newPatientsMcpTrendMCP = $analysisController->newPatientsMcpTrend();

        $totalPaymentEarlyStageMcp = $analysisController->totalPaymentEarlyStageMcp();   
        $totalPaymentEarlyStageMcpCY = $totalPaymentEarlyStageMcp[0]->total_payment_early_stage_cy;
        $totalPaymentEarlyStageMcpP1Y = $totalPaymentEarlyStageMcp[0]->total_payment_early_stage_p1y;
        
        $totalPaymentStage4ckdMcp = $analysisController->totalPaymentStage4ckdMcp();
        $totalPaymentStage4ckdMcpCY = $totalPaymentStage4ckdMcp[0]->total_payment_ckd4_cy;
        $totalPaymentStage4ckdMcpP1Y = $totalPaymentStage4ckdMcp[0]->total_payment_ckd4_p1y;
        
        $totalPaymentStage5ckdMcp = $analysisController->totalPaymentStage5ckdMcp();  
        $totalPaymentStage5ckdMcpCY = $totalPaymentStage5ckdMcp[0]->total_payment_ckd5_cy;
        $totalPaymentStage5ckdMcpP1Y = $totalPaymentStage5ckdMcp[0]->total_payment_ckd5_p1y;
        
        $totalPaymentEsrdMcp = $analysisController->totalPaymentEsrdMcp(); 
        $totalPaymentEsrdMcpCY = $totalPaymentEsrdMcp[0]->total_payment_esrd_cy;
        $totalPaymentEsrdMcpP1Y = $totalPaymentEsrdMcp[0]->total_payment_esrd_p1y;
       
        $totalPaymentNonCkdMcp = $analysisController->totalPaymentNonCkdMcp(); 
        //dd($totalPaymentNonCkdMcp);
        $totalPaymentNonCkdMcpCY = $totalPaymentNonCkdMcp[0]->total_payment_non_ckd_cy;
        $totalPaymentNonCkdMcpP1y = $totalPaymentNonCkdMcp[0]->total_payment_non_ckd_p1y;

        $cashPerPatientMcp = $analysisController->cashPerPatientMcp();
        $totalPaymentsMcp = $analysisController->totalPaymentsMcp();
        $cashPerEncountersMcp = $analysisController->cashPerEncountersMcp();
        $totalEncountersMcp = $analysisController->totalEncountersMcp();
        $totalPatientsMcp = $analysisController->totalPatientsMcp();
        $encounterPerPatientMcp = $analysisController->encounterPerPatientMcp();
        $newPatientMcp = $analysisController->newPatientMcp();
        
        
       
        return view('backend.summary-mcp-services',compact('activePatientPerPhysicians',
        'esrdPatientsPerPhysicians',
        'newPatientMcp',
        'encounterPerPatientMcp',
        'totalPatientsMcp',
        'totalEncountersMcp',
        'cashPerEncountersMcp',
        'cashPerPatientMcp',
        'totalPaymentsMcp',
        'totalPaymentNonCkdMcp',
        'totalPaymentNonCkdMcpCY',
        'totalPaymentNonCkdMcpP1y',
        'totalPaymentEsrdMcp',
        'totalPaymentEsrdMcpCY',
        'totalPaymentEsrdMcpP1Y',
        'totalPaymentStage5ckdMcp',
        'totalPaymentStage5ckdMcpCY',
        'totalPaymentStage5ckdMcpP1Y',
        'totalPaymentStage4ckdMcp',
        'totalPaymentStage4ckdMcpCY',
        'totalPaymentStage4ckdMcpP1Y',
        'totalPaymentEarlyStageMcp',
        'totalPaymentEarlyStageMcpCY',
        'totalPaymentEarlyStageMcpP1Y',
        'newPatientsMcpTrendMCP',
        'newPatientsMcpP1y',
        'newPatientsMcpP1yMCP',
        'newPatientsMcpCy',
        'newPatientsMcpCyMCP',
        'newPatientsMcpMonthGraphMCP',
        'patientsSeenMcpTrendMCP',
        'patientsSeenMcpP1y',
        'patientsSeenMcpP1yMCP',
        'patientsSeenMcpCyMCP',
        'patientsSeenMcpCy',
        'patientsSeenMcpMonthGraphMCP',
        'encountersMcpTrendMCP',
        'encounterMcpP1y',
        'encounterMcpP1yMCP',
        'encounterMcpCy',
        'encounterMcpCyMCP',
        'encounterMcpMonthGraphMCP',
        'cashPostedMcpTrendMCP',
        'cashPostedMcpP1yMCP',
        'cashPostedMcpP1y',
        'cashPostedMcpCy',
        'cashPostedMcpCyMCP',
        'analysisController',
        'cashPostedMcpMonthGraphMCP',
        'newPatientsPerPhysicians',
        'avgRevenuePerPhysiciansperDays',
        'newPatientsActualMonths',
        'activePatientsActualMonths'));
    }
    
}
