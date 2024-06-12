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
ProductivityOthers extends Controller
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
        
        $ProductivityPerYearTableY = $analysisController->ProductivityPerYearTable();
        // dd($ProductivityPerYearTableY);
        
        $ProductivityPerYearTableC1 = $ProductivityPerYearTableY[0]['cy'];
        $ProductivityPerYearTableP1 = $ProductivityPerYearTableY[0]['p1y'];
        $ProductivityPerYearTableP2 = $ProductivityPerYearTableY[0]['p2y']; 
        
        $ProductivityPerYearTableENC1 = $ProductivityPerYearTableY[1]['cy'];
        $ProductivityPerYearTableENP1 = $ProductivityPerYearTableY[1]['p1y'];
        $ProductivityPerYearTableENP2 = $ProductivityPerYearTableY[1]['p2y']; 
        
        $ProductivityPerYearTableTRC1 = $ProductivityPerYearTableY[2]['cy'];
        $ProductivityPerYearTableTRP1 = $ProductivityPerYearTableY[2]['p1y'];
        $ProductivityPerYearTableTRP2 = $ProductivityPerYearTableY[2]['p2y']; 
        
        $ProductivityPerMonthGraphM = $analysisController->ProductivityPerMonthGraph();
        // dd($ProductivityPerMonthGraphM);

            $activePatientsPerYearTableY = $analysisController->activePatientsPerYearTable();
            //dd($activePatientsPerYearTableTA);

            $activePatientsPerYearTableYAPBC1 = $activePatientsPerYearTableY[0]['cy'];
            $activePatientsPerYearTableYAPBP1 = $activePatientsPerYearTableY[0]['p1y'];
            $activePatientsPerYearTableYAPBP2 = $activePatientsPerYearTableY[0]['p2y']; 

            $activePatientsPerYearTableYPGC1 = $activePatientsPerYearTableY[1]['cy'];
            $activePatientsPerYearTableYPGP1 = $activePatientsPerYearTableY[1]['p1y'];
            $activePatientsPerYearTableYPGP2 = $activePatientsPerYearTableY[1]['p2y']; 

            $activePatientsPerYearTableYNCPC1 = $activePatientsPerYearTableY[2]['cy'];
            $activePatientsPerYearTableYNCPP1 = $activePatientsPerYearTableY[2]['p1y'];
            $activePatientsPerYearTableYNCPP2 = $activePatientsPerYearTableY[2]['p2y']; 

            $activePatientsPerYearTableYCPGC1 = $activePatientsPerYearTableY[3]['cy'];
            $activePatientsPerYearTableYCPGP1 = $activePatientsPerYearTableY[3]['p1y'];
            $activePatientsPerYearTableYCPGP2 = $activePatientsPerYearTableY[3]['p2y']; 
            
            $activePatientsPerMonthGraphM = $analysisController->activePatientsPerMonthGraph();
            //dd($activePatientsPerMonthGraphM);

            $CkdHospReAdmissionAndTcmPerYearTableY = $analysisController->CkdHospReAdmissionAndTcmPerYearTable();
            //dd($CkdHospReAdmissionAndTcmPerYearTableY);

            $CkdHospReAdmissionAndTcmPerYearTableHRC1 = $CkdHospReAdmissionAndTcmPerYearTableY[0]['cy'];
            $CkdHospReAdmissionAndTcmPerYearTableHRP1 = $CkdHospReAdmissionAndTcmPerYearTableY[0]['p1y'];
            $CkdHospReAdmissionAndTcmPerYearTableHRP2 = $CkdHospReAdmissionAndTcmPerYearTableY[0]['p2y']; 

            $CkdHospReAdmissionAndTcmPerYearTableTCMC1 = $CkdHospReAdmissionAndTcmPerYearTableY[1]['cy'];
            $CkdHospReAdmissionAndTcmPerYearTableTCMP1 = $CkdHospReAdmissionAndTcmPerYearTableY[1]['p1y'];
            $CkdHospReAdmissionAndTcmPerYearTableTCMP2 = $CkdHospReAdmissionAndTcmPerYearTableY[1]['p2y']; 

        return view('backend.productivity-others',
            compact('activePatientPerPhysicians',
                        'analysisController',
                        'CkdHospReAdmissionAndTcmPerYearTableTCMC1',
                        'CkdHospReAdmissionAndTcmPerYearTableTCMP1',
                        'CkdHospReAdmissionAndTcmPerYearTableTCMP2',
                        'CkdHospReAdmissionAndTcmPerYearTableHRP1',
                        'CkdHospReAdmissionAndTcmPerYearTableHRP2',
                        'CkdHospReAdmissionAndTcmPerYearTableHRC1',
                        'CkdHospReAdmissionAndTcmPerYearTableY',
                        'activePatientsPerMonthGraphM',
                        'activePatientsPerYearTableY',
                        'activePatientsPerYearTableYCPGC1',
                        'activePatientsPerYearTableYCPGP1',
                        'activePatientsPerYearTableYCPGP2',
                        'activePatientsPerYearTableYNCPC1',
                        'activePatientsPerYearTableYNCPP1',
                        'activePatientsPerYearTableYNCPP2',
                        'activePatientsPerYearTableYPGC1',
                        'activePatientsPerYearTableYPGP1',
                        'activePatientsPerYearTableYPGP2',
                        'activePatientsPerYearTableYAPBC1',
                        'activePatientsPerYearTableYAPBP1',
                        'activePatientsPerYearTableYAPBP2',
                        'ProductivityPerMonthGraphM',
                        'ProductivityPerYearTableTRC1',
                        'ProductivityPerYearTableTRP1',
                        'ProductivityPerYearTableTRP2',
                        'ProductivityPerYearTableENC1',
                        'ProductivityPerYearTableENP1',
                        'ProductivityPerYearTableENP2',
                        'ProductivityPerYearTableY',
                        'ProductivityPerYearTableC1',
                        'ProductivityPerYearTableP1',
                        'ProductivityPerYearTableP2',
                    'esrdPatientsPerPhysicians',
                    'newPatientsPerPhysicians',
                    'avgRevenuePerPhysiciansperDays',
                    'newPatientsActualMonths',
                    'activePatientsActualMonths'));
    }
    
}
