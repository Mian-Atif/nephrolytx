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

class DriversOptimalStarts extends Controller
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
        
        $latestageckdvisitintervalD =  DB::select('CALL late_stage_ckd_visit_interval(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
         //dd($latestageckdvisitintervalD);
        $latestageckdvisitintervalD1 = $latestageckdvisitintervalD[0]->analysis_year_value;
        $latestageckdvisitintervalD2 = $latestageckdvisitintervalD[0]->prior_year_value;
        $latestageckdvisitintervalD3 = $latestageckdvisitintervalD[0]->yearly_change;
        
        $latestageckdvisitintervalmonthM =  DB::select('CALL late_stage_ckd_visit_interval_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
         //dd($latestageckdvisitintervalmonthM);

         $latestageckdwaittimeT =  DB::select('CALL late_stage_ckd_wait_time(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);

        $latestageckdwaittimeT1 = $latestageckdwaittimeT[0]->analysis_year_value;
        $latestageckdwaittimeT2 = $latestageckdwaittimeT[0]->prior_year_value;
        $latestageckdwaittimeT3 = $latestageckdwaittimeT[0]->trend_percent;
        
        $latestageckdwaittimemonthM =  DB::select('CALL late_stage_ckd_wait_time_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
         //dd($latestageckdwaittimemonthM);
        
        $timelyreferralD =  DB::select('CALL timely_referral(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        $timelyreferralD1 = $timelyreferralD[0]->analysis_year_value;
        $timelyreferralD2 = $timelyreferralD[0]->prior_year_value;
        $timelyreferralD3 = $timelyreferralD[0]->trend_percent;
        
        $timelyreferralmonthM =  DB::select('CALL timely_referral_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
         //dd($timelyreferralmonthM);

        $hospitaltoofficefollowupD =  DB::select('CALL hospital_to_office_follow_up(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);

        $hospitaltoofficefollowupD1 = $hospitaltoofficefollowupD[0]->analysis_year_value;
        $hospitaltoofficefollowupD2 = $hospitaltoofficefollowupD[0]->prior_year_value;
        $hospitaltoofficefollowupD3 = $hospitaltoofficefollowupD[0]->trend_percent;
        
        $hospitaltoofficefollowupmonthM =  DB::select('CALL hospital_to_office_follow_up_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        //dd($hospitaltoofficefollowupmonthM);

        $newstarthosp30priorD =  DB::select('CALL new_start_hosp_30_prior(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);

        $newstarthosp30priorD1 = $newstarthosp30priorD[0]->analysis_year_value;
        $newstarthosp30priorD2 = $newstarthosp30priorD[0]->prior_year_value;
        $newstarthosp30priorD3 = $newstarthosp30priorD[0]->trend_percent;
       
        $newstarthosp30priormonthM =  DB::select('CALL new_start_hosp_30_prior_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        //dd($newstarthosp30priormonth);
         
         return view('backend.drivers-optimal-starts',compact('activePatientPerPhysicians',
         'esrdPatientsPerPhysicians',
         'newstarthosp30priormonthM',
         'timelyreferralmonthM',
         'newstarthosp30priorD',
         'newstarthosp30priorD1',
         'newstarthosp30priorD2',
         'newstarthosp30priorD3',
         'latestageckdvisitintervalmonthM', 
         'hospitaltoofficefollowupmonthM',
         'hospitaltoofficefollowupD',
         'hospitaltoofficefollowupD1',
         'hospitaltoofficefollowupD2',
         'hospitaltoofficefollowupD3',
         'timelyreferralD',
         'timelyreferralD1',
         'timelyreferralD2',
         'timelyreferralD3',
         'latestageckdwaittimemonthM',
         'latestageckdwaittimeT',
         'latestageckdwaittimeT1',
         'latestageckdwaittimeT2',
         'latestageckdwaittimeT3',
         'latestageckdvisitintervalD',
         'latestageckdvisitintervalD1',
         'latestageckdvisitintervalD2',
         'latestageckdvisitintervalD3',
         'newPatientsPerPhysicians',
         'avgRevenuePerPhysiciansperDays',
         'newPatientsActualMonths',
         'activePatientsActualMonths'));
    }
    
}
