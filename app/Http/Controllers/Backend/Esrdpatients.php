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
use App\Http\Controllers\nepanalysis\AnalysisController;

class
Esrdpatients extends Controller
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
       // $activePatientsActualMonths =  DB::select('CALL active_patients_count_actual_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
       
        $activePatientsActualMonths =  DB::select('CALL active_esrd_patients_balance_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);

        
        $activeESRDPatientsBalanceYear =  DB::select('CALL active_esrd_patients_balance_year_ends(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);

        if(count($activePatientsActualMonths) >= 13){
            $activePatientsActual12Months = array_slice($activePatientsActualMonths, 1, 13);
        }else{
            $activePatientsActual12Months = $activePatientsActualMonths;
        }
        $aEsrd1 = self::checkNullActiveEsrd($activeESRDPatientsBalanceYear[0]);
        $aEsrd2 = self::checkNullActiveEsrd($activeESRDPatientsBalanceYear[1]);
        $aEsrd3 = self::checkNullActiveEsrd($activeESRDPatientsBalanceYear[2]);
        $aEsrd4 = self::checkNullActiveEsrd($activeESRDPatientsBalanceYear[3]);


        $newDialysisStartYearGraphMonths =  DB::select('CALL ESRD_starts_count_actual_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        $newDialysisStartYear =  DB::select('CALL new_dialysis_starts_year(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        $newDialysisStartYearGraph12Months = $newDialysisStartYearGraphMonths;
        //dd($newDialysisStartYearGraphMonths);
        // if(count($newDialysisStartYearGraphMonths) >= 13){
        //     $newDialysisStartYearGraph12Months = array_slice($newDialysisStartYearGraphMonths, 0, 12);
        // }else{
        //     $newDialysisStartYearGraph12Months = $newDialysisStartYearGraphMonths;
        // }

        $nDailysis1 = self::checkNullActiveEsrd($newDialysisStartYear[0]);
        $nDailysis2 = self::checkNullActiveEsrd($newDialysisStartYear[1]);
        $nDailysis3 = self::checkNullActiveEsrd($newDialysisStartYear[2]);
        $nDailysis4 = self::checkNullActiveEsrd($newDialysisStartYear[3]);
        $nDailysis5 = self::checkNullActiveEsrd($newDialysisStartYear[4]);
        $nDailysis6 = self::checkNullActiveEsrd($newDialysisStartYear[5]);

        // dd($nDailysis4);
        
        $home_dialysis_year =  DB::select('CALL home_dialysis_year(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        
        $incident_home = $home_dialysis_year[0];
        $home_training_capture = $home_dialysis_year[1];
        $home_dialysis_month =  DB::select('CALL home_dialysis_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
       // dd($home_dialysis_month);

       $analysisController = new AnalysisController();

       $incidentHomeMonthGraph = $analysisController->incidentHomeMonthGraph();

    //    dd($incidentHomeMonthGraph);

        return view('backend.esrdpatients',compact('activePatientPerPhysicians',
                                                    'esrdPatientsPerPhysicians',
                                                    'newPatientsPerPhysicians',
                                                    'avgRevenuePerPhysiciansperDays',
                                                    'newPatientsActualMonths',
                                                    'activePatientsActualMonths',
                                                    'activePatientsActual12Months',
                                                    'incidentHomeMonthGraph',
                                                    'aEsrd1',
                                                    'aEsrd2',
                                                    'aEsrd3',
                                                    'aEsrd4',
                                                    'newDialysisStartYearGraph12Months',
                                                    'nDailysis1',
                                                    'nDailysis2',
                                                    'nDailysis3',
                                                    'nDailysis4',
                                                    'nDailysis5',
                                                    'nDailysis6',
                                                    'incident_home',
                                                    'home_training_capture',
                                                    'home_dialysis_month'
                                                ));
    }

    public function checkNullActiveEsrd($aEsrd){
        
        $aEsrd->cy = isset($aEsrd->cy) && !empty($aEsrd->cy) ? $aEsrd->cy : 0;
        $aEsrd->p1y = isset($aEsrd->p1y) && !empty($aEsrd->p1y) ? $aEsrd->p1y : 0;
        $aEsrd->p2y = isset($aEsrd->p2y) && !empty($aEsrd->p2y) ? $aEsrd->p2y : 0;

        return $aEsrd;
    }
    
}
