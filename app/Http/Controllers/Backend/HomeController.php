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
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomEmail;

class
HomeController extends Controller
{

    public function home()
    {

   
        $user = Auth::user();
        
        $practice_id = $user->practice_id;
       
        $provider = '';
        $location = '';
        $insurance = '';




        // Activity - Expected Revenue
        $averageRevenuePerMonths =  DB::select('CALL average_revenue_per_visit_actual_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
       
        //dd($averageRevenuePerMonths);
        $averageRevenuePerQuarter =  DB::select('CALL average_revenue_per_visit_actual_quarter(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        $averageRevenuePerYear =  DB::select('CALL average_revenue_per_visit_actual_year(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
     
        // Activity - Patients Seen
        $patientsSeenPerMonths =  DB::select('CALL active_patients_count_actual_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        //dd($patientsSeenPerMonths);
        $patientsSeenPerQuarter =  DB::select('CALL active_patients_count_actual_quarter(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        $patientsSeenPerYear =  DB::select('CALL active_patients_count_actual_year(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
     
        // Activity - ESRD Starts
        $esrdStartsPerMonths =  DB::select('CALL esrd_starts_count_actual_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
         //dd($esrdStartsPerMonths);
        $esrdStartsPerYear =  DB::select('CALL esrd_starts_count_actual_year(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        $esrdStartsPerQuarter =  DB::select('CALL esrd_starts_count_actual_quarter(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        
        // Activity - New Patients
        $newPatientsActualMonths =  DB::select('CALL new_patients_count_actual_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        // dd($newPatientsActualMonths);
        
       $newPatientsActualQuarter =  DB::select('CALL new_patients_count_actual_quarter(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
       
       $newPatientsActualYear =  DB::select('CALL new_patients_count_actual_year(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        
        // Four Single Graph: Key Performance Indicators
        $activePatientPerPhysicians =  DB::select('CALL active_patients_count_per_physician(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        $esrdPatientsPerPhysicians =  DB::select('CALL ESRD_patients_count_per_physician(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        $newPatientsPerPhysicians =  DB::select('CALL new_patients_count_per_physician(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        $avgRevenuePerPhysiciansperDays =  DB::select('CALL average_revenue_per_physician_per_day(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
      
        $home_patients_jsons = '{"active_patients_balance_count_actual_month":[{"kys":"Dec-21","vals":251},{"kys":"Jan-22","vals":261},{"kys":"Feb-22","vals":269},{"kys":"Mar-22","vals":270},{"kys":"Apr-22","vals":272},{"kys":"May-22","vals":274},{"kys":"Jun-22","vals":274},{"kys":"Jul-22","vals":275},{"kys":"Aug-22","vals":272},{"kys":"Sep-22","vals":272},{"kys":"Oct-22","vals":272},{"kys":"Nov-22","vals":278},{"kys":"Dec-22","vals":272}],"active_patients_balance_count_actual_quarter":[{"kys":"Q1-20","vals":74},{"kys":"Q2-20","vals":143},{"kys":"Q3-20","vals":216},{"kys":"Q4-20","vals":294},{"kys":"Q1-21","vals":284},{"kys":"Q2-21","vals":275},{"kys":"Q3-21","vals":273},{"kys":"Q4-21","vals":271},{"kys":"Q1-22","vals":270},{"kys":"Q2-22","vals":274},{"kys":"Q3-22","vals":275},{"kys":"Q4-22","vals":278}],"active_patients_balance_count_actual_year":[{"kys":2020,"vals":294},{"kys":2021,"vals":284},{"kys":2022,"vals":278}],"esrd_patients_count_actual_month":[{"kys":"Dec-21","vals":53},{"kys":"Jan-22","vals":53},{"kys":"Feb-22","vals":54},{"kys":"Mar-22","vals":56},{"kys":"Apr-22","vals":57},{"kys":"May-22","vals":57},{"kys":"Jun-22","vals":56},{"kys":"Jul-22","vals":57},{"kys":"Aug-22","vals":55},{"kys":"Sep-22","vals":52},{"kys":"Oct-22","vals":52},{"kys":"Nov-22","vals":51},{"kys":"Dec-22","vals":51}],"esrd_patients_count_actual_quarter":[{"kys":"Q1-20","vals":12},{"kys":"Q2-20","vals":22},{"kys":"Q3-20","vals":33},{"kys":"Q4-20","vals":53},{"kys":"Q1-21","vals":55},{"kys":"Q2-21","vals":56},{"kys":"Q3-21","vals":58},{"kys":"Q4-21","vals":54},{"kys":"Q1-22","vals":56},{"kys":"Q2-22","vals":57},{"kys":"Q3-22","vals":57},{"kys":"Q4-22","vals":52}],"esrd_patients_count_actual_year":[{"kys":2020,"vals":53},{"kys":2021,"vals":58},{"kys":2022,"vals":57}],"early_stage_ckd_patient_count_actual_month":[{"kys":"Dec-21","vals":107},{"kys":"Jan-22","vals":112},{"kys":"Feb-22","vals":114},{"kys":"Mar-22","vals":114},{"kys":"Apr-22","vals":115},{"kys":"May-22","vals":118},{"kys":"Jun-22","vals":118},{"kys":"Jul-22","vals":119},{"kys":"Aug-22","vals":120},{"kys":"Sep-22","vals":120},{"kys":"Oct-22","vals":120},{"kys":"Nov-22","vals":126},{"kys":"Dec-22","vals":125}],"early_stage_ckd_patient_count_actual_quarter":[{"kys":"Q1-20","vals":28},{"kys":"Q2-20","vals":54},{"kys":"Q3-20","vals":78},{"kys":"Q4-20","vals":99},{"kys":"Q1-21","vals":93},{"kys":"Q2-21","vals":97},{"kys":"Q3-21","vals":107},{"kys":"Q4-21","vals":110},{"kys":"Q1-22","vals":114},{"kys":"Q2-22","vals":118},{"kys":"Q3-22","vals":120},{"kys":"Q4-22","vals":126}],"early_stage_ckd_patient_count_actual_year":[{"kys":2020,"vals":99},{"kys":2021,"vals":110},{"kys":2022,"vals":126}],"late_stage_ckd_patient_count_actual_month":[{"kys":"Dec-21","vals":76},{"kys":"Jan-22","vals":78},{"kys":"Feb-22","vals":84},{"kys":"Mar-22","vals":88},{"kys":"Apr-22","vals":92},{"kys":"May-22","vals":93},{"kys":"Jun-22","vals":94},{"kys":"Jul-22","vals":93},{"kys":"Aug-22","vals":92},{"kys":"Sep-22","vals":93},{"kys":"Oct-22","vals":94},{"kys":"Nov-22","vals":96},{"kys":"Dec-22","vals":96}],"late_stage_ckd_patient_count_actual_quarter":[{"kys":"Q1-20","vals":21},{"kys":"Q2-20","vals":36},{"kys":"Q3-20","vals":53},{"kys":"Q4-20","vals":72},{"kys":"Q1-21","vals":70},{"kys":"Q2-21","vals":69},{"kys":"Q3-21","vals":78},{"kys":"Q4-21","vals":80},{"kys":"Q1-22","vals":88},{"kys":"Q2-22","vals":94},{"kys":"Q3-22","vals":93},{"kys":"Q4-22","vals":96}],"late_stage_ckd_patient_count_actual_year":[{"kys":2020,"vals":72},{"kys":2021,"vals":80},{"kys":2022,"vals":96}]}';
        $home_patients_json = json_decode($home_patients_jsons);


        // Patient Balance Active Patients Graphs
        
        // $patientBalanceMonthsAll =  DB::select('CALL patients_balance_actual_month_for_all(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        
        // Array Order Change 
        $activePatientsActualMonths = $esrdPatientsActualMonths = $earlyStageCkdPatientsActualMonths = $lateStageCkdPatientsActualMonths = array();
        $cas = 0;
        // foreach($patientBalanceMonthsAll as $patientBalanceMonth):

        //     $activePatientsActualMonths[$cas]['kys'] = $patientBalanceMonth->kys;
        //     $activePatientsActualMonths[$cas]['vals'] = $patientBalanceMonth->active_patients;

        //     $esrdPatientsActualMonths[$cas]['kys'] = $patientBalanceMonth->kys;
        //     $esrdPatientsActualMonths[$cas]['vals'] = $patientBalanceMonth->esrd_patients;

        //     $earlyStageCkdPatientsActualMonths[$cas]['kys'] = $patientBalanceMonth->kys;
        //     $earlyStageCkdPatientsActualMonths[$cas]['vals'] = $patientBalanceMonth->early_ckd_patients;
            
        //     $lateStageCkdPatientsActualMonths[$cas]['kys'] = $patientBalanceMonth->kys;
        //     $lateStageCkdPatientsActualMonths[$cas]['vals'] = $patientBalanceMonth->late_ckd_patients;

        //     $cas++;
        // endforeach;
        
        $activePatientsActualMonths = json_decode(json_encode($activePatientsActualMonths));
        $esrdPatientsActualMonths = json_decode(json_encode($esrdPatientsActualMonths));
        $earlyStageCkdPatientsActualMonths = json_decode(json_encode($earlyStageCkdPatientsActualMonths));
        $lateStageCkdPatientsActualMonths = json_decode(json_encode($lateStageCkdPatientsActualMonths));

        
        // $patientBalanceQuarterAll =  DB::select('CALL patients_balance_actual_quarter_for_all(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
       
        // Array Order Change 

        $activePatientsActualQuarter = $esrdPatientsActualQuarter = $earlyStageCkdPatientsActualQuarter = $lateStageCkdPatientsActualQuarter = array();
        $cas = 0;
        // foreach($patientBalanceQuarterAll as $patientBalanceQuarter):

        //     $activePatientsActualQuarter[$cas]['kys'] = $patientBalanceQuarter->kys;
        //     $activePatientsActualQuarter[$cas]['vals'] = $patientBalanceQuarter->active_patients;
            
        //     $esrdPatientsActualQuarter[$cas]['kys'] = $patientBalanceQuarter->kys;
        //     $esrdPatientsActualQuarter[$cas]['vals'] = $patientBalanceQuarter->esrd_patients;
            
        //     $earlyStageCkdPatientsActualQuarter[$cas]['kys'] = $patientBalanceQuarter->kys;
        //     $earlyStageCkdPatientsActualQuarter[$cas]['vals'] = $patientBalanceQuarter->early_ckd_patients;
            
        //     $lateStageCkdPatientsActualQuarter[$cas]['kys'] = $patientBalanceQuarter->kys;
        //     $lateStageCkdPatientsActualQuarter[$cas]['vals'] = $patientBalanceQuarter->late_ckd_patients;

        //     $cas++;
        
        // endforeach;
       
        $activePatientsActualQuarter = json_decode(json_encode($activePatientsActualQuarter));
        $esrdPatientsActualQuarter = json_decode(json_encode($esrdPatientsActualQuarter));
        $earlyStageCkdPatientsActualQuarter = json_decode(json_encode($earlyStageCkdPatientsActualQuarter));
        $lateStageCkdPatientsActualQuarter = json_decode(json_encode($lateStageCkdPatientsActualQuarter));

        // $patientBalanceYearAll =  DB::select('CALL patients_balance_actual_year_for_all(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);
        
        // Array Order Change 
        
        $activePatientsActualYear = $esrdPatientsActualYear = $earlyStageCkdPatientsActualYear = $lateStageCkdPatientsActualYear = array();
        $cas = 0;
        // foreach($patientBalanceYearAll as $patientBalanceYear):

        //     $activePatientsActualYear[$cas]['kys'] = $patientBalanceYear->kys;
        //     $activePatientsActualYear[$cas]['vals'] = $patientBalanceYear->active_patients;

        //     $esrdPatientsActualYear[$cas]['kys'] = $patientBalanceYear->kys;
        //     $esrdPatientsActualYear[$cas]['vals'] = $patientBalanceYear->esrd_patients;

        //     $earlyStageCkdPatientsActualYear[$cas]['kys'] = $patientBalanceYear->kys;
        //     $earlyStageCkdPatientsActualYear[$cas]['vals'] = $patientBalanceYear->early_ckd_patients;

        //     $lateStageCkdPatientsActualYear[$cas]['kys'] = $patientBalanceYear->kys;
        //     $lateStageCkdPatientsActualYear[$cas]['vals'] = $patientBalanceYear->late_ckd_patients;
            
        //     $cas++;
        // endforeach;
        
        $activePatientsActualYear = json_decode(json_encode($activePatientsActualYear));
        $esrdPatientsActualYear = json_decode(json_encode($esrdPatientsActualYear));
        $earlyStageCkdPatientsActualYear = json_decode(json_encode($earlyStageCkdPatientsActualYear));
        $lateStageCkdPatientsActualYear = json_decode(json_encode($lateStageCkdPatientsActualYear));

        return view('backend.home',compact(
                                    'averageRevenuePerYear',
                                    'averageRevenuePerQuarter',
                                    'averageRevenuePerMonths',
                                    'patientsSeenPerYear',
                                    'patientsSeenPerQuarter',
                                    'patientsSeenPerMonths',
                                    'esrdStartsPerMonths',
                                    'esrdStartsPerYear',
                                    'esrdStartsPerQuarter',
                                    'newPatientsActualMonths',
                                    'newPatientsActualQuarter',
                                    'newPatientsActualYear',
                                    'activePatientPerPhysicians',
                                    'esrdPatientsPerPhysicians',
                                    'newPatientsPerPhysicians',
                                    'avgRevenuePerPhysiciansperDays',
                                    'activePatientsActualMonths',
                                    'activePatientsActualQuarter',
                                    'activePatientsActualYear',
                                    'esrdPatientsActualMonths',
                                    'esrdPatientsActualQuarter',
                                    'esrdPatientsActualYear',
                                    'earlyStageCkdPatientsActualMonths',
                                    'earlyStageCkdPatientsActualQuarter',
                                    'earlyStageCkdPatientsActualYear',
                                    'lateStageCkdPatientsActualMonths',
                                    'lateStageCkdPatientsActualQuarter',
                                    'lateStageCkdPatientsActualYear'
                                )
                    );
    }

    function test_query_time (){


        $start = microtime(true);

        $practice_id = 1;
        $location  = '';
        $provider  = '';
        $insurance  = '';

        $practice_id = 1;
        $maxDate = DB::table("analytic_data")
            ->where('practice_id',$practice_id)
            ->max('Date_of_Service');

        $dbraw = DB::table("analytic_data")
            //->select()
            ->where('practice_id',$practice_id)
            ->where('Date_of_Service','>=',DB::raw("DATE_SUB(DATE_ADD('$maxDate',INTERVAL -DAY('$maxDate')+1 DAY), INTERVAL 11 MONTH)"))
            ->distinct('account_nbr_nbr')
            ->count('activePts');
            $time = microtime(true) - $start;
            dd($dbraw,$time);

    }

    public function test_query_time_mysql(){

        $start = microtime(true);

        $practice_id = 1;
        $location  = '';
        $provider  = '';
        $insurance  = '';

        $patientsSeenPerMonths =  DB::select('CALL active_patients_count(?,?,?,?,?)', [$practice_id, $location, $provider, $insurance,'']);

            $time = microtime(true) - $start;
            dd($patientsSeenPerMonths,$time);

    }
    public function revenue_per_fte_month_mysql(){
        
        $start = microtime(true);

        $practice_id = 1;
        $location  = '';
        $provider  = '';
        $insurance  = '';

        $patientsSeenPerMonths =  DB::select('CALL revenue_per_fte_month(?,?,?,?)', [$practice_id, $location, $provider, $insurance]);

            $time = microtime(true) - $start;
            dd($patientsSeenPerMonths,$time);

    }

    public function revenue_per_fte_month_orm(){

        // revenue_per_fte_month

        $start = microtime(true);

        $analysis_end_date = DB::table('analytic_data')
                            ->where('practice_id','=',1)
                            ->max('Date_of_Service');

        $result = DB::table('analytic_data')
        ->select(DB::raw('date_format(Date_of_Service,"%b-%y") kys,round(sum(primary_insurance_payment+secondary_insurance_payment+patient_payment),0) vals'))
        ->groupBy(DB::raw('date_format(Date_of_Service,"%b-%y"),date_format(Date_of_Service,"%y-%m") order by date_format(Date_of_Service,"%y-%m")'))
        ->where('Date_of_Service','>=',DB::raw("DATE_SUB(DATE_ADD('$analysis_end_date',INTERVAL -DAY('$analysis_end_date')+1 DAY), INTERVAL 11 MONTH)"))   
        ->where('practice_id','=', 1)
        ->get();
        $time = microtime(true) - $start;
        dd($result->toArray(),$time);

    }

    public function feedBackSubmit(Request $request){
       
        $user = Auth::user();
        $practice_id = $user->practice_id;
        $practice_name = $user->name;

        DB::table('user_feedback')->insert([
            'user_name' => $request->name,
            'user_email' => $request->email,
            'suggestion' => $request->comment,
            'practice_id' => $practice_id
        ]);

        // define the data to be passed to the email view
        $data = [
            'user_name' => $request->name,
            'user_email' => $request->email,
            'suggestion' => $request->comment,
            'practice_name' => $practice_name
        ];

        // define the recipient email address and subject
        $recipient_email = 'waseem.ashraf@transcure.net';
        $subject = 'Feedback received from '.$practice_name;

        // send the email using Laravel's Mail facade and CustomEmail Mailable class
        Mail::to($recipient_email)
        ->send(new CustomEmail($data, $subject));
        Mail::to('khurram.shahzad@theservicesgroup.net')
        ->send(new CustomEmail($data, $subject));
        Mail::to('hasan.ayub@transcure.net')
        ->send(new CustomEmail($data, $subject));
        Mail::to('umer.khaliq@transcure.net')
        ->send(new CustomEmail($data, $subject));

    }

}







