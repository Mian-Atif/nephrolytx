<?php

namespace App\Http\Controllers\Backend\ProductivityAnalysis;

use App\Http\Controllers\Controller;
use App\Http\Responses\ViewResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductivityAnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param App\Http\Requests\Backend\ProductivityAnalysis
     * @return \App\Http\Responses\ViewResponse
     */
    public function index()
    {
        try {
            $title='Productivity Analysis';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = Carbon::now()->startOfMonth()->format('m/d/Y');
            $currentDate = Carbon::now()->format('m/d/Y');
            $productivities = DB::select("CALL fr_Productivity_Analysis($practice_id,$currentMonth,$currentDate)");
            $productivityAnalysis = collect($productivities)->groupBy('provider');
            $chargeTotal = collect($productivities)->sum('charges');
            $paymentTotal = collect($productivities)->sum('payments');
            return new ViewResponse('backend.productivityAnalysis.index', compact('title','productivityAnalysis', 'chargeTotal', 'paymentTotal', 'currentMonth', 'currentDate','productivities'));
        } catch (\Exception $e) {
//            return $this->respondInternalError($e->getMessage());
            return back();
        }
    }

    public function store(Request $request)
    {
        try {
            $title='Productivity Analysis Report';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = $request->get('dateStartfilter');
            $currentDate = $request->get('dateEndfilter');
            $productivities = DB::select('call fr_Productivity_Analysis(?,?,?)', array($practice_id, $currentMonth, $currentDate));
            $productivityAnalysis = collect($productivities)->groupBy('provider');
            $chargeTotal = collect($productivities)->sum('charges');
            $paymentTotal = collect($productivities)->sum('payments');
            $view = (string)view('backend.productivityAnalysis.partials.tableBody', compact('productivityAnalysis', 'chargeTotal', 'paymentTotal', 'currentMonth', 'currentDate','productivities'));
            $header=(string)view('backend.partials.financialReportsHeader',compact('title','currentDate','currentMonth'));
            return response()->json(['status' => true, 'view' => $view,'header' => $header]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

}
