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

class ClinicalDashboardController extends Controller
{

    public function index()
    {
        try {
            $user = Auth::user();
            $practice_id = $user->practice_id;

            //no of patients/month
            $patientAnalysis = DB::select("CALL monthly_patient_analysis($practice_id,'','','','')");
            $patientMonth = Arr::pluck($patientAnalysis, 'MONTH');
            $patientCount = Arr::pluck($patientAnalysis, 'patientCount');
            $patientCountMax = (!empty($patientCount)) ? max($patientCount) : 0;
            $addTenPercent = ($patientCountMax) * 0.20;
            $patientMax = normalPrettyPrice2($patientCountMax + $addTenPercent);
            $averagePatient = normalPrettyPrice2(array_sum($patientCount) / (count($patientCount)!=0?count($patientCount):1));
            //patient Analysis
            $newPatientAnalysis = DB::select("CALL monthly_new_patient_analysis($practice_id,'','','','')");
            $newPatientAnalysisLabeles = Arr::pluck($newPatientAnalysis, 'MONTH');
            $newPatientAnalysisTargets = Arr::pluck($newPatientAnalysis, 'targetPts');
            $newPatientAnalysisAchieves = Arr::pluck($newPatientAnalysis, 'achievedPts');

            $maxPatientAnalysisTargets = (!empty($newPatientAnalysisTargets))?max($newPatientAnalysisTargets):0;
            $maxPatientAnalysisAchieves = (!empty($newPatientAnalysisAchieves))?max($newPatientAnalysisAchieves):0;
            $maxPatientTargetAchieve = (!empty($maxPatientAnalysisTargets) && !empty($maxPatientAnalysisAchieves))?max([$maxPatientAnalysisTargets, $maxPatientAnalysisAchieves]):0;
            $addTenPercent = ($maxPatientTargetAchieve) * 0.20;
            $maxPatientAnalysis = normalPrettyPrice2($maxPatientTargetAchieve + $addTenPercent);

            //payer average chart
            $payers = DB::select("CALL monthly_charges_collection_analysis($practice_id,'','','','')");
            $payerLabels = Arr::pluck($payers, 'MONTH');
            $payercharges = Arr::pluck($payers, 'chargeAmount');
            $payerCollections = Arr::pluck($payers, 'collectionAmount');
            $maxPayerCharge = !empty($payercharges)?max($payercharges):0;
            $maxPayerCollection = !empty($payerCollections)?max($payerCollections):0;
            $maxChargeCollection = (!empty($maxPayerCharge)||!empty($maxPayerCollection))?max([$maxPayerCharge, $maxPayerCollection]):0;
            $addTenPercent = ($maxChargeCollection) * 0.20;
            $maxPayer = normalPrettyPrice2($maxChargeCollection + $addTenPercent);
            $max=AnalyticData::where('practice_id',$practice_id)->max('Date_of_Service');

            $currentDate = \Carbon\Carbon::parse($max)->format('m/d/Y');
            $currentMonth = \Carbon\Carbon::parse($max)->firstOfMonth()->format('m/d/Y');
            $averagePayerCharges = normalPrettyPrice2(array_sum($payercharges) / (count($payercharges)!=0?count($payercharges):1));
            $averagePayerCollections = normalPrettyPrice2(array_sum($payerCollections) / (count($payerCollections)!=0?count($payerCollections):1));

            //cpt code analysis
            $cptCode = DB::select('CALL monthly_cpdcode_analysis(?,?,?,?,?,?,?)', [$practice_id, '', '', '', '', $currentMonth, $currentDate]);

            $accountReceivables = DB::select("CALL collectable_openbalance_CKD_wise($practice_id,'','','','')");

            $accountReceivablesOpenBalances = Arr::pluck($accountReceivables, 'openBalance');
            $balanceSum = array_sum($accountReceivablesOpenBalances);
            array_push($accountReceivablesOpenBalances, $balanceSum);
            $accountReceivablesCollectable = Arr::pluck($accountReceivables, 'collectable');
            $collectableSum = array_sum($accountReceivablesCollectable);
            array_push($accountReceivablesCollectable, $collectableSum);
            
            $cptCodeLabeles = Arr::pluck($cptCode, 'cptcode');
            $cptCodeUnits = Arr::pluck($cptCode, 'units');

            $lateStageCKDVisitInterval = DB::select("CALL late_stage_ckd_visit_interval($practice_id,'','','')");
            $lateStageCKDVisitInterval = $lateStageCKDVisitInterval[0]; 
            $lateStageCKDVisitInterval->analysis_year_value = number_format($lateStageCKDVisitInterval->analysis_year_value,2);
            $lateStageCKDVisitInterval->prior_year_value = number_format($lateStageCKDVisitInterval->prior_year_value,2);
            $lateStageCKDVisitInterval->yearly_change = number_format($lateStageCKDVisitInterval->yearly_change,2);
            
            if(strstr($lateStageCKDVisitInterval->yearly_change, '-')){
                $lateStageCKDVisitInterval->direction = 'down';
            }else{
                $lateStageCKDVisitInterval->direction = 'up';
            }

            
            $lateStageCKDWaitTime = DB::select("CALL late_stage_ckd_wait_time($practice_id,'','','')");
            $lateStageCKDWaitTime = $lateStageCKDWaitTime[0]; 
            $lateStageCKDWaitTime->analysis_year_value = number_format($lateStageCKDWaitTime->analysis_year_value,2);
            $lateStageCKDWaitTime->prior_year_value = number_format($lateStageCKDWaitTime->prior_year_value,2);
            $lateStageCKDWaitTime->yearly_change = number_format($lateStageCKDWaitTime->yearly_change,2);
            if(strstr($lateStageCKDWaitTime->yearly_change, '-')){
                $lateStageCKDWaitTime->direction = 'down';
            }else{
                $lateStageCKDWaitTime->direction = 'up';
            }
            
            $hospitalToOfficeFollowUp = DB::select("CALL hospital_to_office_follow_up($practice_id,'','','')");
            $hospitalToOfficeFollowUp = $hospitalToOfficeFollowUp[0]; 
            $hospitalToOfficeFollowUp->analysis_year_value = number_format($hospitalToOfficeFollowUp->analysis_year_value,2);
            $hospitalToOfficeFollowUp->prior_year_value = number_format($hospitalToOfficeFollowUp->prior_year_value,2);
            $hospitalToOfficeFollowUp->yearly_change = number_format($hospitalToOfficeFollowUp->yearly_change,2);
            if(strstr($hospitalToOfficeFollowUp->yearly_change, '-')){
                $hospitalToOfficeFollowUp->direction = 'down';
            }else{
                $hospitalToOfficeFollowUp->direction = 'up';
            }
            
            $ptsWithAlbuminUnder2 = DB::select("CALL pts_with_albumin_under_2($practice_id,'','','')");
            $ptsWithAlbuminUnder2 = $ptsWithAlbuminUnder2[0]; 
            $ptsWithAlbuminUnder2->analysis_year_value = number_format($ptsWithAlbuminUnder2->analysis_year_value,2);
            $ptsWithAlbuminUnder2->prior_year_value = number_format($ptsWithAlbuminUnder2->prior_year_value,2);
            $ptsWithAlbuminUnder2->yearly_change = number_format($ptsWithAlbuminUnder2->yearly_change,2);
            if(strstr($ptsWithAlbuminUnder2->yearly_change, '-')){
                $ptsWithAlbuminUnder2->direction = 'down';
            }else{
                $ptsWithAlbuminUnder2->direction = 'up';
            }
            
            $ptsWithGFRUnder60 = DB::select("CALL pts_with_gfr_under_60($practice_id,'','','')");
            $ptsWithGFRUnder60 = $ptsWithGFRUnder60[0]; 
            $ptsWithGFRUnder60->analysis_year_value = number_format($ptsWithGFRUnder60->analysis_year_value,2);
            $ptsWithGFRUnder60->prior_year_value = number_format($ptsWithGFRUnder60->prior_year_value,2);
            $ptsWithGFRUnder60->yearly_change = number_format($ptsWithGFRUnder60->yearly_change,2);
            if(strstr($ptsWithGFRUnder60->yearly_change, '-')){
                $ptsWithGFRUnder60->direction = 'down';
            }else{
                $ptsWithGFRUnder60->direction = 'up';
            }
            
            $newStartHosp30Prior = DB::select("CALL new_start_hosp_30_prior($practice_id,'','','')");
            $newStartHosp30Prior = $newStartHosp30Prior[0]; 
            $newStartHosp30Prior->analysis_year_value = number_format($newStartHosp30Prior->analysis_year_value,2);
            $newStartHosp30Prior->prior_year_value = number_format($newStartHosp30Prior->prior_year_value,2);
            $newStartHosp30Prior->yearly_change = number_format($newStartHosp30Prior->yearly_change,2);
            if(strstr($newStartHosp30Prior->yearly_change, '-')){
                $newStartHosp30Prior->direction = 'down';
            }else{
                $newStartHosp30Prior->direction = 'up';
            }
            
            $timeReferral = DB::select("CALL timely_referral($practice_id,'','','')");
            $timeReferral = $timeReferral[0]; 
            $timeReferral->analysis_year_value = number_format($timeReferral->analysis_year_value,2);
            $timeReferral->prior_year_value = number_format($timeReferral->prior_year_value,2);
            $timeReferral->yearly_change = number_format($timeReferral->yearly_change,2);
            if(strstr($timeReferral->yearly_change, '-')){
                $timeReferral->direction = 'down';
            }else{
                $timeReferral->direction = 'up';
            }
            
            $ptsConversionLateStageCKD = DB::select("CALL pts_conversion_late_stage_ckd($practice_id,'','','')");
            $ptsConversionLateStageCKD = $ptsConversionLateStageCKD[0]; 
            $ptsConversionLateStageCKD->analysis_year_value = number_format($ptsConversionLateStageCKD->analysis_year_value,2);
            $ptsConversionLateStageCKD->prior_year_value = number_format($ptsConversionLateStageCKD->prior_year_value,2);
            $ptsConversionLateStageCKD->yearly_change = number_format($ptsConversionLateStageCKD->yearly_change,2);
            if(strstr($ptsConversionLateStageCKD->yearly_change, '-')){
                $ptsConversionLateStageCKD->direction = 'down';
            }else{
                $ptsConversionLateStageCKD->direction = 'up';
            }

            
            
            $CKDPatientsComparison = DB::select("CALL clinical_ckd_patients_comparison($practice_id,'','','')");
            $CKDPatientsComparison = $CKDPatientsComparison[0];
            $CKDPatientsComparison->maxCDKPC = 2000;

            $mileFromOffice2 = array();
            $mileFromOffice = DB::select("CALL miles_from_office($practice_id,'','','')");
            $mileFromOffice2['count'] = 10785236;
            $mileFromOffice2['photos'] = $mileFromOffice;
            $mileFromOffice = $mileFromOffice2;
            
            $CKDPatientsBMI = DB::select("CALL clinical_ckd_patients_bmi($practice_id,'','','')");
            $CKDPatientsBMI = $CKDPatientsBMI[0];


            $ajaxRequest = 'load';
            
            return view('backend.clinical-dashboard', compact('averagePayerCollections','averagePayerCharges','currentDate','currentMonth','maxPatientAnalysis', 'patientMax', 'patientCount', 'patientMonth', 'averagePatient', 'payerLabels', 'payercharges', 'payerCollections', 'maxPayer', 'cptCodeUnits', 'cptCodeLabeles', 'newPatientAnalysisLabeles', 'newPatientAnalysisTargets', 'newPatientAnalysisAchieves','accountReceivablesCollectable','accountReceivablesOpenBalances','lateStageCKDVisitInterval','lateStageCKDWaitTime','hospitalToOfficeFollowUp','ptsWithAlbuminUnder2','ptsWithGFRUnder60','newStartHosp30Prior','timeReferral','ptsConversionLateStageCKD','CKDPatientsComparison','mileFromOffice','CKDPatientsBMI','ajaxRequest'));
        } catch (\Exception $e) {
            return back();
        }


    }

