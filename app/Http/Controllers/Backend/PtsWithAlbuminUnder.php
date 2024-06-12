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

class PtsWithAlbuminUnder extends Controller
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
       
        $newPatientsActualMonths =  DB::select('CALL new_patients_count_actual_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        $activePatientsActualMonths =  DB::select('CALL active_patients_count_actual_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        
        $ptswithalbuminunder2months =  DB::select('CALL pts_with_albumin_under_2_months(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        // dd($ptswithalbuminunder2months);
        $ptswithalbuminunder2monthspct =  DB::select('CALL pts_with_albumin_under_2_months_pct(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        // dd($ptswithalbuminunder2monthspct);

        $analysisController = new AnalysisController();

        $listOfPtWithAlbuminUnder2Point0F = $analysisController->listOfPtWithAlbuminUnder2Point0();


           //dd($listOfPtWithAlbuminUnder2Point0F);
        return view('backend.pts-with-albumin-under',compact('activePatientPerPhysicians',
        'analysisController',
        'listOfPtWithAlbuminUnder2Point0F',
        'ptswithalbuminunder2months',
        'ptswithalbuminunder2monthspct',
        'esrdPatientsPerPhysicians',
        'newPatientsPerPhysicians',
        'avgRevenuePerPhysiciansperDays',
        'newPatientsActualMonths',
        'activePatientsActualMonths'));
    }

}
