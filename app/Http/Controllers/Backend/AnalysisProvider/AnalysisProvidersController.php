<?php

namespace App\Http\Controllers\Backend\AnalysisProvider;

use App\Http\Controllers\Controller;
use App\Http\Responses\ViewResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalysisProvidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $title='AR Analysis by Provider';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = Carbon::now()->startOfMonth()->format('m/d/Y');
            $currentDate = Carbon::now()->format('m/d/Y');
            $analysisProviders = DB::select("CALL fr_AR_analysis_provider($practice_id,$currentMonth,$currentDate)");
            $chargeTotal = collect($analysisProviders)->sum('charges');
            $paymentTotal = collect($analysisProviders)->sum('payments');
            return view('backend.AR-AnalysisByProvider.index', compact('analysisProviders', 'chargeTotal', 'paymentTotal', 'currentMonth', 'currentDate','title'));
        } catch (\Exception $e) {
//            return $this->respondInternalError($e->getMessage());
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $title='Analysis Report by Provider';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = $request->get('dateStartfilter');
            $currentDate = $request->get('dateEndfilter');
            $analysisProviders = DB::select('call fr_AR_analysis_provider(?,?,?)', array($practice_id, $currentMonth, $currentDate));
            $chargeTotal = collect($analysisProviders)->sum('charges');
            $paymentTotal = collect($analysisProviders)->sum('payments');
            $view = (string)view('backend.AR-AnalysisByProvider.partials.tableBody', compact('analysisProviders', 'chargeTotal', 'paymentTotal', 'currentMonth', 'currentDate'));
            $header=(string)view('backend.partials.financialReportsHeader',compact('title','currentDate','currentMonth'));
            return response()->json(['status' => true, 'view' => $view,'header' => $header]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