    // 
    public function ajaxLoad(Request $request)
    {
        

        $re_provider = $request->input('provider');
        $re_location = $request->input('location');
        $re_insurance = $request->input('payer');
    


        $user = Auth::user();
        $practice_id = $user->practice_id;

      
        
        //no of patients/month
        $patientAnalysis = DB::select("CALL monthly_patient_analysis($practice_id,'','','','')");
        $patientMonth = Arr::pluck($patientAnalysis, 'MONTH');
        $patientCount = Arr::pluck($patientAnalysis, 'patientCount');
        $patientCountMax = (!empty($patientCount)) ? max($patientCount) : 0;
        $addTenPercent = ($patientCountMax) * 0.20;
        $patientMax = normalPrettyPrice2($patientCountMax + $addTenPercent);
        $averagePatient = normalPrettyPrice2(array_sum($patientCount) / (count($patientCount)!=0?count($patientCount):1));
        //patient Analysis
        $newPatientAnalysis = DB::select("CALL monthly_new_patient_analysis($practice_id,'','','','')");
        $newPatientAnalysisLabeles = Arr::pluck($newPatientAnalysis, 'MONTH');
        $newPatientAnalysisTargets = Arr::pluck($newPatientAnalysis, 'targetPts');
        $newPatientAnalysisAchieves = Arr::pluck($newPatientAnalysis, 'achievedPts');

        $maxPatientAnalysisTargets = (!empty($newPatientAnalysisTargets))?max($newPatientAnalysisTargets):0;
        $maxPatientAnalysisAchieves = (!empty($newPatientAnalysisAchieves))?max($newPatientAnalysisAchieves):0;
        $maxPatientTargetAchieve = (!empty($maxPatientAnalysisTargets) && !empty($maxPatientAnalysisAchieves))?max([$maxPatientAnalysisTargets, $maxPatientAnalysisAchieves]):0;
        $addTenPercent = ($maxPatientTargetAchieve) * 0.20;
        $maxPatientAnalysis = normalPrettyPrice2($maxPatientTargetAchieve + $addTenPercent);

        //payer average chart
        $payers = DB::select("CALL monthly_charges_collection_analysis($practice_id,'','','','')");
        $payerLabels = Arr::pluck($payers, 'MONTH');
        $payercharges = Arr::pluck($payers, 'chargeAmount');
        $payerCollections = Arr::pluck($payers, 'collectionAmount');
        $maxPayerCharge = !empty($payercharges)?max($payercharges):0;
        $maxPayerCollection = !empty($payerCollections)?max($payerCollections):0;
        $maxChargeCollection = (!empty($maxPayerCharge)||!empty($maxPayerCollection))?max([$maxPayerCharge, $maxPayerCollection]):0;
        $addTenPercent = ($maxChargeCollection) * 0.20;
        $maxPayer = normalPrettyPrice2($maxChargeCollection + $addTenPercent);
        $max=AnalyticData::where('practice_id',$practice_id)->max('Date_of_Service');

        $currentDate = \Carbon\Carbon::parse($max)->format('m/d/Y');
        $currentMonth = \Carbon\Carbon::parse($max)->firstOfMonth()->format('m/d/Y');
        $averagePayerCharges = normalPrettyPrice2(array_sum($payercharges) / (count($payercharges)!=0?count($payercharges):1));
        $averagePayerCollections = normalPrettyPrice2(array_sum($payerCollections) / (count($payerCollections)!=0?count($payerCollections):1));

        //cpt code analysis
        $cptCode = DB::select('CALL monthly_cpdcode_analysis(?,?,?,?,?,?,?)', [$practice_id, '', '', '', '', $currentMonth, $currentDate]);

        $accountReceivables = DB::select("CALL collectable_openbalance_CKD_wise($practice_id,'','','','')");

        $accountReceivablesOpenBalances = Arr::pluck($accountReceivables, 'openBalance');
        $balanceSum = array_sum($accountReceivablesOpenBalances);
        array_push($accountReceivablesOpenBalances, $balanceSum);
        $accountReceivablesCollectable = Arr::pluck($accountReceivables, 'collectable');
        $collectableSum = array_sum($accountReceivablesCollectable);
        array_push($accountReceivablesCollectable, $collectableSum);
        
        $cptCodeLabeles = Arr::pluck($cptCode, 'cptcode');
        $cptCodeUnits = Arr::pluck($cptCode, 'units');


          
        $lateStageCKDVisitInterval = DB::select('CALL late_stage_ckd_visit_interval(?,?,?,?)', [$practice_id, $re_provider, $re_location, $re_insurance]);
      
        $lateStageCKDVisitInterval = $lateStageCKDVisitInterval[0]; 
        $lateStageCKDVisitInterval->analysis_year_value = number_format($lateStageCKDVisitInterval->analysis_year_value,2);
        $lateStageCKDVisitInterval->prior_year_value = number_format($lateStageCKDVisitInterval->prior_year_value,2);
        $lateStageCKDVisitInterval->yearly_change = number_format($lateStageCKDVisitInterval->yearly_change,2);
        
        if(strstr($lateStageCKDVisitInterval->yearly_change, '-')){
            $lateStageCKDVisitInterval->direction = 'down';
        }else{
            $lateStageCKDVisitInterval->direction = 'up';
        }

        
        $lateStageCKDWaitTime = DB::select('CALL late_stage_ckd_wait_time(?,?,?,?)', [$practice_id, $re_provider, $re_location, $re_insurance]);
        $lateStageCKDWaitTime = $lateStageCKDWaitTime[0]; 
        $lateStageCKDWaitTime->analysis_year_value = number_format($lateStageCKDWaitTime->analysis_year_value,2);
        $lateStageCKDWaitTime->prior_year_value = number_format($lateStageCKDWaitTime->prior_year_value,2);
        $lateStageCKDWaitTime->yearly_change = number_format($lateStageCKDWaitTime->yearly_change,2);
        if(strstr($lateStageCKDWaitTime->yearly_change, '-')){
            $lateStageCKDWaitTime->direction = 'down';
        }else{
            $lateStageCKDWaitTime->direction = 'up';
        }
        
        $hospitalToOfficeFollowUp = DB::select('CALL hospital_to_office_follow_up(?,?,?,?)', [$practice_id, $re_provider, $re_location, $re_insurance]);
        $hospitalToOfficeFollowUp = $hospitalToOfficeFollowUp[0]; 
        $hospitalToOfficeFollowUp->analysis_year_value = number_format($hospitalToOfficeFollowUp->analysis_year_value,2);
        $hospitalToOfficeFollowUp->prior_year_value = number_format($hospitalToOfficeFollowUp->prior_year_value,2);
        $hospitalToOfficeFollowUp->yearly_change = number_format($hospitalToOfficeFollowUp->yearly_change,2);
        if(strstr($hospitalToOfficeFollowUp->yearly_change, '-')){
            $hospitalToOfficeFollowUp->direction = 'down';
        }else{
            $hospitalToOfficeFollowUp->direction = 'up';
        }
        
        $ptsWithAlbuminUnder2 = DB::select('CALL pts_with_albumin_under_2(?,?,?,?)', [$practice_id, $re_provider, $re_location, $re_insurance]);
        $ptsWithAlbuminUnder2 = $ptsWithAlbuminUnder2[0]; 
        $ptsWithAlbuminUnder2->analysis_year_value = number_format($ptsWithAlbuminUnder2->analysis_year_value,2);
        $ptsWithAlbuminUnder2->prior_year_value = number_format($ptsWithAlbuminUnder2->prior_year_value,2);
        $ptsWithAlbuminUnder2->yearly_change = number_format($ptsWithAlbuminUnder2->yearly_change,2);
        if(strstr($ptsWithAlbuminUnder2->yearly_change, '-')){
            $ptsWithAlbuminUnder2->direction = 'down';
        }else{
            $ptsWithAlbuminUnder2->direction = 'up';
        }
        
        $ptsWithGFRUnder60 = DB::select('CALL pts_with_gfr_under_60(?,?,?,?)', [$practice_id, $re_provider, $re_location, $re_insurance]);
        $ptsWithGFRUnder60 = $ptsWithGFRUnder60[0]; 
        $ptsWithGFRUnder60->analysis_year_value = number_format($ptsWithGFRUnder60->analysis_year_value,2);
        $ptsWithGFRUnder60->prior_year_value = number_format($ptsWithGFRUnder60->prior_year_value,2);
        $ptsWithGFRUnder60->yearly_change = number_format($ptsWithGFRUnder60->yearly_change,2);
        if(strstr($ptsWithGFRUnder60->yearly_change, '-')){
            $ptsWithGFRUnder60->direction = 'down';
        }else{
            $ptsWithGFRUnder60->direction = 'up';
        }
        
        $newStartHosp30Prior = DB::select('CALL new_start_hosp_30_prior(?,?,?,?)', [$practice_id, $re_provider, $re_location, $re_insurance]);
        $newStartHosp30Prior = $newStartHosp30Prior[0]; 
        $newStartHosp30Prior->analysis_year_value = number_format($newStartHosp30Prior->analysis_year_value,2);
        $newStartHosp30Prior->prior_year_value = number_format($newStartHosp30Prior->prior_year_value,2);
        $newStartHosp30Prior->yearly_change = number_format($newStartHosp30Prior->yearly_change,2);
        if(strstr($newStartHosp30Prior->yearly_change, '-')){
            $newStartHosp30Prior->direction = 'down';
        }else{
            $newStartHosp30Prior->direction = 'up';
        }
        
        $timeReferral = DB::select('CALL timely_referral(?,?,?,?)', [$practice_id, $re_provider, $re_location, $re_insurance]);
        $timeReferral = $timeReferral[0]; 
        $timeReferral->analysis_year_value = number_format($timeReferral->analysis_year_value,2);
        $timeReferral->prior_year_value = number_format($timeReferral->prior_year_value,2);
        $timeReferral->yearly_change = number_format($timeReferral->yearly_change,2);
        if(strstr($timeReferral->yearly_change, '-')){
            $timeReferral->direction = 'down';
        }else{
            $timeReferral->direction = 'up';
        }
        
        $ptsConversionLateStageCKD = DB::select('CALL pts_conversion_late_stage_ckd(?,?,?,?)', [$practice_id, $re_provider, $re_location, $re_insurance]);
        $ptsConversionLateStageCKD = $ptsConversionLateStageCKD[0]; 
        $ptsConversionLateStageCKD->analysis_year_value = number_format($ptsConversionLateStageCKD->analysis_year_value,2);
        $ptsConversionLateStageCKD->prior_year_value = number_format($ptsConversionLateStageCKD->prior_year_value,2);
        $ptsConversionLateStageCKD->yearly_change = number_format($ptsConversionLateStageCKD->yearly_change,2);
        if(strstr($ptsConversionLateStageCKD->yearly_change, '-')){
            $ptsConversionLateStageCKD->direction = 'down';
        }else{
            $ptsConversionLateStageCKD->direction = 'up';
        }

        
        
        $CKDPatientsComparison = DB::select('CALL clinical_ckd_patients_comparison(?,?,?,?)', [$practice_id, $re_provider, $re_location, $re_insurance]);
        $CKDPatientsComparison = $CKDPatientsComparison[0];
        $CKDPatientsComparison->maxCDKPC = 2000;

        $mileFromOffice2 = array();
        $mileFromOffice = DB::select('CALL miles_from_office(?,?,?,?)', [$practice_id, $re_provider, $re_location, $re_insurance]);
        $mileFromOffice2['count'] = 10785236;
        $mileFromOffice2['photos'] = $mileFromOffice;
        $mileFromOffice = $mileFromOffice2;
        
        $CKDPatientsBMI = DB::select('CALL clinical_ckd_patients_bmi(?,?,?,?)', [$practice_id, $re_provider, $re_location, $re_insurance]);
        $CKDPatientsBMI = $CKDPatientsBMI[0];
        
        $ajaxRequest = 'notload';

        $dat_form = '';
        $dat_to = '';
        $cptCode = '';
     
        $activePatientStats = DB::select('CALL active_patients_count(?,?,?,?,?)', [$practice_id, $re_location, $re_provider, $re_insurance,$cptCode]);
        $newPatientStats =  DB::select('CALL new_patients_count(?,?,?,?,?)', [$practice_id, $re_location, $re_provider, $re_insurance,$cptCode]);
        $earlyStats = DB::select('CALL early_stage_ckd_patient_count(?,?,?,?,?,?)', [$practice_id, $re_location, $re_provider, $re_insurance,$dat_form,$dat_to]);
        $lateStats =  DB::select('CALL late_stage_ckd_patient_count(?,?,?,?,?,?)', [$practice_id, $re_location, $re_provider, $re_insurance,$dat_form,$dat_to]);
     

        $returnHTML_1 =  view('backend.partials.clinical-stats-ajax', compact('lateStats','earlyStats','activePatientStats','newPatientStats'))->render();
    
        
        $returnHTML_2 =  view('backend.clinical-dashboard-ajax', compact('averagePayerCollections','averagePayerCharges','currentDate','currentMonth','maxPatientAnalysis', 'patientMax', 'patientCount', 'patientMonth', 'averagePatient', 'payerLabels', 'payercharges', 'payerCollections', 'maxPayer', 'cptCodeUnits', 'cptCodeLabeles', 'newPatientAnalysisLabeles', 'newPatientAnalysisTargets', 'newPatientAnalysisAchieves','accountReceivablesCollectable','accountReceivablesOpenBalances','lateStageCKDVisitInterval','lateStageCKDWaitTime','hospitalToOfficeFollowUp','ptsWithAlbuminUnder2','ptsWithGFRUnder60','newStartHosp30Prior','timeReferral','ptsConversionLateStageCKD','CKDPatientsComparison','mileFromOffice','CKDPatientsBMI','ajaxRequest'))->render();
        
        $early_stage_cnt_prior_year = (string)$CKDPatientsComparison->early_stage_cnt_prior_year;
        $late_stage_cnt_prior_year = (string)$CKDPatientsComparison->late_stage_cnt_prior_year;
        $esrd_cnt_prior_year = (string)$CKDPatientsComparison->esrd_cnt_prior_year;

        $early_stage_cnt_analysis_year = (string)$CKDPatientsComparison->early_stage_cnt_analysis_year;
        $late_stage_cnt_analysis_year = (string)$CKDPatientsComparison->late_stage_cnt_analysis_year;
        $esrd_cnt_analysis_year = (string)$CKDPatientsComparison->esrd_cnt_analysis_year;

        $canvas1 = array(
            array(
                "label" => "This Year",
                "backgroundColor" => "#4472c5",
                "data" => array($early_stage_cnt_prior_year,$late_stage_cnt_prior_year,$esrd_cnt_prior_year)
            ),
            array(
                "label" => "Prior Year",
                "backgroundColor" => "#ed7e30",
                "data" => array($early_stage_cnt_analysis_year,$late_stage_cnt_analysis_year,$esrd_cnt_analysis_year)
            )
        );

        $canvas1c = array(
            array(
                "label" => "",
                "backgroundColor" => "#04b4f0",
                "hoverBackgroundColor" =>  "#04b4f0",
                "data" => array((string)$CKDPatientsBMI->below_186,
                                (string)$CKDPatientsBMI->rng_186_249,
                                (string)$CKDPatientsBMI->rng_250_299,
                                (string)$CKDPatientsBMI->equal_above_300
                        )
            )
        );

        echo json_encode(
            array(
                'html_1' => $returnHTML_1,
                'html_2' => $returnHTML_2,
                'canvas_html' => $canvas1,
                'canvas1c_html' => $canvas1c,
                'mileFromOffice_html' => $mileFromOffice
            )
        );

        die;


    }

