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

class PtRosterList extends Controller
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
        
        $totalBalanceofPatientsbyStagePT = $analysisController->totalBalanceofPatientsbyStage();
           

            $totalBalanceofPatientsbyStagePT1 = $totalBalanceofPatientsbyStagePT[0]->early;
            $totalBalanceofPatientsbyStagePT2 = $totalBalanceofPatientsbyStagePT[0]->esrd;
            $totalBalanceofPatientsbyStagePT3 = $totalBalanceofPatientsbyStagePT[0]->nonesrd;
            $totalBalanceofPatientsbyStagePT4 = $totalBalanceofPatientsbyStagePT[0]->ckd4;
            $totalBalanceofPatientsbyStagePT5 = $totalBalanceofPatientsbyStagePT[0]->ckd5;

           $activeESRDBalanceBillingTablePT = $analysisController->activeESRDBalanceBillingTable();
           //dd($activeESRDBalanceBillingTablePT);
           $activeESRDBalanceBillingTablePTBase1 = $activeESRDBalanceBillingTablePT[0]['Billed_As_Mcp'];   
           $activeESRDBalanceBillingTablePTBase2 = $activeESRDBalanceBillingTablePT[0]['Billed_As_Non_Mcp'];
           $activeESRDBalanceBillingTablePTBase3 = $activeESRDBalanceBillingTablePT[0]['Not_Billed']; 
            
           $activeESRDBalanceBillingTablePTReA1 = $activeESRDBalanceBillingTablePT[1]['Billed_As_Mcp'];   
           $activeESRDBalanceBillingTablePTReA2 = $activeESRDBalanceBillingTablePT[1]['Billed_As_Non_Mcp'];
           $activeESRDBalanceBillingTablePTReA3 = $activeESRDBalanceBillingTablePT[1]['Not_Billed']; 
           
           $activeESRDBalanceBillingTablePTN1 = $activeESRDBalanceBillingTablePT[2]['Billed_As_Mcp'];   
           $activeESRDBalanceBillingTablePTN2 = $activeESRDBalanceBillingTablePT[2]['Billed_As_Non_Mcp'];
           $activeESRDBalanceBillingTablePTN3 = $activeESRDBalanceBillingTablePT[2]['Not_Billed']; 
           
           $activeESRDBalanceBillingTablePTT1 = $activeESRDBalanceBillingTablePT[3]['Total_base'];   
           $activeESRDBalanceBillingTablePTT2 = $activeESRDBalanceBillingTablePT[3]['Total_reactivated'];
           $activeESRDBalanceBillingTablePTT3 = $activeESRDBalanceBillingTablePT[3]['Total_new']; 
           $activeESRDBalanceBillingTablePTT4 = $activeESRDBalanceBillingTablePT[3]['total_over_all ']; 

           $activeESRDBalanceBillingTablePTOT1 = $activeESRDBalanceBillingTablePT[4]['Billed_As_Mcp'];   
           $activeESRDBalanceBillingTablePTOT2 = $activeESRDBalanceBillingTablePT[4]['Billed_As_Non_Mcp'];
           $activeESRDBalanceBillingTablePTOT3 = $activeESRDBalanceBillingTablePT[4]['Not_Billed']; 
             $patientRosterPT = $analysisController->patientRoster();
            
              //dd($patientRosterPT);
        
        
                return view('backend.pt-roster-list',compact('activePatientPerPhysicians',
        'esrdPatientsPerPhysicians',
        'patientRosterPT',
        'activeESRDBalanceBillingTablePTOT1',
        'activeESRDBalanceBillingTablePTOT2',
        'activeESRDBalanceBillingTablePTOT3',
        'activeESRDBalanceBillingTablePTT1',
        'activeESRDBalanceBillingTablePTT2',
        'activeESRDBalanceBillingTablePTT3',
        'activeESRDBalanceBillingTablePTT4',
        'activeESRDBalanceBillingTablePTN1',
        'activeESRDBalanceBillingTablePTN2',
        'activeESRDBalanceBillingTablePTN3',
        'totalBalanceofPatientsbyStagePT',
        'activeESRDBalanceBillingTablePTReA1',
        'activeESRDBalanceBillingTablePTReA2',
        'activeESRDBalanceBillingTablePTReA3',
        'activeESRDBalanceBillingTablePT',
        'activeESRDBalanceBillingTablePTBase1',
        'activeESRDBalanceBillingTablePTBase2',
        'activeESRDBalanceBillingTablePTBase3',
        'totalBalanceofPatientsbyStagePT1',
        'totalBalanceofPatientsbyStagePT2',
        'totalBalanceofPatientsbyStagePT3',
        'totalBalanceofPatientsbyStagePT4',
        'totalBalanceofPatientsbyStagePT5',
        'analysisController',
        'newPatientsPerPhysicians',
        'avgRevenuePerPhysiciansperDays',
        'newPatientsActualMonths',
        'activePatientsActualMonths'));
    }
    

    public function followUpRoaster()
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
        // //dd($mileFromOffice);
        // $mileFromOffice2['count'] = 10785236;
        // $mileFromOffice2['photos'] = $mileFromOffice;
        // $mileFromOffice = $mileFromOffice2;
        


        $analysisController = new AnalysisController();
            
        $patientsByStagePF = $analysisController->patientsByStage();
           // dd($patientsByStagePF);

        $patientsByStagePF1 = isset($patientsByStagePF[0]->vls) && !empty($patientsByStagePF[0]->vls) ? $patientsByStagePF[0]->vls : 0;
        $patientsByStagePF2 = isset($patientsByStagePF[1]->vls) && !empty($patientsByStagePF[1]->vls) ? $patientsByStagePF[1]->vls : 0;
        $patientsByStagePF3 = isset($patientsByStagePF[2]->vls) && !empty($patientsByStagePF[2]->vls) ? $patientsByStagePF[2]->vls : 0;
        $patientsByStagePF4 = isset($patientsByStagePF[3]->vls) && !empty($patientsByStagePF[3]->vls) ? $patientsByStagePF[3]->vls : 0;
        $patientsByStagePF5 = isset($patientsByStagePF[4]->vls) && !empty($patientsByStagePF[4]->vls) ? $patientsByStagePF[4]->vls : 0;
        
            $mapofPatientsPR = $analysisController->mapofPatients();
            $mapofPatientsPR2['count'] = 10785236;
            $mapofPatientsPR2['photos'] = $mapofPatientsPR;
            $mapofPatientsPR = $mapofPatientsPR2;
               //dd($mapofPatientsPR);
        
        $patientRosterLastDaySeen1 = $analysisController->patientRosterLastDaySeen();
         //dd($patientRosterLastDaySeen1);
           
           
           return view('backend.pt-follow-up-roster',compact('activePatientPerPhysicians',
        'esrdPatientsPerPhysicians',
        'patientsByStagePF',
        'patientsByStagePF1',
        'patientsByStagePF2',
        'patientsByStagePF3',
        'patientsByStagePF4',
        'patientsByStagePF5',
        'analysisController',
        'newPatientsPerPhysicians',
        'avgRevenuePerPhysiciansperDays',
        'newPatientsActualMonths',
        'activePatientsActualMonths',
        'mapofPatientsPR',
        'patientRosterLastDaySeen1'));
    }

}
