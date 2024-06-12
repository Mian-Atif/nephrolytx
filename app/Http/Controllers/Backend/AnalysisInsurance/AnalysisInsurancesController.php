<?php

namespace App\Http\Controllers\Backend\AnalysisInsurance;

use App\Http\Controllers\Controller;
use App\Http\Responses\ViewResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalysisInsurancesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Backend\AnalysisInsurance
     * @return \App\Http\Responses\ViewResponse
     */
    public function index()
    {
        try {
            $title='AR Analysis By Financial Class';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = Carbon::now()->startOfMonth()->format('m/d/Y');
            $currentDate = Carbon::now()->format('m/d/Y');
            $analysisInsurances = DB::select("CALL fr_AR_analysis_insurance($practice_id,$currentMonth,$currentDate)");
            $chargeTotal = collect($analysisInsurances)->sum('charges');
            $paymentTotal = collect($analysisInsurances)->sum('payments');
            return new ViewResponse('backend.AR-AnalysisByFinancialClass.index', compact('analysisInsurances', 'chargeTotal', 'paymentTotal', 'currentMonth', 'currentDate','title'));
        } catch (\Exception $e) {
//            return $this->respondInternalError($e->getMessage());
            return back();
        }
    }

    public function store(Request $request)
    {
        try {
            $title='Analysis By Insurance';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = $request->get('dateStartfilter');
            $currentDate = $request->get('dateEndfilter');
            $analysisInsurances = DB::select('CALL fr_AR_analysis_insurance(?,?,?)', [$practice_id, $currentMonth, $currentDate]);
            $chargeTotal = collect($analysisInsurances)->sum('charges');
            $paymentTotal = collect($analysisInsurances)->sum('payments');
            $header=(string)view('backend.partials.financialReportsHeader',compact('title','currentDate','currentMonth'));
            $view = (string)view('backend.AR-AnalysisByFinancialClass.partials.tableBody', compact('analysisInsurances', 'chargeTotal', 'paymentTotal', 'currentMonth', 'currentDate'));
            return response()->json(['status' => true, 'view' => $view,'header' => $header]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

   /* public function patient-analysis-store(){

}*/

}
