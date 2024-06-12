<?php

namespace App\Http\Controllers\nepanalysis;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class AnalysisController extends Controller
{

    /*           Note
     * Cy   stand for  Current Year
     * p1y  stand for Prior year
     * p2y  stand for two prior year
     * p3y  stand for three prior year
     * 
     * fte  full time equivalent
     * rvu  relative value uits
     * ckd  chronical kidney disease
     * 
     */

    public function __construct()
    {

        $days = 22;
        $this->days = $days;

        $id = Auth::user()->practice_id;
        $this->practice_id = $id;

        $percent = 100;
        $this->percentage = $percent;

        $this->analysis_start_date_cy = self::analysisStartDateCy();
        $this->analysis_end_date_cy = self::analysisEndDateCy();

        $this->analysis_start_date_p1y = self::analysisStartDateP1y();
        $this->analysis_end_date_p1y = self::analysisEndDateP1y();


        $this->analysis_start_date_p2y = self::analysisStartDateP2y();
        $this->analysis_end_date_p2y = self::analysisEndDateP2y();

        $this->analysis_start_date_p3y = self::analysisStartDateP3y();
        $this->analysis_end_date_p3y = self::analysisEndDateP3y();

        $this->analysis_end_date_12_month_prior = self::analysisStartDate12MonthPrior();
    }

     /*
     * Analysis max date use for navi bar
     * formate change in this max date
     */
    public function maxDateForNiveBar()
    {

        if(isset($this->practice_id) && !empty($this->practice_id)){
            $results = DB::select("select date_format(max(date_of_service),'%m-%d-%Y') as max_date from analytic_data where practice_id=$this->practice_id");
            return $results[0]->max_date;

        }else{
            return 'January-31-2023';
        }
    }

     /*
     * Analysis Start (cy) Current Year Date
     * 
     */
    public function analysisStartDateCy()
    {

        $analysis_end_date_cy = self::analysisEndDateCy();
        $analysis_start_date_cy = DB::raw("DATE_SUB(DATE_ADD('$analysis_end_date_cy',INTERVAL -DAY('$analysis_end_date_cy')+1 DAY), INTERVAL 11 MONTH)");

        return $analysis_start_date_cy;
    }

    /*
     * Analysis End  date of Current Year
     * or you can get max date of current year
     */
    public function analysisEndDateCy()
    {

        $analysis_end_date_cy = DB::table('analytic_data')
            ->where('practice_id', '=', $this->practice_id)
            ->max('Date_of_Service');

        return $analysis_end_date_cy;
    }

     /*
     * Analysis Start Date (p1y) 1st Prior year 
     */

     public function analysisStartDateP1y()
     {
 
         $analysis_start_date_p1y = DB::raw("DATE_SUB($this->analysis_start_date_cy,INTERVAL 1 year)");
 
         return $analysis_start_date_p1y;
 
     }
 
     /*
      * Analysis End Date (p1y) 1st Prior  year 
      */
 
     public function analysisEndDateP1y()
     {
 
         $analysis_end_date_p1y = DB::raw("DATE_SUB($this->analysis_start_date_cy,INTERVAL 1 day)");
 
         return $analysis_end_date_p1y;
     }

         /*
     * Analysis Start Date (p2y) 2nd Prior year 
     */

     public function analysisStartDateP2y()
     {
 
         $analysis_start_date_p2y = DB::raw("DATE_SUB($this->analysis_start_date_p1y,INTERVAL 1 year)");
 
         return $analysis_start_date_p2y;
 
     }
 
     /*
      * Analysis End Date (p2y) 2nd Prior year 
      */
 
     public function analysisEndDateP2y()
     {
 
         $analysis_end_date_p2y = DB::raw("DATE_SUB($this->analysis_start_date_p1y,INTERVAL 1 day)");
 
         return $analysis_end_date_p2y;
     }

      /*
     * Analysis start Date (p3y) 3nd Prior year 
     */

    public function analysisStartDateP3y()
    {
        $analysis_start_date_p3y = DB::raw("DATE_SUB($this->analysis_start_date_p2y,INTERVAL 1 year)");

        return $analysis_start_date_p3y;

    }

    /*
     * Analysis End Date (p3y) 3nd Prior year 
     */

    public function analysisEndDateP3y()
    {
        $analysis_end_date_p3y = DB::raw("DATE_SUB($this->analysis_start_date_p2y,INTERVAL 1 day)");

        return $analysis_end_date_p3y;
    }

    /*
     * Analysis get last month of Prior year date
     * start form prior year DEC
     * or you say current year + prior year dec month 
     * totel 13 month 
     */

    public function analysisStartDate12MonthPrior()
    {

        $analysis_end_date_cy = self::analysisEndDateCy();
        $analysis_start_date_12_month_prior = DB::raw("DATE_SUB(DATE_ADD('$analysis_end_date_cy',INTERVAL -DAY('$analysis_end_date_cy')+1 DAY), INTERVAL 12 MONTH)");

        return $analysis_start_date_12_month_prior;
    }

    /*
     * to calulate fte
     * fte  full time equivalent
     */

    public function fteSum()
    {

        $ftesum = DB::table('analytic_data')
            ->select(DB::raw('provider_fte'))
            ->where('Date_of_Service', '>=', DB::raw("DATE_SUB(DATE_ADD('$this->analysis_end_date_cy',INTERVAL -DAY('$this->analysis_end_date_cy')+1 DAY), INTERVAL 11 MONTH)"))
            ->where('practice_id', '=', $this->practice_id)
            ->distinct('provider')
            ->count();

        return $ftesum;
    }

    /* to calculate fte month wise
     * fte  full time equivalent
     */

    public function ftePerMonthGraph()
    {
        $fte_sum = self::fteSum();

        if (isset($fte_sum) && !empty($fte_sum)) {

            $fte_per_month_graph = DB::table('analytic_data')
                ->select(DB::raw("date_format(Date_of_Service,'%b-%y') kys,round(sum(primary_insurance_payment+secondary_insurance_payment+patient_payment)/'$fte_sum',0) vals"))
                ->groupBy(DB::raw('date_format(Date_of_Service,"%b-%y"),date_format(Date_of_Service,"%y-%m") order by date_format(Date_of_Service,"%y-%m")'))
                ->where('Date_of_Service', '>=', DB::raw("DATE_SUB(DATE_ADD('$this->analysis_end_date_cy',INTERVAL -DAY('$this->analysis_end_date_cy')+1 DAY), INTERVAL 11 MONTH)"))
                ->where('practice_id', '=', $this->practice_id)
                ->get();

            return $fte_per_month_graph;
        } else
            return 0;

    }

    /*
     * Analysis Received Payment (cy) Current Year Date
     */
    public function cashCy()
    {

        $cash_cy = DB::table('analytic_data')
            ->select(DB::raw('round(sum(primary_insurance_payment+secondary_insurance_payment+patient_payment),0) AS cash_cy'))
            ->where('practice_id', '=', $this->practice_id)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
            ->get();

        return (int) $cash_cy[0]->cash_cy;
    }

    /*
     * Analysis Unique Patients (cy) Current Year 
     * unique patients means if patients come 2 time in the same month considerd 2 encounter but 1 patient
     */

    public function uniquePatientsCy()
    {

        $unique_patients_cy = DB::table('analytic_data')
            ->select(DB::raw('count(distinct account_nbr_nbr) AS unique_patients_cy'))
            ->where('practice_id', '=', $this->practice_id)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
            ->get();

        return $unique_patients_cy[0]->unique_patients_cy;
    }

    /*
     * Analysis Encounters Current Year
     * Encounters means Number of vist 
     */

    public function encountersCy()
    {

        $encounters_cy = DB::table('analytic_data')
            ->select(DB::raw('count(distinct concat(account_nbr_nbr,date_format(date_of_Service,"%y%m%e"))) AS encounters_cy'))
            ->where('practice_id', '=', $this->practice_id)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
            ->get();

        return $encounters_cy[0]->encounters_cy;
    }

    /*
     * Analysis Total Rvu Current Year
     * ruv relative value units 
     */

    public function totalRvuCy()
    {
        $total_rvu_cy = DB::table('analytic_data')
            ->select(DB::raw('sum(total_rvu*units) AS total_rvu_cy'))
            ->where('practice_id', '=', $this->practice_id)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
            ->get();
        return $total_rvu_cy[0]->total_rvu_cy;
    }

    /*
     * Analysis fteCy Current Year
     * fte full time equivalant 
     */

    public function fteCy()
    {

        $fte_cy = DB::table('analytic_data')
            ->select('provider_fte')
            ->where('practice_id', '=', $this->practice_id)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
            ->distinct('provider')
            ->count();

        return round($fte_cy, 1);
    }

    /*
     * Analysis Cash Recived Current Year / FTE Current Year
     */

    public function cashPerFteCy()
    {
        $cash_cy = self::cashCy();
        $fte_cy = self::fteCy();

        $a = isset($fte_cy) && !empty($fte_cy) ? round($cash_cy[0]->cash_cy / $fte_cy, 0) : 0;

        return (int) $a;
    }

    /*
     * Analysis Unique Patients Current Year / FTE Current Year
     * distinct enncounter means unique patients
     */

    public function uniquePatientsPerFteCy()
    {
        $unique_patients_cy = self::uniquePatientsCy();
        $fte_cy = self::fteCy();

        $a = isset($fte_cy) && !empty($fte_cy) ? round($unique_patients_cy / $fte_cy, 0) : 0;

        return (int) $a;
    }

    /*
     * Analysis Encounters Current Year / Unique Patients Current Year
     * patients number of vist
     */

    public function encountersPerPatientsCy()
    {
        $encounters_cy = self::encountersCy();
        $unique_patients_cy = self::uniquePatientsCy();

        $a = isset($unique_patients_cy) && !empty($unique_patients_cy) ? (round($encounters_cy / $unique_patients_cy, 1)) : 0;

        return $a;
    }

    /*
     * Analysis Total Rvu Current Year / Encounters Current Year
     * encounter is no of patients vist
     * ruv full time equivalant
     */

    public function totalRvuPerEncountersCy()
    {
        $total_rvu_cy = self::totalRvuCy();
        $encounters_cy = self::encountersCy();

        $a = isset($encounters_cy) && !empty($encounters_cy) ? round($total_rvu_cy / $encounters_cy, 1) : 0;

        return $a;
    }

    /*
     * Analysis Cash (cy) Current Year / Total Rvu Current Year
     * rvu  relative value uits
     */

    public function cashPerTotalRvuCy()
    {
        $cash_cy = self::cashCy();
        $total_rvu_cy = self::totalRvuCy();

        $a = isset($total_rvu_cy) && !empty($total_rvu_cy) ? round($cash_cy / $total_rvu_cy, 2) : 0;

        return $a;
    }

    /*
     * Analysis Cash Recived (p1y) 1st Prior Year 
     */

    public function cashP1y()
    {
        $cash_p1y = DB::table('analytic_data')
            ->select(DB::raw('round(sum(primary_insurance_payment+secondary_insurance_payment+patient_payment),0) AS cash_p1y'))
            ->where('practice_id', '=', $this->practice_id)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_p1y, $this->analysis_end_date_p1y])
            ->get();

        return $cash_p1y[0]->cash_p1y;
    }

    /*
     * Analysis Unique Patients (p1y) 1st Prior year 
     */

    public function uniquePatientsP1y()
    {

        $unique_patients_p1y = DB::table('analytic_data')
            ->select(DB::raw('count(distinct account_nbr_nbr) AS unique_patients_p1y'))
            ->where('practice_id', '=', $this->practice_id)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_p1y, $this->analysis_end_date_p1y])
            ->get();

        return $unique_patients_p1y[0]->unique_patients_p1y;

    }

    /*
     * Analysis Encounters (p1y) 1st Prior year 
     * encounter is no of patients vists
     */

    public function encountersP1y()
    {

        $encounters_p1y = DB::table('analytic_data')
            ->select(DB::raw('count(distinct concat(account_nbr_nbr,date_format(date_of_Service,"%y%m%e"))) AS encounters_p1y'))
            ->where('practice_id', '=', $this->practice_id)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_p1y, $this->analysis_end_date_p1y])
            ->get();

        return $encounters_p1y[0]->encounters_p1y;
    }

    /*
     * Analysis Total Rvu (p1y) 1st Prior year 
     * rvu  relative value uits
     */

    public function totalRvuP1y()
    {

        $total_rvu_p1y = DB::table('analytic_data')
            ->select(DB::raw('sum(total_rvu*units) AS total_rvu_p1y'))
            ->where('practice_id', '=', $this->practice_id)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_p1y, $this->analysis_end_date_p1y])
            ->get();
        return $total_rvu_p1y[0]->total_rvu_p1y;
    }

    /*
     * Analysis Fte (p1y) 1st Prior year
     * fte full time equivalant 
     */

    public function fteP1y()
    {

        $fte_p1y = DB::table('analytic_data')
            ->select(DB::raw('provider_fte'))
            ->where('practice_id', '=', $this->practice_id)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_p1y, $this->analysis_end_date_p1y])
            ->distinct('provider')
            ->count();
        return round($fte_p1y, 1);

    }

    /*
     * Analysis Cash 1st Prior year / Analysis Fte 1st Prior year
     */

    public function cashPerFteP1y()
    {
        $cash_p1y = self::cashP1y();
        $fte_p1y = self::fteP1y();

        $a = isset($fte_p1y) && !empty($fte_p1y) ? round($cash_p1y / $fte_p1y, 2) : 0;

        return (int) $a;

    }

    /*
     * Analysis Unique Patients (p1y) 1st Prior year / Analysis Fte (p1y) 1st Prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year
     */

    public function uniquePatientsPerFteP1y()
    {
        $unique_patients_p1y = self::uniquePatientsP1y();
        $fte_p1y = self::fteP1y();

        $a = isset($fte_p1y) && !empty($fte_p1y) ? round($unique_patients_p1y / $fte_p1y, 0) : 0;

        return (int) $a;

    }

    /*
     * Analysis Encounters 1st Prior year / Analysis Unique Patients 1st Prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year
     */

    public function encountersPerPatientsP1y()
    {
        $encounters_p1y = self::encountersP1y();
        $unique_patients_p1y = self::uniquePatientsP1y();

        $a = isset($unique_patients_p1y) && !empty($unique_patients_p1y) ? round($encounters_p1y / $unique_patients_p1y, 1) : 0;

        return $a;
    }

    /*
     * Analysis Total Rvu 1st Prior year / Analysis Encounters 1st Prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year
     */

    public function totalRvuPerEncountersP1y()
    {
        $total_rvu_p1y = self::totalRvuP1y();
        $encounters_p1y = self::encountersP1y();

        $a = isset($encounters_p1y) && !empty($encounters_p1y) ? round($total_rvu_p1y / $encounters_p1y, 1) : 0;

        return $a;

    }

    /*
     * Analysis Cash 1st Prior year / Analysis Total Rvu 1st Prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year
     */

    public function cashPerTotalRvuP1y()
    {
        $cash_p1y = self::cashP1y();
        $total_rvu_p1y = self::totalRvuP1y();

        $a = isset($total_rvu_p1y) && !empty($total_rvu_p1y) ? round($cash_p1y / $total_rvu_p1y, 2) : 0;

        return $a;
    }

    /*
     * Analysis Cash 2nd Prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
     */

    public function cashP2y()
    {

        $cash_p2y = DB::table('analytic_data')
            ->select(DB::raw('round(sum(primary_insurance_payment+secondary_insurance_payment+patient_payment),0) AS cash_p2y'))
            ->where('practice_id', '=', $this->practice_id)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_p2y, $this->analysis_end_date_p2y])
            ->get();

        return $cash_p2y[0]->cash_p2y;

    }

    /*
     * Analysis Unique Patients 2nd Prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
     */

    public function uniquePatientsP2y()
    {

        $unique_patients_p2y = DB::table('analytic_data')
            ->select(DB::raw('count(distinct account_nbr_nbr) AS unique_patients_p2y'))
            ->where('practice_id', '=', $this->practice_id)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_p2y, $this->analysis_end_date_p2y])
            ->get();

        return $unique_patients_p2y[0]->unique_patients_p2y;

    }

    /*
     * Analysis Encounters 2nd Prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
     */

    public function encountersP2y()
    {

        $encounters_p2y = DB::table('analytic_data')
            ->select(DB::raw('count(distinct concat(account_nbr_nbr,date_format(date_of_Service,"%y%m%e"))) AS encounters_p2y'))
            ->where('practice_id', '=', $this->practice_id)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_p2y, $this->analysis_end_date_p2y])
            ->get();

        return $encounters_p2y[0]->encounters_p2y;
    }

    /*
     * Analysis Total Rvu 2nd Prior year 
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year
     */

    public function totalRvuP2y()
    {

        $total_rvu_p2y = DB::table('analytic_data')
            ->select(DB::raw('sum(total_rvu*units) AS total_rvu_p2y'))
            ->where('practice_id', '=', $this->practice_id)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_p2y, $this->analysis_end_date_p2y])
            ->get();
        return $total_rvu_p2y[0]->total_rvu_p2y;
    }

    /*
     * Analysis Fte 2nd Prior year 
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year
     */

    public function fteP2y()
    {

        $fte_p2y = DB::table('analytic_data')
            ->select(DB::raw('provider_fte'))
            ->where('practice_id', '=', $this->practice_id)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_p2y, $this->analysis_end_date_p2y])
            ->distinct('provider')
            ->count();
        return round($fte_p2y, 1);

    }

    /*
     * Analysis Cash 2nd Prior year / Analysis Fte 2nd Prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year
     */

    public function cashPerFteP2y()
    {
        $cash_p2y = self::cashP2y();
        $fte_p2y = self::fteP2y();

        $a = isset($fte_p2y) && !empty($fte_p2y) ? round($cash_p2y / $fte_p2y, 2) : 0;

        return (int) $a;

    }

    /*
     * Analysis Unique Patients 2nd Prior year / Analysis Fte 2nd Prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year
     */

    public function uniquePatientsPerFteP2y()
    {
        $unique_patients_p2y = self::uniquePatientsP2y();
        $fte_p2y = self::fteP2y();

        $a = isset($fte_p2y) && !empty($fte_p2y) ? round($unique_patients_p2y / $fte_p2y, 0) : 0;

        return (int) $a;

    }

    /*
     * Analysis Encounters 2nd Prior year / Analysis Unique Patients 2nd Prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year
     */

    public function encountersPerPatientsP2y()
    {
        $encounters_p2y = self::encountersP2y();
        $unique_patients_p2y = self::uniquePatientsP2y();

        $a = isset($unique_patients_p2y) && !empty($unique_patients_p2y) ? round($encounters_p2y / $unique_patients_p2y, 1) : 0;

        return $a;

    }

    /*
     * Analysis Total Rvu 2nd Prior year / Analysis Encounters 2nd Prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year
     */

    public function totalRvuPerEncountersP2y()
    {
        $total_rvu_p2y = self::totalRvuP2y();
        $encounters_p2y = self::encountersP2y();

        $a = isset($encounters_p2y) && !empty($encounters_p2y) ? round($total_rvu_p2y / $encounters_p2y, 1) : 0;

        return $a;
    }

    /*
     * Analysis Cash 2nd Prior year / Analysis Total Rvu 2nd Prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year
     */

    public function cashPerTotalRvuP2y()
    {
        $cash_p2y = self::cashP2y();
        $total_rvu_p2y = self::totalRvuP2y();

        $a = isset($total_rvu_p2y) && !empty($total_rvu_p2y) ? round($cash_p2y / $total_rvu_p2y, 2) : 0;

        return $a;
    }

    /*
    *fte table which comes from almost above function
    *  fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year  
    */

    public function ftePerMonthTable()
    {

        $results = array(
            array(
                'title' => 'cash / fte',
                'cy' => self::cashPerFteCy(),
                'p1y' => self::cashPerFteP1y(),
                'p2y' => self::cashPerFteP2y()
            ),
            array(
                'title' => 'uninqe patients / fte',
                'cy' => self::uniquePatientsPerFteCy(),
                'p1y' => self::uniquePatientsPerFteP1y(),
                'p2y' => self::uniquePatientsPerFteP2y()
            ),
            array(
                'title' => 'encounters / patients',
                'cy' => self::encountersPerPatientsCy(),
                'p1y' => self::encountersPerPatientsP1y(),
                'p2y' => self::encountersPerPatientsP2y()
            ),
            array(
                'title' => 'total rvu / encounters',
                'cy' => self::totalRvuPerEncountersCy(),
                'p1y' => self::totalRvuPerEncountersP1y(),
                'p2y' => self::totalRvuPerEncountersP2y()
            ),
            array(
                'title' => 'cash / total rvu',
                'cy' => self::cashPerTotalRvuCy(),
                'p1y' => self::cashPerTotalRvuP1y(),
                'p2y' => self::cashPerTotalRvuP2y()
            )
        );
        return $results;
    }

    // office
