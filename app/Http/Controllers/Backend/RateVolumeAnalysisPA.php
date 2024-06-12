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

class
RateVolumeAnalysisPA extends Controller
{

    public function home()
    {
            
        return view('backend.home');
    }
    public function index()
    {
        $user = Auth::user();
        $practice_id = $user->practice_id;
        $newPatientAnalysis = DB::select("CALL monthly_new_patient_analysis($practice_id,'','','','')");
        $newPatientAnalysisLabeles = Arr::pluck($newPatientAnalysis, 'MONTH');
        $newPatientAnalysisTargets = Arr::pluck($newPatientAnalysis, 'targetPts');
        $newPatientAnalysisAchieves = Arr::pluck($newPatientAnalysis, 'achievedPts');

        $accountReceivablesStats = DB::select("CALL primary_secondary_patient_openbalance($practice_id,'','','','')");
        $collectionAndTargetCurrentMonth = DB::select("CALL collectionAndTargetCurrentMonthYear($practice_id,1,'','','','')");
        $collectionAndTargetCurrentYear = DB::select("CALL collectionAndTargetCurrentMonthYear($practice_id,0,'','','','')");

        $projectedActualCollection = DB::select("CALL charge_payment_analysis($practice_id,'','','','')");

        $projectedActualCollections = DB::select("CALL charge_payment_analysis($practice_id,'','','','')");
        $projectedMonthLables = Arr::pluck($projectedActualCollection, 'MONTH');
        $actualCollections = Arr::pluck($projectedActualCollection, 'Actual_Collection');        
        $projectedCollections = Arr::pluck($projectedActualCollection, 'Projected_Collection');
        $actualCollectionMix = (!empty($actualCollections)) ? normalPrettyPrice2(min(($actualCollections))) : 0;
        $actualMax = (!empty($actualCollections)) ? normalPrettyPrice2(max(($actualCollections))) : 0;
        $proectedMax = (!empty($projectedCollections)) ? normalPrettyPrice2(max($projectedCollections)) : 0;
        $maxcollection = (!empty($actualMax) && !empty($proectedMax)) ?max([$proectedMax, $actualMax]):0;
        $addTenPercent = ($maxcollection) * 0.20;

        $actualCollectionMax = normalPrettyPrice2($maxcollection + $addTenPercent);
        $projectedCollections = Arr::pluck($projectedActualCollection, 'Projected_Collection');
        $projectedCollectables = Arr::pluck($projectedActualCollection, 'Projected_Collection');

        $patientVolume = DB::select("CALL revenue_forcast_on_patient_volume($practice_id,'','','','')");

        $revenues = DB::select("CALL collection_ckd_wise($practice_id,'','','','')");

        //        $sumRevenue= $revenue[0]->ckdcollection+$revenue[0]->nonckdcollection+$revenue[0]->esrdcollection;
//        $ckdRevenue=  truncate_number(($revenue[0]->ckdcollection/($sumRevenue > 0 ? $sumRevenue : 1)*100));
//        $nonCkdRevenue= truncate_number(($revenue[0]->nonckdcollection/($sumRevenue > 0 ? $sumRevenue : 1)*100));
//        $esrdRevenue= truncate_number(($revenue[0]->esrdcollection/($sumRevenue > 0 ? $sumRevenue : 1)*100));
//        $revenues=   array($ckdRevenue,$nonCkdRevenue,$esrdRevenue);

        $accountReceivables = DB::select("CALL collectable_openbalance_CKD_wise($practice_id,'','','','')");

        $accountReceivablesOpenBalances = Arr::pluck($accountReceivables, 'openBalance');
        $balanceSum = array_sum($accountReceivablesOpenBalances);
        array_push($accountReceivablesOpenBalances, $balanceSum);
        $accountReceivablesCollectable = Arr::pluck($accountReceivables, 'collectable');
        $collectableSum = array_sum($accountReceivablesCollectable);
        array_push($accountReceivablesCollectable, $collectableSum);

        if ($user->roles()->first()->name == 'Practice User') {
            $person = $user->person;
            $providers = $person->doctors;
            $locations = $person->locations;
        } else {
            $practice = Practice::find($practice_id);
            $providers = $practice->getDotorsdata;
            $locations = $practice->getLocationdata;
        }
        
        
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

        return view('backend.rate-volume-analysis-pa', compact('newPatientAnalysisLabeles', 'newPatientAnalysisTargets', 'newPatientAnalysisAchieves', 'actualCollectionMix', 'actualCollectionMax', 'accountReceivablesStats', 'accountReceivables', 'collectionAndTargetCurrentMonth'
            , 'collectionAndTargetCurrentYear', 'projectedCollections', 'actualCollections', 'patientVolume', 'projectedCollectables'
            , 'revenues','cptCodeLabeles', 'cptCodeUnits','projectedMonthLables', 'accountReceivablesOpenBalances', 'accountReceivablesCollectable', 
            'projectedActualCollections', 'providers', 'locations',
            'payerLabels', 'payercharges', 'payerCollections', 'maxPayer',
            'averagePayerCharges', 'averagePayerCollections'
        ));


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

    public function yearToDate()
    {

        return view('backend.practices.sherry');


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
