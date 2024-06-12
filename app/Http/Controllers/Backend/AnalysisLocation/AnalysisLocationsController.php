<?php

namespace App\Http\Controllers\Backend\AnalysisLocation;

use App\Http\Controllers\Controller;
use App\Http\Responses\ViewResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalysisLocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $title='Analysis Report by Location';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = Carbon::now()->startOfMonth()->format('m/d/Y');
            $currentDate = Carbon::now()->format('m/d/Y');
            $analysisLocations = DB::select("CALL fr_AR_analysis_location($practice_id,$currentMonth,$currentDate)");
            $chargeTotal = collect($analysisLocations)->sum('charges');
            $paymentTotal = collect($analysisLocations)->sum('payments');
            return view('backend.AR-AnalysisByLocation.index', compact('analysisLocations', 'chargeTotal', 'paymentTotal', 'currentMonth', 'currentDate','title'));
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
            $title='Analysis Report by Location';
            $practice_id = Auth::user()->practice_id;
            $currentMonth = $request->get('dateStartfilter');
            $currentDate = $request->get('dateEndfilter');
            $analysisLocations = DB::select('call fr_AR_analysis_location(?,?,?)', array($practice_id, $currentMonth, $currentDate));
            $chargeTotal = collect($analysisLocations)->sum('charges');
            $paymentTotal = collect($analysisLocations)->sum('payments');
            $view = (string) view('backend.AR-AnalysisByLocation.partials.tableBody', compact('analysisLocations', 'chargeTotal', 'paymentTotal', 'currentMonth', 'currentDate'));
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