    public function intervalDetail(){
        try {
            $user = Auth::user();
            $practice_id = $user->practice_id;

            /*
            * @practice_id
            * @re_location
            * @re_provider
            * @re_insurance
            */
            $intervalStageBoxOne = DB::select("CALL ckd_visit_interval_by_stage($practice_id,'','','')");
            $intervalStageBoxtwo = DB::select("CALL ckd_visit_interval_by_month($practice_id,'','','')");
            $intervalStagePatientMonth = Arr::pluck($intervalStageBoxtwo, 'month_year');
            $intervalStagePatientCount = Arr::pluck($intervalStageBoxtwo, 'visit_interval');            
            // $$intervalStagePatientCountMax = (!empty($intervalStagePatientCount)) ? max($intervalStagePatientCount) : 0;
            // $intervalStagePatientaddTenPercent = ($intervalStagePatientCountMax) * 0.20;
            // $intervalStagePatientMax = normalPrettyPrice2($intervalStagePatientCountMax + $intervalStagePatientaddTenPercent);
            
            $intervalStagePatientMax = 2;
            
            $intervalStageBoxthree = DB::select("CALL ckd_visit_interval_target_achieved($practice_id,'','','')");
            $intervalStageBoxthreeLabeles = Arr::pluck($intervalStageBoxthree, 'month_year');
            $intervalStageBoxthreeTargets = Arr::pluck($intervalStageBoxthree, 'target');
            $intervalStageBoxthreeAchieves = Arr::pluck($intervalStageBoxthree, 'achieved');
            $maxintervalStageBoxthreeTargets = 6000;

     
            
            //no of patients/month
            $patientAnalysis = DB::select("CALL monthly_patient_analysis($practice_id,'','','','')");
            $patientMonth = Arr::pluck($patientAnalysis, 'MONTH');
            $patientCount = Arr::pluck($patientAnalysis, 'patientCount');
            $patientCountMax = (!empty($patientCount)) ? max($patientCount) : 0;
            $addTenPercent = ($patientCountMax) * 0.20;
            $patientMax = normalPrettyPrice2($patientCountMax + $addTenPercent);
            $averagePatient = normalPrettyPrice2(array_sum($patientCount) / (count($patientCount)!=0?count($patientCount):1));
            //patient Analysis
            $newPatientAnalysis = DB::select("CALL monthly_new_patient_analysis($practice_id,'','','','')");
            $newPatientAnalysisLabeles = Arr::pluck($newPatientAnalysis, 'MONTH');
            $newPatientAnalysisTargets = Arr::pluck($newPatientAnalysis, 'targetPts');
            $newPatientAnalysisAchieves = Arr::pluck($newPatientAnalysis, 'achievedPts');

            $maxPatientAnalysisTargets = (!empty($newPatientAnalysisTargets))?max($newPatientAnalysisTargets):0;
            $maxPatientAnalysisAchieves = (!empty($newPatientAnalysisAchieves))?max($newPatientAnalysisAchieves):0;
            $maxPatientTargetAchieve = (!empty($maxPatientAnalysisTargets) && !empty($maxPatientAnalysisAchieves))?max([$maxPatientAnalysisTargets, $maxPatientAnalysisAchieves]):0;
            $addTenPercent = ($maxPatientTargetAchieve) * 0.20;
            $maxPatientAnalysis = normalPrettyPrice2($maxPatientTargetAchieve + $addTenPercent);

            //payer average chart
            $payers = DB::select("CALL monthly_charges_collection_analysis($practice_id,'','','','')");
            $payerLabels = Arr::pluck($payers, 'MONTH');
            $payercharges = Arr::pluck($payers, 'chargeAmount');
            $payerCollections = Arr::pluck($payers, 'collectionAmount');
            $maxPayerCharge = !empty($payercharges)?max($payercharges):0;
            $maxPayerCollection = !empty($payerCollections)?max($payerCollections):0;
            $maxChargeCollection = (!empty($maxPayerCharge)||!empty($maxPayerCollection))?max([$maxPayerCharge, $maxPayerCollection]):0;
            $addTenPercent = ($maxChargeCollection) * 0.20;
            $maxPayer = normalPrettyPrice2($maxChargeCollection + $addTenPercent);
            $max=AnalyticData::where('practice_id',$practice_id)->max('Date_of_Service');

            $currentDate = \Carbon\Carbon::parse($max)->format('m/d/Y');
            $currentMonth = \Carbon\Carbon::parse($max)->firstOfMonth()->format('m/d/Y');
            $averagePayerCharges = normalPrettyPrice2(array_sum($payercharges) / (count($payercharges)!=0?count($payercharges):1));
            $averagePayerCollections = normalPrettyPrice2(array_sum($payerCollections) / (count($payerCollections)!=0?count($payerCollections):1));

            //cpt code analysis
            $cptCode = DB::select('CALL monthly_cpdcode_analysis(?,?,?,?,?,?,?)', [$practice_id, '', '', '', '', $currentMonth, $currentDate]);

            $cptCodeLabeles = Arr::pluck($cptCode, 'cptcode');
            $cptCodeUnits = Arr::pluck($cptCode, 'units');


            return view('backend.clinical.interval-detail', compact('maxintervalStageBoxthreeTargets','intervalStageBoxthreeTargets','intervalStageBoxthreeAchieves','newPatientAnalysisAchieves','newPatientAnalysisTargets','intervalStageBoxthreeLabeles','averagePayerCollections','averagePayerCharges','currentDate','currentMonth','maxPatientAnalysis', 'patientMax', 'patientCount', 'patientMonth', 'averagePatient', 'payerLabels', 'payercharges', 'payerCollections', 'maxPayer', 'cptCodeUnits', 'cptCodeLabeles', 'newPatientAnalysisLabeles', 'newPatientAnalysisTargets', 'newPatientAnalysisAchieves','intervalStageBoxOne','intervalStageBoxtwo','intervalStageBoxthree','patientAnalysis','intervalStagePatientMonth','intervalStagePatientCount','intervalStagePatientMax','newPatientAnalysis'));
        } catch (\Exception $e) {
            return back();
        }
    }
    public function intervalFilter(Request $request) 
    {
        try {
  
            $re_provider = $request->input('provider');
            $re_location = $request->input('location');
            $re_insurance = $request->input('payer');
        
    
    
            $user = Auth::user();
            $practice_id = $user->practice_id;
          
            /*
            * @practice_id
            * @re_location
            * @re_provider
            * @re_insurance
            */
           // $cptCode = DB::select('CALL monthly_cpdcode_analysis(?,?,?,?,?,?,?)', [$practice_id, '', '', '', '', $currentMonth, $currentDate]);

            $intervalStageBoxOne = DB::select('CALL ckd_visit_interval_by_stage(?,?,?,?)', [$practice_id,$re_provider,$re_location  ,$re_insurance]);
          
            
            $returnHTML_1 =  view('backend.clinical.interval-ajax', compact('intervalStageBoxOne'))->render();
    
             
            $intervalStageBoxtwo = DB::select('CALL ckd_visit_interval_by_month(?,?,?,?)', [$practice_id,$re_provider,$re_location  ,$re_insurance]);
            $intervalStagePatientMonth = Arr::pluck($intervalStageBoxtwo, 'month_year');
            $intervalStagePatientCount = Arr::pluck($intervalStageBoxtwo, 'visit_interval');            
            // $$intervalStagePatientCountMax = (!empty($intervalStagePatientCount)) ? max($intervalStagePatientCount) : 0;
            // $intervalStagePatientaddTenPercent = ($intervalStagePatientCountMax) * 0.20;
            // $intervalStagePatientMax = normalPrettyPrice2($intervalStagePatientCountMax + $intervalStagePatientaddTenPercent);
            
            $intervalStagePatientMax = 2;
            
            $intervalStageBoxthree = DB::select('CALL ckd_visit_interval_target_achieved(?,?,?,?)', [$practice_id,$re_provider,$re_location  ,$re_insurance]);
            $intervalStageBoxthreeLabeles = Arr::pluck($intervalStageBoxthree, 'month_year');
            $intervalStageBoxthreeTargets = Arr::pluck($intervalStageBoxthree, 'target');
            $intervalStageBoxthreeAchieves = Arr::pluck($intervalStageBoxthree, 'achieved');
            $maxintervalStageBoxthreeTargets = 6000;

     
            
            //no of patients/month
            $patientAnalysis = DB::select("CALL monthly_patient_analysis($practice_id,'','','','')");
            $patientMonth = Arr::pluck($patientAnalysis, 'MONTH');
            $patientCount = Arr::pluck($patientAnalysis, 'patientCount');
            $patientCountMax = (!empty($patientCount)) ? max($patientCount) : 0;
            $addTenPercent = ($patientCountMax) * 0.20;
            $patientMax = normalPrettyPrice2($patientCountMax + $addTenPercent);
            $averagePatient = normalPrettyPrice2(array_sum($patientCount) / (count($patientCount)!=0?count($patientCount):1));
            //patient Analysis
            $newPatientAnalysis = DB::select("CALL monthly_new_patient_analysis($practice_id,'','','','')");
            $newPatientAnalysisLabeles = Arr::pluck($newPatientAnalysis, 'MONTH');
            $newPatientAnalysisTargets = Arr::pluck($newPatientAnalysis, 'targetPts');
            $newPatientAnalysisAchieves = Arr::pluck($newPatientAnalysis, 'achievedPts');

            $maxPatientAnalysisTargets = (!empty($newPatientAnalysisTargets))?max($newPatientAnalysisTargets):0;
            $maxPatientAnalysisAchieves = (!empty($newPatientAnalysisAchieves))?max($newPatientAnalysisAchieves):0;
            $maxPatientTargetAchieve = (!empty($maxPatientAnalysisTargets) && !empty($maxPatientAnalysisAchieves))?max([$maxPatientAnalysisTargets, $maxPatientAnalysisAchieves]):0;
            $addTenPercent = ($maxPatientTargetAchieve) * 0.20;
            $maxPatientAnalysis = normalPrettyPrice2($maxPatientTargetAchieve + $addTenPercent);

            //payer average chart
            $payers = DB::select("CALL monthly_charges_collection_analysis($practice_id,'','','','')");
            $payerLabels = Arr::pluck($payers, 'MONTH');
            $payercharges = Arr::pluck($payers, 'chargeAmount');
            $payerCollections = Arr::pluck($payers, 'collectionAmount');
            $maxPayerCharge = !empty($payercharges)?max($payercharges):0;
            $maxPayerCollection = !empty($payerCollections)?max($payerCollections):0;
            $maxChargeCollection = (!empty($maxPayerCharge)||!empty($maxPayerCollection))?max([$maxPayerCharge, $maxPayerCollection]):0;
            $addTenPercent = ($maxChargeCollection) * 0.20;
            $maxPayer = normalPrettyPrice2($maxChargeCollection + $addTenPercent);
            $max=AnalyticData::where('practice_id',$practice_id)->max('Date_of_Service');

            $currentDate = \Carbon\Carbon::parse($max)->format('m/d/Y');
            $currentMonth = \Carbon\Carbon::parse($max)->firstOfMonth()->format('m/d/Y');
            $averagePayerCharges = normalPrettyPrice2(array_sum($payercharges) / (count($payercharges)!=0?count($payercharges):1));
            $averagePayerCollections = normalPrettyPrice2(array_sum($payerCollections) / (count($payerCollections)!=0?count($payerCollections):1));

            //cpt code analysis
            $cptCode = DB::select('CALL monthly_cpdcode_analysis(?,?,?,?,?,?,?)', [$practice_id, '', '', '', '', $currentMonth, $currentDate]);

            $cptCodeLabeles = Arr::pluck($cptCode, 'cptcode');
            $cptCodeUnits = Arr::pluck($cptCode, 'units');

            $returnHTML_2 = '';
            $canvas1 = '';
        $canvas1 = array(
            array(
                "label" => "Visit Interval by month",
                "backgroundColor" => "#00A4DB",
                "data" => array((string)$intervalStagePatientCount[0],
                                (string)$intervalStagePatientCount[1],
                                (string)$intervalStagePatientCount[2],
                                (string)$intervalStagePatientCount[3],
                                (string)$intervalStagePatientCount[4],
                                (string)$intervalStagePatientCount[5],
                                (string)$intervalStagePatientCount[6],
                                (string)$intervalStagePatientCount[7],
                                (string)$intervalStagePatientCount[8],
                                (string)$intervalStagePatientCount[9],
                                (string)$intervalStagePatientCount[10],
                                (string)$intervalStagePatientCount[11]
                        )
            )
        );
        $canvas1c = '';
            echo json_encode(
                array(
                    'html_1' => $returnHTML_1,
                    'html_2' => $returnHTML_2,
                    'canvas_html' => $canvas1,
                    'canvas1c_html' => $canvas1c
                )
            );

          //return view('backend.clinical.interval-detail', compact('maxintervalStageBoxthreeTargets','intervalStageBoxthreeTargets','intervalStageBoxthreeAchieves','newPatientAnalysisAchieves','newPatientAnalysisTargets','intervalStageBoxthreeLabeles','averagePayerCollections','averagePayerCharges','currentDate','currentMonth','maxPatientAnalysis', 'patientMax', 'patientCount', 'patientMonth', 'averagePatient', 'payerLabels', 'payercharges', 'payerCollections', 'maxPayer', 'cptCodeUnits', 'cptCodeLabeles', 'newPatientAnalysisLabeles', 'newPatientAnalysisTargets', 'newPatientAnalysisAchieves','intervalStageBoxOne','intervalStageBoxtwo','intervalStageBoxthree','patientAnalysis','intervalStagePatientMonth','intervalStagePatientCount','intervalStagePatientMax','newPatientAnalysis'));
        } catch (\Exception $e) {
            return back();
        }
    }
    public function search(Request $request)
    {
        try {
            $provider = $request->get('provider');
            $location = $request->get('location');
            $payer = $request->get('payer');
            $user = Auth::user();
            $practice_id = $user->practice_id;
            $newPatientAnalysis = DB::select('CALL monthly_new_patient_analysis(?,?,?,?,?)', [$practice_id, '', '', '', '']);
            $newPatientAnalysisLabeles = Arr::pluck($newPatientAnalysis, 'MONTH');
            $newPatientAnalysisTargets = Arr::pluck($newPatientAnalysis, 'targetPts');
            $newPatientAnalysisAchieves = Arr::pluck($newPatientAnalysis, 'achievedPts');
//            $accountReceivablesStats = DB::select("CALL primary_secondary_patient_openbalance($practice_id,'','','','','')");
//            $accountReceivablesStats = DB::select("CALL primary_secondary_patient_openbalance(?,?,?,?,?),[$practice_id,$location,$provider,'','']");
            $accountReceivablesStats = DB::select('CALL primary_secondary_patient_openbalance(?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '']);


            $collectionAndTargetCurrentMonth = DB::select('CALL collectionAndTargetCurrentMonthYear(?,?,?,?,?,?)', [$practice_id, 1, $location, $provider, $payer, '']);
            $collectionAndTargetCurrentYear = DB::select('CALL collectionAndTargetCurrentMonthYear(?,?,?,?,?,?)', [$practice_id, 0, $location, $provider, $payer, '']);

            $projectedActualCollection = DB::select('CALL charge_payment_analysis(?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '']);
            $projectedMonthLables = Arr::pluck($projectedActualCollection, 'MONTH');

            $actualCollections = Arr::pluck($projectedActualCollection, 'Actual_Collection');
            $projectedCollections = Arr::pluck($projectedActualCollection, 'Projected_Collection');

            $projectedCollectables = Arr::pluck($projectedActualCollection, 'Projected_Collection');
            $patientVolume = DB::select('CALL revenue_forcast_on_patient_volume(?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '']);
            $revenues = DB::select('CALL collection_ckd_wise(?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '']);
            $accountReceivables = DB::select('CALL collectable_openbalance_CKD_wise(?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '']);
            $accountReceivablesOpenBalances = Arr::pluck($accountReceivables, 'openBalance');
            $balanceSum = array_sum($accountReceivablesOpenBalances);
            array_push($accountReceivablesOpenBalances, $balanceSum);
            $accountReceivablesCollectable = Arr::pluck($accountReceivables, 'collectable');
            $collectableSum = array_sum($accountReceivablesCollectable);

            $actualCollectionMix = (!empty($actualCollections)) ? normalPrettyPrice2(min(($actualCollections))) : 0;
            $actualMax = (!empty($actualCollections)) ? normalPrettyPrice2(max(($actualCollections))) : 0;
            $proectedMax = (!empty($projectedCollections)) ? normalPrettyPrice2(max(($projectedCollections))) : 0;
            $maxcollection = max([$proectedMax, $actualMax]);
            $addTenPercent = ($maxcollection) * 0.20 ;
            $actualCollectionMax = normalPrettyPrice2($maxcollection + $addTenPercent);

            array_push($accountReceivablesCollectable, $collectableSum);
            $view = (string)view('backend.partials.practiceDashboardGraphBody', compact('newPatientAnalysisLabeles', 'newPatientAnalysisTargets', 'newPatientAnalysisAchieves', 'actualCollectionMix', 'actualCollectionMax', 'accountReceivablesStats', 'accountReceivables', 'collectionAndTargetCurrentMonth'
                , 'collectionAndTargetCurrentYear', 'projectedCollections', 'actualCollections', 'patientVolume', 'projectedCollectables'
                , 'revenues', 'projectedMonthLables', 'accountReceivablesOpenBalances', 'accountReceivablesCollectable'
            ));

            $activePatientStats = DB::select('CALL active_patients_count(?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '']);
            $newPatientStats = DB::select('CALL new_patients_count(?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '']);
            $esrdStats = DB::select('CALL ESRD_patients_count(?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '']);
            $nonEsrdStats = DB::select('CALL nonESRD_patient_count(?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '']);
            $stat = (string)view('backend.partials.statsRow', compact('activePatientStats', 'newPatientStats', 'esrdStats', 'nonEsrdStats'
            ));
            return response()->json(['status' => true, 'view' => $view, 'stat' => $stat]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function projectedCollection($location = null, $provider = null, $payer = null, $monthYear = null)
    {
        try {
            $monthYear = $_GET['monthYear'];
            $location = $_GET['location'];
            $provider = $_GET['provider'];
            $payer = $_GET['payer'];
            $user = Auth::user();
            $practice_id = $user->practice_id;
            $openCases = DB::select('CALL open_cases(?,?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '', $monthYear]);
            return view('backend.openCases.index', compact('openCases'));
        } catch (\Exception $e) {
            dd($e);
            return back();
        }
    }

    public function underPaidCases($location = null, $provider = null, $payer = null, $monthYear = null)
    {
        try {
            $monthYear = $_GET['monthYear'];
            $location = $_GET['location'];
            $provider = $_GET['provider'];
            $payer = $_GET['payer'];
            $user = Auth::user();
            $practice_id = $user->practice_id;
            $openCases = DB::select('CALL underpaid_cases(?,?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '', $monthYear]);
            return view('backend.underPaidCase.index', compact('openCases'));
        } catch (\Exception $e) {
            dd($e);
            return back();
        }
    }

    public function monthlyPatientAnalysis($location = null, $provider = null, $payer = null, $monthYear = null)
    {
        try {
            $monthYear = $_GET['monthYear'];
            $location = $_GET['location'];
            $provider = $_GET['provider'];
            $payer = $_GET['payer'];
            $user = Auth::user();
            $practice_id = $user->practice_id;
            $monthlyPatientAnalysis = DB::select('CALL monthly_droped_patient(?,?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '', $monthYear]);
            return view('backend.monthlyPatientAnalysis.index', compact('monthlyPatientAnalysis'));
        } catch (\Exception $e) {
            return back();
        }
    }

    public function patientAnalysis()
    {
        try {
            $user = Auth::user();
            $practice_id = $user->practice_id;

            //no of patients/month
            $patientAnalysis = DB::select("CALL monthly_patient_analysis($practice_id,'','','','')");
            $patientMonth = Arr::pluck($patientAnalysis, 'MONTH');
            $patientCount = Arr::pluck($patientAnalysis, 'patientCount');
            $patientCountMax = (!empty($patientCount)) ? max($patientCount) : 0;
            $addTenPercent = ($patientCountMax) * 0.20;
            $patientMax = normalPrettyPrice2($patientCountMax + $addTenPercent);
            $averagePatient = normalPrettyPrice2(array_sum($patientCount) / (count($patientCount)!=0?count($patientCount):1));
            //patient Analysis
            $newPatientAnalysis = DB::select("CALL monthly_new_patient_analysis($practice_id,'','','','')");
            $newPatientAnalysisLabeles = Arr::pluck($newPatientAnalysis, 'MONTH');
            $newPatientAnalysisTargets = Arr::pluck($newPatientAnalysis, 'targetPts');
            $newPatientAnalysisAchieves = Arr::pluck($newPatientAnalysis, 'achievedPts');

            $maxPatientAnalysisTargets = (!empty($newPatientAnalysisTargets))?max($newPatientAnalysisTargets):0;
            $maxPatientAnalysisAchieves = (!empty($newPatientAnalysisAchieves))?max($newPatientAnalysisAchieves):0;
            $maxPatientTargetAchieve = (!empty($maxPatientAnalysisTargets) && !empty($maxPatientAnalysisAchieves))?max([$maxPatientAnalysisTargets, $maxPatientAnalysisAchieves]):0;
            $addTenPercent = ($maxPatientTargetAchieve) * 0.20;
            $maxPatientAnalysis = normalPrettyPrice2($maxPatientTargetAchieve + $addTenPercent);

            //payer average chart
            $payers = DB::select("CALL monthly_charges_collection_analysis($practice_id,'','','','')");
            $payerLabels = Arr::pluck($payers, 'MONTH');
            $payercharges = Arr::pluck($payers, 'chargeAmount');
            $payerCollections = Arr::pluck($payers, 'collectionAmount');
            $maxPayerCharge = !empty($payercharges)?max($payercharges):0;
            $maxPayerCollection = !empty($payerCollections)?max($payerCollections):0;
            $maxChargeCollection = (!empty($maxPayerCharge)||!empty($maxPayerCollection))?max([$maxPayerCharge, $maxPayerCollection]):0;
            $addTenPercent = ($maxChargeCollection) * 0.20;
            $maxPayer = normalPrettyPrice2($maxChargeCollection + $addTenPercent);
            $max=AnalyticData::where('practice_id',$practice_id)->max('Date_of_Service');

            $currentDate = \Carbon\Carbon::parse($max)->format('m/d/Y');
            $currentMonth = \Carbon\Carbon::parse($max)->firstOfMonth()->format('m/d/Y');
            $averagePayerCharges = normalPrettyPrice2(array_sum($payercharges) / (count($payercharges)!=0?count($payercharges):1));
            $averagePayerCollections = normalPrettyPrice2(array_sum($payerCollections) / (count($payerCollections)!=0?count($payerCollections):1));

            //cpt code analysis
            $cptCode = DB::select('CALL monthly_cpdcode_analysis(?,?,?,?,?,?,?)', [$practice_id, '', '', '', '', $currentMonth, $currentDate]);

            $cptCodeLabeles = Arr::pluck($cptCode, 'cptcode');
            $cptCodeUnits = Arr::pluck($cptCode, 'units');
            return view('backend.patientAnalysis.index', compact('averagePayerCollections','averagePayerCharges','currentDate','currentMonth','maxPatientAnalysis', 'patientMax', 'patientCount', 'patientMonth', 'averagePatient', 'payerLabels', 'payercharges', 'payerCollections', 'maxPayer', 'cptCodeUnits', 'cptCodeLabeles', 'newPatientAnalysisLabeles', 'newPatientAnalysisTargets', 'newPatientAnalysisAchieves'));
        } catch (\Exception $e) {
            return back();
        }
    }

    public function patientAnalysisSearch(Request $request)
    {
        try {

            $practice_id = Auth::user()->practice_id;
            $provider = $request->get('provider');
            $location = $request->get('location');
            $payer = $request->get('payer');
            $currentMonth = $request->get('dateStartfilter');
            $currentDate = $request->get('dateEndfilter');
            //no of patients/month
            $patientAnalysis = DB::select('CALL monthly_patient_analysis(?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '']);
            $patientMonth = Arr::pluck($patientAnalysis, 'MONTH');
            $patientCount = Arr::pluck($patientAnalysis, 'patientCount');
            $patientCountMax = (!empty($patientCount)) ? max($patientCount) : 0;
            $addTenPercent = ($patientCountMax) * 0.20;
            $patientMax = normalPrettyPrice2($patientCountMax + $addTenPercent);
            $averagePatient = normalPrettyPrice2(array_sum($patientCount) / (count($patientCount)!=0?count($patientCount):1));
            //patient Analysis
            $newPatientAnalysis = DB::select('CALL monthly_new_patient_analysis(?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '']);
            $newPatientAnalysisLabeles = Arr::pluck($newPatientAnalysis, 'MONTH');
            $newPatientAnalysisTargets = Arr::pluck($newPatientAnalysis, 'targetPts');
            $newPatientAnalysisAchieves = Arr::pluck($newPatientAnalysis, 'achievedPts');

            $maxPatientAnalysisTargets = (!empty($newPatientAnalysisTargets))?max($newPatientAnalysisTargets):0;
            $maxPatientAnalysisAchieves = (!empty($newPatientAnalysisAchieves))?max($newPatientAnalysisAchieves):0;
            $maxPatientTargetAchieve = (!empty($maxPatientAnalysisTargets) && !empty($maxPatientAnalysisAchieves))?max([$maxPatientAnalysisTargets, $maxPatientAnalysisAchieves]):0;
            $addTenPercent = ($maxPatientTargetAchieve) * 0.20;
            $maxPatientAnalysis = normalPrettyPrice2($maxPatientTargetAchieve + $addTenPercent);
            //cpt code analysis
            $cptCode = DB::select('CALL monthly_cpdcode_analysis(?,?,?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '', $currentMonth, $currentDate]);
            $cptCodeLabeles = Arr::pluck($cptCode, 'cptcode');
            $cptCodeUnits = Arr::pluck($cptCode, 'units');
            //payer average chart
            $payers = DB::select('CALL monthly_charges_collection_analysis(?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '']);
            $payerLabels = Arr::pluck($payers, 'MONTH');
            $payercharges = Arr::pluck($payers, 'chargeAmount');
            $payerCollections = Arr::pluck($payers, 'collectionAmount');
            $maxPayerCharge = (!empty($payercharges))?max($payercharges):0;
            $maxPayerCollection = (!empty($payerCollections))?max($payerCollections):0;
            $maxChargeCollection =  (!empty($maxPayerCharge) && !empty($maxPayerCollection))?max([$maxPayerCharge, $maxPayerCollection]):0;
            $addTenPercent = ($maxChargeCollection) * 0.20;
            $maxPayer = normalPrettyPrice2($maxChargeCollection + $addTenPercent);

            $averagePayerCharges = normalPrettyPrice2(array_sum($payercharges) / (count($payercharges)!=0?count($payercharges):1));
            $averagePayerCollections = normalPrettyPrice2(array_sum($payerCollections) / (count($payerCollections)!=0?count($payerCollections):1));
            
            $view = (string)view('backend.patientAnalysis.partials.graphBody', compact('averagePayerCollections','averagePayerCharges','currentMonth','currentDate','maxPatientAnalysis', 'patientMax', 'patientCount', 'patientMonth', 'averagePatient', 'payerLabels', 'payercharges', 'payerCollections', 'maxPayer', 'cptCodeUnits', 'cptCodeLabeles', 'newPatientAnalysisLabeles', 'newPatientAnalysisTargets', 'newPatientAnalysisAchieves'));

            $activePatientStats = DB::select('CALL active_patients_count(?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '']);
            $newPatientStats = DB::select('CALL new_patients_count(?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '']);
            $esrdStats = DB::select('CALL ESRD_patients_count(?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '']);
            $nonEsrdStats = DB::select('CALL nonESRD_patient_count(?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '']);
            $stat = (string)view('backend.partials.statsRow', compact('activePatientStats', 'newPatientStats', 'esrdStats', 'nonEsrdStats'
            ));
            return response()->json(['status' => true, 'view' => $view, 'stat' => $stat]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function patientAnalysisToFromDate(Request $request)
    {
        try {
            $practice_id = Auth::user()->practice_id;
            $provider = $request->get('provider');
            $location = $request->get('location');
            $payer = $request->get('payer');
            $currentMonth = $request->get('dateStartfilter');
            $currentDate = $request->get('dateEndfilter');
            //cpt code analysis

            //cpt code analysis
            $cptCode = DB::select('CALL monthly_cpdcode_analysis(?,?,?,?,?,?,?)', [$practice_id, $location, $provider, $payer, '', $currentMonth, $currentDate]);
            $cptCodeLabeles = Arr::pluck($cptCode, 'cptcode');
            $cptCodeUnits = Arr::pluck($cptCode, 'units');
            $view = (string)view('backend.patientAnalysis.partials.cptGraphRow', compact('cptCodeLabeles', 'cptCodeUnits'));
            return response()->json(['status' => true, 'view' => $view]);
        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