/*
    * to vist first time in office
    *  fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
*/
    public function officeNewPatientEncounter()
    {

        $results = DB::select("select a.month_year kys,round(a.encounters/b.sum_provider_fte/$this->days,2) vals
        from
        (select date_format(ad.date_of_service,'%y-%m') month_year_order,date_format(ad.date_of_service,'%b-%y') month_year,
         count(distinct concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d'))) encounters
         FROM analytic_data ad
         WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
         and cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')
         group by date_format(date_of_service,'%b-%y')
        ) a,
        (select ads.month_year,sum(ads.provider_fte) sum_provider_fte
        from(
             select distinct date_format(adt.date_of_service,'%b-%y') month_year,adt.provider,adt.provider_fte
             from analytic_data adt
             where adt.practice_id=$this->practice_id
             ) ads
        group by ads.month_year
        ) b
        where a.month_year=b.month_year
        order by a.month_year_order");

        return $results;
    }

    /*
     * Analysis Establised Patients Encounter Current Year Month Wise
     * establised means regularly visiting patients
     * to vist first time in office
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
*/

    public function officeEstbdPatientEncounter()
    {

        $results = DB::select("select m.month_year_display as kys, IFNULL(round(a.encounters/b.sum_provider_fte/$this->days,2), 0) vals
        FROM
        (
          SELECT DISTINCT date_format(date_of_service,'%y-%m') month_year,
                          date_format(date_of_service,'%b-%y') month_year_display
          FROM analytic_data
          WHERE Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        ) m
        LEFT JOIN
        (
          SELECT date_format(ad.date_of_service,'%y-%m') month_year,
                 count(DISTINCT concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d'))) encounters
          FROM analytic_data ad
          WHERE practice_id=$this->practice_id 
          and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
            AND cptcode IN ('99211','99212','99213','99214','99215')
          GROUP BY date_format(date_of_service,'%y-%m')
        ) a ON m.month_year = a.month_year
        LEFT JOIN
        (
          SELECT ads.month_year, sum(ads.provider_fte) sum_provider_fte
          FROM (
            select distinct date_format(adt.date_of_service,'%y-%m') month_year,adt.provider,adt.provider_fte
            FROM analytic_data adt
            WHERE practice_id=$this->practice_id 
          ) ads
          GROUP BY ads.month_year
        ) b ON m.month_year = b.month_year
        ORDER BY m.month_year");

        return $results;


    }
    /*
    * this code level reffers to cpt code time duration
    *  fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
*/
    public function officeNewPatientAvgCodeLevel()
    {

        $results = DB::select("select dt.month_year kys,round(sum(dt.code_level)/sum(dt.units),2) vals
        from (select date_format(date_of_service,'%b-%y') month_year,date_format(date_of_service,'%y%m') month_year_order,cptcode_office_level,count(distinct concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d'))) units,cptcode_office_level*count(distinct concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d'))) code_level
              FROM analytic_data
              WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
              and cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')
              group by date_format(date_of_service,'%b-%y'),cptcode_office_level
              order by 2
             )dt
        group by dt.month_year_order,dt.month_year");

        return $results;

    }

    /*
    * this code level reffers to cpt code time duration
    * establised means regularly visiting patients
     * to vist first time in office
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
*/
    public function officeEstabPatientAvgCodeLevel()
    {
        $results = DB::select("select all_months.month_year kys, COALESCE(round(sum(dt.code_level)/sum(dt.units),2), 0) vals
        FROM (
          SELECT date_format(date_of_service,'%b-%y') month_year, date_format(date_of_service,'%y%m') month_year_order, cptcode_office_level,
                 count(distinct concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d'))) units,
                 cptcode_office_level*count(distinct concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d'))) code_level
          FROM analytic_data
          WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                and cptcode in('99211','99212','99213','99214','99215')
          GROUP BY date_format(date_of_service,'%b-%y'),cptcode_office_level,date_format(date_of_service,'%y%m')
        ) dt
        RIGHT JOIN (
          SELECT date_format(date_of_service,'%b-%y') month_year, date_format(date_of_service,'%y%m') month_year_order
          FROM analytic_data
          WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
          GROUP BY date_format(date_of_service,'%b-%y'),date_format(date_of_service,'%y%m')
        ) all_months ON all_months.month_year_order = dt.month_year_order
        GROUP BY all_months.month_year_order, all_months.month_year
        ORDER BY all_months.month_year_order");

        return $results;
    }

    //hospitals


     /* 
     * to vist first time in office
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */

    public function hospitalNewPatientEncounter()
    {

        $results = DB::select("select a.month_year kys,round(a.encounters/b.sum_provider_fte/$this->days,2) vals
        from
        (select date_format(ad.date_of_service,'%y-%m') month_year_order,date_format(ad.date_of_service,'%b-%y') month_year,
         count(distinct concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d'))) encounters
         FROM analytic_data ad
         WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
         and cptcode in('99221','99222','99223','99251','99252','99253','99254','99255')
         group by date_format(date_of_service,'%b-%y')
        ) a,
        (select ads.month_year,sum(ads.provider_fte) sum_provider_fte
        from(
             select distinct date_format(adt.date_of_service,'%b-%y') month_year,adt.provider,adt.provider_fte
             from analytic_data adt
             where adt.practice_id=$this->practice_id
             ) ads
        group by ads.month_year
        ) b
        where a.month_year=b.month_year
        order by a.month_year_order");

        return $results;

    }

     /*
    * establised means regularly visiting patients
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
*/

    public function hospitalEstbdPatientEncounter()
    {

        $results = DB::select("select m.month_year_display as kys, IFNULL(round(a.encounters/b.sum_provider_fte/$this->days,2), 0) vals
        FROM
        (
          SELECT DISTINCT date_format(date_of_service,'%y-%m') month_year,
                          date_format(date_of_service,'%b-%y') month_year_display
          FROM analytic_data
          WHERE Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        ) m
        LEFT JOIN
        (
          SELECT date_format(ad.date_of_service,'%y-%m') month_year,
                 count(DISTINCT concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d'))) encounters
          FROM analytic_data ad
          WHERE practice_id=$this->practice_id 
          and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
          and  cptcode in('99231','99232','99233')
          GROUP BY date_format(date_of_service,'%y-%m')
        ) a ON m.month_year = a.month_year
        LEFT JOIN
        (
          SELECT ads.month_year, sum(ads.provider_fte) sum_provider_fte
          FROM (
            select distinct date_format(adt.date_of_service,'%y-%m') month_year,adt.provider,adt.provider_fte
            FROM analytic_data adt
            WHERE practice_id=$this->practice_id 
          ) ads
          GROUP BY ads.month_year
        ) b ON m.month_year = b.month_year
        ORDER BY m.month_year");

        return $results;
    }

     /*
    * this code level reffers to cpt code time duration
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
*/
    public function hospitalNewPatientAvgCodeLevel()
    {

        $results = DB::select("select dt.month_year kys,round(sum(dt.code_level)/sum(dt.units),2) vals
        from (select date_format(date_of_service,'%b-%y') month_year,date_format(date_of_service,'%y%m') month_year_order,cptcode_office_level,count(distinct concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d'))) units,cptcode_office_level*count(distinct concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d'))) code_level
              FROM analytic_data
              WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
              and cptcode in('99221','99222','99223','99251','99252','99253','99254','99255')
              group by date_format(date_of_service,'%b-%y'),date_format(date_of_service,'%y%m'),cptcode_office_level
              order by 2
             )dt
        group by dt.month_year_order,dt.month_year
        order by dt.month_year_order");

        return $results;
    }

     /*
    * this code level reffers to cpt code time duration
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
*/

    public function hospitalEstabPatientAvgCodeLevel()
    {
        $results = DB::select("select all_months.month_year kys, IFNULL(round(sum(dt.code_level)/sum(dt.units),2), 0) vals
        FROM (
          SELECT date_format(date_of_service,'%b-%y') month_year, date_format(date_of_service,'%y%m') month_year_order, cptcode_office_level,
                 count(distinct concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d'))) units,
                 cptcode_office_level*count(distinct concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d'))) code_level
          FROM analytic_data
          WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
          and cptcode in('99231','99232','99233')
          GROUP BY date_format(date_of_service,'%b-%y'),cptcode_office_level,date_format(date_of_service,'%y%m')
        ) dt
        RIGHT JOIN (
          SELECT date_format(date_of_service,'%b-%y') month_year, date_format(date_of_service,'%y%m') month_year_order
          FROM analytic_data
          WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
          GROUP BY date_format(date_of_service,'%b-%y'),date_format(date_of_service,'%y%m')
        ) all_months ON all_months.month_year_order = dt.month_year_order
        GROUP BY all_months.month_year_order, all_months.month_year
        ORDER BY all_months.month_year_order");

        return $results;
    }

    // in center dialysis means to perform dialysis in ceneter

    public function inCenterDialysis()
    {

        $results = DB::select("select date_format(date_of_service,'%b-%y') kys,round(sum(if(cptcode=90960,1,0))*$this->percentage/count(cptcode),2) vals
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy' 
        and cptcode in('90960','90961','90962')
        group by date_format(date_of_service,'%b-%y')
        order by date_format(date_of_service,'%y%m')");

        return $results;
    }

    // productivity table
    /*
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
*/

    public function ProductivityPerYearTable()
    {

        $results = array(
            array(
                'title' => 'fte',
                'cy' => self::FteCy(),
                'p1y' => self::FteP1y(),
                'p2y' => self::FteP2y()
            ),
            array(
                'title' => 'encounter / fte',
                'cy' => self::encounterPerFteCy(),
                'p1y' => self::encounterPerFteP1y(),
                'p2y' => self::encounterPerFteP2y()
            ),
            array(
                'title' => 'total rvu / fte',
                'cy' => self::totalRvuPerFteCy(),
                'p1y' => self::totalRvuPerFteP1y(),
                'p2y' => self::totalRvuPerFteP2y()
            )
        );

        return $results;
    }

    //ENCOUTER PER CURRENT YEAR FTE
     /*
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */

    public function encounterPerFteCy()
    {
        $encounters_cy = self::encountersCy();
        $fte_cy = self::fteCy();

        $a = isset($fte_cy) && !empty($fte_cy) ? round($encounters_cy / $fte_cy, 1) : 0;

        return $a;
    }

    //ENCOUTER PER  P1 YEAR FTE
    /*
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */


    public function encounterPerFteP1y()
    {
        $encounters_p1y = self::encountersP1y();
        $fte_p1y = self::fteP1y();

        $a = isset($fte_p1y) && !empty($fte_p1y) ? round($encounters_p1y / $fte_p1y, 1) : 0;

        return $a;
    }

    //ENCOUTER PER P2 YEAR FTE
    /*
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */


    public function encounterPerFteP2y()
    {
        $encounters_p2y = self::encountersP2y();
        $fte_p2y = self::fteP2y();

        $a = isset($fte_p2y) && !empty($fte_p2y) ? round($encounters_p2y / $fte_p2y, 1) : 0;

        return (int) $a;
    }

    //TOTEL RVU PER CURRENT  YEAR FTE
    /*
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */

    public function totalRvuPerFteCy()
    {
        $total_rvu_cy = self::totalRvuCy();
        $fte_cy = self::fteCy();

        $a = isset($fte_cy) && !empty($fte_cy) ? round($total_rvu_cy / $fte_cy, 1) : 0;

        return (int) $a;
    }

    //TOTEL RVU ENCOUTER PER P1 YEAR FTE
    /*
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */


    public function totalRvuPerFteP1y()
    {
        $total_rvu_p1y = self::totalRvuP1y();
        $fte_p1y = self::fteP1y();

        $a = isset($fte_p1y) && !empty($fte_p1y) ? round($total_rvu_p1y / $fte_p1y, 1) : 0;

        return (int) $a;
    }

    //TOTEL RVU ENCOUTER PER P2 YEAR FTE
    /*
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */


    public function totalRvuPerFteP2y()
    {
        $total_rvu_p2y = self::totalRvuP2y();
        $fte_p2y = self::fteP2y();

        $a = isset($fte_p2y) && !empty($fte_p2y) ? round($total_rvu_p2y / $fte_p2y, 1) : 0;

        return $a;
    }
    
    /* to calculate productivity month wise
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */

    public function ProductivityPerMonthGraph()
    {
        $results = DB::select("select a.month_year kys,round(a.total_rvu/b.sum_provider_fte,2) vals
        from (select date_format(ad.date_of_service,'%b-%y') month_year,date_format(ad.date_of_service,'%y%m') month_year_ord,sum(total_rvu*units) total_rvu
               FROM analytic_data ad
               WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
               group by date_format(date_of_service,'%b-%y'),date_format(ad.date_of_service,'%y%m')
               )a,
        (select ads.month_year,ads.month_year_ord,sum(ads.provider_fte) sum_provider_fte
        from(
            select distinct date_format(adt.date_of_service,'%b-%y') month_year,date_format(adt.date_of_service,'%y%m') month_year_ord,adt.provider,adt.provider_fte
            from analytic_data adt
            where adt.practice_id=$this->practice_id
            ) ads
        group by ads.month_year,ads.month_year_ord
        ) b
        where a.month_year=b.month_year
        order by a.month_year_ord");

        return $results;

    }

    // Total patient growth

    /*  active Patients current year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function activePatientsCy()
    {
        $active_patients_cy = DB::select("select COUNT(DISTINCT account_nbr_nbr) as activePts 
        FROM analytic_data 
        WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return $active_patients_cy[0]->activePts;
    }

     /*  active Patients Prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function activePatientsP1y()
    {
        $active_patients_p1y = DB::select("select COUNT(DISTINCT account_nbr_nbr) as activePts 
        FROM analytic_data 
        WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return $active_patients_p1y[0]->activePts;
    }

    /*  active Patients two prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function activePatientsP2y()
    {
        $active_patients_p2y = DB::select("select COUNT(DISTINCT account_nbr_nbr) as activePts 
        FROM analytic_data 
        WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_p2y and $this->analysis_end_date_p2y");

        return $active_patients_p2y[0]->activePts;
    }

    // (additional) using in formula to calculate Total Patients Growth
    /*  active Patients three prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 


    public function activePatientsP3y()
    {
        $active_patients_p3y = DB::select("select COUNT(DISTINCT account_nbr_nbr) as activePts 
        FROM analytic_data 
        WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_p3y and $this->analysis_end_date_p3y");

        return $active_patients_p3y[0]->activePts;
    }

    // Total Patients Growth current year

    public function TotalPatientGrowthCy()
    {
        $active_patients_cy = self::activePatientsCy();
        $active_patients_p1y = self::activePatientsP1y();

        $a = isset($active_patients_p1y) && !empty($active_patients_p1y) ? round((($active_patients_cy - $active_patients_p1y) * $this->percentage) / $active_patients_p1y, 2) : 0;

        return $a;
    }

    // Total Patients Growth prior year

    public function TotalPatientGrowthP1y()
    {
        $active_patients_p1y = self::activePatientsP1y();
        $active_patients_p2y = self::activePatientsP2y();

        $a = isset($active_patients_p2y) && !empty($active_patients_p2y) ? round((($active_patients_p1y - $active_patients_p2y) * $this->percentage) / $active_patients_p2y, 2) : 0;

        return $a;
    }

    // Total Patients Growth two prior year

    public function TotalPatientGrowthP2y()
    {
        $active_patients_p2y = self::activePatientsP2y();
        $active_patients_p3y = self::activePatientsP3y();

        $a = isset($active_patients_p3y) && !empty($active_patients_p3y) ? round((($active_patients_p2y - $active_patients_p3y) * $this->percentage) / $active_patients_p3y, 2) : 0;

        return $a;
    }

    /*  Total New Ckd Patients current year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function TotalNewCkdPatientsCy()
    {
        $total_new_ckd_patients_cy = DB::select("select count(DISTINCT account_nbr_nbr) as TotalNewCdkPatient 
        FROM analytic_data 
        WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and ckd_Stage not in ('Non-CKD','Unspecified')
        and cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')");

        return $total_new_ckd_patients_cy[0]->TotalNewCdkPatient;
    }

    /*  Total New Ckd Patients prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function TotalNewCkdPatientsP1y()
    {
        $total_new_ckd_patients_p1y = DB::select("select count(DISTINCT account_nbr_nbr) as TotalNewCdkPatient 
        FROM analytic_data 
        WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
        and ckd_Stage not in ('Non-CKD','Unspecified')
        and cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')");

        return $total_new_ckd_patients_p1y[0]->TotalNewCdkPatient;
    }

    /*  Total New Ckd Patients two prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function TotalNewCkdPatientsP2y()
    {
        $total_new_ckd_patients_p2y = DB::select("select count(DISTINCT account_nbr_nbr) as TotalNewCdkPatient 
        FROM analytic_data 
        WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_p2y and $this->analysis_end_date_p2y
        and ckd_Stage not in ('Non-CKD','Unspecified')
        and cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')");

        return $total_new_ckd_patients_p2y[0]->TotalNewCdkPatient;
        ;
    }

    // (additional) using in formula Total New CKD Patients Growth

    /*  Total New Ckd Patients three prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function TotalNewCkdPatientsP3y()
    {
        $total_new_ckd_patients_p3y = DB::select("select count(DISTINCT account_nbr_nbr) as TotalNewCdkPatient 
        FROM analytic_data 
        WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_p3y and $this->analysis_end_date_p3y
        and ckd_Stage not in ('Non-CKD','Unspecified')
        and cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')");

        return $total_new_ckd_patients_p3y[0]->TotalNewCdkPatient;
    }

  /*  Total New Ckd Patients Growth current year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function TotalNewCkdPatientsGrowthCy()
    {
        $total_new_ckd_patients_growth_cy = self::TotalNewCkdPatientsCy();
        $total_new_ckd_patients_growth_p1y = self::TotalNewCkdPatientsP1y();

        $a = isset($total_new_ckd_patients_growth_p1y) && !empty($total_new_ckd_patients_growth_p1y) ? round((($total_new_ckd_patients_growth_cy - $total_new_ckd_patients_growth_p1y) * $this->percentage) / $total_new_ckd_patients_growth_p1y, 2) : 0;

        return $a;
    }

    /*  Total New Ckd Patients Growth prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function TotalNewCkdPatientsGrowthP1y()
    {
        $total_new_ckd_patients_growth_p1y = self::TotalNewCkdPatientsP1y();
        $total_new_ckd_patients_growth_p2y = self::TotalNewCkdPatientsP2y();

        $a = isset($total_new_ckd_patients_growth_p2y) && !empty($total_new_ckd_patients_growth_p2y) ? round((($total_new_ckd_patients_growth_p1y - $total_new_ckd_patients_growth_p2y) * $this->percentage) / $total_new_ckd_patients_growth_p2y, 2) : 0;

        return $a;
    }

    /*  Total New Ckd Patients Growth two prior year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function TotalNewCkdPatientsGrowthP2y()
    {
        $total_new_ckd_patients_growth_p2y = self::TotalNewCkdPatientsP2y();
        $total_new_ckd_patients_growth_p3y = self::TotalNewCkdPatientsP3y();

        $a = isset($total_new_ckd_patients_growth_p3y) && !empty($total_new_ckd_patients_growth_p3y) ? round((($total_new_ckd_patients_growth_p2y - $total_new_ckd_patients_growth_p3y) * $this->percentage) / $total_new_ckd_patients_growth_p3y, 2) : 0;

        return $a;
    }

    // Active patients means to vist in current time according to there satge wise  per month graph

    public function activePatientsPerMonthGraph()
    {
        $active_patients_per_month_graph = DB::select("select date_format(date_of_service,'%b-%y') kys ,COUNT(DISTINCT account_nbr_nbr) as activePts 
        FROM analytic_data 
        WHERE practice_id=$this->practice_id and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by date_format(date_of_service,'%b-%y'),date_format(date_of_service,'%y-%m')
        order by date_format(date_of_service,'%y-%m')");

        return $active_patients_per_month_graph;
    }

        // Active patients means to vist in current time according to there satge wise  table

    public function activePatientsPerYearTable()
    {

        $activePatientsPerYearTable = array(
            array(
                'title' => 'active patients',
                'cy' => self::activePatientsCy(),
                'p1y' => self::activePatientsP1y(),
                'p2y' => self::activePatientsP2y()
            ),
            array(
                'title' => 'Total Patient Growth',
                'cy' => self::TotalPatientGrowthCy(),
                'p1y' => self::TotalPatientGrowthP1y(),
                'p2y' => self::TotalPatientGrowthP2y()
            ),
            array(
                'title' => 'Total New Ckd Patients',
                'cy' => self::TotalNewCkdPatientsCy(),
                'p1y' => self::TotalNewCkdPatientsP1y(),
                'p2y' => self::TotalNewCkdPatientsP2y()
            ),
            array(
                'title' => 'Total New Ckd Patients Growth',
                'cy' => self::TotalNewCkdPatientsGrowthCy(),
                'p1y' => self::TotalNewCkdPatientsGrowthP1y(),
                'p2y' => self::TotalNewCkdPatientsGrowthP2y()
            )
        );

        return $activePatientsPerYearTable;
    }


    // CKD Hosp. Re-Admission after 30 days of discharge " current Year"
      /*  Total New Ckd Patients current year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function CkdHospReAdmissionAfterDischargeCy()
    {
        $ckd_hosp_re_admission_after_discharge_cy = DB::select("select count(distinct concat(account_nbr_nbr,date_format(date_of_Service,'%y%m%d'))) CkdReAdmission
        from analytic_data
        where practice_id=$this->practice_id
        and date_of_service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and rehospitalization_ind=1
        and ckd_stage in('CKD-1','CKD-2','CKD-3','CKD-4','CKD-5','ESRD')
        order by account_nbr_nbr");

        return $ckd_hosp_re_admission_after_discharge_cy[0]->CkdReAdmission;
    }

    // CKD Hosp. Re-Admission after 30 days of discharge "prior Year"
      /*  Total New Ckd Patients current year
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function CkdHospReAdmissionAfterDischargeP1y()
    {
        $ckd_hosp_re_admission_after_discharge_p1y = DB::select("select count(distinct concat(account_nbr_nbr,date_format(date_of_Service,'%y%m%d'))) CkdReAdmission
        from analytic_data
        where practice_id=$this->practice_id
        and date_of_service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
        and rehospitalization_ind=1
        and ckd_stage in('CKD-1','CKD-2','CKD-3','CKD-4','CKD-5','ESRD')
        order by account_nbr_nbr");

        return $ckd_hosp_re_admission_after_discharge_p1y[0]->CkdReAdmission;
    }

      /*  CKD Hosp. Re-Admission after 30 days of discharge "Two Prior Year"
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function CkdHospReAdmissionAfterDischargeP2y()
    {
        $ckd_hosp_re_admission_after_discharge_p2y = DB::select("select count(distinct concat(account_nbr_nbr,date_format(date_of_Service,'%y%m%d'))) CkdReAdmission
        from analytic_data
        where practice_id=$this->practice_id
        and date_of_service between $this->analysis_start_date_p2y and $this->analysis_end_date_p2y
        and rehospitalization_ind=1
        and ckd_stage in('CKD-1','CKD-2','CKD-3','CKD-4','CKD-5','ESRD')
        order by account_nbr_nbr");

        return $ckd_hosp_re_admission_after_discharge_p2y[0]->CkdReAdmission;
    }

    /* Total CKD Hospital Admission "Current Year" 
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function totalCkdHosAdmissionCy()
    {
        $ckd_hosp_re_admission_cy = DB::select("select count(distinct account_nbr_nbr) totalCkdHosAdmissionCy
        from analytic_data
        where practice_id=$this->practice_id and cptcode in(99221,99222,99223,99251,99252,99253,99254,99255)
        and date_of_service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and ckd_stage in('CKD-1','CKD-2','CKD-3','CKD-4','CKD-5','ESRD')
        order by account_nbr_nbr");

        return $ckd_hosp_re_admission_cy[0]->totalCkdHosAdmissionCy;
    }

    /* Total CKD Hospital Admission  "Prior Year" 
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function totalCkdHosAdmissionP1y()
    {
        $ckd_hosp_re_admission_p1y = DB::select("select count(distinct account_nbr_nbr) totalCkdHosAdmissionP1y
        from analytic_data
        where practice_id=$this->practice_id and cptcode in(99221,99222,99223,99251,99252,99253,99254,99255)
        and date_of_service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
        and ckd_stage in('CKD-1','CKD-2','CKD-3','CKD-4','CKD-5','ESRD')
        order by account_nbr_nbr");

        return $ckd_hosp_re_admission_p1y[0]->totalCkdHosAdmissionP1y;
    }
      /* Total CKD Hospital Admission "Two Prior Year" 
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function totalCkdHosAdmissionP2y()
    {
        $ckd_hosp_re_admission_p2y = DB::select("select count(distinct account_nbr_nbr) totalCkdHosAdmissionP2y
        from analytic_data
        where practice_id=$this->practice_id and cptcode in(99221,99222,99223,99251,99252,99253,99254,99255)
        and date_of_service between $this->analysis_start_date_p2y and $this->analysis_end_date_p2y
        and ckd_stage in('CKD-1','CKD-2','CKD-3','CKD-4','CKD-5','ESRD')
        order by account_nbr_nbr");

        return $ckd_hosp_re_admission_p2y[0]->totalCkdHosAdmissionP2y;
    }

    // CKD Hospital Admission "final formulas"

    /* calculate Re-addmision formula
        CKD Hospital Re-Admission "Current Year" / total ckd hospital admisssion "Current Year"
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */  

    public function CkdHospReAdmissionCy()
    {
        $Ckd = self::CkdHospReAdmissionAfterDischargeCy();
        $total_ckd = self::totalCkdHosAdmissionCy();

        $a = isset($total_ckd) && !empty($total_ckd) ? round((($Ckd) * $this->percentage) / $total_ckd, 2) : 0;

        return $a;
    }

    /* calculate Re-addmision formula
        CKD Hospital Re-Admission "prior Year" / total ckd hospital admisssion "prior Year"
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function CkdHospReAdmissionP1y()
    {
        $Ckd = self::CkdHospReAdmissionAfterDischargeP1y();
        $total_ckd = self::totalCkdHosAdmissionP1y();

        $a = isset($total_ckd) && !empty($total_ckd) ? round((($Ckd) * $this->percentage) / $total_ckd, 2) : 0;

        return $a;
    }

      /* calculate Re-addmision formula
        CKD Hospital Re-Admission "two prior Year" / total ckd hospital admisssion "two prior Year"
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */ 

    public function CkdHospReAdmissionP2y()
    {
        $Ckd = self::CkdHospReAdmissionAfterDischargeP2y();
        $total_ckd = self::totalCkdHosAdmissionP2y();

        $a = isset($total_ckd) && !empty($total_ckd) ? round((($Ckd) * $this->percentage) / $total_ckd, 2) : 0;

        return $a;
    }

    //  CKD TCM Post-Discharge "year" 

    /* calculate Re-addmision formula
        CKD Hospital Re-Admission "two prior Year" / total ckd hospital admisssion "two prior Year"
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
    */

    public function CkdTcmPostDischargCy()
    {
        $ckd_tcm = DB::select("select count(distinct concat(account_nbr_nbr,date_format(date_of_Service,'%y%m%d'))) CkdTcmPostDischargCy
        from analytic_data
        where practice_id=$this->practice_id
        and date_of_service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and tcm_post_discharge_ind=1
        and ckd_stage in('CKD-1','CKD-2','CKD-3','CKD-4','CKD-5','ESRD')
        order by account_nbr_nbr");

        return $ckd_tcm[0]->CkdTcmPostDischargCy;
    }

    /*  Transitional care management is a medical billing option that
        reimburses billing practitioners for treating patients with a complex
        medical condition during their 30-day post-discharge period
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
        */

    public function CkdTcmPostDischargP1y()
    {
        $ckd_tcm = DB::select("select count(distinct concat(account_nbr_nbr,date_format(date_of_Service,'%y%m%d'))) CkdTcmPostDischargP1y
        from analytic_data
        where practice_id=$this->practice_id
        and date_of_service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
        and tcm_post_discharge_ind=1
        and ckd_stage in('CKD-1','CKD-2','CKD-3','CKD-4','CKD-5','ESRD')
        order by account_nbr_nbr");

        return $ckd_tcm[0]->CkdTcmPostDischargP1y;
    }

    /*  Transitional care management is a medical billing option that
        reimburses billing practitioners for treating patients with a complex
        medical condition during their 30-day post-discharge period
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
        */

    public function CkdTcmPostDischargP2y()
    {
        $ckd_tcm = DB::select("select count(distinct concat(account_nbr_nbr,date_format(date_of_Service,'%y%m%d'))) CkdTcmPostDischargP2y
        from analytic_data
        where practice_id=$this->practice_id
        and date_of_service between $this->analysis_start_date_p2y and $this->analysis_end_date_p2y
        and tcm_post_discharge_ind=1
        and ckd_stage in('CKD-1','CKD-2','CKD-3','CKD-4','CKD-5','ESRD')
        order by account_nbr_nbr");

        return $ckd_tcm[0]->CkdTcmPostDischargP2y;
    }

    //  total CKD TCM Post-Discharge "year"
    /*  Transitional care management is a medical billing option that
        reimburses billing practitioners for treating patients with a complex
        medical condition during their 30-day post-discharge period
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
        */

    public function totalCkdTcmPostDischargeCy()
    {

        $total_ckd_tcm = DB::select("select count(distinct account_nbr_nbr) totalCkdTcmPostDischargeCy
        from analytic_data
        where practice_id=$this->practice_id and cptcode in(99238,99239)
        and date_of_service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and ckd_stage in('CKD-1','CKD-2','CKD-3','CKD-4','CKD-5','ESRD')
        order by account_nbr_nbr");

        return $total_ckd_tcm[0]->totalCkdTcmPostDischargeCy;
    }

    //  total CKD TCM Post-Discharge "year"
    /*  Transitional care management is a medical billing option that
        reimburses billing practitioners for treating patients with a complex
        medical condition during their 30-day post-discharge period
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
        */

    public function totalCkdTcmPostDischargeP1y()
    {

        $total_ckd_tcm = DB::select("select count(distinct account_nbr_nbr) totalCkdTcmPostDischargeP1y
        from analytic_data
        where practice_id=$this->practice_id and cptcode in(99238,99239)
        and date_of_service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
        and ckd_stage in('CKD-1','CKD-2','CKD-3','CKD-4','CKD-5','ESRD')
        order by account_nbr_nbr");

        return $total_ckd_tcm[0]->totalCkdTcmPostDischargeP1y;
    }

    //  total CKD TCM Post-Discharge "year"
    /*  Transitional care management is a medical billing option that
        reimburses billing practitioners for treating patients with a complex
        medical condition during their 30-day post-discharge period
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
        */

    public function totalCkdTcmPostDischargeP2y()
    {

        $total_ckd_tcm = DB::select("select count(distinct account_nbr_nbr) totalCkdTcmPostDischargeP2y
        from analytic_data
        where practice_id=$this->practice_id and cptcode in(99238,99239)
        and date_of_service between $this->analysis_start_date_p2y and $this->analysis_end_date_p2y
        and ckd_stage in('CKD-1','CKD-2','CKD-3','CKD-4','CKD-5','ESRD')
        order by account_nbr_nbr");

        return $total_ckd_tcm[0]->totalCkdTcmPostDischargeP2y;
    }

    //  CKD TCM Post-Discharge "final formulas"
    /*  Transitional care management is a medical billing option that
        reimburses billing practitioners for treating patients with a complex
        medical condition during their 30-day post-discharge period
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
        */

    public function CkdTcmPostDischargeCy()
    {
        $ckd_tcm = self::CkdTcmPostDischargCy();
        $total_ckd_tcm = self::totalCkdTcmPostDischargeCy();

        $a = isset($total_ckd_tcm) && !empty($total_ckd_tcm) ? round((($ckd_tcm) * $this->percentage) / $total_ckd_tcm, 2) : 0;

        return $a;
    }

    //  CKD TCM Post-Discharge "final formulas"
    /*  Transitional care management is a medical billing option that
        reimburses billing practitioners for treating patients with a complex
        medical condition during their 30-day post-discharge period
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
        */

    public function CkdTcmPostDischargeP1y()
    {
        $ckd_tcm = self::CkdTcmPostDischargP1y();
        $total_ckd_tcm = self::totalCkdTcmPostDischargeP1y();

        $a = isset($total_ckd_tcm) && !empty($total_ckd_tcm) ? round((($ckd_tcm) * $this->percentage) / $total_ckd_tcm, 2) : 0;

        return $a;
    }

    //  CKD TCM Post-Discharge "final formulas"
    /*  Transitional care management is a medical billing option that
        reimburses billing practitioners for treating patients with a complex
        medical condition during their 30-day post-discharge period
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
        */

    public function CkdTcmPostDischargeP2y()
    {
        $ckd_tcm = self::CkdTcmPostDischargP2y();
        $total_ckd_tcm = self::totalCkdTcmPostDischargeP2y();

        $a = isset($total_ckd_tcm) && !empty($total_ckd_tcm) ? round((($ckd_tcm) * $this->percentage) / $total_ckd_tcm, 2) : 0;

        return $a;
    }
    //  CKD Hosp. Re-Admission and CKD TCM Post-Discharge "per year table"

    public function CkdHospReAdmissionAndTcmPerYearTable()
    {

        $CkdHospReAdmissionAndTcmPerYearTable = array(
            array(
                'title' => ' CKD Hosp. Re-Admission',
                'cy' => self::CkdHospReAdmissionCy(),
                'p1y' => self::CkdHospReAdmissionP1y(),
                'p2y' => self::CkdHospReAdmissionP2y()
            ),
            array(
                'title' => 'CKD TCM Post-Discharge',
                'cy' => self::CkdTcmPostDischargeCy(),
                'p1y' => self::CkdTcmPostDischargeP1y(),
                'p2y' => self::CkdTcmPostDischargeP2y()
            ),

        );

        return $CkdHospReAdmissionAndTcmPerYearTable;
    }

    // ------------------------------------------------------------------------------------------------------------------------

    //  optimal Starts

    /*  Optimal starts are generally defined as when a patient starts at home dialysis,
         receives a preemptive transplant or starts in-center hemodialysis with a permanent access. 
        They can result in fewer complications, reduce costs, and improve outcomes for patients.
     * fte  : full time equivalent
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
        */

    public function optimalStartsPercent()
    {
        $osp = DB::select("select date_format(date_of_Service,'%b-%y') kys -- ,count(encounteer)
        ,round((sum(optimal_start)+sum(optimal_start_new))/count(encounter)*$this->percentage,2) vals
                from(
                select distinct date_of_service,concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d')) encounter,
                (select count(cptcode) from analytic_data adi
                where practice_id=$this->practice_id
                and adi.account_nbr_nbr=ad.account_nbr_nbr
                and adi.Date_of_Service < ad.date_of_Service
                and adi.cptcode in(36555,36556,36557,36558)
                ) optimal_Start,
                (select count(distinct account_nbr_nbr) from analytic_data adi
                where practice_id=$this->practice_id
                and adi.account_nbr_nbr=ad.account_nbr_nbr
                and adi.Date_of_Service between date_sub(ad.date_of_Service,interval 30 day) and date_sub(ad.date_of_service,interval 1 day)
                ) optimal_Start_new
                FROM analytic_data ad
                WHERE practice_id=$this->practice_id
                and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                and cptcode in('90960','90961','90962','90963','90964','90965','90966','90935','90937','90945','90947','90970')
                and first_dialysis_ind=1
                ) dt
                group by date_format(date_of_Service,'%b-%y'),date_format(date_of_Service,'%y%m')
                order by date_format(date_of_Service,'%y%m')");

        return $osp;

    }

    /*  Optimal starts are generally defined as when a patient starts at home dialysis,
         receives a preemptive transplant or starts in-center hemodialysis with a permanent access. 
        They can result in fewer complications, reduce costs, and improve outcomes for patients.
     * fte  : full time equivalent
     * 12 month prior means to get 13 month data
     * rvu  : relative value uits
     * ckd  : chronical kidney disease
     * encounter : number of patients vist
     * unique patients : distinct encouter
     * Cy   : stand for  Current Year
     * p1y  : stand for Prior year
     * p2y  : stand for two prior year
     * p3y  : stand for three prior year 
        */

    public function optimalStarts12MonthPriorPercent()
    {
        $osp = DB::select("select date_format(date_of_Service,'%b-%y') kys -- ,count(encounteer)
        ,round((sum(optimal_start)+sum(optimal_start_new))/count(encounter)*$this->percentage,2) vals
                from(
                select distinct date_of_service,concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d')) encounter,
                (select count(cptcode) from analytic_data adi
                where practice_id=$this->practice_id
                and adi.account_nbr_nbr=ad.account_nbr_nbr
                and adi.Date_of_Service < ad.date_of_Service
                and adi.cptcode in(36555,36556,36557,36558)
                ) optimal_Start,
                (select count(distinct account_nbr_nbr) from analytic_data adi
                where practice_id=$this->practice_id
                and adi.account_nbr_nbr=ad.account_nbr_nbr
                and adi.Date_of_Service between date_sub(ad.date_of_Service,interval 30 day) and date_sub(ad.date_of_service,interval 1 day)
                ) optimal_Start_new
                FROM analytic_data ad
                WHERE practice_id=$this->practice_id
                and Date_of_Service between $this->analysis_end_date_12_month_prior and '$this->analysis_end_date_cy'
                and cptcode in('90960','90961','90962','90963','90964','90965','90966','90935','90937','90945','90947','90970')
                and first_dialysis_ind=1
                ) dt
                group by date_format(date_of_Service,'%b-%y'),date_format(date_of_Service,'%y%m')
                order by date_format(date_of_Service,'%y%m')");
        // dd($osp);
        return $osp;
    }

    public function optimalStarts()
    {
        $os = DB::select("select date_format(date_of_Service,'%b-%y') kys -- ,count(encounteer)
        ,round(sum(optimal_start),2)+round(sum(optimal_start_new),2) vals
                from(
                select distinct date_of_service,concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d')) encounter,
                (select count(cptcode) from analytic_data adi
                where practice_id=$this->practice_id
                and adi.account_nbr_nbr=ad.account_nbr_nbr
                and adi.Date_of_Service < ad.date_of_Service
                and adi.cptcode in(36555,36556,36557,36558)
                ) optimal_Start,
                (select count(distinct account_nbr_nbr) from analytic_data adi
                where practice_id=$this->practice_id
                and adi.account_nbr_nbr=ad.account_nbr_nbr
                and adi.Date_of_Service between date_sub(ad.date_of_Service,interval 30 day) and date_sub(ad.date_of_service,interval 1 day)
                ) optimal_Start_new
                FROM analytic_data ad
                WHERE practice_id=$this->practice_id
                and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                and cptcode in('90960','90961','90962','90963','90964','90965','90966','90935','90937','90945','90947','90970')
                and first_dialysis_ind=1
                ) dt
                group by date_format(date_of_Service,'%b-%y'),date_format(date_of_Service,'%y%m')
                order by date_format(date_of_Service,'%y%m')");

        return $os;
    }

    public function optimalStarts12MonthPrior()
    {
        $os = DB::select("select date_format(date_of_Service,'%b-%y') kys -- ,count(encounteer)
        ,round(sum(optimal_start),2)+round(sum(optimal_start_new),2) vals
                from(
                select distinct date_of_service,concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d')) encounter,
                (select count(cptcode) from analytic_data adi
                where practice_id=$this->practice_id
                and adi.account_nbr_nbr=ad.account_nbr_nbr
                and adi.Date_of_Service < ad.date_of_Service
                and adi.cptcode in(36555,36556,36557,36558)
                ) optimal_Start,
                (select count(distinct account_nbr_nbr) from analytic_data adi
                where practice_id=$this->practice_id
                and adi.account_nbr_nbr=ad.account_nbr_nbr
                and adi.Date_of_Service between date_sub(ad.date_of_Service,interval 30 day) and date_sub(ad.date_of_service,interval 1 day)
                ) optimal_Start_new
                FROM analytic_data ad
                WHERE practice_id=$this->practice_id
                and Date_of_Service between $this->analysis_end_date_12_month_prior and '$this->analysis_end_date_cy'
                and cptcode in('90960','90961','90962','90963','90964','90965','90966','90935','90937','90945','90947','90970')
                and first_dialysis_ind=1
                ) dt
                group by date_format(date_of_Service,'%b-%y'),date_format(date_of_Service,'%y%m')
                order by date_format(date_of_Service,'%y%m')");

        return $os;
    }

    public function inCenterNoCatheter()
    {
        $icnc = DB::select("select date_format(date_of_Service,'%b-%y') kys,count(incenter_no_catheter) vls from (
            select distinct date_of_service,concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d')) encounter,cptcode outercpt,
            (select distinct adi.account_nbr_nbr
            from analytic_data adi 
            where adi.practice_id=$this->practice_id 
            and adi.account_nbr_nbr=ad.account_nbr_nbr
            and adi.Date_of_Service=ad.Date_of_Service
            and adi.cptcode in(90945,90947,90999)
            ) incenter_no_catheter
            FROM analytic_data ad
            WHERE practice_id=$this->practice_id 
            and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
            and ((cptcode between 90935 and 90970) or cptcode =90999)
            -- and account_nbr_nbr=166411
            )dt
            group by date_format(date_of_Service,'%b-%y'),date_format(date_of_Service,'%y%m')
            order by date_format(date_of_Service,'%y%m')");

        return $icnc;
    }

    public function inCenterNoCatheter12MonthPrior()
    {
        $icnc = DB::select("select date_format(date_of_Service,'%b-%y') kys,count(incenter_no_catheter) vls from (
            select distinct date_of_service,concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d')) encounter,cptcode outercpt,
            (select distinct adi.account_nbr_nbr
            from analytic_data adi 
            where adi.practice_id=$this->practice_id 
            and adi.account_nbr_nbr=ad.account_nbr_nbr
            and adi.Date_of_Service=ad.Date_of_Service
            and adi.cptcode in(90945,90947,90999)
            ) incenter_no_catheter
            FROM analytic_data ad
            WHERE practice_id=$this->practice_id 
            and Date_of_Service between $this->analysis_end_date_12_month_prior and '$this->analysis_end_date_cy'
            and ((cptcode between 90935 and 90970) or cptcode =90999)
            -- and account_nbr_nbr=166411
            )dt
            group by date_format(date_of_Service,'%b-%y'),date_format(date_of_Service,'%y%m')
            order by date_format(date_of_Service,'%y%m')");

        return $icnc;
    }

    public function incidentHome()
    {
        $ih = DB::select("select date_format(date_of_Service,'%b-%y') kys,round(sum(incident_home),2) vals
        from(
        select distinct date_of_service,concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d')) encounter,
            (select count(cptcode) from analytic_data adi
            where practice_id=$this->practice_id
            and adi.account_nbr_nbr=ad.account_nbr_nbr 
            and adi.date_of_service=ad.date_of_service
            and adi.cptcode in(90963,90964,90965,90966)
            and adi.first_dialysis_ind=1
            ) incident_home
        FROM analytic_data ad
        WHERE practice_id=$this->practice_id
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and cptcode between 90935 and 90970
        ) dt
        group by date_format(date_of_Service,'%b-%y'),date_format(date_of_Service,'%y%m')
        order by date_format(date_of_Service,'%y%m');");

        return $ih;
    }

    public function incidentHomePerFte()
    {
        $ih = DB::select("select date_format(date_of_Service,'%b-%y') kys,round(sum(incident_home)/max(fte.fte_val),2) vals
        from(
        select distinct date_of_service,concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d')) encounter,
            (select count(cptcode) from analytic_data adi
             where practice_id=$this->practice_id
             and adi.account_nbr_nbr=ad.account_nbr_nbr
             and adi.date_of_service=ad.date_of_service
             and adi.cptcode in(90963,90964,90965,90966)
             and adi.first_dialysis_ind=1
            ) incident_home
        FROM analytic_data ad
        WHERE practice_id=$this->practice_id
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and cptcode between 90935 and 90970
        ) dt,
        (select month_fte,sum(1*provider_fte) fte_val
		 from(
		 	  select distinct date_format(date_of_Service,'%y%m') month_fte,provider,provider_fte
			  FROM analytic_data adf
			  WHERE practice_id=$this->practice_id
			  and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
			  ) fte
		 group by month_fte
		) fte
		where date_format(dt.date_of_Service,'%y%m')=fte.month_fte
        group by date_format(date_of_Service,'%b-%y'),date_format(date_of_Service,'%y%m')
        order by date_format(date_of_Service,'%y%m')");

        return $ih;
    }

    public function incidentHome12MonthPrior()
    {
        $ih = DB::select("select date_format(date_of_Service,'%b-%y') kys,round(sum(incident_home),2) vals 
        from(
        select distinct date_of_service,concat(account_nbr_nbr,date_format(date_of_service,'%y%m%d')) encounter,
        (select count(cptcode) from analytic_data adi 
        where practice_id=$this->practice_id 
        and adi.account_nbr_nbr=ad.account_nbr_nbr 
        and adi.date_of_service=ad.date_of_service
        and adi.cptcode in(90963,90964,90965,90966)
        and adi.first_dialysis_ind=1
        ) incident_home
        FROM analytic_data ad
        WHERE practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_end_date_12_month_prior and '$this->analysis_end_date_cy'
        and cptcode between 90935 and 90970
        ) dt
        group by date_format(date_of_Service,'%b-%y'),date_format(date_of_Service,'%y%m')
        order by date_format(date_of_Service,'%y%m')");

        return $ih;
    }

    public function totalNewStarts()
    {
        $tns = DB::select("select date_format(date_of_Service,'%b-%y') kys,count(account_nbr_nbr) vals 
        from(
        select min(date_of_service) date_of_service,account_nbr_nbr 
        from analytic_data adi 
        where practice_id=$this->practice_id 
        and first_dialysis_ind=1
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by account_nbr_nbr
        ) dt
        group by date_format(date_of_Service,'%b-%y'),date_format(date_of_Service,'%y%m')
        order by date_format(date_of_Service,'%y%m')");

        return $tns;
    }

    public function totalNewStarts12MonthPrior()
    {
        $tns = DB::select("select date_format(date_of_Service,'%b-%y') kys,count(account_nbr_nbr) vals 
        from(
        select min(date_of_service) date_of_service,account_nbr_nbr 
        from analytic_data adi 
        where practice_id=$this->practice_id 
        and first_dialysis_ind=1
        and Date_of_Service between $this->analysis_end_date_12_month_prior and '$this->analysis_end_date_cy'
        group by account_nbr_nbr
        ) dt
        group by date_format(date_of_Service,'%b-%y'),date_format(date_of_Service,'%y%m')
        order by date_format(date_of_Service,'%y%m')");

        return $tns;
    }



    // optimal -> home 

    public function homePatients()
    {
        $hp = DB::select("select  date_format(Date_of_Service,'%b-%y') kys,sum(dialysis_yes) vls from(
            SELECT DISTINCT Date_of_Service,account_nbr_nbr,
            if(cptcode in('90963','90964','90965','90966'),1,0) dialysis_yes,
            if(cptcode in('90963','90964','90965','90966') and first_dialysis_ind=1,1,0) first_dialysis_yes
            FROM analytic_data 
            WHERE practice_id=$this->practice_id 
            and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
            )dt
            group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
            order by date_format(Date_of_Service,'%y%m')");

        return $hp;
    }

    public function newHomePatients()
    {
        $nhp = DB::select("select  date_format(Date_of_Service,'%b-%y') kys,sum(first_dialysis_yes) vls from(
            SELECT DISTINCT Date_of_Service,account_nbr_nbr,
            if(cptcode in('90963','90964','90965','90966'),1,0) dialysis_yes,
            if(cptcode in('90963','90964','90965','90966') and first_dialysis_ind=1,1,0) first_dialysis_yes
            FROM analytic_data 
            WHERE practice_id=$this->practice_id 
            and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
            )dt
            group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
            order by date_format(Date_of_Service,'%y%m')");

        return $nhp;
    }

    public function homeCountPerFte()
    {
        $hpf = DB::select("select  a.month_year kys,round(a.vls/b.sum_provider_fte,2) home_fte 
        from
        (select  date_format(Date_of_Service,'%b-%y') month_year,date_format(Date_of_Service,'%y%m') month_year_order,sum(dialysis_yes) vls,COUNT(DISTINCT account_nbr_nbr),sum(dialysis_yes) from(
			 SELECT DISTINCT Date_of_Service,account_nbr_nbr,
             if(cptcode in('90963','90964','90965','90966'),1,0) dialysis_yes,
             if(cptcode in('90963','90964','90965','90966') and first_dialysis_ind=1,1,0) first_dialysis_yes
			 FROM analytic_data ad
			 WHERE practice_id=$this->practice_id 
			 and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
			 )dt
			 group by date_format(Date_of_Service,'%b-%y')
        ) a,
        (select ads.month_year,sum(ads.provider_fte) sum_provider_fte
        from(
             select distinct date_format(adt.date_of_service,'%b-%y') month_year,adt.provider,adt.provider_fte
             from analytic_data adt
             where adt.practice_id=$this->practice_id
             ) ads
        group by ads.month_year
        ) b
        where a.month_year=b.month_year
        order by a.month_year_order");

        // dd($hpf);

        return $hpf;
    }

    public function newHomePerFte()
    {
        $nhpf = DB::select("select  a.month_year kys,round(a.vls/b.sum_provider_fte,2) new_home_fte 
        from
        (select  date_format(Date_of_Service,'%b-%y') month_year,date_format(Date_of_Service,'%y%m') month_year_order,sum(first_dialysis_yes) vls,COUNT(DISTINCT account_nbr_nbr),sum(dialysis_yes) from(
			 SELECT DISTINCT Date_of_Service,account_nbr_nbr,
             if(cptcode in('90963','90964','90965','90966'),1,0) dialysis_yes,
             if(cptcode in('90963','90964','90965','90966') and first_dialysis_ind=1,1,0) first_dialysis_yes
			 FROM analytic_data ad
			 WHERE practice_id=$this->practice_id 
			 and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
			 )dt
			 group by date_format(Date_of_Service,'%b-%y')
        ) a,
        (select ads.month_year,sum(ads.provider_fte) sum_provider_fte
        from(
             select distinct date_format(adt.date_of_service,'%b-%y') month_year,adt.provider,adt.provider_fte
             from analytic_data adt
             where adt.practice_id=$this->practice_id
             ) ads
        group by ads.month_year
        ) b
        where a.month_year=b.month_year
        order by a.month_year_order");

        return $nhpf;
    }

    public function homePercent()
    {
        $hp = DB::select("select  date_format(Date_of_Service,'%b-%y') kys ,round(sum(dialysis_yes)/COUNT(DISTINCT account_nbr_nbr)*$this->percentage,2) homeper from(
            select DISTINCT Date_of_Service,account_nbr_nbr,
            if(cptcode in('90963','90964','90965','90966'),1,0) dialysis_yes,
            if(cptcode in('90963','90964','90965','90966') and first_dialysis_ind=1,1,0) first_dialysis_yes
            FROM analytic_data 
            WHERE practice_id=$this->practice_id 
            and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
            )dt
            group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
            order by date_format(Date_of_Service,'%y%m')");

        return $hp;
    }

    // optimal start -> new start Roster

    public function byFirstProvider()
    {
        $bfp = DB::select("select provider,count(distinct account_nbr_nbr) new_start_patients
        from analytic_data 
        where practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and first_dialysis_ind=1 
        and cptcode in(90960, 90961, 90962, 90963, 90964, 90965, 90966, 90935,90937, 90945, 90947, 90970)
        group by provider
        order by 1");

        return $bfp;
    }

    public function byLastProvider()
    {
        $blp = DB::select("select provider,count(distinct account_nbr_nbr) new_start_patients
        from analytic_data 
        where (account_nbr_nbr,date_of_service) in(
        select account_nbr_nbr,max(date_of_service) max_date_of_service
        from analytic_data 
        where practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and cptcode in(90960, 90961, 90962, 90963, 90964, 90965, 90966, 90935,90937, 90945, 90947, 90970)
        group by account_nbr_nbr)
        and practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by provider");

        return $blp;
    }

    public function byFirstDialysisLocation()
    {
        $bfdl = DB::select("select service_location,count(distinct account_nbr_nbr) new_start_patients
        from analytic_data 
        where practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and first_dialysis_ind=1 
        and cptcode in(90960, 90961, 90962, 90963, 90964, 90965, 90966, 90935,90937, 90945, 90947, 90970)
        group by service_location
        order by 1");

        return $bfdl;
    }

    public function bylastDialysisLocation()
    {
        $bldl = DB::select("select service_location,count(distinct account_nbr_nbr) new_start_patients
        from analytic_data 
        where (account_nbr_nbr,date_of_service) in(
        select account_nbr_nbr,max(date_of_service) max_date_of_service
        from analytic_data 
        where practice_id=$this->practice_id
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and cptcode in(90960, 90961, 90962, 90963, 90964, 90965, 90966, 90935,90937, 90945, 90947, 90970)
        and account_nbr_nbr in(select account_nbr_nbr
        from analytic_data 
        where practice_id=$this->practice_id
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and cptcode in(90960, 90961, 90962, 90963, 90964, 90965, 90966, 90935,90937, 90945, 90947, 90970)
        and first_dialysis_ind = 1
        )
        group by account_nbr_nbr)
        and practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by service_location");

        return $bldl;
    }



    // optimal start -> late stage Roster

    public function byProvider()
    {
        $bp = DB::select("select provider,count(distinct account_nbr_nbr)  last_stage_patients
        from analytic_data
        where practice_id=$this->practice_id
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and ckd_stage in('CKD-4','CKD-5','ESRD')
        group by provider
        order by 1");

        return $bp;
    }

    public function byFirstLocation()
    {
        $bfl = DB::select("select service_location,count(distinct account_nbr_nbr) last_stage_patients
        from analytic_data 
        where (account_nbr_nbr,date_of_service) in(
        select account_nbr_nbr,min(date_of_service)
        from analytic_data 
        where practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and ckd_stage in('CKD-4','CKD-5','ESRD')
        group by account_nbr_nbr)
        and practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by service_location
        order by 1");

        return $bfl;
    }

    public function byInsurance()
    {
        $bi = DB::select("select primary_insurance_name,count(distinct account_nbr_nbr) last_stage_patients
        from analytic_data 
        where practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy' 
        and ckd_stage in('CKD-4','CKD-5','ESRD')
        group by primary_insurance_name
        order by 1");

        return $bi;
    }

    // late stage roster
    public function lastOfficeLocation()
    {
        $lol = DB::select("select service_location,count(distinct account_nbr_nbr) last_stage_patients
        from analytic_data 
        where (account_nbr_nbr,date_of_service) in(
        select account_nbr_nbr,max(date_of_service) max_date_of_service
        from analytic_data 
        where practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and ckd_stage in('CKD-4','CKD-5','ESRD')
        group by account_nbr_nbr)
        and practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by service_location");

        return $lol;
    }

    public function byStage()
    {
        $bs = DB::select("select ckd_stage,count(distinct account_nbr_nbr) last_stage_patients
        from analytic_data 
        where practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and ckd_stage in('CKD-4','CKD-5','ESRD')
        group by ckd_stage
        order by 1");
        return $bs;
    }

    public function newstartPatientMap()
    {
        $lspm = DB::select("select new_pts.ckd_stage,new_pts.account_nbr_nbr,new_pts.cptcode,new_pts.date_of_Service,new_pts.zipcode,
        md.latitude,md.longitude,md.city,md.state,md.country from 
        (select distinct ad.ckd_stage,ad.account_nbr_nbr,ad.cptcode,ad.date_of_Service,ad.zipcode
                from analytic_data ad
                where practice_id=$this->practice_id
                and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                and cptcode between 90935 and 90970
                and first_dialysis_ind=1
                ) new_pts,
        (select distinct ad.ckd_stage,ad.account_nbr_nbr,ad.cptcode,ad.date_of_Service,
          (select adi.account_nbr_nbr
           from analytic_data adi 
           where adi.practice_id=$this->practice_id
           and adi.Date_of_Service <ad.date_of_Service
           and adi.account_nbr_nbr=ad.account_nbr_nbr
           and adi.cptcode in(49400,74190,36555,36556,36557,36558)
           union
           select distinct account_nbr_nbr
           from analytic_data adi
           where practice_id=$this->practice_id
           and adi.account_nbr_nbr=ad.account_nbr_nbr
           and adi.Date_of_Service between date_sub(ad.date_of_Service,interval 30 day) and date_sub(ad.date_of_service,interval 1 day)) optimal_start_account_nbr_nbr
         from analytic_data ad
         where practice_id=$this->practice_id
         and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
         and cptcode between 90935 and 90970
         and first_dialysis_ind=1
         ) optimal_start,
         map_data md
        where new_pts.account_nbr_nbr= optimal_start.optimal_start_account_nbr_nbr
        and md.zipcode=new_pts.zipcode");

        return $lspm;
    }

    public function lateStagePatientMap()
    {
        $lspm = DB::select("select distinct  ad.ckd_stage, ad.account_nbr_nbr,md.zipcode,md.latitude,md.longitude,md.city,md.state,md.country
        from analytic_data ad,map_data md
        where ad.zipcode=md.zipcode
        and practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and ckd_stage in('CKD-4','CKD-5','ESRD')
        order by 1");

        return $lspm;
    }

    public function lateStageCKDRoster()
    {
        $ltcr = DB::table('analytic_data')
            ->select('account_nbr_nbr', 'patient_name', 'dateofbirth', 'ckd_Stage', 'service_location', 'provider', 'primary_insurance_name', DB::raw('max(date_of_service) office_date'), DB::raw('datediff(now(),max(date_of_service)) last_visit'))
            ->where('practice_id', $this->practice_id)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
            ->where('active_late_stage_ind', 1)
            ->whereIn('ckd_stage', ['CKD-4', 'CKD-5','ESRD'])
            ->groupBy('account_nbr_nbr', 'patient_name', 'dateofbirth', 'ckd_Stage', 'service_location', 'provider', 'primary_insurance_name')
            ->paginate(25);

        return $ltcr;
    }

    public function newStartRoster()
    {
        $result = DB::table('analytic_data as ad1')
        ->select('ad1.account_nbr_nbr as patient_id', 'patient_name', 'dateofbirth', 'provider', 'service_location as location',
            DB::raw("(SELECT max(service_location) FROM analytic_data ad2 
                      WHERE ad1.account_nbr_nbr=ad2.account_nbr_nbr
                      AND ad2.Date_of_Service = (
                        SELECT MAX(Date_of_Service)
                        FROM analytic_data ad3
                        WHERE ad3.account_nbr_nbr = ad1.account_nbr_nbr 
                      )) AS last_office_location"),
            'date_of_service as Day_of_First_MCP',
            DB::raw("(SELECT max(IF(cptcode IN (49400,74190), 'PDCATH', IF(cptcode = 36556, 'CVCATH', '-'))) 
                      FROM analytic_data adcath 
                      WHERE practice_id = $this->practice_id 
                      AND adcath.account_nbr_nbr = ad1.account_nbr_nbr) AS first_access"),
            DB::raw("(SELECT max(IF(cptcode IN (90963,90964,90965,90966), 'Incident Home', '-')) 
                      FROM analytic_data adcath 
                      WHERE practice_id = $this->practice_id 
                      AND adcath.account_nbr_nbr = ad1.account_nbr_nbr) AS home_status"),
            DB::raw("ifnull((select 'Optimal Start' from analytic_data ad4
                    where practice_id = $this->practice_id 
                    and ad4.account_nbr_nbr=ad1.account_nbr_nbr
                    and ad4.date_of_service<ad1.date_of_service
                    and ad4.cptcode in(49400,74190,36555 ,36556 ,36557, 36558)),'-') as optimal_start"))
        ->where('practice_id', $this->practice_id)
        ->whereBetween('Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
        ->where('first_dialysis_ind', '=', 1)    
        ->paginate(25);

        return $result;
    }

    //patient dashboard -> Roster -> pt Roster List

    public function totalBalanceofPatientsbyStage()
    {
        $tbopbs = DB::select("select SUM(if(ckd_stage='CKD-1',cnt,0)+if(ckd_stage='CKD-2',cnt,0)+if(ckd_stage='CKD-3',cnt,0)) early,
        SUM(if(ckd_stage='ESRD',cnt,0)) esrd,
        SUM(if(ckd_stage='CKD-1',cnt,0)+if(ckd_stage='CKD-2',cnt,0)+if(ckd_stage='CKD-3',cnt,0)+if(ckd_stage='CKD-4',cnt,0)+if(ckd_stage='CKD-5',cnt,0)) nonesrd,
        SUM(if(ckd_stage='CKD-4',cnt,0)) ckd4,
        SUM(if(ckd_stage='CKD-5',cnt,0)) ckd5
         from(
        select ckd_stage,count(distinct account_nbr_nbr) cnt
        from analytic_data
        where practice_id=$this->practice_id
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and (account_nbr_nbr,date_of_service) in (
                                                select account_nbr_nbr,max(date_of_service)
                                                from analytic_data
                                                where practice_id=$this->practice_id
                                                and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                                                group by account_nbr_nbr)
        and ckd_stage not in('Non-CKD','Unspecified')                                        
        group by ckd_stage) dt");

        return $tbopbs;
    }

    public function billedAsMcp()
    {
        $bam = DB::select("select dt.ky,dt.base,dt.reactive,new,sum(if(dt.base>0,base,0)+if(dt.new>0,new,0)+if(dt.reactive>0,reactive,0)) totel from (
            select date_format(date_of_service,'%b-%y') ky,date_format(date_of_service,'%y%m')kyord,count(distinct account_nbr_nbr) base,sum(reactivated_ind) reactive,sum(if(date_of_service=first_visit_date,1,0)) new
            from analytic_data 
            where practice_id=$this->practice_id
            and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
            and cptcode in(90960,90961,90962,90963,90964,90965,90966)
            group by date_format(date_of_service,'%b-%y'),date_format(date_of_service,'%y%m')
            order by date_format(date_of_service,'%y%m'))dt 
        group by dt.ky,kyord
        order by kyord");

        return $bam;
    }

    public function billedAsNonMcp()
    {
        $tbopbs = DB::select("select dt.ky,dt.base,dt.reactive,new,sum(if(dt.base>0,base,0)+if(dt.new>0,new,0)+if(dt.reactive>0,reactive,0)) totel from (
            select date_format(date_of_service,'%b-%y') ky,date_format(date_of_service,'%y%m')kyord,count(distinct account_nbr_nbr) base,sum(reactivated_ind) reactive,sum(if(date_of_service=first_visit_date,1,0)) new
            from analytic_data 
            where practice_id=$this->practice_id
            and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
            and cptcode in(90935,90937,90945,90947)
            group by date_format(date_of_service,'%b-%y'),date_format(date_of_service,'%y%m')
            order by date_format(date_of_service,'%y%m'))dt 
        group by dt.ky,kyord
        order by kyord");

        return $tbopbs;
    }

    public function notBilled()
    {
        $tbopbs = DB::select("select date_format(date_of_service,'%b-%y') ky,count(distinct account_nbr_nbr) base,sum(reactivated_ind) reactive,sum(if(date_of_service=first_visit_date,1,0)) new
        from analytic_data 
        where practice_id=$this->practice_id
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and Claim_BillDate is null
        group by date_format(date_of_service,'%b-%y'),date_format(date_of_service,'%y%m')
        order by date_format(date_of_service,'%y%m')");

        return $tbopbs;
    }


    public function activeESRDBalanceBillingTable()
    {
        $a = self::billedAsMcp();
        $b = self::billedAsNonMcp();
        $c = self::notBilled();

        $a10base = isset($a[10]->base) && !empty($a[10]->base) ? $a[10]->base : 0;
        $b10base = isset($b[10]->base) && !empty($b[10]->base) ? $b[10]->base : 0;
        $c10base = isset($c[10]->base) && !empty($c[10]->base) ? $c[10]->base : 0;

        $a11reactive = isset($a[11]->reactive) && !empty($a[11]->reactive) ? $a[11]->reactive : 0;
        $b11reactive = isset($b[11]->reactive) && !empty($b[11]->reactive) ? $b[11]->reactive : 0;
        $c11reactive = isset($c[11]->reactive) && !empty($c[11]->reactive) ? $c[11]->reactive : 0;

        $a11new = isset($a[11]->new) && !empty($a[11]->new) ? $a[11]->new : 0;
        $b11new = isset($b[11]->new) && !empty($b[11]->new) ? $b[11]->new : 0;
        $c11new = isset($c[11]->new) && !empty($c[11]->new) ? $c[11]->new : 0;

        $activeESRDBalanceBillingTable = array(
            array(
                'title' => 'base',
                'Billed_As_Mcp' => $a10base,
                'Billed_As_Non_Mcp' => $b10base,
                'Not_Billed' => $c10base
            ),
            array(
                'title' => 'reactivated',
                'Billed_As_Mcp' => $a11reactive,
                'Billed_As_Non_Mcp' => $b11reactive,
                'Not_Billed' => $c11reactive
            ),
            array(
                'title' => 'New',
                'Billed_As_Mcp' => $a11new,
                'Billed_As_Non_Mcp' => $b11new,
                'Not_Billed' => $c11new
            ),
            array(
                'title' => 'Total',
                'Total_base' => $a10base + $b10base + $c10base,
                'Total_reactivated' => $a11reactive + $b11reactive + $c11reactive,
                'Total_new' => $a11new + $b11new + $c11new,
                'total_over_all ' => $a10base + $a11reactive + $a11new + $b10base + $b11reactive + $b11new + $c10base + $c11reactive + $c11new

            ),
            array(
                'title' => 'over all total',
                'Billed_As_Mcp' => $a10base + $a11reactive + $a11new,
                'Billed_As_Non_Mcp' => $b10base + $b11reactive + $b11new,
                'Not_Billed' => $c10base + $c11reactive + $c11new
            )
        );
        return $activeESRDBalanceBillingTable;
    }

    public function patientRoster()
    {
        // $prlds = DB::table('analytic_data')
        //     ->select(DB::raw("DISTINCT ckd_Stage as Stage_name, account_nbr_nbr as patient_number, patient_name, ZIPCode, IF(cptcode IN (90960, 90961, 90962, 90963, 90964, 90965, 90966), 'Billed As MCP',IF(cptcode IN (90935,90937,90945,90947), 'Billed As Non MCP',IF(Claim_BillDate IS NULL, 'Not billed', ''))) as 'Current_month_Billed_Activity', service_location as 'Office_Location'"))
        //     ->where('practice_id', $this->practice_id)
        //     ->whereBetween('Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
        //     ->whereIn(DB::raw("(account_nbr_nbr,date_of_service)"), function ($query) {
        //         $query->select(DB::raw("account_nbr_nbr, MAX(date_of_service)"))
        //             ->from('analytic_data')
        //             ->where('practice_id', $this->practice_id)
        //             ->whereBetween('Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
        //             ->groupBy('account_nbr_nbr');
        //     })
        //     ->where('ckd_Stage', '!=', 'unspecified')
        //     ->orderBy('Stage_name')
        //     // ->get();
        //     ->paginate(25);
        //     dd($prlds);
        
            $prlds = DB::table(function ($subquery) {
                $subquery->select(DB::raw("DISTINCT ckd_Stage as Stage_name, account_nbr_nbr as patient_number, patient_name, ZIPCode, IF(cptcode IN (90960, 90961, 90962, 90963, 90964, 90965, 90966), 'Billed As MCP', IF(cptcode IN (90935,90937,90945,90947), 'Billed As Non MCP', IF(Claim_BillDate IS NULL, 'Not billed', ''))) as 'Current_month_Billed_Activity', service_location as 'Office_Location'"))
                    ->from('analytic_data')
                    ->where('practice_id', $this->practice_id)
                    ->whereBetween('Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
                    ->whereIn(DB::raw("(account_nbr_nbr,date_of_service)"), function ($query) {
                        $query->select(DB::raw("account_nbr_nbr, MAX(date_of_service)"))
                            ->from('analytic_data')
                            ->where('practice_id', $this->practice_id)
                            ->whereBetween('Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
                            ->groupBy('account_nbr_nbr');
                    })
                    ->where('ckd_Stage', '!=', 'unspecified')
                    ->orderBy('Stage_name');
            })
            ->paginate(25);
    
    // dd($prlds);

        return $prlds;
    }

    //patient dashboard -> Roster -> pt follow up Roster 

    public function patientsByStage()
    {
        $pbs = DB::select("select ckd_Stage,sum(dt.patients_by_stage) vls  from(
            select if(ckd_stage in ('CKD-1','CKD-2','CKD-3'),'Early CKD',ckd_Stage) ckd_stage, 
            if(ckd_stage in ('CKD-1','CKD-2','CKD-3'),'A',ckd_Stage) ckd_stage_order,
            count(distinct account_nbr_nbr) patients_by_stage
                    from analytic_data 
                    where (account_nbr_nbr,date_of_service) in(
                                                                select account_nbr_nbr,max(date_of_service) max_date_of_service
                                                                from analytic_data 
                                                                where practice_id=$this->practice_id
                                                                and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                                                                group by account_nbr_nbr)
                    and practice_id=$this->practice_id
                    and ckd_Stage != 'Unspecified'
                    and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                    group by ckd_Stage)dt
                    group by ckd_Stage
                    order by ckd_stage_order,1,2");

        return $pbs;
    }

    public function mapofPatients()
    {
        $mop = DB::select("select distinct ad.ckd_stage patient_stage, ad.account_nbr_nbr patient,md.zipcode,md.latitude,md.longitude,md.city,md.state,md.country
        from analytic_data ad,map_data md
        where ad.zipcode=md.zipcode
        and practice_id=$this->practice_id
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and ckd_Stage != 'Unspecified'
        order by 1");

        return $mop;
    }

    public function patientRosterLastDaySeen()
    {
        // $prlds = DB::table('analytic_data as ad')
        //     ->select(DB::raw("DISTINCT ckd_Stage as 'Stage_name', patient_name as 'Patient_Name','primary_phone', Address, md.city as 'City', Date_of_Service as 'Last_date_of_service', provider as 'last_seen_provider', service_location as 'Office_Location'"))
        //     ->join('map_data as md', 'ad.zipcode', '=', 'md.zipcode')
        //     ->where('ad.practice_id', $this->practice_id)
        //     ->whereBetween('ad.Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
        //     ->whereIn(DB::raw("(ad.account_nbr_nbr, ad.date_of_service)"), function ($query) {
        //         $query->select(DB::raw("account_nbr_nbr, MAX(date_of_service)"))
        //             ->from('analytic_data')
        //             ->where('practice_id', $this->practice_id)
        //             ->whereBetween('Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
        //             ->groupBy('account_nbr_nbr');
        //     })
        //     ->where('ad.ckd_Stage', '!=', 'unspecified')
        //     ->orderBy('Stage_name')
        //     ->paginate(25);
            // ->get();

            $prlds = DB::table(function ($subquery) {
                $subquery->select(DB::raw("DISTINCT ckd_Stage as 'Stage_name', patient_name as 'Patient_Name','primary_phone', Address, md.city as 'City', Date_of_Service as 'Last_date_of_service', provider as 'last_seen_provider', service_location as 'Office_Location'"))
                    ->from('analytic_data as ad')
                    ->join('map_data as md', 'ad.zipcode', '=', 'md.zipcode')
                    ->where('ad.practice_id', $this->practice_id)
                    ->whereBetween('ad.Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
                    ->whereIn(DB::raw("(ad.account_nbr_nbr, ad.date_of_service)"), function ($query) {
                        $query->select(DB::raw("account_nbr_nbr, MAX(date_of_service)"))
                            ->from('analytic_data')
                            ->where('practice_id', $this->practice_id)
                            ->whereBetween('Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
                            ->groupBy('account_nbr_nbr');
                    })
                    ->where('ad.ckd_Stage', '!=', 'unspecified')
                    ->orderBy('Stage_name');
            })
            ->paginate(25);
        
        return $prlds;
    }

    // Patient Analytics

    public function numberOfPatientsPerMonth()
    {
        $noppm = DB::select("select  date_format(Date_of_Service,'%b-%y') kys,round(COUNT(DISTINCT account_nbr_nbr),0) vls
        FROM analytic_data 
        WHERE practice_id=$this->practice_id  
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by date_format(Date_of_Service,'%b-%y')
        order by date_format(Date_of_Service,'%y%m')");

        return $noppm;
    }

    public function TotalNumberOfPatientsPerProviderPerMonth()
    {
        $tnoppppm = DB::select("select  a.month_year kys,round(a.total_patient/b.sum_provider_fte,0) vls
        from
        (select  date_format(Date_of_Service,'%b-%y') month_year,date_format(Date_of_Service,'%y%m') month_year_order,COUNT(DISTINCT account_nbr_nbr) total_patient
			FROM analytic_data 
			 WHERE practice_id=$this->practice_id  
			 and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
			 group by date_format(Date_of_Service,'%b-%y')
        ) a,
        (select ads.month_year,sum(ads.provider_fte) sum_provider_fte
        from(
             select distinct date_format(adt.date_of_service,'%b-%y') month_year,adt.provider,adt.provider_fte
             from analytic_data adt
             where adt.practice_id=$this->practice_id 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) ads
        group by ads.month_year
        ) b
        where a.month_year=b.month_year
        order by a.month_year_order");

        return $tnoppppm;
    }

    public function NumberOfPatientsByWhoPaidBillsPerMonth()
    {
        $nopbwpbpm = DB::select("select  date_format(primary_paymentDate_CheckDate,'%b-%y') kys,round(COUNT(DISTINCT account_nbr_nbr),0) vls
        FROM analytic_data 
        WHERE practice_id=$this->practice_id  
        and primary_paymentDate_CheckDate between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by date_format(primary_paymentDate_CheckDate,'%b-%y')
        order by date_format(primary_paymentDate_CheckDate,'%y%m')");

        return $nopbwpbpm;
    }

    // patient -> patients analytics -> ckd pt comparision
    // totalNewCKDPatients = officeConsultsCy

    public function totalNewCKDPatientsStagecy()
    {
        $new_ckd_cy = DB::select("select round(COUNT(DISTINCT account_nbr_nbr),0) new_ckd
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and ckd_Stage not in ('Non-CKD','Unspecified') 
        and cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')	
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return round($new_ckd_cy[0]->new_ckd, 2);
    }

    public function totalNewCKDPatientsStageP1y()
    {
        $new_ckd_p1y = DB::select("select round(COUNT(DISTINCT account_nbr_nbr),0) new_ckd
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and ckd_Stage not in ('Non-CKD','Unspecified') 
        and cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')	
        and date_of_service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return round($new_ckd_p1y[0]->new_ckd, 2);
    }

    public function officeConsultsCy()
    {
        $occy = DB::select("select round(COUNT(DISTINCT account_nbr_nbr),0) off_consults
        FROM analytic_data 
        WHERE practice_id=$this->practice_id 
        and cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')	
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return round($occy[0]->off_consults, 2);
    }

    public function officeConsultsP1y()
    {
        $ocp1y = DB::select("select round(COUNT(DISTINCT account_nbr_nbr),0) off_consults
        FROM analytic_data 
        WHERE practice_id=$this->practice_id 
        and cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')	
        and date_of_service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return round($ocp1y[0]->off_consults, 2);
    }


    public function hospitalConsultsCy()
    {
        $hccy = DB::select("select round(COUNT(DISTINCT account_nbr_nbr),0) hosp_consults
        FROM analytic_data 
        WHERE practice_id=$this->practice_id 
        and cptcode in('99221','99222','99223','99251','99252','99253','99254','99255')	
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return round($hccy[0]->hosp_consults, 2);
    }

    public function hospitalConsultsP1y()
    {
        $hcp1y = DB::select("select round(COUNT(DISTINCT account_nbr_nbr),0) hosp_consults
        FROM analytic_data 
        WHERE practice_id=$this->practice_id 
        and cptcode in('99221','99222','99223','99251','99252','99253','99254','99255')	
        and date_of_service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return round($hcp1y[0]->hosp_consults, 2);
    }

    public function nonCKDToCKDCy()
    {
        $nctccy = DB::select("select count(distinct account_nbr_nbr) as Non_CKD_to_CKD
        from analytic_data ad
        WHERE practice_id=$this->practice_id
        and ckd_stage in (select distinct ckdStage from ckd_code)
        and account_nbr_nbr in(select distinct account_nbr_nbr 
                               from analytic_data ad1
                               where ad1.account_nbr_nbr=ad.account_nbr_nbr
                               and ad1.date_of_service<ad.date_of_service                               
                               and ckd_stage='Non-CKD'
                               and practice_id=$this->practice_id
                               and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy')");

        return round($nctccy[0]->Non_CKD_to_CKD, 2);
    }

    public function nonCKDToCKDP1y()
    {
        $nctcp1y = DB::select("select count(distinct account_nbr_nbr) as Non_CKD_to_CKD
        from analytic_data ad
        WHERE practice_id=$this->practice_id
        and ckd_stage in (select distinct ckdStage from ckd_code)
        and account_nbr_nbr in(select distinct account_nbr_nbr 
                               from analytic_data ad1
                               where ad1.account_nbr_nbr=ad.account_nbr_nbr
                               and ad1.date_of_service<ad.date_of_service                               
                               and ckd_stage='Non-CKD'
                               and practice_id=$this->practice_id
                               and date_of_service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y)");

        return round($nctcp1y[0]->Non_CKD_to_CKD, 2);
    }

    public function patientInFlowRatecy()
    {
        $result = DB::select("select round(a.yearly_new/b.pre_year_last_month,2) inflow from(
            (SELECT round(COUNT(DISTINCT account_nbr_nbr),0) yearly_new 
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')
             and ckd_Stage not in ('Non-CKD','Unspecified')	
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             )a,
             (
             select round(COUNT(DISTINCT account_nbr_nbr),0) pre_year_last_month
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
            and Date_of_Service between DATE_SUB(DATE_ADD('$this->analysis_end_date_cy',INTERVAL -DAY('$this->analysis_end_date_cy')+1 DAY), INTERVAL 12 MONTH) and date_sub(last_day('$this->analysis_end_date_cy'),interval 1 year)
            )b
            )");

        return round($result[0]->inflow, 2);
    }

    public function patientInFlowRateP1y()
    {
        $result = DB::select("select round(a.yearly_new/b.pre_year_last_month,2) inflow from(
            (SELECT round(COUNT(DISTINCT account_nbr_nbr),0) yearly_new 
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')
             and ckd_Stage not in ('Non-CKD','Unspecified')	
             and date_of_service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )a,
             (
             select round(COUNT(DISTINCT account_nbr_nbr),0) pre_year_last_month
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
            and Date_of_Service between DATE_SUB(DATE_ADD('$this->analysis_end_date_cy',INTERVAL -DAY('$this->analysis_end_date_cy')+1 DAY), INTERVAL 12 MONTH) and date_sub(last_day('$this->analysis_end_date_cy'),interval 1 year)
            )b
            )");

        return round($result[0]->inflow, 2);
    }

    public function CKDPatientsInflowTable()
    {
        $newckdcy = self::totalNewCKDPatientsStagecy();
        $newckdp1y = self::totalNewCKDPatientsStageP1y();
        $offcy = self::officeConsultsCy();
        $offp1y = self::officeConsultsP1y();
        $hoscy = self::hospitalConsultsCy();
        $hosp1y = self::hospitalConsultsP1y();
        $ckdcy = self::nonCKDToCKDCy();
        $ckdp1y = self::nonCKDToCKDP1y();
        $inflowcy = self::patientInFlowRateCy();
        $inflowp1y = self::patientInFlowRateP1y();

        $result = array(
            array(
                'title' => 'Total New CKD Patients',
                'cy' => $newckdcy,
                'p1y' => $newckdp1y,
                'change' => isset($newckdp1y) && !empty($newckdp1y) ? round((($newckdcy - $newckdp1y) / $newckdp1y) * $this->percentage, 2) : 0
            ),
            array(
                'title' => 'Office Consults',
                'cy' => $offcy,
                'p1y' => $offp1y,
                'change' => isset($offp1y) && !empty($offp1y) ? round((($offcy - $offp1y) / $offp1y) * $this->percentage, 2) : 0
            ),
            array(
                'title' => 'Hospital Consults',
                'cy' => $hoscy,
                'p1y' => $hosp1y,
                'change' => isset($hosp1y) && !empty($hosp1y) ? round((($hoscy - $hosp1y) / $hosp1y) * $this->percentage, 2) : 0
            ),
            array(
                'title' => 'Non-CKD to CKD',
                'cy' => $ckdcy,
                'p1y' => $ckdp1y,
                'change' => isset($ckdp1y) && !empty($ckdp1y) ? round((($ckdcy - $ckdp1y) / $ckdp1y) * $this->percentage, 2) : 0
            ),
            array(
                'title' => 'Patient In-Flow Rate',
                'cy' => $inflowcy,
                'p1y' => $inflowp1y,
                'change' => isset($inflowp1y) && !empty($inflowp1y) ? round((($inflowcy - $inflowp1y) / $inflowp1y) * $this->percentage, 2) : 0
            )
        );

        return $result;
    }

    public function patientInFlowRateGraph()
    {
        $result = DB::select("select * from
        (SELECT date_format(Date_of_Service,'%b-%y') kys_monthly_new ,round(COUNT(DISTINCT account_nbr_nbr),0) monthly_new 
         FROM analytic_data 
         WHERE practice_id=$this->practice_id  
         and cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')
         and ckd_Stage not in ('Non-CKD','Unspecified')
         and Date_of_Service between DATE_SUB(DATE_ADD('$this->analysis_end_date_cy',INTERVAL -DAY('$this->analysis_end_date_cy')+1 DAY), INTERVAL 12 MONTH) and '$this->analysis_end_date_cy'
         group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
         order by date_format(Date_of_Service,'%y%m')
          )a,
         (
         select date_format(Date_of_Service,'%b-%y') kys_monthly_active_ckd,round(COUNT(DISTINCT account_nbr_nbr),0) monthly_active_ckd
         FROM analytic_data 
         WHERE practice_id=$this->practice_id  
         and ckd_Stage not in ('Non-CKD','Unspecified')
        and Date_of_Service between DATE_SUB(DATE_ADD('$this->analysis_end_date_cy',INTERVAL -DAY('$this->analysis_end_date_cy')+1 DAY), INTERVAL 12 MONTH) and '$this->analysis_end_date_cy'
        group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
        order by date_format(Date_of_Service,'%y%m')
        )b
        where a.kys_monthly_new=b.kys_monthly_active_ckd");

        //more calculation on frontent side according to BI fromula

        return $result;

    }

    // Total patient lost ~ inactive Patientscy

    public function inactivePatientsCy()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) inactive_Patients
        from analytic_data 
        where inactive_ind=1 
        and practice_id=$this->practice_id 
        and ckd_Stage not in('Non-CKD','Unspecified')
        and inactive_date between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return round($result[0]->inactive_Patients, 2);
    }

    public function inactivePatientsP1y()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) inactive_Patients
        from analytic_data 
        where inactive_ind=1 
        and practice_id=$this->practice_id 
        and ckd_Stage not in('Non-CKD','Unspecified')
        and inactive_date between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return round($result[0]->inactive_Patients, 2);
    }

    public function activeNoLongerEsrdCy()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) as ESRD_To_Non_ERSD
        from analytic_data ad
        WHERE practice_id=$this->practice_id
        and ckd_stage='ESRD'
        and account_nbr_nbr in(select distinct account_nbr_nbr
                               from analytic_data ad1
                               where ad1.account_nbr_nbr=ad.account_nbr_nbr
                               and ad1.date_of_service>ad.date_of_service
                               and ckd_stage<>'ESRD'
                               and practice_id=$this->practice_id
                               and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy')");

        return round($result[0]->ESRD_To_Non_ERSD, 2);
    }

    public function activeNoLongerEsrdP1y()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) as ESRD_To_Non_ERSD
        from analytic_data ad
        WHERE practice_id=$this->practice_id
        and ckd_stage='ESRD'
        and account_nbr_nbr in(select distinct account_nbr_nbr
                               from analytic_data ad1
                               where ad1.account_nbr_nbr=ad.account_nbr_nbr
                               and ad1.date_of_service>ad.date_of_service
                               and ckd_stage<>'ESRD'
                               and practice_id=$this->practice_id
                               and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y)");

        return round($result[0]->ESRD_To_Non_ERSD, 2);

    }

    public function latePatientBalanceCy()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) late_Patient_Balance
        from analytic_data 
        where practice_id=$this->practice_id 
        and ckd_Stage in('CKD-4','CKD-5')
        and active_late_stage_ind=1
        and date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return round($result[0]->late_Patient_Balance, 2);
    }

    public function latePatientBalanceP1y()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) late_Patient_Balance
        from analytic_data 
        where practice_id=$this->practice_id 
        and ckd_Stage in('CKD-4','CKD-5')
        and active_late_stage_ind=1
        and date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return round($result[0]->late_Patient_Balance, 2);
    }

    public function ouTFlowRateCy()
    {
        $result = DB::select("select round(a.yearly_lost/(b.pre_year_last_month+c.new_pts_current_year),2) outflow from(
            (select count(distinct account_nbr_nbr) yearly_lost
				from analytic_data 
				where inactive_ind=1 
				and practice_id=$this->practice_id
				and ckd_Stage not in('Non-CKD','Unspecified')
				and inactive_date between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             )a,
             (
             select round(COUNT(DISTINCT account_nbr_nbr),0) pre_year_last_month
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and ckd_Stage not in('Non-CKD','Unspecified')
            and Date_of_Service between DATE_SUB(DATE_ADD('$this->analysis_end_date_cy',INTERVAL -DAY('$this->analysis_end_date_cy')+1 DAY), INTERVAL 12 MONTH) and date_sub(last_day('$this->analysis_end_date_cy'),interval 1 year)
            )b,
            (
             select round(COUNT(DISTINCT account_nbr_nbr),0) new_pts_current_year
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and ckd_Stage not in('Non-CKD','Unspecified')
             and date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             and cptcode in(99201,99202,99203,99204,99205,99241,99242,99243,99244,99245)
            )c
            )");

        return round($result[0]->outflow, 2);
    }

    public function ouTFlowRateP1y()
    {
        $result = DB::select("select round(a.yearly_lost/(b.pre_year_last_month+c.new_pts_current_year),2) outflow from(
            (select count(distinct account_nbr_nbr) yearly_lost
				from analytic_data 
				where inactive_ind=1 
				and practice_id=$this->practice_id
				and ckd_Stage not in('Non-CKD','Unspecified')
				and inactive_date between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )a,
             (
             select round(COUNT(DISTINCT account_nbr_nbr),0) pre_year_last_month
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and ckd_Stage not in('Non-CKD','Unspecified')
            and Date_of_Service between DATE_SUB(DATE_ADD($this->analysis_end_date_p1y,INTERVAL -DAY($this->analysis_end_date_p1y)+1 DAY), INTERVAL 12 MONTH) and date_sub(last_day($this->analysis_end_date_p1y),interval 1 year)
            )b,
            (
             select round(COUNT(DISTINCT account_nbr_nbr),0) new_pts_current_year
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and ckd_Stage not in('Non-CKD','Unspecified')
             and date_of_service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             and cptcode in(99201,99202,99203,99204,99205,99241,99242,99243,99244,99245)
            )c
             )");

        return round($result[0]->outflow, 2);
    }

    public function CKDPatientsOutflowTable()
    {
        $inactivecy = self::inactivePatientsCy();
        $inactivep1y = self::inactivePatientsP1y();
        $esrdcy = self::activeNoLongerEsrdCy();
        $esrdp1y = self::activeNoLongerEsrdP1y();
        $balancecy = self::latePatientBalanceCy();
        $balancep1y = self::latePatientBalanceP1y();
        $outflowcy = self::ouTFlowRateCy();
        $outflowp1y = self::ouTFlowRateP1y();

        $result = array(
            array(
                'title' => 'Total patient lost ',
                'cy' => $inactivecy,
                'p1y' => $inactivep1y,
                'change' => isset($inactivep1y) && !empty($inactivep1y) ? round((($inactivecy - $inactivep1y) / $inactivep1y) * $this->percentage, 2) : 0
            ),
            array(
                'title' => 'New inactive Patients ',
                'cy' => $inactivecy,
                'p1y' => $inactivep1y,
                'change' => isset($inactivep1y) && !empty($inactivep1y) ? round((($inactivecy - $inactivep1y) / $inactivep1y) * $this->percentage, 2) : 0
            ),
            array(
                'title' => 'Active No longer ESRD',
                'cy' => $esrdcy,
                'p1y' => $esrdp1y,
                'change' => isset($esrdp1y) && !empty($esrdp1y) ? round((($esrdcy - $esrdp1y) / $esrdp1y) * $this->percentage, 2) : 0
            ),
            array(
                'title' => 'Late patient Balance ',
                'cy' => $balancecy,
                'p1y' => $balancep1y,
                'change' => isset($balancep1y) && !empty($balancep1y) ? round((($balancecy - $balancep1y) / $balancep1y) * $this->percentage, 2) : 0
            ),
            array(
                'title' => 'OuT-Flow Rate',
                'cy' => $outflowcy,
                'p1y' => $outflowp1y,
                'change' => isset($outflowp1y) && !empty($outflowp1y) ? round((($outflowcy - $outflowp1y) / $outflowp1y) * $this->percentage, 2) : 0
            )
        );

        return $result;
    }

    public function patientOutFlowRateGraph()
    {
        $result = DB::select("select a.month_year,a.yearly_lost,b.pre_year_last_month,c.new_pts_current_year
        from(
            (select date_format(inactive_date,'%b-%y') month_year,date_format(inactive_date,'%y%m') month_year_ord,count(distinct account_nbr_nbr) yearly_lost
                from analytic_data
                where inactive_ind=1 
                and practice_id=$this->practice_id
                and ckd_Stage not in('Non-CKD','Unspecified')
                and inactive_date between DATE_SUB(DATE_ADD('$this->analysis_end_date_cy',INTERVAL -DAY('$this->analysis_end_date_cy')+1 DAY), INTERVAL 12 MONTH) and '$this->analysis_end_date_cy'
                group by date_format(inactive_date,'%b-%y'),date_format(inactive_date,'%y%m')
             )a,
             (
              select date_format(Date_of_Service,'%b-%y') month_year,date_format(Date_of_Service,'%y%m') month_year_ord,round(COUNT(DISTINCT account_nbr_nbr),0) pre_year_last_month
              FROM analytic_data 
              WHERE practice_id=$this->practice_id
              and ckd_Stage not in('Non-CKD','Unspecified')
              and Date_of_Service between DATE_SUB(DATE_ADD('$this->analysis_end_date_cy',INTERVAL -DAY('$this->analysis_end_date_cy')+1 DAY), INTERVAL 12 MONTH) and '$this->analysis_end_date_cy'
              group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
            )b,
            (
             select date_format(date_of_service,'%b-%y') month_year,date_format(date_of_service,'%y%m') month_year_ord,round(COUNT(DISTINCT account_nbr_nbr),0) new_pts_current_year
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and ckd_Stage not in('Non-CKD','Unspecified')
             and date_of_service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             and cptcode in(99201,99202,99203,99204,99205,99241,99242,99243,99244,99245)
             group by date_format(date_of_service,'%b-%y'),date_format(date_of_service,'%y%m')
            )c
            )
            where a.month_year=c.month_year
            and a.month_year=b.month_year
            order by a.month_year_ord");

        //more calculation on frontent side according to BI fromula

        // $a=array(); 
        // for ($i=0; $i<12; $i++) {                
        //         array_push($a,[$result[$i+1]->kys_monthly_new,round($result[$i+1]->monthly_new/$result[$i]->monthly_active_ckd,2)]);
        //     }
        return $result;

    }

    // /Revenue


    public function cashPostedMonthGraph()
    {
        $result = DB::select("select date_format(Date_of_Service,'%b-%y') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) vls
        FROM analytic_data 
        WHERE practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
        order by date_format(Date_of_Service,'%y%m')");

        return $result;
    }


    public function cashPostedCy()
    {
        $result = DB::select("select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) cash_posted_cy
        FROM analytic_data 
        WHERE practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return (float) $result[0]->cash_posted_cy;
    }

    public function cashPostedP1y()
    {
        $result = DB::select("select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) cash_posted_p1y
        FROM analytic_data 
        WHERE practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return (float) $result[0]->cash_posted_p1y;

    }

    public function cashPostedTrend()
    {
        $cy = self::cashPostedCy();
        $p1y = self::cashPostedP1y();

        $a = isset($p1y) && !empty($p1y) ? round((($cy - $p1y) / $p1y) * $this->percentage, 2) : 0;

        return $a;
    }


    public function encounterMonthGraph()
    {
        $result = DB::select("select date_format(Date_of_Service,'%b-%y') kys, count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter
        FROM analytic_data 
        WHERE practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
        order by date_format(Date_of_Service,'%y%m')");

        return $result;
    }


    public function encounterCy()
    {
        $result = DB::select("select count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_cy
        FROM analytic_data 
        WHERE practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return $result[0]->total_encounter_cy;
    }

    public function encounterP1y()
    {
        $result = DB::select("select count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_p1y
        FROM analytic_data 
        WHERE practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return $result[0]->total_encounter_p1y;
    }

    public function encountersTrend()
    {
        $cy = self::encounterCy();
        $p1y = self::encounterP1y();

        $a = isset($p1y) && !empty($p1y) ? round((($cy - $p1y) / $p1y) * $this->percentage, 2) : 0;

        return $a;
    }

    public function patientsSeenMonthGraph()
    {
        $result = DB::select("select date_format(Date_of_Service,'%b-%y') kys,count(distinct account_nbr_nbr) total_patient_seen
        FROM analytic_data 
        WHERE practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
        order by date_format(Date_of_Service,'%y%m')");

        return $result;
    }


    public function patientsSeenCy()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) total_patient_seen_cy
        FROM analytic_data 
        WHERE practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return $result[0]->total_patient_seen_cy;
    }

    public function patientsSeenP1y()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) total_patient_seen_p1y
        FROM analytic_data 
        WHERE practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return $result[0]->total_patient_seen_p1y;
    }

    public function patientsSeenTrend()
    {
        $cy = self::patientsSeenCy();
        $p1y = self::patientsSeenP1y();

        $a = isset($p1y) && !empty($p1y) ? round((($cy - $p1y) / $p1y) * $this->percentage, 2) : 0;

        return $a;
    }

    public function newPatientsMonthGraph()
    {
        $result = DB::select("select date_format(Date_of_Service,'%b-%y') kys,count(distinct account_nbr_nbr) new_patient
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and  cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245') 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
        order by date_format(Date_of_Service,'%y%m')");

        return $result;
    }


    public function newPatientsCy()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) new_patient_cy
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and  cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245') 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return $result[0]->new_patient_cy;
    }

    public function newPatientsP1y()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) new_patient_p1y
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and  cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245') 
        and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return $result[0]->new_patient_p1y;
    }

    public function newPatientsTrend()
    {
        $cy = self::newPatientsCy();
        $p1y = self::newPatientsP1y();

        $a = isset($p1y) && !empty($p1y) ? round((($cy - $p1y) / $p1y) * $this->percentage, 2) : 0;

        return $a;
    }

    public function cashPerPatient()
    {
        $result = DB::select("select a.kys,a.cash_per_pts_cy,b.cash_per_pts_p1y from (
            select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/count(distinct account_nbr_nbr),2) cash_per_pts_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             ) a,
             (select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/count(distinct account_nbr_nbr),2) cash_per_pts_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             )b
             where a.kys=b.kys");

        return $result;
    }

    public function cashPerEncounters()
    {
        $result = DB::select("select a.kys,a.cash_per_encounter_cy,b.cash_per_encounter_p1y from (
            select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))),2) cash_per_encounter_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             ) a,
             (select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))),2) cash_per_encounter_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             )b
             where a.kys=b.kys");

        return $result;
    }


    public function totalPayments()
    {
        $result = DB::select("select a.kys,a.total_payment_cy,b.total_payment_p1y from (
	select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_cy
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id 
	 and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     ) a,
     (select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_p1y
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id 
	 and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     )b
     where a.kys=b.kys");

        return $result;
    }


    public function totalEncounters()
    {
        $result = DB::select("select a.kys,a.total_encounter_cy,b.total_encounter_p1y from (
	select date_format(Date_of_Service,'%b') kys,count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_cy
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id 
	 and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     ) a,
     (select date_format(Date_of_Service,'%b') kys,count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_p1y
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id 
	 and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     )b
     where a.kys=b.kys");

        return $result;
    }
    public function totalPatients()
    {
        $result = DB::select("select a.kys,a.total_patient_cy,b.total_patient_p1y from (
	select date_format(Date_of_Service,'%b') kys,count(distinct account_nbr_nbr) total_patient_cy
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id 
	 and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     ) a,
     (select date_format(Date_of_Service,'%b') kys,count(distinct account_nbr_nbr) total_patient_p1y
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id 
	 and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     )b
     where a.kys=b.kys");

        return $result;
    }

    public function totalNewPatients()
    {
        $result = DB::select("select a.kys,a.total_encounter_cy,ifnull(b.total_encounter_p1y,0) total_encounter_p1y  from (
            select date_format(Date_of_Service,'%b') kys,count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
            and  cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')  
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             ) a
        left OUTER JOIN
             (select date_format(Date_of_Service,'%b') kys,count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
            and  cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')  
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             )b
             on a.kys=b.kys;");

        return $result;
    }


    public function encounterPerPatient()
    {
        $result = DB::select("select a.kys,a.encounter_per_patient_cy,b.encounter_per_patient_p1y from (
            select date_format(Date_of_Service,'%b') kys,count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d')))/count(distinct account_nbr_nbr) encounter_per_patient_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             ) a,
             (select date_format(Date_of_Service,'%b') kys,count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d')))/count(distinct account_nbr_nbr) encounter_per_patient_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             )b
             where a.kys=b.kys");

        return $result;
    }

    public function totalPaymentEarlyStage()
    {
        $result = DB::select("select a.total_payment_early_stage_cy,b.total_payment_early_stage_p1y  from (
            select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_early_stage_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage in ('CKD-1','CKD-2','CKD-3')
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_early_stage_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage in ('CKD-1','CKD-2','CKD-3')
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function totalPaymentStage4ckd()
    {
        $result = DB::select("select a.total_payment_ckd4_cy,b.total_payment_ckd4_p1y  from (
            select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_ckd4_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'CKD-4' 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_ckd4_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'CKD-4' 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function totalPaymentStage5ckd()
    {
        $result = DB::select("select a.total_payment_ckd5_cy,b.total_payment_ckd5_p1y  from (
            select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_ckd5_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'CKD-5' 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_ckd5_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'CKD-5' 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function totalPaymentEsrd()
    {
        $result = DB::select("select a.total_payment_esrd_cy,b.total_payment_esrd_p1y  from (
            select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_esrd_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'ESRD' 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_esrd_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'ESRD' 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function totalPaymentNonCkd()
    {
        $result = DB::select("select a.total_payment_non_ckd_cy,b.total_payment_non_ckd_p1y  from (
            select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_non_ckd_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'NON-CKD' 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_non_ckd_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'NON-CKD' 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    //office

    public function cashPostedOfficeMonthGraph()
    {
        $result = DB::select("select date_format(Date_of_Service,'%b-%y') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) vls
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')  
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
        order by date_format(Date_of_Service,'%y%m')");

        return $result;
    }


    public function cashPostedOfficeCy()
    {
        $result = DB::select("select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) cash_posted_cy
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')  
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return (float) $result[0]->cash_posted_cy;
    }

    public function cashPostedOfficeP1y()
    {
        $result = DB::select("select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) cash_posted_p1y
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')  
        and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return (float) $result[0]->cash_posted_p1y;
    }

    public function cashPostedOfficeTrend()
    {
        $cy = self::cashPostedOfficeCy();
        $p1y = self::cashPostedOfficeP1y();

        $a = isset($p1y) && !empty($p1y) ? round((($cy - $p1y) / $p1y) * $this->percentage, 2) : 0;

        return $a;
    }

    public function encounterOfficeMonthGraph()
    {
        $result = DB::select("select date_format(Date_of_Service,'%b-%y') kys, count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245') 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
        order by date_format(Date_of_Service,'%y%m')");

        return $result;
    }


    public function encounterOfficeCy()
    {
        $result = DB::select("select count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_cy
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245') 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return $result[0]->total_encounter_cy;
    }

    public function encounterOfficeP1y()
    {
        $result = DB::select("select count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_p1y
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245') 
        and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return $result[0]->total_encounter_p1y;
    }

    public function encountersOfficeTrend()
    {
        $cy = self::encounterOfficeCy();
        $p1y = self::encounterOfficeP1y();

        $a = isset($p1y) && !empty($p1y) ? round((($cy - $p1y) / $p1y) * $this->percentage, 2) : 0;

        return $a;
    }

    public function patientsSeenOfficeMonthGraph()
    {
        $result = DB::select("select date_format(Date_of_Service,'%b-%y') kys,count(distinct account_nbr_nbr) total_patient_seen
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')  
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
        order by date_format(Date_of_Service,'%y%m')");

        return $result;
    }


    public function patientsSeenOfficeCy()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) total_patient_seen_cy
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')  
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return $result[0]->total_patient_seen_cy;
    }

    public function patientsSeenOfficeP1y()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) total_patient_seen_p1y
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')  
        and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return $result[0]->total_patient_seen_p1y;
    }

    public function patientsSeenOfficeTrend()
    {
        $cy = self::patientsSeenOfficeCy();
        $p1y = self::patientsSeenOfficeP1y();

        $a = isset($p1y) && !empty($p1y) ? round((($cy - $p1y) / $p1y) * $this->percentage, 2) : 0;

        return $a;
    }

    public function newPatientsOfficeMonthGraph()
    {
        $result = DB::select("select date_format(Date_of_Service,'%b-%y') kys,count(distinct account_nbr_nbr) new_patient
        FROM analytic_data 
        where practice_id=$this->practice_id 
		and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and  cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245') 
        and (account_nbr_nbr,date_of_service) in (select account_nbr_nbr,min(date_of_service) 
                                                  from analytic_data
													where practice_id=$this->practice_id 
													and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                                                    and  cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245') 
													group by account_nbr_nbr)
        group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
        order by date_format(Date_of_Service,'%y%m')");

        return $result;
    }


    public function newPatientsOfficeCy()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) new_patient_cy
        FROM analytic_data 
        where practice_id=$this->practice_id 
		and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and  cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245') 
        and (account_nbr_nbr,date_of_service) in (select account_nbr_nbr,min(date_of_service) 
                                                  from analytic_data
													where practice_id=$this->practice_id 
													and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                                                    and  cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245') 
													group by account_nbr_nbr)");

        return $result[0]->new_patient_cy;
    }

    public function newPatientsOfficeP1y()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) new_patient_p1y
        FROM analytic_data 
        where practice_id=$this->practice_id 
		and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
        and  cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245') 
        and (account_nbr_nbr,date_of_service) in (select account_nbr_nbr,min(date_of_service) 
                                                  from analytic_data
													where practice_id=$this->practice_id 
													and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
                                                    and  cptcode in('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245') 
													group by account_nbr_nbr)");

        return $result[0]->new_patient_p1y;
    }

    public function newPatientsOfficeTrend()
    {
        $cy = self::newPatientsOfficeCy();
        $p1y = self::newPatientsOfficeP1y();

        $a = isset($p1y) && !empty($p1y) ? round((($cy - $p1y) / $p1y) * $this->percentage, 2) : 0;

        return $a;
    }

    public function cashPerPatientOffice()
    {
        $result = DB::select("select a.kys,a.cash_per_pts_cy,ifnull(b.cash_per_pts_p1y,0) cash_per_pts_p1y from (
            select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/count(distinct account_nbr_nbr),2) cash_per_pts_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')   
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             ) a
             left join
             (select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/count(distinct account_nbr_nbr),2) cash_per_pts_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')   
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             )b
             on a.kys=b.kys");

        return $result;
    }

    public function totalPaymentsOffice()
    {
        $result = DB::select("select a.kys,a.total_payment_cy,ifnull(b.total_payment_p1y,0) total_payment_p1y from (
	select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_cy
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245') 
	 and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     ) a
     left join
     (select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_p1y
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245') 
	 and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     )b
     on a.kys=b.kys");

        return $result;
    }

    public function cashPerEncountersOffice()
    {
        $result = DB::select("select a.kys,a.cash_per_encounter_cy,ifnull(b.cash_per_encounter_p1y,0) cash_per_encounter_p1y from (
            select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))),2) cash_per_encounter_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')  
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             ) a
             left join
             (select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))),2) cash_per_encounter_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')  
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             )b
             on a.kys=b.kys;");

        return $result;
    }

    public function totalEncountersOffice()
    {
        $result = DB::select("select a.kys,a.total_encounter_cy,ifnull(b.total_encounter_p1y,0) total_encounter_p1y from (
	select date_format(Date_of_Service,'%b') kys,count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_cy
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')  
	 and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     ) a
     left join
     (select date_format(Date_of_Service,'%b') kys,count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_p1y
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')  
	 and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     )b
     on a.kys=b.kys");

        return $result;
    }

    public function totalPatientsOffice()
    {
        $result = DB::select("select a.kys,a.total_patient_cy,ifnull(b.total_patient_p1y,0) total_patient_p1y from (
	select date_format(Date_of_Service,'%b') kys,count(distinct account_nbr_nbr) total_patient_cy
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')   
	 and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     ) a
     left join
     (select date_format(Date_of_Service,'%b') kys,count(distinct account_nbr_nbr) total_patient_p1y
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')   
	 and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     )b
     on a.kys=b.kys");

        return $result;
    }

    public function encounterPerPatientOffice()
    {
        $result = DB::select("select a.kys,a.encounter_per_patient_cy,ifnull(b.encounter_per_patient_p1y,0) encounter_per_patient_p1y from (
            select date_format(Date_of_Service,'%b') kys,round(count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d')))/count(distinct account_nbr_nbr),2) encounter_per_patient_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')   
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             ) a
             left join
             (select date_format(Date_of_Service,'%b') kys,round(count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d')))/count(distinct account_nbr_nbr),2) encounter_per_patient_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')   
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             )b
             on a.kys=b.kys");

        return $result;
    }

    public function newPatientsOffice()
    {
        $result = DB::select("select a.kys,a.new_patient_cy,ifnull(b.new_patient_p1y,0) new_patient_p1y from (
            select date_format(Date_of_Service,'%b') kys,count(distinct account_nbr_nbr) new_patient_cy
            FROM analytic_data 
            where practice_id=$this->practice_id 
            and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
            and cptcode in ('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')
            and (account_nbr_nbr,date_of_service) in (select account_nbr_nbr,min(date_of_service) 
                                                      from analytic_data
                                                        where practice_id=$this->practice_id 
                                                        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                                                        and cptcode in ('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')
                                                        group by account_nbr_nbr)
            group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
            order by date_format(Date_of_Service,'%y%m')
         ) a
         left join
         (select date_format(Date_of_Service,'%b') kys,count(distinct account_nbr_nbr) new_patient_p1y
            FROM analytic_data 
            where practice_id=$this->practice_id 
            and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
            and cptcode in ('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')
            and (account_nbr_nbr,date_of_service) in (select account_nbr_nbr,min(date_of_service) 
                                                      from analytic_data
                                                        where practice_id=$this->practice_id 
                                                        and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
                                                        and cptcode in ('99201','99202','99203','99204','99205','99241','99242','99243','99244','99245')
                                                        group by account_nbr_nbr)
            group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
            order by date_format(Date_of_Service,'%y%m')
         )b
         on a.kys=b.kys");

        return $result;
    }

    public function totalPaymentEarlyStageOffice()
    {
        $result = DB::select("select a.total_payment_early_stage_cy,b.total_payment_early_stage_p1y  from (
            select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_early_stage_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage in ('CKD-1','CKD-2','CKD-3')
             and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')   
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_early_stage_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage in ('CKD-1','CKD-2','CKD-3')
             and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')   
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function totalPaymentStage4ckdOffice()
    {
        $result = DB::select("select a.total_payment_ckd4_cy,b.total_payment_ckd4_p1y  from (
            select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_ckd4_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'CKD-4'
             and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')    
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_ckd4_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'CKD-4'
             and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')    
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function totalPaymentStage5ckdOffice()
    {
        $result = DB::select("select a.total_payment_ckd5_cy,b.total_payment_ckd5_p1y  from (
            select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_ckd5_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'CKD-5'
             and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')    
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_ckd5_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'CKD-5'
             and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')    
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function totalPaymentEsrdOffice()
    {
        $result = DB::select("select a.total_payment_esrd_cy,b.total_payment_esrd_p1y  from (
            select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_esrd_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'ESRD'
             and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')    
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_esrd_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'ESRD'
             and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')    
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function totalPaymentNonCkdOffice()
    {
        $result = DB::select("select a.total_payment_non_ckd_cy,b.total_payment_non_ckd_p1y  from (
            select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_non_ckd_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'NON-CKD'
             and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')    
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_non_ckd_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'NON-CKD'
             and cptcode in ('99201','99202','99203','99204','99205','99211','99212','99213','99214','99215','99241','99242','99243','99244','99245')    
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    // Hospital

    public function cashPostedHospitalMonthGraph()
    {
        $result = DB::select("select date_format(Date_of_Service,'%b-%y') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) vls
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255')    
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by date_format(Date_of_Service,'%b-%y')");

        return $result;
    }


    public function cashPostedHospitalCy()
    {
        $result = DB::select("select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) cash_posted_cy
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255')    
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return (float) $result[0]->cash_posted_cy;
    }

    public function cashPostedHospitalP1y()
    {
        $result = DB::select("select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) cash_posted_p1y
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255') 
        and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return (float) $result[0]->cash_posted_p1y;
    }

    public function cashPostedHospitalTrend()
    {
        $cy = self::cashPostedHospitalCy();
        $p1y = self::cashPostedHospitalP1y();

        $a = isset($p1y) && !empty($p1y) ? round((($cy - $p1y) / $p1y) * $this->percentage, 2) : 0;

        return $a;
    }

    public function encounterHospitalMonthGraph()
    {
        $result = DB::select("select date_format(Date_of_Service,'%b-%y') kys, count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99221','99222','99223','99251','99252','99253','99254','99255')  
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
        order by date_format(Date_of_Service,'%y%m')");

        return $result;
    }


    public function encounterHospitalCy()
    {
        $result = DB::select("select count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_cy
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99221','99222','99223','99251','99252','99253','99254','99255')  
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return $result[0]->total_encounter_cy;
    }

    public function encounterHospitalP1y()
    {
        $result = DB::select("select count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_p1y
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99221','99222','99223','99251','99252','99253','99254','99255')  
        and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return $result[0]->total_encounter_p1y;
    }

    public function encountersHospitalTrend()
    {
        $cy = self::encounterHospitalCy();
        $p1y = self::encounterHospitalP1y();

        $a = isset($p1y) && !empty($p1y) ? round((($cy - $p1y) / $p1y) * $this->percentage, 2) : 0;

        return $a;
    }

    public function patientsSeenHospitalMonthGraph()
    {
        $result = DB::select("select date_format(Date_of_Service,'%b-%y') kys,count(distinct account_nbr_nbr) total_patient_seen
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99251','99252','99253','99254','99255') 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
        order by date_format(Date_of_Service,'%y%m')");

        return $result;
    }


    public function patientsSeenHospitalCy()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) total_patient_seen_cy
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99251','99252','99253','99254','99255') 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return $result[0]->total_patient_seen_cy;
    }

    public function patientsSeenHospitalP1y()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) total_patient_seen_p1y
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99251','99252','99253','99254','99255') 
        and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return $result[0]->total_patient_seen_p1y;
    }

    public function patientsSeenHospitalTrend()
    {
        $cy = self::patientsSeenHospitalCy();
        $p1y = self::patientsSeenHospitalP1y();

        $a = isset($p1y) && !empty($p1y) ? round((($cy - $p1y) / $p1y) * $this->percentage, 2) : 0;

        return $a;
    }

    public function newPatientsHospitalMonthGraph()
    {
        $result = DB::select("select date_format(Date_of_Service,'%b-%y') kys,count(distinct account_nbr_nbr) new_patient
        FROM analytic_data 
        where practice_id=$this->practice_id 
		and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and  cptcode in('99221','99222','99223','99251','99252','99253','99254','99255') 
        and (account_nbr_nbr,date_of_service) in (select account_nbr_nbr,min(date_of_service) 
                                                  from analytic_data
													where practice_id=$this->practice_id 
													and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                                                    and  cptcode in('99221','99222','99223','99251','99252','99253','99254','99255') 
													group by account_nbr_nbr)
        group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
        order by date_format(Date_of_Service,'%y%m')");

        return $result;
    }


    public function newPatientsHospitalCy()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) new_patient_cy
        FROM analytic_data 
        where practice_id=$this->practice_id 
		and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and  cptcode in('99221','99222','99223','99251','99252','99253','99254','99255') 
        and (account_nbr_nbr,date_of_service) in (select account_nbr_nbr,min(date_of_service) 
                                                  from analytic_data
													where practice_id=$this->practice_id 
													and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                                                    and  cptcode in('99221','99222','99223','99251','99252','99253','99254','99255') 
													group by account_nbr_nbr)");

        return $result[0]->new_patient_cy;
    }

    public function newPatientsHospitalP1y()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) new_patient_p1y
        FROM analytic_data 
        where practice_id=$this->practice_id 
		and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
        and  cptcode in('99221','99222','99223','99251','99252','99253','99254','99255') 
        and (account_nbr_nbr,date_of_service) in (select account_nbr_nbr,min(date_of_service) 
                                                  from analytic_data
													where practice_id=$this->practice_id 
													and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
                                                    and  cptcode in('99221','99222','99223','99251','99252','99253','99254','99255') 
													group by account_nbr_nbr)");

        return $result[0]->new_patient_p1y;
    }

    public function newPatientsHospitalTrend()
    {
        $cy = self::newPatientsHospitalCy();
        $p1y = self::newPatientsHospitalP1y();

        $a = isset($p1y) && !empty($p1y) ? round((($cy - $p1y) / $p1y) * $this->percentage, 2) : 0;

        return $a;
    }

    public function totalPaymentEarlyStageHospital()
    {
        $result = DB::select("select a.total_payment_early_stage_cy,b.total_payment_early_stage_p1y  from (
            select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_early_stage_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage in ('CKD-1','CKD-2','CKD-3')
             and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255') 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_early_stage_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage in ('CKD-1','CKD-2','CKD-3')
             and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255') 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function totalPaymentStage4ckdHospital()
    {
        $result = DB::select("select a.total_payment_ckd4_cy,b.total_payment_ckd4_p1y  from (
            select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_ckd4_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'CKD-4'
             and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255')  
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_ckd4_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'CKD-4'
             and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255')  
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function totalPaymentStage5ckdHospital()
    {
        $result = DB::select("select a.total_payment_ckd5_cy,b.total_payment_ckd5_p1y  from (
            select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_ckd5_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'CKD-5'
             and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255')  
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_ckd5_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'CKD-5'
             and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255')  
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function totalPaymentEsrdHospital()
    {
        $result = DB::select("select a.total_payment_esrd_cy,b.total_payment_esrd_p1y  from (
            select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_esrd_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'ESRD'
             and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255')  
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_esrd_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'ESRD'
             and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255')  
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function totalPaymentNonCkdHospital()
    {
        $result = DB::select("select a.total_payment_non_ckd_cy,b.total_payment_non_ckd_p1y  from (
            select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_non_ckd_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'NON-CKD'
             and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255')  
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_non_ckd_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'NON-CKD'
             and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255')   
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function cashPerPatientHospital()
    {
        $result = DB::select("select a.kys,a.cash_per_pts_cy,ifnull(b.cash_per_pts_p1y,0) cash_per_pts_p1y from (
            select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/count(distinct account_nbr_nbr),2) cash_per_pts_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255') 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             ) a
             left join
             (select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/count(distinct account_nbr_nbr),2) cash_per_pts_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255') 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             )b
             on a.kys=b.kys");

        return $result;
    }

    public function totalPaymentsHospital()
    {
        $result = DB::select("select a.kys,a.total_payment_cy,ifnull(b.total_payment_p1y,0) total_payment_p1y from (
	select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_cy
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255') 
	 and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     ) a
     left join
     (select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_p1y
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255') 
	 and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     )b
     on a.kys=b.kys");

        return $result;
    }

    public function cashPerEncountersHospital()
    {
        $result = DB::select("select a.kys,a.cash_per_encounter_cy,ifnull(b.cash_per_encounter_p1y,0) cash_per_encounter_p1y from (
            select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))),2) cash_per_encounter_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255') 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             ) a
             left join
             (select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))),2) cash_per_encounter_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255') 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             )b
             on a.kys=b.kys");

        return $result;
    }

    public function totalEncountersHospital()
    {
        $result = DB::select("select a.kys,a.total_encounter_cy,ifnull(b.total_encounter_p1y,0) total_encounter_p1y from (
	select date_format(Date_of_Service,'%b') kys,count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_cy
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255') 
	 and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     ) a
     left join
     (select date_format(Date_of_Service,'%b') kys,count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_p1y
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255') 
	 and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     )b
     on a.kys=b.kys");

        return $result;
    }

    public function totalPatientsHospital()
    {
        $result = DB::select("select a.kys,a.total_patient_cy,ifnull(b.total_patient_p1y,0) total_patient_p1y from (
	select date_format(Date_of_Service,'%b') kys,count(distinct account_nbr_nbr) total_patient_cy
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255') 
	 and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     ) a
     left join
     (select date_format(Date_of_Service,'%b') kys,count(distinct account_nbr_nbr) total_patient_p1y
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255') 
	 and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     )b
     on a.kys=b.kys");

        return $result;
    }

    public function encounterPerPatientHospital()
    {
        $result = DB::select("select a.kys,a.encounter_per_patient_cy,ifnull(b.encounter_per_patient_p1y,0) encounter_per_patient_p1y from (
            select date_format(Date_of_Service,'%b') kys,round(count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d')))/count(distinct account_nbr_nbr),2) encounter_per_patient_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255') 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             ) a
             left join
             (select date_format(Date_of_Service,'%b') kys,round(count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d')))/count(distinct account_nbr_nbr),2) encounter_per_patient_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('99221','99222','99223','99231','99232','99233','99234','99235','99236','99238','99239','99251','99252','99253','99254','99255') 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             )b
             on a.kys=b.kys");

        return $result;
    }

    public function newPatientHospital()
    {
        $result = DB::select("select a.kys,a.new_patient_cy,ifnull(b.new_patient_p1y,0) new_patient_p1y from (
            select date_format(Date_of_Service,'%b') kys,count(distinct account_nbr_nbr) new_patient_cy
            FROM analytic_data 
            where practice_id=$this->practice_id 
            and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
            and  cptcode in('99221','99222','99223','99251','99252','99253','99254','99255') 
            and (account_nbr_nbr,date_of_service) in (select account_nbr_nbr,min(date_of_service) 
                                                      from analytic_data
                                                        where practice_id=$this->practice_id 
                                                        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                                                        and  cptcode in('99221','99222','99223','99251','99252','99253','99254','99255') 
                                                        group by account_nbr_nbr)
            group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
            order by date_format(Date_of_Service,'%y%m')
         ) a
         left join
         (select date_format(Date_of_Service,'%b') kys,count(distinct account_nbr_nbr) new_patient_p1y
            FROM analytic_data 
            where practice_id=$this->practice_id 
            and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
            and  cptcode in('99221','99222','99223','99251','99252','99253','99254','99255') 
            and (account_nbr_nbr,date_of_service) in (select account_nbr_nbr,min(date_of_service) 
                                                      from analytic_data
                                                        where practice_id=$this->practice_id 
                                                        and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
                                                        and  cptcode in('99221','99222','99223','99251','99252','99253','99254','99255') 
                                                        group by account_nbr_nbr)
            group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
            order by date_format(Date_of_Service,'%y%m')
         )b
         on a.kys=b.kys");

        return $result;
    }

    // Mcp

    public function cashPostedMcpMonthGraph()
    {
        $result = DB::select("select date_format(Date_of_Service,'%b-%y') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) vls
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('90960','90961','90962','90963','90964','90965','90966')  
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
        order by date_format(Date_of_Service,'%y%m')");

        return $result;
    }


    public function cashPostedMcpCy()
    {
        $result = DB::select("select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) cash_posted_cy
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('90960','90961','90962','90963','90964','90965','90966')  
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return (float) $result[0]->cash_posted_cy;
    }

    public function cashPostedMcpP1y()
    {
        $result = DB::select("select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) cash_posted_p1y
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('90960','90961','90962','90963','90964','90965','90966')  
        and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return (float) $result[0]->cash_posted_p1y;
    }

    public function cashPostedMcpTrend()
    {
        $cy = self::cashPostedMcpCy();
        $p1y = self::cashPostedMcpP1y();

        $a = isset($p1y) && !empty($p1y) ? round((($cy - $p1y) / $p1y) * $this->percentage, 2) : 0;

        return $a;
    }


    public function encounterMcpMonthGraph()
    {
        $result = DB::select("select date_format(Date_of_Service,'%b-%y') kys, count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('90960','90961','90962','90963','90964','90965','90966')  
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
        order by date_format(Date_of_Service,'%y%m')");

        return $result;
    }


    public function encounterMcpCy()
    {
        $result = DB::select("select count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_cy
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('90960','90961','90962','90963','90964','90965','90966')  
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return $result[0]->total_encounter_cy;
    }

    public function encounterMcpP1y()
    {
        $result = DB::select("select count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_p1y
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('90960','90961','90962','90963','90964','90965','90966')  
        and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return $result[0]->total_encounter_p1y;
    }

    public function encountersMcpTrend()
    {
        $cy = self::encounterMcpCy();
        $p1y = self::encounterMcpP1y();

        $a = isset($p1y) && !empty($p1y) ? round((($cy - $p1y) / $p1y) * $this->percentage, 2) : 0;

        return $a;
    }

    public function patientsSeenMcpMonthGraph()
    {
        $result = DB::select("select date_format(Date_of_Service,'%b-%y') kys,count(distinct account_nbr_nbr) total_patient_seen
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('90960','90961','90962','90963','90964','90965','90966')  
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
        order by date_format(Date_of_Service,'%y%m')");

        return $result;
    }


    public function patientsSeenMcpCy()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) total_patient_seen_cy
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('90960','90961','90962','90963','90964','90965','90966')  
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'");

        return $result[0]->total_patient_seen_cy;
    }

    public function patientsSeenMcpP1y()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) total_patient_seen_p1y
        FROM analytic_data 
        WHERE practice_id=$this->practice_id
        and cptcode in ('90960','90961','90962','90963','90964','90965','90966')  
        and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y");

        return $result[0]->total_patient_seen_p1y;
    }

    public function patientsSeenMcpTrend()
    {
        $cy = self::patientsSeenMcpCy();
        $p1y = self::patientsSeenMcpP1y();

        $a = isset($p1y) && !empty($p1y) ? round((($cy - $p1y) / $p1y) * $this->percentage, 2) : 0;

        return $a;
    }


    public function newPatientsMcpMonthGraph()
    {
        $result = DB::select("select date_format(Date_of_Service,'%b-%y') kys,count(distinct account_nbr_nbr) new_patient
        FROM analytic_data 
        where practice_id=$this->practice_id 
		and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
        and (account_nbr_nbr,date_of_service) in (select account_nbr_nbr,min(date_of_service) 
                                                  from analytic_data
													where practice_id=$this->practice_id 
													and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                                                    and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
													group by account_nbr_nbr)
        group by date_format(Date_of_Service,'%b-%y'),date_format(Date_of_Service,'%y%m')
        order by date_format(Date_of_Service,'%y%m')");

        return $result;
    }


    public function newPatientsMcpCy()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) new_patient_cy
        FROM analytic_data 
        where practice_id=$this->practice_id 
		and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
        and (account_nbr_nbr,date_of_service) in (select account_nbr_nbr,min(date_of_service) 
                                                  from analytic_data
													where practice_id=$this->practice_id 
													and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                                                    and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
													group by account_nbr_nbr)");

        return $result[0]->new_patient_cy;
    }

    public function newPatientsMcpP1y()
    {
        $result = DB::select("select count(distinct account_nbr_nbr) new_patient_p1y
        FROM analytic_data 
        where practice_id=$this->practice_id 
		and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
        and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
        and (account_nbr_nbr,date_of_service) in (select account_nbr_nbr,min(date_of_service) 
                                                  from analytic_data
													where practice_id=$this->practice_id 
													and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
                                                    and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
													group by account_nbr_nbr)");

        return $result[0]->new_patient_p1y;
    }

    public function newPatientsMcpTrend()
    {
        $cy = self::newPatientsMcpCy();
        $p1y = self::newPatientsMcpP1y();

        $a = isset($p1y) && !empty($p1y) ? round((($cy - $p1y) / $p1y) * $this->percentage, 2) : 0;

        return $a;
    }

    public function totalPaymentEarlyStageMcp()
    {
        $result = DB::select("select a.total_payment_early_stage_cy,b.total_payment_early_stage_p1y  from (
            select ifnull(round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2),0) total_payment_early_stage_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage in ('CKD-1','CKD-2','CKD-3')
             and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_early_stage_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage in ('CKD-1','CKD-2','CKD-3')
             and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function totalPaymentStage4ckdMcp()
    {
        $result = DB::select("select a.total_payment_ckd4_cy,b.total_payment_ckd4_p1y  from (
            select ifnull(round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2),0) total_payment_ckd4_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'CKD-4'
             and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select ifnull(round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2),0) total_payment_ckd4_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'CKD-4'
             and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function totalPaymentStage5ckdMcp()
    {
        $result = DB::select("select a.total_payment_ckd5_cy,b.total_payment_ckd5_p1y  from (
            select ifnull(round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2),0) total_payment_ckd5_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'CKD-5'
             and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select ifnull(round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2),0) total_payment_ckd5_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'CKD-5'
             and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function totalPaymentEsrdMcp()
    {
        $result = DB::select("select a.total_payment_esrd_cy,b.total_payment_esrd_p1y  from (
            select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_esrd_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'ESRD'
             and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_esrd_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'ESRD'
             and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function totalPaymentNonCkdMcp()
    {
        $result = DB::select("select a.total_payment_non_ckd_cy,b.total_payment_non_ckd_p1y  from (
            select ifnull(round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2),0) total_payment_non_ckd_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'NON-CKD'
             and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             ) a,
             (select ifnull(round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2),0) total_payment_non_ckd_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id 
             and ckd_Stage = 'NON-CKD'
             and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             )b");

        return $result;
    }

    public function cashPerPatientMcp()
    {
        $result = DB::select("select a.kys,a.cash_per_pts_cy,ifnull(b.cash_per_pts_p1y,0) cash_per_pts_p1y from (
            select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/count(distinct account_nbr_nbr),2) cash_per_pts_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             ) a
             left join
             (select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/count(distinct account_nbr_nbr),2) cash_per_pts_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             )b
             on a.kys=b.kys");

        return $result;
    }

    public function totalPaymentsMcp()
    {
        $result = DB::select("select a.kys,a.total_payment_cy,ifnull(b.total_payment_p1y,0) total_payment_p1y from (
	select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_cy
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
	 and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     ) a
     left join
     (select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment),2) total_payment_p1y
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
	 and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     )b
     on a.kys=b.kys");

        return $result;
    }

    public function cashPerEncountersMcp()
    {
        $result = DB::select("select a.kys,a.cash_per_encounter_cy,ifnull(b.cash_per_encounter_p1y,0) cash_per_encounter_p1y from (
            select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))),2) cash_per_encounter_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             ) a
             left join
             (select date_format(Date_of_Service,'%b') kys,round(sum(Primary_Insurance_Payment+Secondary_Insurance_Payment+Patient_Payment)/count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))),2) cash_per_encounter_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             )b
             on a.kys=b.kys;");

        return $result;
    }

    public function totalEncountersMcp()
    {
        $result = DB::select("select a.kys,a.total_encounter_cy,ifnull(b.total_encounter_p1y,0) total_encounter_p1y from (
	select date_format(Date_of_Service,'%b') kys,count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_cy
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
	 and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     ) a
     left join
     (select date_format(Date_of_Service,'%b') kys,count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d'))) total_encounter_p1y
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
	 and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     )b
     on a.kys=b.kys");

        return $result;
    }

    public function totalPatientsMcp()
    {
        $result = DB::select("select a.kys,a.total_patient_cy,ifnull(b.total_patient_p1y,0) total_patient_p1y from (
	select date_format(Date_of_Service,'%b') kys,count(distinct account_nbr_nbr) total_patient_cy
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
	 and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     ) a
     left join
     (select date_format(Date_of_Service,'%b') kys,count(distinct account_nbr_nbr) total_patient_p1y
	 FROM analytic_data 
	 WHERE practice_id=$this->practice_id
     and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
	 and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
	 group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
     order by date_format(Date_of_Service,'%y%m')
     )b
     on a.kys=b.kys");

        return $result;
    }

    public function encounterPerPatientMcp()
    {
        $result = DB::select("select a.kys,a.encounter_per_patient_cy,ifnull(b.encounter_per_patient_p1y,0) encounter_per_patient_p1y from (
            select date_format(Date_of_Service,'%b') kys,round(count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d')))/count(distinct account_nbr_nbr),2) encounter_per_patient_cy
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
             and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             ) a
             left join
             (select date_format(Date_of_Service,'%b') kys,round(count(distinct CONCAT(account_nbr_nbr,date_format(Date_of_Service,'%y%m%d')))/count(distinct account_nbr_nbr),2) encounter_per_patient_p1y
             FROM analytic_data 
             WHERE practice_id=$this->practice_id
             and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
             and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
             group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
             order by date_format(Date_of_Service,'%y%m')
             )b
             on a.kys=b.kys");

        return $result;
    }

    public function newPatientMcp()
    {
        $result = DB::select("select a.kys,a.new_patient_cy,ifnull(b.new_patient_p1y,0) new_patient_p1y from (
            select date_format(Date_of_Service,'%b') kys,count(distinct account_nbr_nbr) new_patient_cy
            FROM analytic_data 
            where practice_id=$this->practice_id 
            and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
            and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
            and (account_nbr_nbr,date_of_service) in (select account_nbr_nbr,min(date_of_service) 
                                                      from analytic_data
                                                        where practice_id=$this->practice_id 
                                                        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                                                        and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
                                                        group by account_nbr_nbr)
            group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
            order by date_format(Date_of_Service,'%y%m')
         ) a
         left join
         (select date_format(Date_of_Service,'%b') kys,count(distinct account_nbr_nbr) new_patient_p1y
            FROM analytic_data 
            where practice_id=$this->practice_id 
            and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
            and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
            and (account_nbr_nbr,date_of_service) in (select account_nbr_nbr,min(date_of_service) 
                                                      from analytic_data
                                                        where practice_id=$this->practice_id 
                                                        and Date_of_Service between $this->analysis_start_date_p1y and $this->analysis_end_date_p1y
                                                        and cptcode in ('90960','90961','90962','90963','90964','90965','90966') 
                                                        group by account_nbr_nbr)
            group by date_format(Date_of_Service,'%b'),date_format(Date_of_Service,'%y%m')
            order by date_format(Date_of_Service,'%y%m')
         )b
         on a.kys=b.kys");

        return $result;
    }



    public function listOfPtWithAlbuminUnder2Point0()
    {
        $result = DB::table('analytic_data AS ad')
            ->select(DB::raw('DISTINCT account_nbr_nbr AS account_nbr, Patient_Name, DATE_FORMAT(dateofbirth, "%m/%d/%Y") AS DOB, Service_Location AS Location, provider, Primary_Insurance_Name AS Insurance'))
            ->whereIn('id', function ($query) {
                $query->select('id')
                    ->from('analytic_data')
                    ->whereIn(
                        DB::raw('(account_nbr_nbr, lastlab)'),
                        function ($subquery) {
                                $subquery->select(DB::raw('account_nbr_nbr, MAX(lastlab)'))
                                    ->from('analytic_data')
                                    ->where('practice_id', $this->practice_id)
                                    ->groupBy('account_nbr_nbr');
                            }
                    )
                    ->where('practice_id', $this->practice_id);
            })
            ->where('Albumin', '<', 2.0)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
            ->orderBy('account_nbr_nbr', 'desc')
            ->paginate(25);

        return $result;
    }

    public function ptsWithGfrUnder60()
    {
        $result = DB::table('analytic_data AS ad')
            ->select(DB::raw('DISTINCT account_nbr_nbr AS account_nbr, Patient_Name, DATE_FORMAT(dateofbirth, "%m/%d/%Y") AS DOB, Service_Location AS Location, provider, Primary_Insurance_Name AS Insurance'))
            ->whereIn('id', function ($query) {
                $query->select('id')
                    ->from('analytic_data')
                    ->whereIn(
                        DB::raw('(account_nbr_nbr, lastlab)'),
                        function ($subquery) {
                                $subquery->select(DB::raw('account_nbr_nbr, MAX(lastlab)'))
                                    ->from('analytic_data')
                                    ->where('practice_id', $this->practice_id)
                                    ->groupBy('account_nbr_nbr');
                            }
                    )
                    ->where('practice_id', $this->practice_id);
            })
            ->where('GFR', '<', 60)
            ->whereBetween('Date_of_Service', [$this->analysis_start_date_cy, $this->analysis_end_date_cy])
            ->orderBy('account_nbr_nbr', 'desc')
            ->paginate(25);

        return $result;

    }

    /**
     * @direction 
     * 0 equal to Zero
     * 1 equal to trend up
     * 2 equal to trend down
     */
    public static function svgTrend($direction = 1)
    {
        if ($direction == 0) {
            ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="109" height="124" viewBox="0 0 109 124"><g id="Group_41760" data-name="Group 41760" transform="translate(16618 11684)"><g id="Group_40931" data-name="Group 40931" transform="translate(-16618 -11668.314)"><g id="Group_40754" data-name="Group 40754"><path id="Path_38116" data-name="Path 38116" d="M817.353,386.764c-.045-.19-.224-.158-.351-.2a6.739,6.739,0,0,1-5-6.64Q812,368.7,812,357.462q0-19.111,0-38.221a6.757,6.757,0,0,1,5.165-6.729,7.6,7.6,0,0,1,1.891-.194c2.088,0,4.177,0,6.265,0a6.77,6.77,0,0,1,6.911,5.094c.029.094.007.228.159.247v63.9a6.438,6.438,0,0,1-1.212,2.622,6.309,6.309,0,0,1-4.347,2.577Z" transform="translate(-723.002 -278.003)" fill="#e395c4"/><path id="Path_38117" data-name="Path 38117" d="M567.556,511.679c-.048-.231-.227-.191-.353-.236-3.076-1.111-5-4.2-5-8.112q-.014-12.082,0-24.165,0-16.75,0-33.5c0-4.008,2.093-7.291,5.186-8.206a6.372,6.372,0,0,1,1.838-.23c2.125,0,4.251-.007,6.376,0,4.119.02,7.029,3.557,7.03,8.56q.006,28.7,0,57.4c0,4.265-2.088,7.433-5.482,8.366-.041.011-.072.079-.108.12Z" transform="translate(-500.845 -402.914)" fill="#e395c4"/><path id="Path_38118" data-name="Path 38118" d="M317.744,636.566c-.05-.295-.229-.242-.355-.3-3.064-1.4-5.009-5.4-5.014-10.42q-.016-17.366,0-34.732,0-8.938,0-17.877c0-6.588,2.9-11.106,7.126-11.117q3.106-.008,6.212,0c4.192.014,7.094,4.544,7.095,11.079q0,26.219,0,52.439c0,5.489-2.055,9.516-5.472,10.771-.041.015-.071.1-.107.156Z" transform="translate(-278.282 -527.801)" fill="#e395c4"/><path id="Path_38119" data-name="Path 38119" d="M67.87,761.471c-.071-.434-.267-.353-.411-.445-2.936-1.881-4.891-7.375-4.968-14.069-.031-2.7-.009-5.4-.009-8.105q0-18.3,0-36.6c.008-7.8,2.345-13.837,5.814-15.067a3.579,3.579,0,0,1,1.194-.154c2.143-.014,4.286-.022,6.429,0,4.075.035,6.995,6.442,7,15.365q.008,21.874,0,43.748c0,7.693-2.036,13.3-5.462,15.1-.041.021-.07.145-.105.221Z" transform="translate(-55.657 -652.706)" fill="#e395c4"/><path id="Path_38120" data-name="Path 38120" d="M51.086,6.233,88.6,0l-13.3,35.33c-.244-.05-.318-.253-.437-.4q-3.472-4.173-6.927-8.36c-.277-.338-.44-.316-.762-.081-7.854,5.731-43.289,31.645-47.32,33.77-8.226,5.309-10.4,1.517-11.851-.07-2.47-3.786-.361-7.631,3.82-10.475,4.194-2.89,41.269-29.792,46.534-33.586.569-.41.57-.409.137-.93L51.469,6.719c-.113-.136-.219-.278-.383-.486" transform="matrix(0.809, 0.588, -0.588, 0.809, 36.847, -48.867)" fill="#e395c4"/></g></g></g></svg>
                                            <?php
        } elseif ($direction == 1) {
            ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="109" height="108" viewBox="0 0 109 108"> <g id="Group_40931" data-name="Group 40931" transform="translate(0 -0.315)"> <g id="Group_40754" data-name="Group 40754"> <path id="Path_38116" data-name="Path 38116" d="M817.353,386.764c-.045-.19-.224-.158-.351-.2a6.739,6.739,0,0,1-5-6.64Q812,368.7,812,357.462q0-19.111,0-38.221a6.757,6.757,0,0,1,5.165-6.729,7.6,7.6,0,0,1,1.891-.194c2.088,0,4.177,0,6.265,0a6.77,6.77,0,0,1,6.911,5.094c.029.094.007.228.159.247v63.9a6.438,6.438,0,0,1-1.212,2.622,6.309,6.309,0,0,1-4.347,2.577Z" transform="translate(-723.394 -278.449)" fill="#32679b"/> <path id="Path_38117" data-name="Path 38117" d="M567.556,498.13c-.048-.189-.227-.156-.353-.193a6.729,6.729,0,0,1-5-6.636q-.014-9.883,0-19.767,0-13.7,0-27.4a6.756,6.756,0,0,1,5.186-6.713,7.719,7.719,0,0,1,1.838-.188c2.125,0,4.251-.006,6.376,0a6.75,6.75,0,0,1,7.03,7q.006,23.477,0,46.953a6.7,6.7,0,0,1-5.482,6.843c-.041.009-.072.065-.108.1Z" transform="translate(-500.845 -389.815)" fill="#32679b"/> <path id="Path_38118" data-name="Path 38118" d="M317.744,609.474c-.05-.187-.229-.154-.355-.19a6.732,6.732,0,0,1-5.014-6.628q-.016-11.047,0-22.094,0-5.686,0-11.372a6.765,6.765,0,0,1,7.126-7.072q3.106-.005,6.212,0a6.759,6.759,0,0,1,7.095,7.047q0,16.678,0,33.357a6.708,6.708,0,0,1-5.472,6.852c-.041.01-.071.065-.107.1Z" transform="translate(-278.282 -501.16)" fill="#32679b"/> <path id="Path_38119" data-name="Path 38119" d="M67.87,720.834c-.071-.2-.267-.16-.411-.2a6.744,6.744,0,0,1-4.968-6.39c-.031-1.226-.009-2.454-.009-3.681,0-5.54-.009-11.081,0-16.621A6.738,6.738,0,0,1,68.3,687.1a7.683,7.683,0,0,1,1.194-.07q3.214-.01,6.429,0a6.753,6.753,0,0,1,7,6.979q.008,9.935,0,19.869a6.715,6.715,0,0,1-5.462,6.86c-.041.01-.07.066-.105.1Z" transform="translate(-55.657 -612.52)" fill="#32679b"/> <path id="Path_38120" data-name="Path 38120" d="M51.086,6.233,88.6,0l-13.3,35.33c-.244-.05-.318-.253-.437-.4q-3.472-4.173-6.927-8.36c-.277-.338-.44-.316-.762-.081A190.741,190.741,0,0,1,42.515,41.944,130.233,130.233,0,0,1,18.972,51.5,99.474,99.474,0,0,1,7.956,54.081,6.814,6.814,0,0,1,.124,48.669a6.7,6.7,0,0,1,5.243-7.851A107.873,107.873,0,0,0,19.766,37a131.573,131.573,0,0,0,22.274-10.3A186.472,186.472,0,0,0,58.367,16.131c.569-.41.57-.409.137-.93L51.469,6.719c-.113-.136-.219-.278-.383-.486" transform="translate(0)" fill="#32679b"/> </g> </g></svg>
                                            <?php
        } elseif ($direction == 2) {
            ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="109" height="108" viewBox="0 0 109 108"><g id="Group_41759" data-name="Group 41759" transform="translate(16615 11468)"><g id="Group_40931" data-name="Group 40931" transform="translate(-16615 -11468.314)"><g id="Group_40754" data-name="Group 40754"><path id="Path_38116" data-name="Path 38116" d="M827.043,386.764c.045-.19.224-.158.351-.2a6.739,6.739,0,0,0,5-6.64q.009-11.233,0-22.467,0-19.11,0-38.221a6.757,6.757,0,0,0-5.165-6.729,7.6,7.6,0,0,0-1.891-.194c-2.088,0-4.177,0-6.265,0a6.77,6.77,0,0,0-6.911,5.094c-.029.094-.007.228-.159.247v63.9a6.438,6.438,0,0,0,1.212,2.622,6.309,6.309,0,0,0,4.347,2.577Z" transform="translate(-805.185 -278.449)" fill="#70c2be"/><path id="Path_38117" data-name="Path 38117" d="M577.268,498.129c.048-.189.227-.156.353-.193a6.729,6.729,0,0,0,5-6.636q.014-9.883,0-19.767,0-13.7,0-27.4a6.756,6.756,0,0,0-5.186-6.713,7.719,7.719,0,0,0-1.838-.188c-2.125,0-4.251-.006-6.376,0a6.75,6.75,0,0,0-7.03,7q-.006,23.477,0,46.953a6.7,6.7,0,0,0,5.482,6.843c.041.009.072.065.108.1Z" transform="translate(-528.162 -389.815)" fill="#70c2be"/><path id="Path_38118" data-name="Path 38118" d="M327.431,609.474c.05-.187.229-.154.355-.19a6.732,6.732,0,0,0,5.014-6.628q.016-11.047,0-22.093,0-5.686,0-11.372a6.765,6.765,0,0,0-7.126-7.072q-3.106-.005-6.212,0a6.759,6.759,0,0,0-7.095,7.047q0,16.678,0,33.357a6.708,6.708,0,0,0,5.472,6.852c.041.01.071.065.107.1Z" transform="translate(-251.077 -501.16)" fill="#70c2be"/><path id="Path_38119" data-name="Path 38119" d="M77.528,720.834c.071-.2.267-.16.411-.2a6.744,6.744,0,0,0,4.968-6.39c.031-1.226.009-2.454.009-3.681,0-5.54.009-11.081,0-16.621A6.738,6.738,0,0,0,77.1,687.1a7.683,7.683,0,0,0-1.194-.07q-3.214-.01-6.429,0a6.753,6.753,0,0,0-7,6.979q-.008,9.935,0,19.869a6.714,6.714,0,0,0,5.462,6.86c.041.01.07.066.105.1Z" transform="translate(26.077 -612.52)" fill="#70c2be"/><path id="Path_38120" data-name="Path 38120" d="M51.087,47.947,88.606,54.18l-13.3-35.33c-.244.05-.318.253-.437.4q-3.472,4.173-6.927,8.36c-.277.338-.44.316-.762.081A190.744,190.744,0,0,0,42.515,12.235a130.235,130.235,0,0,0-23.543-9.56A99.475,99.475,0,0,0,7.956.1,6.814,6.814,0,0,0,.124,5.51a6.7,6.7,0,0,0,5.243,7.851,107.874,107.874,0,0,1,14.4,3.815,131.575,131.575,0,0,1,22.275,10.3A186.474,186.474,0,0,1,58.368,38.049c.569.41.57.409.137.93L51.47,47.461c-.113.136-.219.278-.383.486" transform="translate(13)" fill="#70c2be"/></g></g></g></svg>
                                            <?php
        }

    }

    public static function svgTrendValue($arr = "", $key = "")
    {
        $lastIndexVal = round(end($arr)->$key, 2);
        $secLastIndex = count($arr) - 2;
        $secLastIndexVal = round($arr[$secLastIndex]->$key, 2);
        $result = $lastIndexVal - $secLastIndexVal;
        if ($result == 0) {
            $direction = 0;
        } elseif ($result > 0) {
            $direction = 1;
        } elseif ($result < 0) {
            $direction = 2;
        }
        return (object) array(
            'direction' => $direction,
            'value' => $lastIndexVal
        );
    }

    public static function calculatePercentage($arr = "", $key = "")
    {
        $lastIndexVal = round(end($arr)->$key, 2);
        $secLastIndex = count($arr) - 2;
        $secLastIndexVal = round($arr[$secLastIndex]->$key, 2);
        $result = $lastIndexVal - $secLastIndexVal;

        $final_result = ($result*100)/$secLastIndexVal;

        return round($final_result,2);
    }

    public function byAccessType()
    {
        $result = DB::select("select round(pdcath/total*100,2) pdcath_pct,round(cvcath/total*100,2) cvcath_pct,round(none/total*100,2) none_pct
        from
        (select count(account_nbr_nbr) total,
        sum(ifnull((select 1 from analytic_data ad1 where practice_id=$this->practice_id and cptcode in(49400,74190) and ad1.account_nbr_nbr=ado.account_nbr_nbr),0)) PDCATH,
        sum(ifnull((select 1 from analytic_data ad2 where practice_id=$this->practice_id and cptcode in(36556) and ad2.account_nbr_nbr=ado.account_nbr_nbr),0)) CVCATH,
        sum(ifnull((select distinct 1 from analytic_data ad3 where practice_id=$this->practice_id and cptcode not in(49400,74190,36556) and ad3.account_nbr_nbr=ado.account_nbr_nbr),0)) None
        FROM analytic_data ado
        WHERE practice_id=$this->practice_id
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and first_dialysis_ind = 1) vals");

        return $result;
    }

    public function byHomeStatus()
    {
        $result = DB::select("select round(incident_home/total_first_dialysis*100,1) incident_home_pct,
        round(home_status/total_first_dialysis*100,1) home_status_pct,
        round((total_first_dialysis-(home_status+incident_home))/total_first_dialysis*100,1) new_pct
        from
        (select count(distinct account_nbr_nbr) incident_home 
        from analytic_data ad1 
        where practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and cptcode in(90963,90964,90965,90966) 
        and first_dialysis_ind=1)inc_hom,
        (select count(distinct account_nbr_nbr) home_status
        from analytic_data ad1 
        where practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and cptcode in(90963,90964,90965,90966) 
        and account_nbr_nbr not in(select distinct account_nbr_nbr 
                                    from analytic_data ad1 
                                    where practice_id=$this->practice_id 
                                    and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
                                    and cptcode in(90963,90964,90965,90966) 
                                    and first_dialysis_ind=1
                                   )) hm,
        (select count(distinct account_nbr_nbr) total_first_dialysis
        from analytic_data ad1 
        where practice_id=$this->practice_id 
        and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
        and cptcode in(90960, 90961, 90962, 90963, 90964,90965, 90966, 90935, 90937, 90945, 90947, 90970) 
        and first_dialysis_ind=1) tot");

        return $result;
    }


function incidentHomeMonthGraph(){

    $result = DB::select("select date_format(date_of_service,'%b-%y') kys ,count(distinct if(ckd_stage='ESRD',account_nbr_nbr,null)) incident_home 
    from analytic_data ad1 
    where practice_id=$this->practice_id 
    and Date_of_Service between $this->analysis_start_date_cy and '$this->analysis_end_date_cy'
    and cptcode in(90963,90964,90965,90966) 
    and first_dialysis_ind=1
    group by date_format(date_of_service,'%b-%y'),date_format(date_of_service,'%y-%m')
    order by date_format(date_of_service,'%y-%m')");

    return $result;

}

}